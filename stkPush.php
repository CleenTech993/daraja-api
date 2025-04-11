<?php
include 'accessToken.php';
date_default_timezone_set ('Africa/Nairobi');

$processrequestUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
$callbackurl = 'https://1c95-105-161-14-223.ngrok-free.app/MPEsa-Daraja-Api/callback.php';
$passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
$BusinessShortCode = '174379';
$Timestamp = date('YmdHis');
$Password = base64_encode($BusinessShortCode . $passkey . $Timestamp);

// ✅ Replace with a real phone number in international format without '+'
$phone = '254723582705';
$money = '1';
$PartyA = $phone;
$PartyB = '254794222657';
$AccountReference = 'cleen technologies';
$TransactionDesc = 'stkpush test';
$Amount = $money;

$stkpushheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token];

//INITIATE CURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $processrequestUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, $stkpushheader);
$curl_post_data = array(
  'BusinessShortCode' => $BusinessShortCode,
  'Password' => $Password,
  'Timestamp' => $Timestamp,
  'TransactionType' => 'CustomerPayBillOnline',
  'Amount' => $Amount,
  'PartyA' => $PartyA,
  'PartyB' => $BusinessShortCode,
  'PhoneNumber' => $PartyA,
  'CallBackURL' => $callbackurl,
  'AccountReference' => $AccountReference,
  'TransactionDesc' => $TransactionDesc
);

$data_string = json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
$curl_response = curl_exec($curl);

// ✅ Error handling
$data = json_decode($curl_response);
if (isset($data->errorCode)) {
    echo "Error Code: " . $data->errorCode . "<br>";
    echo "Error Message: " . $data->errorMessage;
} else {
    $CheckoutRequestID = $data->CheckoutRequestID;
    $ResponseCode = $data->ResponseCode;

    if ($ResponseCode == "0") {
        echo "The CheckoutRequestID for this transaction is: " . $CheckoutRequestID;
    } else {
        echo "STK Push failed. Response Code: " . $ResponseCode;
    }
}
?>
