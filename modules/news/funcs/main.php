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

$xtpl = new XTemplate("main.tpl", "modules/". $module_name ."/template");
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

$xtpl->assign('content', defaultDogList());
$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");

