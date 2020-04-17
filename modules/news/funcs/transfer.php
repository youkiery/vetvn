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
		case 'filter':
      $filter = $nv_Request->get_array('filter', 'post');

      $result['html'] = transferList($userinfo['id'], $filter);
      if (empty($result['html'])) {
        $result['notify'] = 'Có lỗi xảy ra';
      }
      else {
        $result['status'] = 1;
      }
		break;
		case 'filter1':
      $filter = $nv_Request->get_array('filter', 'post');

      $result['html'] = transferedList($userinfo['id'], $filter);
      if (empty($result['html'])) {
        $result['notify'] = 'Có lỗi xảy ra';
      }
      else {
        $result['status'] = 1;
      }
		break;
		case 'filter2':
      $filter = $nv_Request->get_array('filter', 'post');

      $result['html'] = transferqList($userinfo['id'], $filter);
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

$xtpl = new XTemplate("main.tpl", PATH2);

// $xtpl->assign('content', transferList($userinfo['id']));
// $xtpl->assign('content1', transferedList($userinfo['id']));
// $xtpl->assign('content2', transferqList($userinfo['id']));
$xtpl->assign('url', '/' . $module_name . '/' . $op . '/');

$xtpl->assign('module_file', $module_file);
$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");
