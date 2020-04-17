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

$page_title = "Danh sách dự trữ";

$action = $nv_Request->get_string('action', 'post', '');
$userinfo = getUserInfo();
if (empty($userinfo)) {
	header('location: /' . $module_name . '/login/');
	die();
}

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
		case 'filter':
      $filter = $nv_Request->get_array('filter', 'post');

      $result['html'] = reserveList($userinfo['id'], $filter);
      if (empty($result['html'])) {
        $result['notify'] = 'Có lỗi xảy ra';
      }
      else {
        $result['status'] = 1;
      }
		break;
		case 'confirm':
      $filter = $nv_Request->get_array('filter', 'post');
      $id = $nv_Request->get_int('id', 'post');
      $result['notify'] = 'Có lỗi xảy ra';

      $sql = 'select * from `'. PREFIX .'_pet` where id = ' . $id . ' and userid = ' . $userinfo['id'];
      $query = $db->query($sql);

      if (count($filter) > 1 && !empty($row = $query->fetch())) {
        // zen: change to status
        $sql = 'update `'. PREFIX .'_pet` set sell = 0 where id = ' . $id;

        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['notify'] = 'Đã di chuyển';
          $result['html'] = reserveList($userinfo['id'], $filter);
        }
      }
		break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("main.tpl", PATH2);

// $xtpl->assign('content', reserveList($userinfo['id']));
// $xtpl->assign('url', '/' . $module_name . '/' . $op . '/');

$xtpl->assign('module_file', $module_file);
$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");
