<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\EmailQueue;
use Validator;
use App\Models\User;

class MailController extends Controller
{
    public function queueMail(Request $request){
        $validator = Validator::make($request->all(), [
            'mailservice' => 'required|numeric',
            'subject' => 'required|string',
            'to' => 'required|email',
            'name' => 'required|string',
            'template_id' => 'required|numeric',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // $htmlTemplateData = // get by Id
        $mailservice = $request->input('mailservice');
        $subject = $request->input('subject');
        $to = $request->input('to');
        $name = $request->input('name');
        $template_id = $request->input('template_id');
        $existOrCreate = ['to'=>$to,'name'=>$name];
        User::createUserFromEmailQueue($existOrCreate);

        $saveMailQueue = [
            'smtp_config_id'=>$mailservice,
            'subject'=>$subject,
            'template_id'=>$template_id,
            'email'=>$to,
            'name'=>$name,
            'read_status'=>'queue',
            'template_html'=>'', //keep null will render before sending on schedule job
            'status_update_time'=>date('Y-m-d H:i:s'),
            'created_at'=>date('Y-m-d H:i:s'),
        ];
        EmailQueue::insert($saveMailQueue);    
    }
}
