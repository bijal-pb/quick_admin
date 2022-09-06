<?php

use App\Models\Notification;
use App\Models\User;

function sendPushNotification($device_token,$device_type,$noti_title,$noti_body,$badge,$user_id)
{
    $user = User::find($user_id);
    if($user->is_notification == 1){
        $setting = Setting::latest()->first();

        $url = "https://fcm.googleapis.com/fcm/send";
        $registrationIds = array($device_token);
        $serverKey = $setting->push_token;
        $title = $noti_title;
        // $body = array('text' => $noti_body);
        $notification = array('title' =>$title , 'body' => $noti_body, 'key_1' => '', 'key_2' =>'');
        if($device_type == 'android') {
            $arrayToSend = array('registration_ids' => $registrationIds, 'data'=>$notification, 'priority'=>'high', "content_available"=> true, "mutable_content"=> true);
            $json = json_encode($arrayToSend);
            
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "to" : "'.$device_token.'",
                "data" : {
                        "body" : "'.$noti_body.'",
                        "title": "'.$noti_title.'",
                        "key_1" : "Value for key_1",
                        "key_2" : "Value for key_2"
                        }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: key ='.$serverKey,
                'Content-Type: application/json'
                ),
            ));

            //Send the request
            $result = curl_exec($curl);
            if ($result === FALSE) 
            {
                die('FCM Send Error: ' . curl_error($curl));
            }

            curl_close( $curl );
        } else {
            $arrayToSend = array('registration_ids' => $registrationIds, 'notification'=>$notification, 'priority'=>'high', "content_available"=> true, "mutable_content"=> true);
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            //Send the request
            $result = curl_exec($ch);
            if ($result === FALSE) 
            {
                die('FCM Send Error: ' . curl_error($ch));
            }

            curl_close( $ch );
        }
    

    

        $notification = New Notification; 
        $notification->user_id = $user_id;
        $notification->title = $noti_title;
        $notification->message = $noti_body;
        $notification->status = 1;
        $notification->payload = $json;
        $notification->result = $result;
        $notification->save();

        return $result;
    }
}