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
		'text' => '「'.$search_kind.'」が「'.$message_text.'」に該当する店舗はありませんでした。'
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
			"text" => '定休日: '.$_data['holiday'].'
住所: '.$_data['address'].'
予算: 昼 '.$_data['day_average'].'円, 夜 '.$_data['night_average'].'円',
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
					"uri" => 'https://www.google.com/maps?ll=43.062338,141.355623&z=17&t=m&hl=ja&gl=US&mapclient=embed&q=%E3%80%92060-0001+%E5%8C%97%E6%B5%B7%E9%81%93%E6%9C%AD%E5%B9%8C%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E5%8C%97%EF%BC%91%E6%9D%A1%E8%A5%BF%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%96'
				],
				[
					"type" => "uri",
					"label" => "電話する",
					"uri" => $_data['url']
				]
			]
		];

		array_push($columns, $column);
	}

	return $columns;
}

?>
