<?php 

require 'referrallink.php'; 
require 'config.php'; 

$ref = new ReferralLink($config); 

$refKey = $ref->keyPresentsIn($_SERVER['QUERY_STRING']); 
$entry  = $ref->find($refKey);

if(isset($_POST['user_id']) && ! empty($_POST['user_id'])){
  $user_id = $_POST['user_id']; 
}

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
    <h1>Создание ссылки </h1>
    <?php if(isset($user_id)) { ?>
    <div>user id: <?= $user_id ?> </div>
    <div>link: <?= $ref->generateLink($user_id) ?> 
    <? } ?>
    <form action="" method="POST">
      <label for="user_id">Укажите id пользователя</label>
      <input type="text" name="user_id" />
      <input type="submit" name="create"/>
    </form>

  </body>
</html>

