<?php
namespace Helper;

use App\Models\Profile;

class Helper
{
    
    function my_weird_af_function(){
        return 'sup';
    }

    public static function Profile(){
        $datas = Profile::first();

        return $datas;
    }

    public static function sendWa($number, $message)
    {   
        $number = str_replace("+62","0",$number);
        $key='7e10303d8e75d503ef83ab381ac95f692a476a9766c51090';
        $url='http://116.203.92.59/api/async_send_message';
        $data = array(
            "phone_no"=> $number,
            "key"       =>$key,
            "message"   =>$message,
        // "url"        =>$img_url,
        );
        $data_string = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 360);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
        
    }
}


?>