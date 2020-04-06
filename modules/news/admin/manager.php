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
define('BUILDER_EDIT', 2);

$page_title = "Danh sách quản lý";

$action = $nv_Request->get_string('action', 'post', '');

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'deactive-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `'. PREFIX .'_remind` set view = 0, manager = 1 where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = remindList($filter);
				if ($result['html']) {
					$result['notify'] = 'Đã lưu';
					$result['status'] = 1;
				}
      }
    break;
    case 'filter':
      $filter = $nv_Request->get_array('filter', 'post');

      $html = managerList($filter);
      if (!empty($html)) {
        $result['html'] = $html;
        $result['status'] = 1;
        $result['notify'] = 'Đã lưu';
      }
    break;
    case 'insert':
      $filter = $nv_Request->get_array('filter', 'post');
      $data = $nv_Request->get_array('data', 'post');

      if (!empty($owner = getOwnerById($data['id']))) {
        $sql = 'update `'. PREFIX .'_user` set view = '. $data['p1'] .', manager = '. $data['p2'] .' where id = ' . $data['id'];
        if ($db->query($sql)) {
          $html = managerList($filter);
          if (!empty($html)) {
            $result['html'] = $html;
          }
          $result['status'] = 1;
          $result['notify'] = 'Đã lưu';
        }
      }
    break;
    case 'remove':
      $filter = $nv_Request->get_array('filter', 'post');
      $id = $nv_Request->get_int('id', 'post', 0);

      if (!empty($owner = getOwnerById($id))) {
        $sql = 'update `'. PREFIX .'_user` set view = 0, manager = 0 where id = ' . $id;
        if ($db->query($sql)) {
          $html = managerList($filter);
          if (!empty($html)) {
            $result['html'] = $html;
          }
          $result['status'] = 1;
          $result['notify'] = 'Đã lưu';
        }
      }
    break;
    case 'owner':
			$keyword = $nv_Request->get_string('keyword', 'post', '');

			$sql = 'select * from `'. PREFIX .'_user`';
			$query = $db->query($sql);

			$html = '';
      $count = 0;
      // checkMobile
			while (($row = $query->fetch()) && $count < 10) {
        if (checkMobile($row['mobile'], $keyword) || mb_strpos($row['fullname'], $keyword)) {
          $html .= '
          <div class="suggest_item" onclick="pickOwner(\''. $row['fullname'] .'\', '. $row['id'] .')">
            <p>
            '. $row['fullname'] .'
            </p>
          </div>
          ';
          $count ++;
        }
			}

			if (empty($html)) {
				$html = 'Không có kết quả trùng khớp';
			}

			$result['status'] = 1;
			$result['html'] = $html;
		break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("manager.tpl", PATH);

$xtpl->assign('content', managerList());

$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
include (NV_ROOTDIR . "/modules/". $module_file ."/layout/prefix.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");