<?php
class Linebot extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('turn');
        $this->load->helper('url_helper');
    }

    public function index()
    {
        require 'apiKey.php';
        $accessToken = $line_bot_access_token;
        //ユーザーからのメッセージ取得
        $json_string = file_get_contents('php://input');
        $json_object = json_decode($json_string);
        $user_id = $json_object->{"events"}[0]->{"source"}->{"userId"};
        // データ取得
        $data['turn'] = $this->turn->get($user_id);
        if ($data['turn']) {
            $turn = intval($data['turn']['turn']);
        } else {
            $turn = 0;
        }
        

        
        $replyToken = $json_object->{"events"}[0]->{"replyToken"};
        $message_type = $json_object->{"events"}[0]->{"message"}->{"type"};
        $message_text = $json_object->{"events"}[0]->{"message"}->{"text"};
        
        if($message_type != "text") exit;
        
        // 検索方法を決める
        if ($turn === 0) {
            if ($message_text === "ジャンル") {
                sending_messages($accessToken, $replyToken, $message_type, willShownText('selected_kind'));
                $turn = 1;
                $this->turn->set($user_id, $turn);
            } else if ($message_text === "食べ物") {
                sending_messages($accessToken, $replyToken, $message_type, willShownText('selected_food'));
                $turn = 2;
                $this->turn->set($user_id, $turn);
            } else if ($message_text === "店名") {
                sending_messages($accessToken, $replyToken, $message_type, willShownText('selected_shop'));
                $turn = 3;
                $this->turn->set($user_id, $turn);
            } else {
                sending_messages($accessToken, $replyToken, $message_type, willShownText('selected_error'));
            }

        // 検索内容
        } else if ($turn === 1) {
            sending_messages($accessToken, $replyToken, $message_type, $message_text.'の検索結果');
            $turn = 0;
            $this->turn->set($user_id, $turn);
        } else if ($turn === 2) {
            sending_messages($accessToken, $replyToken, $message_type, $message_text.'の検索結果');
            $turn = 0;
            $this->turn->set($user_id, $turn);
        } else if ($turn === 3) {
            sending_messages($accessToken, $replyToken, $message_type, $message_text.'の検索結果');   
            $turn = 0;
            $this->turn->set($user_id, $turn);
        }
    }
}
?>


<?php
//返信メッセージのテキスト取得
function willShownText($key) {
    $text = (object) array(
        'selected_kind' => 
        "選択ありがとうございます！

食べたいもののジャンルを教えてください

例) ランチ
　  ディナー
　  居酒屋      など",

        'selected_food' => 
        "選択ありがとうございます！

食べたいものを教えてください

例) ラーメン
　  カレー
　  うどん      など",

        'selected_shop' => 
    "選択ありがとうございます！

お店の名前を教えてください

例) ひらがなラーメン
　  カタカナカレー
　  漢字中華      など",

        'selected_error' => "「ジャンル」、「店名」、「食べ物」のいずれかを入力してください。"
    );
        return $text->$key;
    }

    ?>


    <?php
    //メッセージの送信
    function sending_messages($accessToken, $replyToken, $message_type, $return_message_text){
        $response_format_text = [
            "type" => $message_type,
            "text" => $return_message_text
        ];

        $post_data = [
            "replyToken" => $replyToken,
            "messages" => [$response_format_text]
        ];

        $ch = curl_init("https://api.line.me/v2/bot/message/reply");
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
?>
