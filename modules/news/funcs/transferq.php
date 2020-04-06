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

$page_title = "Danh sách yêu cầu";

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

      $result['html'] = transferqList($userinfo['id'], $filter);
      if (empty($result['html'])) {
        $result['notify'] = 'Có lỗi xảy ra';
      }
      else {
        $result['status'] = 1;
      }
		break;
		case 'cancel':
      $filter = $nv_Request->get_array('filter', 'post');
      $id = $nv_Request->get_int('id', 'post');
      $result['notify'] = 'Có lỗi xảy ra';

      if (!empty(checkTransferRequest($id))) {
        // zen: change to status
        $sql = 'delete from `'. PREFIX .'_transfer_request` where id = ' . $id;
        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['notify'] = 'Đã xóa';
          $result['html'] = transferqList($userinfo['id'], $filter);
        }
      }
		break;
		case 'confirm':
      $filter = $nv_Request->get_array('filter', 'post');
      $id = $nv_Request->get_int('id', 'post');
      $row = checkTransferRequest($id);
      $result['notify'] = 'Có lỗi xảy ra';

      if (count($filter) > 1 && !empty($row)) {
        // zen: change to status
        $pet = getPetById($row['petid']);

        $sql = 'delete from `'. PREFIX .'_transfer_request` where id = ' . $row['id'];
        $sql2 = 'update `'. PREFIX .'_pet` set userid = ' . $userinfo['id'] . ' where id = ' . $pet['id'];
        $sql3 = 'insert into `'. PREFIX .'_transfer` (fromid, targetid, petid, time, type) values('. $pet['userid'] .', '. $userinfo['id'] .', '. $row['petid'] .', '. time() .', 1)';
        // die($sql3);

        if ($db->query($sql) && $db->query($sql2) && $db->query($sql3)) {
          $result['status'] = 1;
          $result['notify'] = 'Đã chuyển nhượng';
          $result['html'] = transferqList($userinfo['id'], $filter);
        }
      }
		break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("transferq.tpl", "modules/". $module_name ."/template");

$xtpl->assign('content', transferqList($userinfo['id']));
$xtpl->assign('url', '/' . $module_name . '/' . $op . '/');
$xtpl->assign('url', '/' . $module_name . '/' . $op . '/');

$xtpl->assign('module_file', $module_file);
$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");
