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

$page_title = "Danh sách chó bán";

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'filter':
      $filter = $nv_Request->get_array('filter', 'post');

      if (!empty($html = buyList($filter))) {
        $result['status'] = 1;
        $result['html'] = $html;
      }
    break;
		case 'send-contact':
      $id = $nv_Request->get_string('id', 'post', '0');
      $data = $nv_Request->get_array('data', 'post');
      $filter = $nv_Request->get_array('filter', 'post');

      $sql = 'insert into `'. PREFIX .'_info` ('. sqlBuilder($data, BUILDER_INSERT_NAME) .', rid, type, status, time) values ('. sqlBuilder($data, BUILDER_INSERT_VALUE) .', '. $id .', 2, '. $config['info'] .', '. time() .')';

      if ($db->query($sql)) {
        $result['status'] = 1;
        $result['notify'] = 'Đã gửi thông tin cho người đăng';
      }
    break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("main.tpl", PATH2);

// $xtpl->assign('content', buyList());
if (!empty($userinfo = getUserinfo())) {
  $userinfo['address'] = xdecrypt($userinfo['address']);
  $userinfo['mobile'] = xdecrypt($userinfo['mobile']);
  $xtpl->assign('fullname', $userinfo['fullname']);
  $xtpl->assign('address', $userinfo['address']);
  $xtpl->assign('mobile', $userinfo['mobile']);
}

$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_name ."/layout/footer.php");
