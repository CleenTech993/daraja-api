<?php
//MPESA API KEYS

$consumerKey = 'rF7ZfTd5dm5MF7C4U6MVsZzFLll6J6PwHZNnuyRX5r09kG2v';
$consumerSecret = 't9Idx0u4vW4wwPJCvCXZe0SAkCs6AcVfTsQsyWT5Mf7HjGdomRtkP1uDgL9UhjQA';

//MPESA API URLS
$access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$header = ['content-type: application/json; charset=utf-8'];
$curl = curl_init($access_token_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
$result = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$result = json_decode($result, true);
echo $access_token = $result['access_token'];
curl_close($curl);

?>