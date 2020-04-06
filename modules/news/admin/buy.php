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

$page_title = "Duyệt bài đăng";

$action = $nv_Request->get_string('action', 'post', '');

if (!empty($action)) {
  $result = array('status' => 0);
  switch ($action) {
    case 'push':
      $id = $nv_Request->get_string('id', 'post', '0');

      $sql = 'update `'. PREFIX .'_buy` set time = '. time() .' where id = ' . $id;
      if ($db->query($sql)) {
        $result['status'] = 1;
        $result['notify'] = 'Đã đưa lên đầu trang';
      }
    break;
    case 'remove-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'delete from `'. PREFIX .'_buy` where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = buyList2($filter);
  			if ($result['html']) {
					$result['notify'] = 'Đã xóa';
					$result['status'] = 1;
				}
      }
    break;
    case 'active-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `'. PREFIX .'_buy` set status = 1 where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = buyList2($filter);
				if ($result['html']) {
					$result['notify'] = 'Đã lưu';
					$result['status'] = 1;
				}
      }
    break;
    case 'deactive-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `'. PREFIX .'_buy` set status = 0 where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = buyList2($filter);
				if ($result['html']) {
					$result['notify'] = 'Đã lưu';
					$result['status'] = 1;
				}
      }
    break;
    case 'get-buy':
      $id = $nv_Request->get_string('id', 'post');

      $sql = 'select * from `'. PREFIX .'_buy` where id = ' . $id;
      $query = $db->query($sql);
      if (!empty($row = $query->fetch())) {
        $result['data'] = $row;
        $result['status'] = 1;
      }
    break;
    case 'buy':
      $id = $nv_Request->get_string('id', 'post');
      $data = $nv_Request->get_array('data', 'post');
      $filter = $nv_Request->get_array('filter', 'post');

      $data['sex'] --;

      $sql = 'update `'. PREFIX .'_buy` set '. sqlBuilder($data, BUILDER_EDIT) .', time = '. time() .' where id = ' . $id;
      $result['html'] = buyList2($filter);
      if ($db->query($sql) && $result['html']) {
        $result['status'] = 1;
        $result['notify'] = 'Đã thêm cần mua';
      }
    break;
    case 'filter':
      $filter = $nv_Request->get_array('filter', 'post');

      if (count($filter) > 1) {
        $result['html'] = buyList2($filter);
        if ($result['html']) {
          $result['status'] = 1;
        }
      }
    break;
    case 'check':
      $id = $nv_Request->get_string('id', 'post');
      $filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `' . PREFIX . '_buy` set status = 1, time = '. time() .' where id = ' . $id;
      if ($db->query($sql)) {
        $result['html'] = buyList2($filter);
        if ($result['html']) {
          $result['status'] = 1;
        }
      }
    break;
    case 'uncheck':
      $id = $nv_Request->get_string('id', 'post');
      $filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `' . PREFIX . '_buy` set status = 0 where id = ' . $id;
      if ($db->query($sql)) {
        $result['html'] = buyList2($filter);
        if ($result['html']) {
          $result['status'] = 1;
        }
      }
    break;
    case 'remove':
      $id = $nv_Request->get_string('id', 'post');
      $filter = $nv_Request->get_array('filter', 'post');

      $sql = 'delete from `' . PREFIX . '_buy` where id = ' . $id;
      if ($db->query($sql)) {
        $result['html'] = buyList2($filter);
        if ($result['html']) {
          $result['status'] = 1;
        }
      }
    break;
  }
  echo json_encode($result);
  die();
}

$xtpl = new XTemplate("buy.tpl", PATH);
$xtpl->assign('content', buyList2());
$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
include (NV_ROOTDIR . "/modules/" . $module_file . "/layout/prefix.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
