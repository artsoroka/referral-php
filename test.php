<?php 

require 'referrallink.php'; 
require 'config.php'; 

$ref = new ReferralLink($config); 

$refKey = $ref->keyPresentsIn($_SERVER['QUERY_STRING']); 
$entry  = $ref->find($refKey);
$saved  = $ref->increment($entry['link_id']); 
 
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
    <h1>Реферальная ссылка </h1>
    <div>Реферальная ссылка в адресной строке <?= ($refKey) ? "присутствует" : "отсутствует"; ?> </div> 
    <div>Реферальная ссылка в базе данных <?= ($entry) ? "найдена" : "не найдена"; ?> </div>
    <div>Запись в базе <?= ($saved) ? "сохранена" : "не сохранена"; ?> </div>
  </body>
</html>

