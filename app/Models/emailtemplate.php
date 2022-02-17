<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;
    protected $table = 'email_template';

    function getEmailKeysOnly(){
        $templateKeys = self::select('template_key')->groupby('template_key')->get();
        // $templateKeys->;

        if($templateKeys){
            $templateKeys = $templateKeys->toArray();
        }
        return $templateKeys;
    }

    function getTemplateByKey($templateKey){
        $templateData = self::where('template_key',$templateKey)->first();
        if($templateData){
            $templateData = $templateData->toArray();
        }
        return $templateData;
    }

}
