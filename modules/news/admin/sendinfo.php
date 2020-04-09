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

$page_title = "Quản lý yêu cầu";

$action = $nv_Request->get_string('action', 'post', '');

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
		case 'edit-info':
			$id = $nv_Request->get_int('id', 'post');
			$data = $nv_Request->get_array('data', 'post');

			// check các remind
			$data['species'] = checkRemind($data['species'], 'species2');
			$data['color'] = checkRemind($data['color'], 'color');
			$data['type'] = checkRemind($data['type'], 'type');
			$data['birthtime'] = totime($data['birthtime']);

			// cập nhật bảng
			$sql = 'update `'. PREFIX .'_sendinfo` set name = "'. $data['name'] .'", sex = "'. $data['sex'] .'", birthtime = "'. $data['birthtime'] .'", species = "'. $data['species'] .'", color = "'. $data['color'] .'", type = "'. $data['type'] .'", breeder = "'. $data['breeder'] .'", owner = "'. $data['owner'] .'" where id = ' . $id;
			if ($db->query($sql)) {
				// thông báo
				$result['status'] = 1;
				$result['html'] = sendinfoContent();
			}
		break;
		case 'get-remind':
			$keyword = $nv_Request->get_string('keyword', 'post', '');
			$type = $nv_Request->get_string('type', 'post', '');

			$sql = 'select * from `'. PREFIX .'_remind` where type = "'. $type .'" and visible = 1 and name like "%'. $keyword .'%" order by rate limit 20';
			$query = $db->query($sql);
			$xtpl = new XTemplate('remind.tpl', PATH2);
			$xtpl->assign('type', $type);

			$check = true;
			while ($remind = $query->fetch()) {
				$check = false;
				$xtpl->assign('name', $remind['name']);
				$xtpl->parse('main.row');
			}
			if ($check) $xtpl->parse('main.no');
			$xtpl->parse('main');
      $result['status'] = 1;
			$result['html'] = $xtpl->text();
		break;
		case 'get-info':
			$id = $nv_Request->get_int('id', 'post');

			$sql = 'select * from `'. PREFIX .'_sendinfo` where id = ' . $id;
			$query = $db->query($sql);
			$info = $query->fetch();
			$info['birthtime'] = date('d/m/Y', $info['birthtime']);
			$info['species'] = getRemindId($info['species'])['name'];
			$info['color'] = getRemindId($info['color'])['name'];
			$info['type'] = getRemindId($info['type'])['name'];
			$info['image'] = explode(',', $info['image']);
			$result['status'] = 1;
			$result['data'] = $info;
		break;
		case 'done':
			$id = $nv_Request->get_int('id', 'post');
			$micro = $nv_Request->get_string('micro', 'post');

			$sql = 'select * from `'. PREFIX .'_sendinfo` where id = ' . $id;
			$query = $db->query($sql);
			$info = $query->fetch();

			$species = getRemindId($info['species'])['name'];
			$color = getRemindId($info['color'])['name'];
			$breed = substr($species, 0, strpos($species, ' '));
			$species = checkRemind($species, 'species');
			$breed = checkRemind($breed, 'breed');

			$sql = 'update `'. PREFIX .'_sendinfo` set active = 1 where id = ' . $id;
			$sql2 = 'insert into `'. PREFIX .'_pet` (name, dateofbirth, species, breed, sex, color, microchip, miear, image, active, userid, breeder, origin, fid, mid, type, graph, sell, breeding, time, ceti, price, ctime, youtube) values("'. $info['name'] .'", '. $info['birthtime'] .', '. $species .', '. $breed .', '. $info['sex'] .', "'. $color .'", "'. $micro .'", "", "'. $info['image'] .'", 1, '. $info['userid'] .', 0, "", "", "", 1, "", 0, 0, '. time() .', 0, 0, 0, "")';
			if ($db->query($sql) && $db->query($sql2)) {
				// thông báo
				$result['status'] = 1;
				$result['html'] = sendinfoContent();
			}
		break;
	}
	echo json_encode($result);
	die();
}
$xtpl = new XTemplate("main.tpl", PATH2);

$xtpl->assign('content', sendinfoContent());
$xtpl->assign('modal', sendinfoModal());
$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
include (NV_ROOTDIR . "/modules/". $module_file ."/layout/prefix.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");