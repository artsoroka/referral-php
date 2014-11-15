<?php 

require 'referrallink.php'; 
require 'config.php'; 

$referral = new ReferralLink($config);

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
    <h1>Реферальные ссылки</h1>
    <div><a href="test.php">Проверить</a></div>
    <div><a href="create.php">Создать</a></div>
    <div><a href="statistics.php">Статистика посещений</a></div>
    </div>
  </body>
</html>
