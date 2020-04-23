<?php

/**
 * @Project Petcoffee-tech
 * @Chistua (hchieuthua@gmail.com)
 * @Copyright (C) 2019
 * @Createdate 21-03-2019 13:15
 */

if (!defined('NV_IS_FORM')) {
	die('Stop!!!');
}

$page_title = "Veterinary Vietnam";

// $sql = 'select * from pet_news_pet';
// $query = $db->query($sql);
// while ($row = $query->fetch()) {
//   $species = checkRemind($row['species'], 'species2');
//   $color = checkRemind($row['color'], 'color');
//   $type = checkRemind('Ngắn', 'type');
//   $sql = "insert into pet_news_sendinfo (name, micro, regno, sex, birthtime, species, color, type, breeder, owner, image, userid, active, active2, father, mother, intro, time) values ('$row[name]', '$row[microchip]', '', $row[sex], $row[dateofbirth], $species, $color, $type, 0, 0, '$row[image]', $row[userid], $row[active], 1, 0, 0, '$row[graph]', $row[time]);";
//   $db->query($sql);
//   if ($row['ceti']) {
//     $sql = "insert into pet_news_certify(petid, signid, price, time) values (". $db->lastInsertId() .", 1, $row[price], $row[time]);";
//     $db->query($sql);
//   }
// }
// die();


// $sql = 'select * from ((select id, fullname, mobile, address, 1 as type from `'. PREFIX .'_user`) union (select id, fullname, mobile, address, 2 as type from `'. PREFIX .'_contact` where userid = '. $userinfo['id'] .')) as c';
// $query = $db->query($sql);

// while ($row = $query->fetch()) {
//   echo "$row[fullname] ($row[type]): ". xdecrypt($row['mobile']) ." <br>";
// }
// die();



// $sql = 'select * from `'. PREFIX .'_contact`';
// $query = $db->query($sql);

// while ($row = $query->fetch()) {
//   $mobile = xencrypt($row['mobile']);
//   $address = xencrypt($row['address']);
//   $sql = 'update `'. PREFIX .'_contact` set mobile = "'. $mobile .'", address = "'. $address .'" where id = ' . $row['id'];
//   $db->query($sql);
// }
// die();

$xtpl = new XTemplate("main.tpl", PATH2);
$userinfo = getUserInfo();
$xtpl->assign('module_file', $module_file);

if (!empty($userinfo)) {
  if ($userinfo['center']) {
    $xtpl->parse("main.log_center");
  }
  else {
    $xtpl->parse("main.log");
  }
}
else {
  $xtpl->parse("main.nolog");
}

// echo md5('abc');
// die();

$xtpl->assign('content', mainContent());
$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");

