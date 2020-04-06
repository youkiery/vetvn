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

$page_title = "Gợi ý tiêm phòng";

$action = $nv_Request->get_string('action', 'post', '');

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
        case 'remove-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'delete from `'. PREFIX .'_disease_suggest` where id in ('. $list .')' ;
      if ($db->query($sql)) {
				$result['html'] = diseaseList2($filter);
  			if ($result['html']) {
					$result['notify'] = 'Đã xóa';
					$result['status'] = 1;
				}
      }
    break;
    case 'active-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `'. PREFIX .'_disease_suggest` set active = 1 where id in ('. $list .')' ;
      if ($db->query($sql)) {
				$result['html'] = diseaseList2($filter);
				if ($result['html']) {
					$result['notify'] = 'Đã lưu';
					$result['status'] = 1;
				}
      }
    break;
    case 'deactive-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `'. PREFIX .'_disease_suggest` set active = 0 where id in ('. $list .')' ;
      if ($db->query($sql)) {
				$result['html'] = diseaseList2($filter);
				if ($result['html']) {
					$result['notify'] = 'Đã lưu';
					$result['status'] = 1;
				}
      }
    break;
		case 'check':
			$id = $nv_Request->get_string('id', 'post');
			$filter = $nv_Request->get_array('filter', 'post');

      $disease = getDiseaseById($id);
			$sql = 'update `'. PREFIX .'_disease_suggest` set active = 1 where disease = "' . $disease['disease'] . '"';
			if ($db->query($sql)) {
				$result['html'] = diseaseList2($filter);
				if ($result['html']) {
					$result['status'] = 1;
				}
			}
		break;
		case 'uncheck':
			$id = $nv_Request->get_string('id', 'post');
			$filter = $nv_Request->get_array('filter', 'post');

      $disease = getDiseaseById($id);
			$sql = 'update `'. PREFIX .'_disease_suggest` set active = 0 where disease = "' . $disease['disease'] . '"';
			if ($db->query($sql)) {
				$result['html'] = diseaseList2($filter);
				if ($result['html']) {
					$result['status'] = 1;
				}
			}
    case 'filter':
			$filter = $nv_Request->get_array('filter', 'post');

			if ($db->query($sql)) {
				$result['html'] = diseaseList2($filter);
				if ($result['html']) {
					$result['status'] = 1;
				}
			}
    break;
    case 'remove':
			$filter = $nv_Request->get_array('filter', 'post');
			$id = $nv_Request->get_int('id', 'post', 0);

      if (!empty($id)) {
        $disease = getDiseaseById($id);
        $sql = 'delete from `'. PREFIX .'_disease_suggest` where disease = "' . $disease['disease'] . '"';
        // die($sql);
        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['notify'] = 'Đã xóa';
          $result['html'] = diseaseList2($filter);
        }
      }
    break;
    case 'edit':
			$filter = $nv_Request->get_array('filter', 'post');
			$id = $nv_Request->get_int('id', 'post', 0);
			$name = $nv_Request->get_string('name', 'post', '');

      if (!empty($id) && !empty($name)) {
        $disease = getDiseaseById($id);
        $sql = 'update `'. PREFIX .'_disease_suggest` set disease = "'. $name .'" where disease = "' . $disease['disease'] . '"';
        // die($sql);
        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['notify'] = 'Đã cập nhật';
          $result['html'] = diseaseList2($filter);
        }
      }
    break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("disease.tpl", PATH);

$xtpl->assign('content', diseaseList2());
$xtpl->assign('module_file', $module_file);
$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
include (NV_ROOTDIR . "/modules/". $module_file ."/layout/prefix.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");