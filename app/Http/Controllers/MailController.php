<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\EmailQueue;
use Validator;

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

        $saveMailQueue = [
            'smtp_config_id'=>$mailservice,
            'subject'=>$subject,
            'template_id'=>$template_id,
            'email'=>$to,
            'name'=>$name,
            'status'=>'queue',
            'template_html'=>'queue',
            'status_update_time'=>date('Y-m-d H:i:s'),
        ];


        EmailQueue::insert($saveMailQueue);


        // Mail::send('emails.support', $data, function($message) use ($data)
        // {
        //     $message->to($data['email'],$data['name']);
        //     $message->subject($data['subject']);
        // });
    
    }
}
