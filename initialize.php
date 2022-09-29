<?php

session_start();
require_once 'enterKonn.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();
$curl = curl_init();


$email = $_GET['email'];
$amount = $_GET['amount']."00";  //the amount in kobo. This value is actually NGN 300
$product_id = $_GET['id'];

$address = $_GET['address'];
$phone = $_GET['phone'];


try{
$update_info = $conn->prepare('UPDATE registration SET phone = ?, address = ? WHERE email = ? ');
$update_info->execute([$phone,$address,$email]);


}catch(PDOException $e){
    
    echo $e->getMessage();
    
}
// url to go to after payment
$callback_url = 'https://mikeandcathy.com.ng/callback.php?product_id='.$product_id;  

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'amount'=>$amount,
    'email'=>$email,
    'callback_url' => $callback_url,
   'currency' => "NGN",
  ]),
  CURLOPT_HTTPHEADER => [
      
        "authorization: Bearer sk_live_23b906de774c70b1a7a7f68b5ba3000502de0731", 
  //  "authorization: Bearer sk_test_c9a4948b34d352dc78f9b01fe0ec63c10f7bafa2", 
  //replace this with your own test key
    "content-type: application/json",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
  // there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response, true);

if(!$tranx['status']){
  // there was an error from the API
  print_r('API returned error: ' . $tranx['message']);
}

// comment out this line if you want to redirect the user to the payment page
//print_r($tranx);
// redirect to page so User can pay
// uncomment this line to allow the user redirect to the payment page
header('Location: ' . $tranx['data']['authorization_url']);

?>