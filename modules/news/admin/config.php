<?php

/**
 * @Project Petcoffee-tech
 * @Chistua (hchieuthua@gmail.com)
 * @Copyright (C) 2019
 * @Createdate 21-03-2019 13:15
 */
if (!defined('NV_IS_ADMIN_FORM')) {
  die('Stop!!!');
}
define('BUILDER_INSERT_NAME', 0);
define('BUILDER_INSERT_VALUE', 1);
define('BUILDER_EDIT', 2);

$page_title = "Cấu hình";

$action = $nv_Request->get_string('action', 'post', '');

if (!empty($action)) {
  $result = array('status' => 0);
  switch ($action) {
    case 'save':
      $data = $nv_Request->get_array('data', 'post');

      foreach ($data as $name => $value) {
        $sql = 'select * from `'. PREFIX .'_config` where name = "'. $name .'"';
        $query = $db->query($sql);

        if (!empty($query->fetch())) {
          $sql = 'update `'. PREFIX .'_config` set value = "'. $value .'" where name = "'. $name .'"';
        }
        else {
          $sql = 'insert into `'. PREFIX .'_config` (name, value) values("'. $name .'", "'. $value .'")';
        }
        $db->query($sql);
      }
      $result['status'] = 1;
      $result['notify'] = 'Đã lưu';
    break;
  }
  echo json_encode($result);
  die();
}

$xtpl = new XTemplate("config.tpl", PATH);
// $xtpl->assign('content', buyList2());
$array = array('user', 'pet', 'trade', 'buy', 'info');

foreach ($array as $value) {
  $sql = 'select * from `'. PREFIX .'_config` where name = "'. $value .'"';
  $query = $db->query($sql);

  if (!empty($row = $query->fetch())) {
    if ($row['value'] == "1") {
      $xtpl->assign($value, 'checked');
    }
  }
}

$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
include (NV_ROOTDIR . "/modules/" . $module_file . "/layout/prefix.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
