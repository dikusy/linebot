<?php
// カルーセルの送信
function send_carousel($accessToken, $replyToken, $message_type, $show_data) {
	$columns = create_column($show_data);

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
				]
			]
		];

		array_push($columns, $column);
	}

	return $columns;
}

?>
