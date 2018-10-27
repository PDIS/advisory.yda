<?php namespace RainLab\Blog\Behaviors;

use Backend\Behaviors\ImportExportController;
use Lang;
use Vdomah\Excel\Classes\Excel;

class ImportExportBehavior extends ImportExportController
{
    public static $combineColumn = array(
        'casenum', //案號
        'case', //案由
        'proposer', //提案人
        'cosigner', //連署人
        'content', //一、青年委員提案內容
        'description', //(一)提案說明
        'suggestion', //(二)具體建議
        'opinion', //二、綜合研處意見
        'resolution', //決議
    );

    protected function getImportFileColumns()
    {
        if (!$path = $this->getImportFilePath()) {
            return null;
        }

        // $reader = $this->createCsvReader($path);
        // $firstRow = $reader->fetchOne(0);

        //Hao=====
        $result = Excel::excel()->load($path, function ($reader) {
            $reader->first();
        });

        $dataArray = $result->toArray();
        $firstRow = [];
        if (count($dataArray) == 1) {
            foreach ($dataArray[0] as $key => $val) {
                $flag = true;
                foreach ($this::$combineColumn as $excludeVal) {
                    if ($key == $excludeVal) {
                        $flag = false;
                        break;
                    }
                }
                if ($flag) {
                    switch ($key) {
                        case 'id':
                            $key = strtoupper($key);
                            break;
                        case 'author_email':
                            $key = ucwords(str_replace("_", " ", $key));
                            break;
                        default:
                            $key = ucfirst(str_replace("_", " ", $key));
                            break;
                    }
                    array_push($firstRow, $key);
                }
            }
        } else {
            //$reader->first() => error
        }

        array_push($firstRow, 'Content');
        //Hao=====

        if (!post('first_row_titles')) {
            array_walk($firstRow, function (&$value, $key) {
                $value = 'Column #' . ($key + 1);
            });
        }

        /*
         * Prevents unfriendly error to be thrown due to bad encoding at response time.
         */
        if (json_encode($firstRow) === false) {
            throw new ApplicationException(Lang::get('backend::lang.import_export.encoding_not_supported_error'));
        }

        return $firstRow;
    }
}
