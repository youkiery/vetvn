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

$page_title = "In giấy chứng nhận";
$userinfo = getUserInfo();
if (empty($userinfo)) {
  header('location: /news/login');
}

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'filter':
      $filter = $nv_Request->get_array('filter', 'post');

      if (!empty($html = buyList($filter))) {
        $result['status'] = 1;
        $result['html'] = $html;
      }
    break;
    case 'get-print':
      $id = $nv_Request->get_int('id', 'post', 0);

      $query = $db->query('select * from `'. PREFIX .'_pet` where id = ' . $id);
      if (empty($row = $query->fetch())) {
        $result['notify'] = 'Thú cưng không tồn tại';
      }
      else {
        $query = $db->query('select * from `'. PREFIX .'_print` where rid = ' . $id);
        $print = $query->fetch();
        $owner = getOwnerById($row['userid']);
        // var_dump($owner);die();
        $data = array('regno' => '', 'micro' => $row['microchip'], 'tatto' => $row['miear'], 'name' => $row['name'], 'species' => $row['species'], 'sex' => $row['sex'], 'dob' => date('d/m/Y', $row['dob']), 'coat' => '', 'color' => '', 'breeder' => $row['owner'], 'owner' => $owner['fullname'], 'issue' => date('d/m/Y'));
        if (!empty($print)) {
          $data['regno'] = $print['regno'];
          $data['color'] = $print['color'];
          $data['coat'] = $print['coat'];
          $data['breeder'] = $print['breeder'];
          $data['issue'] = date('d/m/Y', $print['issue']);
        }
        $result['status'] = 1;
        $result['data'] = $data;
      }
    break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("ceti-print.tpl", "modules/". $module_name ."/template/block");
$xtpl->assign('content', cetiList());

$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_name ."/layout/footer.php");
