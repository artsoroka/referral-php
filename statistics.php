<?php 

require 'referrallink.php'; 
require 'config.php'; 

$ref = new ReferralLink($config); 

$statistics = $ref->statistics(); 

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
    <h1>Статистика посещений: </h1>
    <table>
    <thead>
    	<th>id пользователя</th>
    	<th>адрес ссылки</th>
    	<th>количество переходов</th>
    </thead>
    <tbody>
    	<? foreach ($statistics as $row) { ?>
    	<tr>
    		<td><?= $row['user_id'] ?></td>
    		<td><?= $ref->getPath($row['link']); ?></td>
    		<td><?= $row['count'] ?></td>
    	</tr>
    	<? } ?>
    </tbody>
    </div>
  </body>
</html>

