<?php
//返信メッセージのテキスト取得
function will_shown_text($key) {
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
