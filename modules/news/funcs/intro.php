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

$page_title = "Danh sách chuyển nhượng";

$action = $nv_Request->get_string('action', 'post', '');
$userinfo = getUserInfo();
if (empty($userinfo)) {
	header('location: /' . $module_name . '/login/');
	die();
}

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'hide':
      $id = $nv_Request->get_int('id', 'post', '0');
      $filter = $nv_Request->get_array('filter', 'post');

      $sql = 'select * from (((select a.* from `'. PREFIX .'_info` a inner join `'. PREFIX .'_pet` b on a.rid = b.id where (a.type = 1 or a.type = 3) and b.userid = '. $userinfo['id'] . ' and status = 1) union (select a.* from `'. PREFIX .'_info` a inner join `'. PREFIX .'_buy` b on a.rid = b.id where a.type = 2 and b.userid = '. $userinfo['id'] . ' and a.status = 1)) as c) where id = ' . $id;
      $query = $db->query($sql);
      if (empty($row = $query->fetch())) {
        $result['notify'] = 'Có lỗi xảy ra';
      }
      else {
        $sql = 'update `'. PREFIX .'_info` set status = 2 where id = ' . $id;

        if (!$db->query($sql) || empty($html = introList($userinfo['id'], $filter))) {
          $result['notify'] = 'Có lỗi xảy ra';
        }
        else {
          $result['status'] = 1;
          $result['notify'] = 'Đã ẩn';
          $result['html'] = $html;
        }
      }
    break;
		case 'filter':
      $filter = $nv_Request->get_array('filter', 'post');

      if (empty($html = introList($userinfo['id'], $filter))) {
        $result['notify'] = 'Có lỗi xảy ra';
      }
      else {
        $result['status'] = 1;
        $result['html'] = $html;
      }
		break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("main.tpl", PATH2);

// $xtpl->assign('content', introList($userinfo['id']));
$xtpl->assign('url', '/' . $module_name . '/' . $op . '/');

$xtpl->assign('module_file', $module_file);
$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");
