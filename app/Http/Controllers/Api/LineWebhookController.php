<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LINE\LINEBot;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\SignatureValidator;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use Exception;
use Illuminate\Support\Facades\Log;

class LineWebhookController extends Controller
{

    public function webhook (Request $request)
    {
        // ログファイルの確認
        Log::debug($request->header());
        Log::debug($request->input());

        $lineAccessToken = env('LINE_ACCESS_TOKEN', "");
        $lineChannelSecret = env('LINE_CHANNEL_SECRET', "");

        // //ユーザーからのメッセージ取得
        // $json_string = file_get_contents('php://input');
        // $json_object = json_decode($json_string);

        // //取得データ
        // $replyToken = $json_object->{"events"}[0]->{"replyToken"};        //返信用トークン
        // $message_type = $json_object->{"events"}[0]->{"message"}->{"type"};    //メッセージタイプ
        // $message_text = $json_object->{"events"}[0]->{"message"}->{"text"};    //メッセージ内容

        // 署名のチェック
        $signature = $request->headers->get(HTTPHeader::LINE_SIGNATURE);
        if (!SignatureValidator::validateSignature($request->getContent(), $lineChannelSecret, $signature)) {
            // TODO 不正アクセス
            return;
        }

        $httpClient = new CurlHTTPClient ($lineAccessToken);
        $lineBot = new LINEBot($httpClient, ['channelSecret' => $lineChannelSecret]);

        //mysqlに接続
        define("DB_DATABASE","line_english_db");
        define("DB_USERNAME","root");
        define("DB_PASSWORD","root");
        define("PDO_DSN","mysql:host=localhost;dbname=" . DB_DATABASE);

        try {
            $dbh = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
             } 
             catch(PDOException $e) {
            $dbh->rollback();
            echo $e->getMessage();
            exit;
        }

        $english_word_id = 1;

        //変数$english_word_idに値が入っていた場合、データベースと照合する
        if(!empty($english_word_id)){

            //返信する内容を保存する変数
            $Return_english_word = "";
            
            //データベースから読み取った英単語
            try{
                $sql = "select * from words";
                $stmt = $dbh->query($sql);
                }
                catch(PDOException $e) {
                    $dbh->rollback();
                    echo $e->getMessage();
                    exit;
                }
            
                //データベースとユーザーが投稿した内容が一致するか確認する
                while($line_english_db = $stmt->fetch(PDO::FETCH_ASSOC)){
                    if($line_english_db["word_id"] == $english_word_id) {
                        $Return_english_word = $line_english_db["name_english"];
                    }
            }
        }else{
            $Return_english_word = "もう一度入力してください";
        }
        
        sending_messages($accessToken, $replyToken, $message_type, $Return_english_word);
?>

<?php
        function sending_messages($accessToken, $replyToken, $message_type, $Return_english_word){
    
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
            $ch = curl_init("https://00ad7e7a95ef.ap.ngrok.io/api/line/webhook");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charser=UTF-8',
                'Authorization: Bearer ' . $accessToken
            ));
            $result = curl_exec($ch);
            curl_close($ch);
        }
    }
}
?>
