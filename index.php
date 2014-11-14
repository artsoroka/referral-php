<?php 

require 'referrallink.php'; 

$referral = new ReferralLink(array(
  'url' => 'heyhey.ru',
  'length' => 5, 
  'keyName' => 'wow'
));

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Referral-PHP </title>
  </head>
  <body>
    <h1>Hello</h1>
    <div>Referal link: <? echo $referral->createLink(); ?>
    </div>
  </body>
</html>
