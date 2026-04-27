<?php

$data = json_decode(file_get_contents("php://input"), true);

$query = $data['query'] ?? '';

$payload = json_encode([
    "query"=>$query
]);

$ch = curl_init("http://127.0.0.1:5000/search");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

$response = curl_exec($ch);

curl_close($ch);

$books = json_decode($response, true);

$html = "<h3>AI Results</h3>";

foreach($books as $b){

$html .= "
<div style='padding:10px;border:1px solid #ddd;margin:5px'>
<b>{$b['title']}</b><br>
Author: {$b['author']}<br>
Genre: {$b['genre']}
</div>";

}

echo json_encode(["html"=>$html]);