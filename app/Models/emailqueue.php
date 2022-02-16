<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class EmailQueue extends Model
{
    use HasFactory;
    protected $table = 'email_queue';

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
