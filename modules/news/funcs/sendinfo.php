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

$userinfo = getUserinfo();
if (empty($userinfo) || $userinfo['active'] == 0) {
	header('location: /'. $module_name .'/login/');
}
$userinfo['address'] = xdecrypt($userinfo['address']);
$userinfo['mobile'] = xdecrypt($userinfo['mobile']);

$filter = array(
	'keyword' => $nv_Request->get_string('keyword', 'get', '')
);

$page_title = 'Gửi thông tin chứng nhận';
$action = $nv_Request->get_string('action', 'post', '');
if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
		case 'send-info':
			$data = $nv_Request->get_array('data', 'post');
			$image = $nv_Request->get_array('image', 'post');

			// check các remind
			$data['species'] = checkRemind($data['species'], 'species2');
			$data['color'] = checkRemind($data['color'], 'color');
			$data['type'] = checkRemind($data['type'], 'type');
			$data['birthtime'] = totime($data['birthtime']);

			// insert vào bảng
			$sql = 'insert into `'. PREFIX .'_sendinfo` (userid, name, sex, birthtime, species, color, type, breeder, owner, image, mother, father) values("'. $userinfo['id'] .'", "'. $data['name'] .'", "'. $data['sex'] .'", "'. $data['birthtime'] .'", "'. $data['species'] .'", "'. $data['color'] .'", "'. $data['type'] .'", "'. $data['breeder'] .'", "'. $data['owner'] .'", "'. implode(',', $image) .'", '. $data['mother'] .', '. $data['father'] .')';
			if ($db->query($sql)) {
				// thông báo
				$result['status'] = 1;
				$result['html'] = sendinfoList();
			}
		break;
		case 'edit-info':
			$id = $nv_Request->get_int('id', 'post');
			$data = $nv_Request->get_array('data', 'post');

			// check các remind
			$data['species'] = checkRemind($data['species'], 'species2');
			$data['color'] = checkRemind($data['color'], 'color');
			$data['type'] = checkRemind($data['type'], 'type');
			$data['birthtime'] = totime($data['birthtime']);

			// cập nhật bảng
			$sql = 'update `'. PREFIX .'_sendinfo` set name = "'. $data['name'] .'", sex = "'. $data['sex'] .'", birthtime = "'. $data['birthtime'] .'", species = "'. $data['species'] .'", color = "'. $data['color'] .'", type = "'. $data['type'] .'", breeder = "'. $data['breeder'] .'", owner = "'. $data['owner'] .'", father = '. $data['father'] .', mother = '. $data['mother'] .' where id = ' . $id;
			if ($db->query($sql)) {
				// thông báo
				$result['status'] = 1;
				$result['html'] = sendinfoList();
			}
		break;
		case 'get-pet':
			$id = $nv_Request->get_int('id', 'post', '');
			$type = $nv_Request->get_string('type', 'post', '');
			$keyword = $nv_Request->get_string('keyword', 'post', '');

			$sql = 'select * from `'. PREFIX .'_sendinfo` where id = ' . $id;
			$query = $db->query($sql);
			$info = $query->fetch();

			$sql = 'select * from `'. PREFIX .'_pet` where name like "%'. $keyword .'%" and userid = '. $info['userid'] .' and sex = '. $type .' order by name limit 20';
			$query = $db->query($sql);
			$xtpl = new XTemplate('pet.tpl', PATH2);
			$xtpl->assign('type', $type);
			
			$check = true;
			while ($pet = $query->fetch()) {
				$check = false;
				$xtpl->assign('id', $pet['id']);
				$xtpl->assign('name', $pet['name']);
				$xtpl->parse('main.row');
			}
			if ($check) $xtpl->parse('main.no');
			$xtpl->parse('main');
      $result['status'] = 1;
			$result['html'] = $xtpl->text();
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

			$father = getPetById($info['father'])['name'];
			$mother = getPetById($info['mother'])['name'];

			$info['fathername'] = $father;
			$info['mothername'] = $mother;
			$info['birthtime'] = date('d/m/Y', $info['birthtime']);
			$info['species'] = getRemindId($info['species'])['name'];
			$info['color'] = getRemindId($info['color'])['name'];
			$info['type'] = getRemindId($info['type'])['name'];
			$info['image'] = explode(',', $info['image']);
			$result['status'] = 1;
			$result['data'] = $info;
		break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("main.tpl", PATH2);
$xtpl->assign('keyword', $filter['keyword']);
$xtpl->assign('modal', sendinfoModal());
$xtpl->assign('content', sendinfoList());

$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");
