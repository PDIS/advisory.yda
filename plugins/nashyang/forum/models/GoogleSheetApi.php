<?php namespace Nashyang\Forum\Models;

use Bedard\BlogTags\Models\Tag;
use Google_Client;
use Google_Service_Sheets;
use Illuminate\Support\Facades\DB;
use Model;

/**
 * Model
 */
class GoogleSheetApi extends Model {
    public $googleClient;
    public $googleSheets;
    public $sheetData;
    public $sheetUID;
    public $authConfigJsonPath;
    protected $applicationName = 'YdaSheetApiServices';
    protected $scopeList = [
        Google_Service_Sheets::SPREADSHEETS,
    ];
    protected $accessType = 'offline';


    public function __construct() {
        $this->initGoogleSheetObj();
    }

    public function initGoogleSheetObj() {
        $this->googleClient = new Google_Client();
        $this->googleClient->setApplicationName( $this->applicationName );
        $this->googleClient->setScopes( $this->scopeList );
        $this->googleClient->setAccessType( $this->accessType );
        $this->authConfigJsonPath = plugins_path( 'nashyang' );
        $this->authConfigJsonPath .= DIRECTORY_SEPARATOR . 'forum' . DIRECTORY_SEPARATOR . 'yda-api-service-b3f220a5df2f.json';
        $this->googleClient->setAuthConfig( $this->authConfigJsonPath );
        $this->googleSheets = new Google_Service_Sheets( $this->googleClient );
//        $this->eventID = $eventID;
    }

    /**
     * 取 Sheet 所有資料內容。回傳樣式為 Google 回傳格式。
     * @param integer $sheetUID
     * @param string $sheetName
     * @param string $range
     * @return mixed
     */
    public function getSheets( $sheetUID = NULL, $sheetName = '表單回應 1', $range = 'A1:Z' ) {
        $sheetUID = is_null( $sheetUID ) ? $this->sheetUID : $sheetUID;
        $sheetName = empty( $sheetName ) ? $sheetName : $sheetName . '!';
        $this->sheetData = $this->googleSheets->spreadsheets_values->get( $sheetUID, $sheetName . $range, [ 'majorDimension' => 'ROWS' ] );
    }

    public function checkSheetID( $url ) {
        $urlArr = parse_url( $url );
        $paths = explode( '/', $urlArr['path'] );
        $isTrue = TRUE;
        $isTrue = $isTrue && $urlArr['scheme'] === 'https';
        $isTrue = $isTrue && $urlArr['host'] === 'docs.google.com';
        $isTrue = $isTrue && $paths['0'] === '';
        $isTrue = $isTrue && $paths['1'] === 'spreadsheets';
        $isTrue = $isTrue && $paths['2'] === 'd';
        return $isTrue;
    }

    public function getSheetIdFormUrl( $url ) {
        return explode( '/', parse_url( $url )['path'] )[3];
    }

    public function setSheetID( $sheetID ) {
        $this->sheetUID = $sheetID;
    }

    public function explodeSheetData( $string, $delimiter = ','  ) {
        return explode( $delimiter, $string );
    }

    public function saveSheetDataToDB( $eventID ) {

        DB::transaction( function() use ( $eventID ) {
            $models = [
                'issue' => new Issue(),
                'respondent' => new Respondent(),
            ];

            foreach ( $this->sheetData->values AS $sheetIndex => $sheet ) {
                if ( $sheetIndex === 0 ) {
                    foreach ( $sheet AS $key => $value ) {
                        if ( in_array( $value, [ '姓名', '單位', '職稱', '問題 / 需求', '具體建議', '聯繫電話', '電子郵件', '指定回答者' ] ) ) {
                            switch ( $value ) {
                                case '姓名':
                                    $saveIndex['questioner_name'] = $key;
                                    break;
                                case '單位':
                                    $saveIndex['questioner_company'] = $key;
                                    break;
                                case '職稱':
                                    $saveIndex['questioner_jobtitle'] = $key;
                                    break;
                                case '問題 / 需求':
                                    $saveIndex['questioner'] = $key;
                                    break;
                                case '具體建議':
                                    $saveIndex['suggest'] = $key;
                                    break;
                                case '聯繫電話':
                                    $saveIndex['phone'] = $key;
                                    break;
                                case '電子郵件':
                                    $saveIndex['questioner_email'] = $key;
                                    break;
                                case '指定回答者':
                                    $saveIndex['importEtcName'] = $key;
                                    break;
                            }
                        }
                        continue;
                    }
                    continue;
                }
                if ( empty( $sheet[ $saveIndex['questioner_name'] ] ) || empty( $sheet[ $saveIndex['questioner_company'] ] ) ||
                    empty( $sheet[ $saveIndex['questioner_jobtitle'] ] ) || empty( $sheet[ $saveIndex['questioner'] ] ) ||
                    empty( $sheet[ $saveIndex['phone'] ] ) || empty( $sheet[ $saveIndex['questioner_email'] ] )
                ) {
                    continue;
                }
                $issueInsertArr = [
                    'questioner_name' => $sheet[ $saveIndex['questioner_name'] ],
                    'questioner_company' => $sheet[ $saveIndex['questioner_company'] ],
                    'questioner_jobtitle' => $sheet[ $saveIndex['questioner_jobtitle'] ],
                    'questioner' => $sheet[ $saveIndex['questioner'] ],
                    'suggest' => isset( $sheet[ $saveIndex['suggest'] ] ) ? $sheet[ $saveIndex['suggest'] ] : '',
                    'phone' => $sheet[ $saveIndex['phone'] ],
                    'questioner_email' => $sheet[ $saveIndex['questioner_email'] ],
                    'event_id' => $eventID,
                    'status' => 5,
                ];
                $newIssueID = $models['issue']->create( $issueInsertArr )->id;
                if ( isset( $saveIndex['importEtcName'] ) ) {
                    foreach ( $this->explodeSheetData( $sheet[ $saveIndex['importEtcName'] ] ) AS $importEtcName ) {
                        $userObj = ForumUser::getUserByName( $importEtcName );
                        $models['respondent']->create( [ 'issue_id' => $newIssueID, 'user_id' => ( $userObj ? $userObj->id : $importEtcName ) ] );
                    }
                }
            }
        } );
    }
}