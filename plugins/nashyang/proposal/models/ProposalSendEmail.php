<?php namespace Nashyang\Proposal\Models;

use Model;
use Illuminate\Support\Facades\Mail;

/**
 * Model
 */
class ProposalSendEmail extends Model {

    private $isSend = TRUE;
    private $isTest = FALSE;
    private $testMails = [
        'hikkijojo@gmail.com' => '測試接收信箱1',
        'momoto566@gmail.com' => '測試接收信箱2',
        'hikkijojo@yahoo.com.tw' => '測試接收信箱3',
        'hikkijojo@pchome.com.tw' => '測試接收信箱4',
        'hikkijojo@msn.com' => '測試接收信箱5',
    ];

    public function sendMail( $vars, $mails ) {
        if ( $this->isSend ) {
            if ( $this->isTest ) {
                $mails = $this->testMails;
            }
            Mail::send( $vars['mailtemplates'], $vars, function( $message ) use ( $mails ) {
                $message->from( 'yda_noreply@mail.yda.gov.tw', '行政院青年諮詢委員會(系統郵件)' )
                    ->bcc( $mails, $name = NULL );
            } );
        }
    }


    static public function onSendProposalEmail1() {
        $sendUserObj = Proposal_list::find( post( 'id' ) )->user;
        $mails = User::getCommitteeMemberEmailList( $sendUserObj->id )->lists( 'name', 'email' );
        $vars = [
            'name' => $sendUserObj->name,
            'link' => url('/proposal/list'),
            'mailtemplates' => 'nashyang.proposal::mail.sendProposalSendEmail1',
        ];
        $sendMailObj = new self();
        $sendMailObj->sendMail( $vars, $mails );
    }

    static public function onSendProposalEmail2( $meetingID ) {
        $userIDs = Respondents::where( 'meeting_id', $meetingID )->lists( 'user_id' );
        $mails = \Nashyang\Proposal\Models\User::wherein( 'id', $userIDs )->lists( 'name', 'email' );
        $vars = [
            'link' => url( '/proreply' ),
            'mailtemplates' => 'nashyang.proposal::mail.sendProposalSendEmail2',
        ];
        $sendMailObj = new self();
        $sendMailObj->sendMail( $vars, $mails );
    }

    static public function onSendProposalEmail3( $meetingID ) {
        $userIDs = Respondents::where( 'meeting_id', $meetingID )->lists( 'user_id' );
        $meetingObj = Meeting::where('id', $meetingID)->first();
        $mails = \Nashyang\Proposal\Models\User::wherein( 'id', $userIDs )->lists( 'name', 'email' );
        $vars = [
            'link' => url( '/proreply' ),
            'eventName' => $meetingObj->name,
            'eventTime' => $meetingObj->time,
            'location' => $meetingObj->location,
            'mailtemplates' => 'nashyang.proposal::mail.sendProposalSendEmail3',
        ];
        $sendMailObj = new self();
        $sendMailObj->sendMail( $vars, $mails );
    }

}