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

$page_title = "Xác nhận yêu cầu tiêm phòng";

$action = $nv_Request->get_string('action', 'post', '');

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'remove-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'delete from `'. PREFIX .'_request` where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = requestList($filter);
  			if ($result['html']) {
					$result['notify'] = 'Đã xóa';
					$result['status'] = 1;
				}
      }
    break;
    case 'active-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `'. PREFIX .'_request` set status = 2 where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = requestList($filter);
				if ($result['html']) {
					$result['notify'] = 'Đã lưu';
					$result['status'] = 1;
				}
      }
    break;
		case 'filter':
      $filter = $nv_Request->get_array('filter', 'post');

      $result['status'] = 1;
      $result['html'] = requestList($filter);
		break;
		case 'check':
      $id = $nv_Request->get_int('id', 'post', 1);
      $filter = $nv_Request->get_array('filter', 'post');

      if (!empty($row = getRequestId($id))) {
        $sql = 'update `'. PREFIX .'_request` set status = 2 where id = ' . $id;
        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['html'] = requestList($filter);
        }
      }
		break;
		case 'remove':
      $id = $nv_Request->get_int('id', 'post', 1);
      $filter = $nv_Request->get_array('filter', 'post');

      if (!empty($row = getRequestId($id))) {
        $sql = 'delete from `'. PREFIX .'_request` where id = ' . $id;
        // $sql = 'update `'. PREFIX .'_request` set status = 0 where id = ' . $id;
        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['html'] = requestList($filter);
        }
      }
		break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("request.tpl", PATH);

$time = time();

$xtpl->assign('atime', date('d/m/Y', $time - 60 * 60 * 24 * 30));
$xtpl->assign('ztime', date('d/m/Y', $time));
$xtpl->assign('content', requestList());

$xtpl->assign('module_file', $module_file);
$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
include (NV_ROOTDIR . "/modules/". $module_file ."/layout/prefix.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
