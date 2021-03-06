<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EmailQueue;
use Illuminate\Support\Facades\Mail;

class sendQueueMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'everyminute:sendqueuemails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send queue mails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $queueMails = EmailQueue::getQueueFailedMailsNew();
        echo  'schedule start at '. date('Y-m-d h:i:s A');
        $start = microtime(true);
        if($queueMails){
            foreach($queueMails as $queueMail){
                try{
                    Mail::raw($queueMail['template']['template_html'], function ($message) use($queueMail) {
                        $message->from($queueMail['from'], $queueMail['from_name']);
                        $message->to($queueMail['email'], $queueMail['name']);
                        $message->subject($queueMail['subject']);
                    });
                    $updateQueueStatus = ['read_status'=>'sent','status_update_time'=>date('Y-m-d H:i:s'),'template_html'=>$queueMail['template']['template_html']];
                    if (Mail::failures()) {
                        $updateQueueStatus['read_status']='failed';
                    }

                } catch(\exception $errorRes){
                    $updateQueueStatus['read_status']='failed';
                }

                EmailQueue::where('id',$queueMail['id'])->update($updateQueueStatus);
            }
        }

        $end = microtime(true);
        $exec_time = ($end - $start);
        echo  ' Schedule end at '. date('Y-m-d h:i:s A') .' and took '.$exec_time.' seconds';
        return 0;
    }
}
