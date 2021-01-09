<?php
namespace App\Lib;

class Common{
    
    public static function sending_messages($lineAccessToken, $replyToken, $message_type, $Return_english_word)
    {
        //レスポンスフォーマット
        $response_format_text = [
            "type" => $message_type,
            "text" => $Return_english_word
        ];
        
        //ポストデータ
        $post_data = [
            "replyToken" => $replyToken,
            "messages" => [$response_format_text]
        ];
        
        //curl実行
        $ch = curl_init("https://b23827172c4e.ap.ngrok.io/api/line/webhook");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charser=UTF-8',
            'Authorization: Bearer ' . $lineAccessToken
        ));
        $result = curl_exec($ch);
        curl_close($ch);
    }    
}
?>