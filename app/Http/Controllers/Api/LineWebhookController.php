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
use App\Models\Test;

class LineWebhookController extends Controller
{

    public function webhook (Request $request)
    {
        //dd(Test::all());
        // ログファイルの確認
        
        $lineAccessToken = env('LINE_ACCESS_TOKEN', "");
        $lineChannelSecret = env('LINE_CHANNEL_SECRET', "");

        // 署名のチェック
        $signature = $request->headers->get(HTTPHeader::LINE_SIGNATURE);
        if (!SignatureValidator::validateSignature($request->getContent(), $lineChannelSecret, $signature)) {
            // TODO 不正アクセス
            return;
        }

        $httpClient = new CurlHTTPClient ($lineAccessToken);
        $lineBot = new LINEBot($httpClient, ['channelSecret' => $lineChannelSecret]);

        $test = new Test;
        $english_word_id = $test->find(2);
        
        Log::debug($english_word_id);

        try {
            // ユーザーメッセージ取得
            $events = $lineBot->parseEventRequest($request->getContent(), $signature);
            
            foreach ($events as $event) {
                $message = $event->getText();//ユーザーが送るメッセージ
                //Log::debug($message);
                $replyToken = $event->getReplyToken();//リプライトークン
                //Log::debug($replyToken);
                if($message === 'テスト'){
                    $textMessage = new TextMessageBuilder($english_word_id['name_japanese']);
                    $lineBot->replyMessage($replyToken, $textMessage);

                }else {
                    $textMessage = new TextMessageBuilder("こんにちは");
                    $lineBot->replyMessage($replyToken, $textMessage);
                }


                $events = $lineBot->parseEventRequest($request->getContent(), $signature);
                foreach($events as $event){
                    $message = $event->getText();
                    $replyToken = $event->getReplyToken();
                    if($message == $english_word_id['name_english']){
                        $textMessage = new TextMessageBuilder("正解");
                        $lineBot->replyMessage($replyToken, $textMessage);
                    }else{
                        $textMessage = new TextMessageBuilder("不正解");
                        $lineBot->replyMessage($replyToken, $textMessage);
                    }
                }
            }
        } catch (Exception $e) {
            // TODO 例外
            return;
        }

        return;
    }
}
