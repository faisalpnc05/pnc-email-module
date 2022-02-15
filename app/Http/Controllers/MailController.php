<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function sendmail(Request $request){
        $validator = Validator::make($request->all(), [
            'mailservice' => 'required|number',
            'subject' => 'required|string',
            'to' => 'required|email',
            'name' => 'required|string',
            'template_id' => 'required|number',
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
        
        $data = [
            'email'   => $to, 
            'subject' => $subject,
            'body'    => $request->input('body')
        ];

        Mail::send('emails.support', $data, function($message) use ($data)
        {
            $message->to($data['email'],$data['name']);
            $message->subject($data['subject']);
        });
    
    }
}
