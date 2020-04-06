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

$page_title = "Duyệt liên hệ";

$action = $nv_Request->get_string('action', 'post', '');

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'remove-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'delete from `'. PREFIX .'_info` where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = infoList($filter);
  			if ($result['html']) {
					$result['notify'] = 'Đã xóa';
					$result['status'] = 1;
				}
      }
    break;
    case 'active-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `'. PREFIX .'_info` set status = 1 where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = infoList($filter);
				if ($result['html']) {
					$result['notify'] = 'Đã lưu';
					$result['status'] = 1;
				}
      }
    break;
    case 'deactive-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `'. PREFIX .'_info` set status = 0 where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = infoList($filter);
				if ($result['html']) {
					$result['notify'] = 'Đã lưu';
					$result['status'] = 1;
				}
      }
    break;
    case 'remove':
			$filter = $nv_Request->get_array('filter', 'post');
			$id = $nv_Request->get_int('id', 'post', 0);

      if (!empty($id)) {
        $sql = 'delete from `'. PREFIX .'_info` where id = ' . $id;
        // die($sql);
        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['notify'] = 'Đã xóa';
          $result['html'] = infoList($filter);
        }
      }
    break;
    // case 'insert':
		// 	$filter = $nv_Request->get_array('filter', 'post');
		// 	$data = $nv_Request->get_array('data', 'post');

    //   $sql = 'insert into `'. PREFIX .'_info` (name, type, rate, status, xid) values("'.$data['name'].'", "'.$data['value'].'", 0, 1, 0)';
    //   if ($db->query($sql)) {
    //     $result['status'] = 1;
    //     $result['html'] = infoList($filter);
    //   }
    break;
    case 'filter':
			$filter = $nv_Request->get_array('filter', 'post');

			if ($db->query($sql)) {
				$result['html'] = infoList($filter);
				if ($result['html']) {
					$result['status'] = 1;
				}
			}
    break;
		case 'check':
			$id = $nv_Request->get_string('id', 'post');
			$filter = $nv_Request->get_array('filter', 'post');

			$sql = 'update `'. PREFIX .'_info` set status = 1 where id = ' . $id;
			if ($db->query($sql)) {
				$result['html'] = infoList($filter);
				if ($result['html']) {
					$result['status'] = 1;
				}
			}
		break;
		case 'uncheck':
			$id = $nv_Request->get_string('id', 'post');
			$filter = $nv_Request->get_array('filter', 'post');

			$sql = 'update `'. PREFIX .'_info` set status = 0 where id = ' . $id;
			if ($db->query($sql)) {
				$result['html'] = infoList($filter);
				if ($result['html']) {
					$result['status'] = 1;
				}
			}
		break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("intro.tpl", PATH);

$xtpl->assign('content', infoList());
$xtpl->assign('module_file', $module_file);
$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
include (NV_ROOTDIR . "/modules/". $module_file ."/layout/prefix.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
