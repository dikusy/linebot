<?php
// カルーセルの送信
function send_carousel($accessToken, $replyToken, $message_type, $message_text, $search_kind, $show_data) {
	$columns = create_column($show_data);

	$what_search_text = [
		"type" => 'text',
		'text' => '「'.$message_text.'」の検索結果です。'
	];

	$no_search_data_text = [
		"type" => 'text',
		'text' => $search_kind.'が「'.$message_text.'」に該当する店舗はありませんでした。'
	];

	$response_format_text = [
		"type" => "template",
		"altText" => "this is a carousel template",
		"template" => [
			"type" => "carousel",
			"columns" => $columns,
			"imageAspectRatio" => "rectangle",
			"imageSize" => "cover"
		]
	];

	$next_announce_text = [
        "type" => 'text',
        "text" => 'もう一度検索する場合は「ジャンル」「店名」「食べ物」から検索する項目を入力してください。'
    ];
	if (count($columns) !== 0) {
		$post_data = [
			"replyToken" => $replyToken,
			"messages" => [
				$what_search_text, 
				$response_format_text, 
				$next_announce_text
			]
		];
	} else {
		$post_data = [
			"replyToken" => $replyToken,
			"messages" => [
				$no_search_data_text, 
				$next_announce_text
			]
		];
	}
    

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

<?php
// カルーセルに入れるデータの配列作成
function create_column($data) {
	$columns = array();
	foreach($data as $_data) {
		$column = [
			"thumbnailImageUrl" => "https://example.com/bot/images/item1.jpg",
			"imageBackgroundColor" => "#FFFFFF",
			"title" => $_data['name'],
			"text" => '営業時間: '.$_data['open_at'].'時 ~ '.$_data['close_at'].'時
定休日: '.$_data['holiday'].'
予算: 昼 '.number_format($_data['day_average']).'円, 夜 '.number_format($_data['night_average']).'円',
			"defaultAction" => [
				"type" => "uri",
				"label" => "ホームページ",
				"uri" => $_data['url']
			],
			"actions" => [
				[
					"type" => "uri",
					"label" => "ホームページ",
					"uri" => $_data['url']
				],
				[
					"type" => "uri",
					"label" => "マップ",
					"uri" => 'https://www.google.com/maps/search/%E6%9D%B1%E4%BA%AC%E9%A7%85/@35.6808686,139.7658987,17z/data=!3m1!4b1?hl=ja'
				],
				[
					"type" => "uri",
					"label" => "電話する",
					"uri" => 'tel://'.$_data["tel"]
				]
			]
		];

		array_push($columns, $column);
	}

	return $columns;
}

?>
