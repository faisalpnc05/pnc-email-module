<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\EmailQueue;
use Validator;
use App\Models\User;
use App\Models\EmailTemplate;
use Illuminate\Validation\Rule;

class MailController extends Controller
{
    public function queueMail(Request $request){
        // MARKETING_EMAIL

        $validator = Validator::make($request->all(), [
            'mailservice' => 'required|numeric',
            'subject' => 'required|string',
            'to' => 'required|email',
            'name' => 'required|string',
            'template' => 'required|exists:email_template,template_key',
        ]);

        if($validator->fails()) {
            return response()->json(['error '=>$validator->errors()], 400);
        }
        
        $templateInfo = EmailTemplate::getTemplateByKey($request->input('template'));
        $mailservice = $request->input('mailservice');
        $subject = $request->input('subject');
        $to = $request->input('to');
        $name = $request->input('name');
        $fromName = $request->input('fromName');
        $fromEmail = $request->input('fromEmail');
        $template_id = $templateInfo['id'];
        $existOrCreate = ['to'=>$to,'name'=>$name];
        $user = User::createUserFromEmailQueue($existOrCreate);
        $saveMailQueue = [
            'smtp_config_id'=>$mailservice,
            'subject'=>$subject,
            'template_id'=>$template_id,
            'email'=>$to,
            'user_id'=>$user['id'],
            'name'=>$name,
            'from_name'=>$fromName,
            'from'=>$fromEmail,
            'read_status'=>'queue',
            'template_html'=>'', //keep null will render before sending on schedule job
            'status_update_time'=>date('Y-m-d H:i:s'),
            'created_at'=>date('Y-m-d H:i:s'),
        ];
        EmailQueue::insert($saveMailQueue);
        
        return response()->json([
            'message' => 'Mail registered successfully',
        ], 201);
    }

    public function queueMailReports(){
        return response()->json([
            'data' => EmailQueue::reports(),
        ], 200);

    }
}
