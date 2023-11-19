<?php

$amount = $_POST["spanValue"]*100;
$name = $_POST["name"];
$phoneNumbeer = $_POST["phone"];
$namePrefix = substr($name, 0, 3);

$CNT = 10 ;

$fromattedMerchantTransactionId = $namePrefix . "1234562345".$CNT;

$CNT++;

echo " Merchant ID : ". $fromattedMerchantTransactionId ;

$data = [
        "merchantId" => "PGTESTPAYUAT",
        "merchantTransactionId" => $fromattedMerchantTransactionId,
        "merchantUserId" => $name,
        "amount" => $amount,
        "redirectUrl" => "http://localhost/Toursim-Webdevelop/phonepe/redirect-url.php",
        "redirectMode" => "POST",
        "callbackUrl" => "http://localhost/phonepe/callback-url.php",
        "mobileNumber" => $phoneNumbeer,
        "paymentInstrument" => [
          "type" => "PAY_PAGE"
        ]
    ] ;
 
$saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399' ;
$saltIndex = 1 ;

$encode = json_encode($data);
$encoded = base64_encode($encode);

$string = $encoded.'/pg/v1/pay'.$saltKey;
$sha256 = hash('sha256',$string);
$finalXHeader = $sha256.'###'.$saltIndex;

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay");
curl_setopt($ch, CURLOPT_HTTPHEADER ,
            array(
                'Content-Type:application/json',
                'accept:application/json',
                'X-VERIFY: '.$finalXHeader,
            )
        );

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array('request' => $encoded)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

$final = json_decode($response,true);

// echo '<pre>' ;
// print_r($final);
// echo '</pre>';

if (isset($final['data']['instrumentResponse']['redirectInfo']['url'])) {
    $redirectURL = $final['data']['instrumentResponse']['redirectInfo']['url'];
    // echo '<a href="' . $redirectURL . '" target="_blank"><button> Make Payment </button></a>';
    header('Location:'.$redirectURL);
    exit();
} else {
    echo "Redirect URL is not available in the response.";
}
    
?>