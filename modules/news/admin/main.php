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

$page_title = "Quản lý chíp";

$step = $nv_Request->get_int('s', 'get', 1);

$xtpl = new XTemplate("main.tpl", PATH);
$xtpl->assign('module_file', $module_file);

$last_month = time() - 60 * 60 * 24 * 30;
// new member
$sql = 'select count(*) as count from `'. PREFIX .'_user` where time > ' . $last_month;
$count = $db->query($sql)->fetch();
$xtpl->assign('user_new', $count['count']);
// active member
$sql = 'select count(*) as count from `'. PREFIX .'_user` where active = 1';
$count = $db->query($sql)->fetch();
$xtpl->assign('user_active', $count['count']);
// total member
$sql = 'select count(*) as count from `'. PREFIX .'_user`';
$count = $db->query($sql)->fetch();
$xtpl->assign('user_total', $count['count']);
// new pet
$sql = 'select count(*) as count from `'. PREFIX .'_pet` where time > ' . $last_month;
$count = $db->query($sql)->fetch();
$xtpl->assign('pet_new', $count['count']);
// new pet
$sql = 'select count(*) as count from `'. PREFIX .'_pet` where active = 1';
$count = $db->query($sql)->fetch();
$xtpl->assign('pet_active', $count['count']);
// new total
$sql = 'select count(*) as count from `'. PREFIX .'_pet`';
$count = $db->query($sql)->fetch();
$xtpl->assign('pet_total', $count['count']);
// new request
$sql = 'select count(*) as count from `'. PREFIX .'_request` where status = 1';
$count = $db->query($sql)->fetch();
$xtpl->assign('request_new', $count['count']);
// recent request
$sql = 'select count(*) as count from `'. PREFIX .'_request` where time > ' . $last_month;
$count = $db->query($sql)->fetch();
$xtpl->assign('request_recent', $count['count']);
// remind new
$sql = 'select count(*) as count from `'. PREFIX .'_remind` where visible = 0';
$count = $db->query($sql)->fetch();
$xtpl->assign('remind_new', $count['count']);
// remind recent
// $sql = 'select count(*) as count from `'. PREFIX .'_remind` where time > ' . $last_month;
// $count = $db->query($sql)->fetch();
// $xtpl->assign('remind_recent', $count['count']);
// vaccine suggest new
$sql = 'select count(*) as count from `'. PREFIX .'_disease_suggest` where active = 0';
$count = $db->query($sql)->fetch();
$xtpl->assign('vaccine_new', $count['count']);
// transfer total
$sql = 'select count(*) as count from `'. PREFIX .'_transfer`';
$count = $db->query($sql)->fetch();
$xtpl->assign('transfer_count', $count['count']);
// sell total
$sql = 'select count(*) as count from `'. PREFIX .'_pet` where sell = 1';
$count = $db->query($sql)->fetch();
$xtpl->assign('sell_count', $count['count']);
// breeding total
$sql = 'select count(*) as count from `'. PREFIX .'_pet` where breeding = 1';
$count = $db->query($sql)->fetch();
$xtpl->assign('breeding_count', $count['count']);

// $xtpl->assign('remind', json_encode(getRemind()));
$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
include (NV_ROOTDIR . "/modules/". $module_file ."/layout/prefix.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
