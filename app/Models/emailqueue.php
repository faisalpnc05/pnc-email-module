<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\EmailTemplate;

class EmailQueue extends Model
{
    use HasFactory;
    protected $table = 'email_queue';

    public function template(){
        return $this->hasOne(EmailTemplate::class,'id','template_id');
    }

    public static function getQueueFailedMailsNew(){
        return self::whereIn('read_status',['queue','failed'])->with('template')->get()->toArray();
    }

    public static function reports(){


        $raw_count = '
            SUM(CASE 
            WHEN read_status = \'queue\' 
            THEN 1 
            ELSE 0 
            END) AS totalQueue,

            SUM(CASE 
            WHEN read_status = \'sent\' 
            THEN 1 
            ELSE 0 
            END) AS totalSent,

            SUM(CASE 
            WHEN read_status = \'failed\' 
            THEN 1 
            ELSE 0 
            END) AS totalFailed,

            SUM(CASE 
            WHEN read_status = \'read\' 
            THEN 1 
            ELSE 0 
            END) AS totalRead
        ';

        $queueCounts = self::selectRaw($raw_count)->get()->toArray();

        $queueRecords = self::whereIn('read_status',['queue','failed'])->with('template')->get()->toArray();
        return ['queueCounts'=>$queueCounts,'queueRecords'=>$queueRecords];
    }

    public static function getQueueFailedMails(){
        $queueRecords = self::select(DB::raw('email_queue.*'),'email_template.template_html')->whereIn('read_status',['queue','failed'])
        ->leftJoin('email_template','email_queue.template_id','email_template.id')
        ->get();
        if(method_exists($queueRecords,'toArray')){
            return $queueRecords->toArray();
        }
        return $queueRecords;
    }
}
