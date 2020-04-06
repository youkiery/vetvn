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

$page_title = "Danh sách gợi nhớ";

$action = $nv_Request->get_string('action', 'post', '');

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'remove-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'delete from `'. PREFIX .'_remind` where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = remindList($filter);
  			if ($result['html']) {
					$result['notify'] = 'Đã xóa';
					$result['status'] = 1;
				}
      }
    break;
    case 'active-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `'. PREFIX .'_remind` set visible = 1 where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = remindList($filter);
				if ($result['html']) {
					$result['notify'] = 'Đã lưu';
					$result['status'] = 1;
				}
      }
    break;
    case 'deactive-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `'. PREFIX .'_remind` set visible = 0 where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = remindList($filter);
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
        $sql = 'delete from `'. PREFIX .'_remind` where id = ' . $id;
        // die($sql);
        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['html'] = remindList($filter);
        }
      }
    break;
    case 'edit':
			$filter = $nv_Request->get_array('filter', 'post');
			$data = $nv_Request->get_array('data', 'post');
			$id = $nv_Request->get_int('id', 'post', 0);

      if (!empty($id)) {
        $sql = 'update `'. PREFIX .'_remind` set name = "'. $data['name'] .'", type = "'. $data['value'] .'" where id = ' . $id;
        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['html'] = remindList($filter);
        }
      }
    break;
    case 'insert':
			$filter = $nv_Request->get_array('filter', 'post');
			$data = $nv_Request->get_array('data', 'post');

      $sql = 'insert into `'. PREFIX .'_remind` (name, type, rate, visible, xid) values("'.$data['name'].'", "'.$data['value'].'", 0, 1, 0)';
      if ($db->query($sql)) {
        $result['status'] = 1;
        $result['html'] = remindList($filter);
      }
    break;
    case 'filter':
			$filter = $nv_Request->get_array('filter', 'post');

			if ($db->query($sql)) {
				$result['html'] = remindList($filter);
				if ($result['html']) {
					$result['status'] = 1;
				}
			}
    break;
		case 'check':
			$id = $nv_Request->get_string('id', 'post');
			$filter = $nv_Request->get_array('filter', 'post');

			$sql = 'update `'. PREFIX .'_remind` set visible = 1 where id = ' . $id;
			if ($db->query($sql)) {
				$result['html'] = remindList($filter);
				if ($result['html']) {
					$result['status'] = 1;
				}
			}
		break;
		case 'no-check':
			$id = $nv_Request->get_string('id', 'post');
			$filter = $nv_Request->get_array('filter', 'post');

			$sql = 'update `'. PREFIX .'_remind` set visible = 0 where id = ' . $id;
			if ($db->query($sql)) {
				$result['html'] = remindList($filter);
				if ($result['html']) {
					$result['status'] = 1;
				}
			}
		break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("remind.tpl", PATH);

$sql = 'select * from `'. PREFIX .'_remind` group by type';
$query = $db->query($sql);

$xtpl->assign('name', 'all');
$xtpl->assign('value', 'Toàn bộ');
$xtpl->parse('main.sel');
$xtpl->parse('main.sele');
while ($row = $query->fetch()) {
  $xtpl->assign('name', $row['type']);
  $xtpl->assign('value', $select_array[$row['type']]);
  $xtpl->parse('main.sel');
  $xtpl->parse('main.sele');
}

$reversal = array();
foreach ($select_array as $name => $value) {
  $reversal[$value] = $name;
}

$xtpl->assign('reversal', json_encode($reversal));
$xtpl->assign('content', remindList());
$xtpl->assign('module_file', $module_file);
$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
include (NV_ROOTDIR . "/modules/". $module_file ."/layout/prefix.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
