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

$page_title = 'Gửi thông tin chứng nhận';
$action = $nv_Request->get_string('action', 'post', '');
if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
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
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("main.tpl", PATH2);

$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");
