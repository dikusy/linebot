<?php
class Linebot extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('turn');
        $this->load->model('store_form');
        $this->load->helper('url_helper');
    }

    public function index()
    {
        require 'api_key.php';
        require 'utils/send_message.php';
        require 'utils/send_carousel.php';
        require 'utils/will_shown_text.php';
        require 'utils/get_search_result.php';

        $accessToken = $LINE_BOT_ACCESS_TOKEN;
        
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
                sending_messages($accessToken, $replyToken, $message_type, will_shown_text('selected_kind'));
                $turn = 1;
                $this->turn->set($user_id, $turn);
            } else if ($message_text === "食べ物") {
                sending_messages($accessToken, $replyToken, $message_type, will_shown_text('selected_food'));
                $turn = 2;
                $this->turn->set($user_id, $turn);
            } else if ($message_text === "店名") {
                sending_messages($accessToken, $replyToken, $message_type, will_shown_text('selected_shop'));
                $turn = 3;
                $this->turn->set($user_id, $turn);
            } else {
                sending_messages($accessToken, $replyToken, $message_type, will_shown_text('selected_error'));
            }

        // 検索内容
        } else if ($turn === 1) {
            $data = $this->store_form->get_by_key('category', $message_text);
            send_carousel($accessToken, $replyToken, 'template', $message_text, $data);
            $turn = 0;
            $this->turn->set($user_id, $turn);
        } else if ($turn === 2) {
            $data = $this->store_form->get_by_key('category', $message_text);
            send_carousel($accessToken, $replyToken, 'template', $message_text, $data);
            $turn = 0;
            $this->turn->set($user_id, $turn);
        } else if ($turn === 3) {
            $data = $this->store_form->get_by_key('name', $message_text);
            send_carousel($accessToken, $replyToken, 'template', $message_text, $data);   
            $turn = 0;
            $this->turn->set($user_id, $turn);
        }
    }
}
