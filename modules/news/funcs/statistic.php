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
define('BUILDER_EDIT', 2);

$page_title = "Quản lý thu chi";

$action = $nv_Request->get_string('action', 'post', '');

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'filter':
      $filter = $nv_Request->get_array('filter', 'post');

      if ($db->query($sql)) {
        if ($filter['type'] == 1) {
          $result['html'] = revenue($filter);
        } 
        else {
          $result['html'] = paylist($filter);
        }
        if ($result['html']) {
          $result['status'] = 1;
        }
      }
    break;
    case 'get':
      $id = $nv_Request->get_string('id', 'post', 0);

      $sql = 'select * from `' . PREFIX . '_pet` where id = ' . $id;
      $query = $db->query($sql);

      if (!empty($row = $query->fetch())) {
        $result['data'] = array('name' => $row['name'], 'dob' => date('d/m/Y', $row['dateofbirth']), 'species' => $row['species'], 'breed' => $row['breed'], 'color' => $row['color'], 'microchip' => $row['microchip'], 'parentf' => $row['fid'], 'parentm' => $row['mid'], 'miear' => $row['miear'], 'origin' => $row['origin']);
        $result['more'] = array('breeder' => $row['breeder'], 'sex' => intval($row['sex']), 'm' => getPetNameId($row['mid']), 'f' => getPetNameId($row['fid']), 'userid' => $row['userid'], 'username' => getOwnerById($row['userid'], $row['type'])['fullname']);
        $result['image'] = $row['image'];
        $result['status'] = 1;
      } else {
        $result['notify'] = 'Có lỗi xảy ra';
      }
      break;
    case 'pet':
      $userid = $nv_Request->get_string('userid', 'post', '');
			$keyword = $nv_Request->get_string('keyword', 'post', '');
      $html = '';

      if (!empty(getOwnerById($userid))) {
        $sql = 'select * from `'. PREFIX .'_pet` where name like "%'. $keyword .'%"';
        $query = $db->query($sql);

        while ($row = $query->fetch()) {
          $html .= '
            <div class="suggest_item" onclick="pickPet(\''. $row['name'] .'\', '. $row['id'] .')">
              <p>
              '. $row['name'] .'
              </p>
            </div>
          ';
        }

        if (empty($html)) {
          $html = 'Không có kết quả trùng khớp';
        }
      }
      else {
        $html = 'Chưa chọn chủ thú cưng';
      }

			$result['status'] = 1;
			$result['html'] = $html;
		break;
    case 'statistic':
      $filter = $nv_Request->get_array('filter', 'post');

      $html = statistic($filter);
      if (!empty($html)) {
        $result['status'] = 1;
        $result['html'] = $html;
      }
		break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("statistic.tpl", PATH);

$xtpl->assign('content', revenue());

$sql = 'select * from `'. PREFIX .'_user` where view = 1';
$query = $db->query($sql);

while ($row = $query->fetch()) {
  $xtpl->assign('userid', $row['id']);
  $xtpl->assign('username', $row['fullname']);
  $xtpl->parse('main.user');
}

$xtpl->assign('statistic', statistic());
$xtpl->assign('url', '/' . $module_name . '/' . $op . '/');
$xtpl->assign('module_file', $module_file);
$xtpl->parse("main");
$contents = $xtpl->text("main");

include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");
