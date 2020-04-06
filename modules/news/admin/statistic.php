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

$page_title = "Thống kê thu chi";

$action = $nv_Request->get_string('action', 'post', '');

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'filter':
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

$xtpl->assign('content', statistic());

$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
include (NV_ROOTDIR . "/modules/". $module_file ."/layout/prefix.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
