<?php

/**
 * @Project Petcoffee-tech
 * @Chistua (hchieuthua@gmail.com)
 * @Copyright (C) 2019
 * @Createdate 21-03-2019 13:15
 */

if (! defined('NV_ADMIN') or ! defined('NV_MAINFILE') or ! defined('NV_IS_MODADMIN')) {
  die('Stop!!!');
}

define('NV_IS_ADMIN_FORM', true);
define("PATH", NV_ROOTDIR . "/modules/" . $module_file . '/template/admin/');
define("PATH2", NV_ROOTDIR . "/modules/" . $module_file . '/template/admin/' . $op);

require NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';
require NV_ROOTDIR . '/modules/' . $module_file . '/theme.php';
$select_array = array('breed' => 'Loài', 'disease' => 'Bệnh', 'origin' => 'Nguồn gốc', 'request' => 'Yêu cầu', 'species' => 'Giống', 'species2' => 'Giống loài', 'color' => 'Màu lông', 'type' => 'Kiểu lông');
$trade_array = array('1' => 'Cần bán', '2' => 'Cần phối');
$sex_data = array(0 => 'Đực', 'Cái');

function tradeList($filter = array('owner' => '', 'mobile' => '', 'address' => '', 'name' => '', 'species' => '', 'breed' => '', 'status' => 0 , 'type' => 0, 'page' => 1, 'limit' => 10)) {
  global $db, $module_file, $sex_array, $trade_array;

  $xtpl = new XTemplate('trade-list.tpl', PATH);

  $sql = 'select c.mobile, c.address, a.type, a.status, a.petid, a.id, b.species, b.breed, b.name, c.fullname from `'. PREFIX .'_trade` a inner join `'. PREFIX .'_pet` b on a.petid = b.id and b.type = 1 inner join `'. PREFIX .'_user` c on b.userid = c.id where c.fullname like "%'. $filter['owner'] .'%" and b.name like "%'. $filter['name'] .'%" and species like "%'. $filter['species'] .'%" and breed like "%'. $filter['breed'] .'%" '. ($filter['type'] > 0 ? ' and a.type = ' . ($filter['type']) : '') .' '. ($filter['status'] > 0 ? ' and a.status = ' . ($filter['status'] - 1) : '');
  $query = $db->query($sql);
  // $count = $query->fetch()['count'];
  // $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));

  // $sql = 'select * from `'. PREFIX .'_trade` where status < 2 order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  // $query = $db->query($sql);
  // $index = ($filter['page'] - 1) * $filter['limit'] + 1;
  $from = ($filter['page'] - 1) * $filter['limit'];
  $end = $from + $filter['limit'] + 1;
  $count = 0;

  while ($row = $query->fetch()) {
    $row['mobile'] = xdecrypt($row['mobile']);
    $row['address'] = xdecrypt($row['address']);
    if ((empty($filter['mobile']) || (mb_strpos($row['mobile'], $filter['mobile']) !== false)) && empty($filter['address']) || (mb_strpos($row['address'], $filter['address']) !== false)) {
      $count ++;

      if ($count > $from && $count < $end) {
        $type = $trade_array[$row['type']];
        $xtpl->assign('index', $count);
        $xtpl->assign('id', $row['id']);
        $xtpl->assign('petid', $row['petid']);
        // $xtpl->assign('image', $row['image']);
        $xtpl->assign('species', $row['species']);
        $xtpl->assign('breed', $row['breed']);
        $xtpl->assign('petname', $row['name']);
        $xtpl->assign('breed', $row['breed']);
        $xtpl->assign('owner', $row['fullname']);
        $xtpl->assign('address', $row['address']);
        $xtpl->assign('mobile', $row['mobile']);
        $xtpl->assign('type', $type);
        if ($row['status'] == 1) {
          $xtpl->parse('main.row.yes');
        }
        else {
          $xtpl->parse('main.row.no');
        }
        $xtpl->parse('main.row');
      }
    }
  }

  $xtpl->parse('main');
  return $xtpl->text();
}

function buyList2($filter = array('owner' => '', 'mobile' => '', 'address' => '', 'species' => '', 'breed' => '', 'status' => 0 , 'page' => 1, 'limit' => 10)) {
  global $db, $module_file, $sex_array, $trade_array;

  $xtpl = new XTemplate('buy-list.tpl', PATH);

  $sql = 'select a.*, c.mobile, c.address, c.fullname from `'. PREFIX .'_buy` a inner join `'. PREFIX .'_user` c on a.userid = c.id where c.fullname like "%'. $filter['owner'] .'%" and species like "%'. $filter['species'] .'%" and breed like "%'. $filter['breed'] .'%" '. ($filter['status'] > 0 ? ' and a.status = ' . ($filter['status'] - 1) : '');
  $query = $db->query($sql);
  // $count = $query->fetch()['count'];
  // $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));

  // $sql = 'select * from `'. PREFIX .'_buy` order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  // $query = $db->query($sql);
  // $index = ($filter['page'] - 1) * $filter['limit'] + 1;
  $from = ($filter['page'] - 1) * $filter['limit'];
  $end = $from + $filter['limit'] + 1;
  $count = 0;

  while ($row = $query->fetch()) {
    $row['mobile'] = xdecrypt($row['mobile']);
    $row['address'] = xdecrypt($row['address']);
    if ((empty($filter['mobile']) || (mb_strpos($row['mobile'], $filter['mobile']) !== false)) && empty($filter['address']) || (mb_strpos($row['address'], $filter['address']) !== false)) {
      $count ++;

      if ($count > $from && $count < $end) {
        $xtpl->assign('index', $count);
        $xtpl->assign('id', $row['id']);
        // $xtpl->assign('image', $row['image']);
        $xtpl->assign('species', $row['species']);
        $xtpl->assign('breed', $row['breed']);
        $xtpl->assign('sex', $sex_array[$row['sex']]);
        $xtpl->assign('owner', $row['fullname']);
        $xtpl->assign('address', $row['address']);
        $xtpl->assign('mobile', $row['mobile']);
        if ($row['status'] == 1) {
          $xtpl->parse('main.row.yes');
        }
        else {
          $xtpl->parse('main.row.no');
        }
        $xtpl->parse('main.row');
      }
    }
  }
  $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));

  $xtpl->parse('main');
  return $xtpl->text();
}

function remindList($filter = array('page' => 1, 'limit' => 10, 'keyword' => '', 'status' => 0, 'type' => '')) {
  global $db, $select_array, $module_file;

  $xtpl = new XTemplate('remind-list.tpl', PATH);
  $xtpl->assign('module_file', $module_file);

  $filter['status'] = intval($filter['status']);
  if (empty($filter['status'])) {
    $filter['status'] = '0, 1';
  }
  else {
    $filter['status'] = $filter['status'] - 1;
  }
  $xtra = '';
  if (!empty($filter['type']) && $filter['type'] != 'all') {
    $xtra .= 'and type = "'. $filter['type'] .'"';
  }

  $sql = 'select count(*) as count from `'. PREFIX .'_remind` where (name like "%'. $filter['keyword'] .'%" or type like "%'. $filter['keyword'] .'%") and visible in (' . $filter['status'] . ') ' . $xtra;
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));

  $sql = 'select * from `'. PREFIX .'_remind` where (name like "%'. $filter['keyword'] .'%" or type like "%'. $filter['keyword'] .'%") and visible in (' . $filter['status'] . ') '. $xtra .' order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  $index = ($filter['page'] - 1) * $filter['limit'] + 1;

  while ($row = $query->fetch()) {
    $xtpl->assign('index', $index++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('name', $row['name']);
    $xtpl->assign('type', $select_array[$row['type']]);
    $xtpl->assign('rate', $row['rate']);
    if ($row['visible']) {
      $xtpl->parse('main.row.no');
    }
    else {
      $xtpl->parse('main.row.yes');
    }

    $xtpl->parse('main.row');
  }

  $xtpl->parse('main');
  return $xtpl->text();
}

function diseaseList2($filter = array('page' => 1, 'limit' => 10, 'keyword' => '', 'status' => 0)) {
  global $db;

  $filter['status'] = intval($filter['status']);
  if (empty($filter['status'])) {
    $filter['status'] = '0, 1';
  }
  else {
    $filter['status'] = $filter['status'] - 1;
  }

  $xtpl = new XTemplate('disease-list.tpl', PATH);
  $sql = 'select count(*) as count from `'. PREFIX .'_disease_suggest` where disease like "%'. $filter['keyword'] .'%" and active in ('. $filter['status'] .') group by disease';
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));

  $sql = 'select * from `'. PREFIX .'_disease_suggest` where disease like "%'. $filter['keyword'] .'%" and active in ('. $filter['status'] .')  group by disease order by id desc, disease desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  $index = ($filter['page'] - 1) * $filter['limit'] + 1;

  while ($row = $query->fetch()) {
    $xtpl->assign('index', $index++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('disease', $row['disease']);
    $xtpl->assign('rate', $row['rate']);
    if ($row['active']) {
      $xtpl->parse('main.row.no');
    }
    else {
      $xtpl->parse('main.row.yes');
    }

    $xtpl->parse('main.row');
  }

  $xtpl->parse('main');
  return $xtpl->text();
}

function infoList($filter = array('customer' => '', 'mobile' => '', 'address' => '', 'owner' => '', 'species' => '', 'breed' => '', 'page' => 1, 'limit' => 10, 'keyword' => '', 'status' => 0)) {
  global $db, $module_file;

  $xtpl = new XTemplate('intro-list.tpl', PATH);
  $xtpl->assign('module_file', $module_file);

  $filter['status'] = intval($filter['status']);
  if (empty($filter['status'])) {
    $filter['status'] = '0, 1';
  }
  else {
    $filter['status'] = $filter['status'] - 1;
  }

  $xtra = ' a.fullname like "%'. $filter['customer'] .'%" and a.mobile like "%'. $filter['mobile'] .'%" and a.address like "%'. $filter['address'] .'%" and b.species like "%'. $filter['species'] .'%" and b.breed like "%'. $filter['breed'] .'%" and c.fullname like "%'. $filter['owner'] .'%"';

  $sql = 'select count(*) as count from ((select a.*, b.userid from `'. PREFIX .'_info` a inner join `'. PREFIX .'_pet` b on a.rid = b.id inner join `'. PREFIX .'_user` c on b.userid = c.id where (a.type = 1 or a.type = 3) and a.status in ('. $filter['status'] .') and '. $xtra .') union (select a.*, b.userid from `'. PREFIX .'_info` a inner join `'. PREFIX .'_buy` b on a.rid = b.id inner join `'. PREFIX .'_user` c on b.userid = c.id where a.type = 2 and a.status in ('. $filter['status'] .') and '. $xtra .')) as c';
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));

  $sql = 'select * from ((select a.*, b.userid from `'. PREFIX .'_info` a inner join `'. PREFIX .'_pet` b on a.rid = b.id inner join `'. PREFIX .'_user` c on b.userid = c.id where (a.type = 1 or a.type = 3) and a.status in ('. $filter['status'] .') and '. $xtra .') union (select a.*, b.userid from `'. PREFIX .'_info` a inner join `'. PREFIX .'_buy` b on a.rid = b.id inner join `'. PREFIX .'_user` c on b.userid = c.id where a.type = 2 and a.status in ('. $filter['status'] .') and '. $xtra .') order by id desc) as c limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  $index = ($filter['page'] - 1) * $filter['limit'] + 1;

  while ($row = $query->fetch()) {
    $owner = getOwnerById($row['userid']);
    $xtpl->assign('index', $index++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('target', $row['fullname']);
    $xtpl->assign('address', $row['address']);
    $xtpl->assign('mobile', $row['mobile']);
    $xtpl->assign('note', $row['note']);
    if ($row['type'] == 2) {
      $sql = 'select * from `'. PREFIX .'_buy` where id = ' . $row['rid'];
      $query = $db->query($sql);
      $row2 = $query->fetch();
      $owner2 = getOwnerById($row2['userid']);
      $owner2['mobile'] = xdecrypt($owner2['mobile']);
      $xtpl->assign('from', $owner2['fullname']);
      $xtpl->assign('mobile2', $owner2['mobile']);
      $xtpl->assign('petname', '');
      $xtpl->assign('breed', $row2['breed']);
    }
    else {
      $pet = getPetById($row['rid']);
      $owner2 = getOwnerById($pet['userid']);
      $owner2['mobile'] = xdecrypt($owner2['mobile']);
      $xtpl->assign('from', $owner2['fullname']);
      $xtpl->assign('mobile2', $owner2['mobile']);
      $xtpl->assign('petname', $pet['name']);
      $xtpl->assign('breed', $pet['breed']);
    }
    if ($row['status']) {
      $xtpl->parse('main.row.no');
    }
    else {
      $xtpl->parse('main.row.yes');
    }

    switch ($row['type']) {
      case 1:
        $xtpl->assign('type', 'Cần bán');
      break;
      case 2:
        $xtpl->assign('type', 'Cần mua');
      break;
      default:
      $xtpl->assign('type', 'Cần phối');
    }
    $xtpl->parse('main.row');
  }

  $xtpl->parse('main');
  return $xtpl->text();
}

function centerList($filter = array('page' => 1, 'limit' => 10, 'keyword' => '', 'status' => 0)) {
  global $db, $module_file;

  $xtpl = new XTemplate('center-list.tpl', PATH);
  $xtpl->assign('module_file', $module_file);

  $filter['status'] = intval($filter['status']);
  if (empty($filter['status'])) {
    $filter['status'] = '0, 1';
  }
  else {
    $filter['status'] = $filter['status'] - 1;
  }

  $sql = 'select count(*) as count from `'. PREFIX .'_user` where (fullname like "%'. $filter['keyword'] .'%") and center in (' . $filter['status'] . ')';
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));

  $sql = 'select * from `'. PREFIX .'_user` where (fullname like "%'. $filter['keyword'] .'%") and center in (' . $filter['status'] . ') order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  $index = ($filter['page'] - 1) * $filter['limit'] + 1;

  while ($row = $query->fetch()) {
    // $row['mobile'] = xdecr
    $xtpl->assign('index', $index++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('fullname', $row['fullname']);
    $xtpl->assign('mobile', $row['mobile']);
    $xtpl->assign('address', $row['address']);
    $xtpl->assign('politic', $row['politic']);

    $xtpl->parse('main.row');
  }

  $xtpl->parse('main');
  return $xtpl->text();
}

function requestList($filter = array('keyword' => '', 'page' => 1, 'limit' => 10, 'status' => 0)) {
  global $db, $request_array, $module_file;

  $time = time();
  if (empty($filter['atime'])) {    
    $filter['atime'] = date('d/m/Y', $time - 60 * 60 * 24 * 30);
  }
  if (empty($filter['ztime'])) {    
    $filter['ztime'] = date('d/m/Y', $time);
  }
  $filter['atime'] = totime($filter['atime']);
  $filter['ztime'] = totime($filter['ztime']);

  $xtpl = new XTemplate('request-list.tpl', PATH);
  $xtpl->assign('module_file', $module_file);
  // die(PATH);

  $filter['status'] = intval($filter['status']);
  if (empty($filter['status'])) {
    $filter['status'] = '0, 1, 2';
  }
  else {
    $filter['status'] = $filter['status'] - 1;
  }

  $sql = 'select count(*) as count from `'. PREFIX .'_request` a inner join `'. PREFIX .'_pet` b on a.petid = b.id inner join `'. PREFIX .'_user` c on b.userid = c.id where (b.name like "%'. $filter['keyword'] .'%" or c.fullname like "%'. $filter['keyword'] .'%") and a.status in (' . $filter['status'] . ')';
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));

  $sql = 'select a.*, b.name, c.fullname, c.mobile, c.address from `'. PREFIX .'_request` a inner join `'. PREFIX .'_pet` b on a.petid = b.id inner join `'. PREFIX .'_user` c on b.userid = c.id  where (b.name like "%'. $filter['keyword'] .'%" or c.fullname like "%'. $filter['keyword'] .'%") and a.status in (' . $filter['status'] . ') order by a.id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  $index = ($filter['page'] - 1) * $filter['limit'] + 1;

  while ($row = $query->fetch()) {
    $xtpl->assign('index', $index++);
    // if ($row['type'] == 2) {
    //   $sql = 'select * from `'. PREFIX .'_remind` where type = "request" and id = ' . $row['value'];
    // }
    // else {
    //   $sql = 'select * from `'. PREFIX .'_remind` where type = "request" and xid = ' . $row['value'];
    // }
    $sql = 'select * from `'. PREFIX .'_remind` where type = "request" and id = ' . $row['value'];

    // die($sql);
    $query2 = $db->query($sql);
    $remind = $query2->fetch();
    $row['mobile'] = xdecrypt($row['mobile']);
    $row['address'] = xdecrypt($row['address']);

    $xtpl->assign('id', $row['id']);
    $xtpl->assign('pet', $row['name']);
    $xtpl->assign('owner', $row['fullname']);
    $xtpl->assign('mobile', $row['mobile']);
    $xtpl->assign('address', $row['address']);
    $xtpl->assign('type', $remind['name']);
    switch ($row['status']) {
      case 0:
        $xtpl->assign('color', 'red');
      break;
      case 1:
        $xtpl->assign('color', '');
        $xtpl->parse('main.row.tick');
      break;
      case 2:
        $xtpl->assign('color', 'green');
      break;
      default:
        $xtpl->assign('color', '');
    }

    $xtpl->parse('main.row');
  }

  $xtpl->parse('main');
  return $xtpl->text();
}

function userRowList($filter = array('username' => '', 'fullname' => '', 'mobile' => '', 'address' => '', 'status' => 0, 'page' => 1, 'limit' => 10)) {
  global $db, $user_info, $module_file;

  $xtpl = new XTemplate('user-list.tpl', PATH);
  $xtpl->assign('module_file', $module_file);

  $filter['fullname'] = mb_strtolower($filter['fullname']);
  $sql = 'select id, username, fullname, address, mobile, active from `'. PREFIX .'_user` where lower(fullname) like "%'. $filter['fullname'] .'%" and username like "%'. $filter['username'] .'%" ' . ($filter['status'] > 0 ? ' and active = ' . ($filter['status'] - 1) : '') . ' order by id desc';
  $query = $db->query($sql);

  $from = ($filter['page'] - 1) * $filter['limit'];
  $end = $from + $filter['limit'] + 1;
  $count = 0;

  while ($row = $query->fetch()) {
    $row['address'] = xdecrypt($row['address']);
    $row['mobile'] = xdecrypt($row['mobile']);
    if ((empty($filter['mobile']) || (mb_strpos($row['mobile'], $filter['mobile']) !== false)) && (empty($filter['address']) || (mb_strpos($row['address'], $filter['address']) !== false))) {
      $count ++;

      if ($count > $from && $count < $end) {
        $xtpl->assign('index', $count);
        $xtpl->assign('fullname', $row['fullname']);
        $xtpl->assign('username', $row['username']);
        $xtpl->assign('address', $row['address']);
        $xtpl->assign('mobile', $row['mobile']);
        $xtpl->assign('id', $row['id']);

        if ($row['active']) {
          $xtpl->parse('main.row.uncheck');
        }
        else {
          $xtpl->parse('main.row.check');
        }
        $xtpl->parse('main.row');
      }
    }
  }
  $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));
  $xtpl->parse('main');
  return $xtpl->text();
}

function getUserInfo($userid) {
  global $db;

  $sql = 'select * from `'. PREFIX .'_user` where id = ' . $userid;
  $query = $db->query($sql);

  return $query->fetch();
}

function managerList($filter = array('page' => 1, 'limit' => 10)) {
  global $db;

  $index = ($filter['page'] - 1) * $filter['limit'] + 1;
  $xtpl = new XTemplate('manager-list.tpl', PATH);

  $sql = 'select count(*) as count from `'. PREFIX .'_user` where view = 1 or manager = 1';
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList2($count, $filter['page'], $filter['limit'], 'goPage2'));

  $sql = 'select * from `'. PREFIX .'_user` where view = 1 or manager = 1 order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  // $data = getUserPetList($filter);

  while ($row = $query->fetch()) {
    $row['mobile'] = xdecrypt($row['mobile']);
    $row['address'] = xdecrypt($row['address']);
    $allow = array();
    if ($row['view'] == 1) $allow[] = 'Nội bộ';
    if ($row['manager'] == 1) $allow[] = 'Quản lý';
    $xtpl->assign('index', $index++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('allow', implode(', ', $allow));
    $xtpl->assign('name', $row['fullname']);
    $xtpl->assign('mobile', $row['mobile']);
    $xtpl->assign('address', $row['address']);
    $xtpl->assign('time', ctime($row['time']));
    $xtpl->parse('main.row');
  }
  $xtpl->parse('main');
  return $xtpl->text();
}

function userDogRow($filter = array('owner' => '', 'mobile' => '', 'name' => '', 'species' => '', 'breed' => '', 'micro' => '', 'miear' => '', 'status' => 0, 'page' => 1, 'limit' => 10)) {
  global $db, $user_info, $module_file, $sex_array;
  $index = ($filter['page'] - 1) * $filter['limit'] + 1;
  $xtpl = new XTemplate('pet-list.tpl', PATH);
  $xtpl->assign('module_file', $module_file);

  $x = $_SERVER['HTTP_REFERER'];
  $y = substr($x, 0, strpos($x, '/', 8));

  $xtpl->assign('url', $y);

  $sql = 'select * from `'. PREFIX .'_pet` where name like "%'. $filter['name'] .'%" and species like "%'. $filter['species'] .'%" and breed like "%'. $filter['breed'] .'%" and microchip like "%'. $filter['micro'] .'%" and miear like "%'. $filter['miear'] .'%" ' . ($filter['status'] > 0 ? ' and active = ' . ($filter['status'] - 1) : '') . ' order by id desc';
  $query = $db->query($sql);
  // $count = $query->fetch()['count'];

  // $sql = 'select * from `'. PREFIX .'_pet` where name like "%'. $filter['keyword'] .'%"' . ($filter['status'] > 0 ? ' and active = ' . ($filter['status'] - 1) : '') . ' order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  // $query = $db->query($sql);

  // $data = getUserPetList($filter);
  $from = ($filter['page'] - 1) * $filter['limit'];
  $end = $from + $filter['limit'] + 1;
  $count = 0;

  while ($row = $query->fetch()) {
    $owner = getUserInfo($row['userid']);
    $owner['mobile'] = xdecrypt($owner['mobile']);
    if (empty($filter['mobile']) || (mb_strpos($owner['mobile'], $filter['mobile']) !== false)) {
      $count ++;

      if ($count > $from && $count < $end) {
        $xtpl->assign('index', $count);
        $xtpl->assign('id', $row['id']);
        $xtpl->assign('price', $row['price']);
        $xtpl->assign('name', $row['name']);
        $xtpl->assign('owner', $owner['fullname']);
        $xtpl->assign('mobile', $owner['mobile']);
        $xtpl->assign('userid', $row['userid']);
        $xtpl->assign('id', $row['id']);
        $xtpl->assign('microchip', $row['microchip']);
        $xtpl->assign('breed', $row['breed']);
        $xtpl->assign('sex', $sex_array[$row['sex']]);
        $xtpl->assign('dob', cdate($row['dateofbirth']));
        $sql = 'select * from `'. PREFIX .'_lock` where petid = ' . $row['id'];
        $query2 = $db->query($sql);
        if (!empty($query2->fetch())) {
          $xtpl->parse('main.row.unlock');
        }
        else {
          $xtpl->parse('main.row.lock');
        }
        if ($row['active']) {
          if ($row['ceti'] == 1) {
            $xtpl->parse('main.row.uncheck.yes');
          }
          else {
            $xtpl->parse('main.row.uncheck.no');
          }
          $xtpl->parse('main.row.uncheck');
        }
        else {
          $xtpl->parse('main.row.check');
        }
        $xtpl->parse('main.row');
      }
    }
  }
  $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));

  $xtpl->parse('main');
  return $xtpl->text();
}

function reviewList($filter = array('page' => 1, 'limit' => 10)) {
  global $db;

  $index = ($filter['page'] - 1) * $filter['limit'] + 1;
  $xtpl = new XTemplate('review-list.tpl', PATH);

  $sql = 'select count(*) as count from `'. PREFIX .'_review`';
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));

  $sql = 'select * from `'. PREFIX .'_review` order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);

  while ($row = $query->fetch()) {
    $xtpl->assign('username', $row['username']);
    if ($row['userid'] > 0) {
      $owner = getUserInfo($row['userid']);
      $xtpl->assign('username', $owner['username']);
    }
    $xtpl->assign('index', $index++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('content', $row['content']);
    $xtpl->assign('time', date('d/m/Y H:i:s', $row['time']));
    $xtpl->parse('main.row');
  }
  $xtpl->parse('main');
  return $xtpl->text();
}

function getUserPetList($filter, $limit) {
  global $db;

  $list = array();
  $sql = 'select * from `'. PREFIX .'_pet` where name like "%'. $filter['keyword'] .'%"' . ($filter['status'] > 0 ? ' and active = ' . ($filter['status'] - 1) : '') . ' limit ' . $limit['limit'] . ' offset ' . ($limit['page'] - 1) * $limit['limit'];
  $query = $db->query($sql);

  while ($row = $query->fetch()) {
    $list[] = $row;
  }

  return $list;
}

function checkUsername($user) {
  global $db;

  $sql = 'select * from `'. PREFIX .'_user` where username = "'. $user . '"';
  $query = $db->query($sql);

  if (!empty($query->fetch())) {
    return true;
  }
  return false;
}

function checkLogin($username, $password = '') {
  global $db;

  $sql = 'select * from ' . PREFIX . '_user where username = "' . $username . '" and password = "' . md5($password) . '"';
  $query = $db->query($sql);

  if (!empty($checker = $query->fetch())) {
    return $checker;
  }
  return false;
}

function sendinfoModal() {
  global $userinfo;
  $xtpl = new XTemplate('modal.tpl', PATH2);
  $sign = getSign();
  foreach ($sign as $row) {
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('name', $row['name']);
    $xtpl->parse('main.sign');
  }
  $xtpl->assign('sign_content', signContent());
  $xtpl->parse('main');
  return $xtpl->text();
}

function sendinfoContent() {
  global $db, $userinfo, $sex_data, $filter;
  $xtpl = new XTemplate('list.tpl', PATH2);
  $filter['status'] --;

  $sql = 'select * from `'. PREFIX .'_sendinfo` where '. ($filter['status'] >= 0 ? ' active = ' . $filter['status'] . ' and ' : '') .' (active2 = 0 or active2 = 2) order by id desc';

  $query = $db->query($sql);
  $list = array();
  $number = 0;

  // nếu filter.keyword rỗng, không thực hiện lọc
  // kiểm tra owner, nếu không tồn tại dùng thông tin userinfo

  while ($row = $query->fetch()) {
    $owner = getContactId($row['owner']);
    if (empty($owner)) {
      $userinfo = checkUserinfo($row['userid'], 1);
      $userinfo['mobile'] = xdecrypt($userinfo['mobile']);
      $row['fullname'] = $userinfo['fullname'];
      $row['mobile'] = $userinfo['mobile'];
    }
    else {
      $row['fullname'] = $owner['fullname'];
      $row['mobile'] = $owner['mobile'];
    }
    if (empty($filter['keyword'])) $list []= $row;
    else if ((mb_strpos($row['fullname'], $filter['keyword']) !== false) || (strpos($row['mobile'], $filter['keyword']) !== false)) {
      $list []= $row;
    }
  }
  
  $from = ($filter['page'] - 1) * $filter['limit'];
  $end = $from + $filter['limit'];
  for ($i = $from; $i < $end; $i++) { 
    if (empty($list[$i])) break;
    else $row = $list[$i];
    $species = getRemindId($row['species']);
    $xtpl->assign('index', $i + 1);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('user', $row['fullname']);
    $xtpl->assign('mobile', $row['mobile']);
    $xtpl->assign('name', $row['name']);
    $xtpl->assign('regno', $row['regno']);
    $xtpl->assign('micro', $row['micro']);
    $xtpl->assign('species', $species['name']);
    $xtpl->assign('sex', $sex_data[$row['sex']]);
    $xtpl->assign('birthtime', date('d/m/Y', $row['birthtime']));
    if (!$row['active']) {
      $xtpl->parse('main.row.done');
    }
    $xtpl->parse('main.row');
  }

  $xtpl->assign('nav', nav_generater('/admin32/index.php?nv=news&op=sendinfo', count($list), $filter['page'], $filter['limit']));
  $xtpl->parse('main');
  return $xtpl->text();
}

function petContent() {
  global $db, $userinfo, $filter, $module_file, $sex_array;
  $xtpl = new XTemplate('list.tpl', PATH2);
  $xtpl->assign('module_file', $module_file);
  $filter['status'] --;

  $sql = 'select * from `'. PREFIX .'_sendinfo` where active2 > 0 ' . ($filter['status'] >= 0 ? ' and active = ' . $filter['status'] : '') . ' order by time desc';
  $query = $db->query($sql);
  $list = array();

  $filter['name'] = mb_strtolower($filter['name']);
  $filter['species'] = mb_strtolower($filter['species']);
  $filter['mc'] = mb_strtolower($filter['mc']);
  $filter['username'] = mb_strtolower($filter['username']);
  $filter['owner'] = mb_strtolower($filter['owner']);
  $filter['mobile'] = mb_strtolower($filter['mobile']);

  while ($row = $query->fetch()) {
    $row['user'] = getUserInfo($row['userid']);
    $row['owner'] = getContactId($row['owner'], $row['userid']);
    $row['species'] = getRemindId($row['species'])['name'];
    $row['user']['mobile'] = xdecrypt($row['user']['mobile']);

    if (!empty($row['user']) && !empty($row['owner'])) {
      $name = mb_strtolower($row['name']);
      $species = mb_strtolower($row['species']);
      $micro = mb_strtolower($row['micro']);
      $username = mb_strtolower($row['user']['username']);
      $fullname = mb_strtolower($row['owner']['fullname']);
      $mobile = mb_strtolower($row['user']['mobile']);

      $c1 = empty($filter['name']) || (mb_strpos($name, $filter['name']) !== false);
      $c2 = empty($filter['species']) || (mb_strpos($species, $filter['species']) !== false);
      $c3 = empty($filter['mc']) || (mb_strpos($micro, $filter['mc']) !== false);
      $c4 = empty($filter['username']) || (mb_strpos($username, $filter['username']) !== false);
      $c5 = empty($filter['owner']) || (mb_strpos($fullname, $filter['owner']) !== false);
      $c6 = empty($filter['mobile']) || (mb_strpos($mobile, $filter['mobile']) !== false);

      if ($c1 && $c2 && $c3 && $c4 && $c5 && $c6) $list []= $row;
    }
  }

  $from = ($filter['page'] - 1) * $filter['limit'];
  $end = $from + $filter['limit'];

  for ($i = $from; $i < $end; $i++) { 
    if (empty($list[$i])) break;
    $row = $list[$i];

    $xtpl->assign('id', $row['id']);
    $xtpl->assign('username', $row['user']['fullname']);
    $xtpl->assign('owner', $row['owner']['fullname']);
    $xtpl->assign('mobile', $row['user']['mobile']);
    $xtpl->assign('name', $row['name']);
    $xtpl->assign('species', $row['species']);
    // var_dump($row);die();
    $xtpl->assign('micro', $row['micro']);

    $lock = checkPetlock($row['id']);
    if (!empty($lock)) $xtpl->parse('main.row.unlock');
    else $xtpl->parse('main.row.lock');

    if ($row['active']) {
      $xtpl->assign('ceti_btn', 'btn-info');
      $certify = checkCertify($row['id']);
      if (!empty($certify)) {
        $xtpl->assign('ceti_btn', 'btn-warning');
      }
      $xtpl->parse('main.row.uncheck');
    }
    else {
      $xtpl->parse('main.row.check');
    }
    $xtpl->parse('main.row');
  }
  
  $glit = json_decode(json_encode($filter), true);
  $glit['status']++;
  unset($glit['page']);
  unset($glit['limit']);
  $xtpl->assign('nav', nav_generater('/admin32/index.php?nv=news&op=pet&' . http_build_query($glit), count($list), $filter['page'], $filter['limit']));
  $xtpl->parse('main');
  return $xtpl->text();
}

function petModal() {
  global $position;
  $xtpl = new XTemplate('modal.tpl', PATH2);

  foreach ($position as $l1i => $l1) {
    $xtpl->assign('l1name', $l1->{'name'});
    $xtpl->assign('l1id', $l1i);
    $xtpl->parse('main.l1');
    foreach ($l1->{'district'} as $l2i => $l2) {
      $xtpl->assign('l2name', $l2);
      $xtpl->assign('l2id', $l2i);
      $xtpl->parse('main.l2.l2c');
    }
  
    $xtpl->assign('active', '');
    if ($l1i == '1') {
      $xtpl->assign('active', 'display: none');
    }
    $xtpl->parse('main.l2');
  }
  
  $xtpl->parse('main');
  return $xtpl->text();
}

function signContent() {
  global $db;
  $xtpl = new XTemplate('sign-list.tpl', PATH2);

  $sign = getSign();
  $index = 1;
  foreach ($sign as $row) {
    $xtpl->assign('index', $index ++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('name', $row['name']);
    $xtpl->parse('main.row');
  }
  
  $xtpl->parse('main');
  return $xtpl->text();
}

function statisticCollect() {
  global $db, $sex_array, $filter;

  $index = ($filter['page'] - 1) * $filter['limit'] + 1;
  $xtpl = new XTemplate('list.tpl', PATH2);

  $sql = 'select count(*) as count from `'. PREFIX .'_certify`';
  $query = $db->query($sql);
  $count = $query->fetch()['count'];

  $sql = 'select * from `'. PREFIX .'_certify` order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  // $data = getUserPetList($filter);

  while ($row = $query->fetch()) {
    $pet = getPetinfoId($row['petid']);
    $user = getUserinfoId($pet['userid']);
    $xtpl->assign('cid', $row['id']);
    $xtpl->assign('id', $pet['id']);
    $xtpl->assign('name', $pet['name']);
    $xtpl->assign('fullname', $user['fullname']);
    $xtpl->assign('microchip', $pet['micro']);
    $xtpl->assign('sex', $pet['sex']);
    $xtpl->assign('species', $pet['species']);
    $xtpl->assign('price', number_format($row['price'], 0, '', ','));
    $xtpl->assign('time', date('d/m/Y', $row['time']));
    $xtpl->parse('main.row');
  }

  $xtpl->assign('nav', nav_generater('/admin32/index.php?nv=news&op=revenue&type=' . $filter['type'], $count, $filter['page'], $filter['limit']));
  $xtpl->parse('main');
  return $xtpl->text();
}

function revenueContent() {
  global $filter;

  if ($filter['type'] == 1) {
    return statisticCollect();
  }
  return statisticPay();
}

function revenueModal() {
  global $db;

  $xtpl = new XTemplate("modal.tpl", PATH2);

  $sql = 'select * from `'. PREFIX .'_user` where view = 1';
  $query = $db->query($sql);
  
  while ($row = $query->fetch()) {
    $xtpl->assign('userid', $row['id']);
    $xtpl->assign('username', $row['fullname']);
    $xtpl->parse('main.user');
  }
  $xtpl->assign('statistic_content', statisticContent());
  
  $xtpl->parse('main');
  return $xtpl->text();
}

function statisticPay() {
  global $db, $sex_array, $filter;
  $index = ($filter['page'] - 1) * $filter['limit'] + 1;
  $xtpl = new XTemplate('pay-list.tpl', PATH2);

  $sql = 'select count(*) as count from `'. PREFIX .'_pay`';
  $query = $db->query($sql);
  $count = $query->fetch()['count'];

  $sql = 'select * from `'. PREFIX .'_pay` order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  // $data = getUserPetList($filter);

  while ($row = $query->fetch()) {
    $owner = getUserinfoId($row['userid']);
    $xtpl->assign('index', $index++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('price', number_format($row['price'], 0, '', ','));
    $xtpl->assign('content', $row['content']);
    $xtpl->assign('fullname', $owner['fullname']);
    $xtpl->assign('time', date('d/m/Y', ($row['time'])));
    $xtpl->parse('main.row');
  }
  $xtpl->assign('nav', nav_generater('/admin32/index.php?nv=news&op=revenue&type=' . $filter['type'], $count, $filter['page'], $filter['limit']));
  $xtpl->parse('main');
  return $xtpl->text();
}

function statisticContent($filter = array('from' => '', 'to' => '')) {
  global $db;

  $xtpl = new XTemplate('content.tpl', PATH2);

  $check = 0;
  if (empty($filter['from'])) {
    $check += 1;
  }
  if (empty($filter['end'])) {
    $check += 2;
  }

  $xtra = '';
  switch ($check) {
    case 1:
      $filter['end'] = totime($filter['end']) + 60 * 60 * 24 - 1;
      $xtra = 'where time < ' . $filter['end'];
      $xtpl->assign('to', 'đến ngày ' . date('d/m/Y', $filter['end']));
      break;
    case 2:
      $filter['from'] = totime($filter['from']);
      $xtra = 'where time > ' . $filter['from'];
      $xtpl->assign('from', 'từ ngày ' . date('d/m/Y', $filter['from']));
      break;
    case 0:
      $filter['from'] = totime($filter['from']);
      $filter['end'] = totime($filter['end']) + 60 * 60 * 24 - 1;
      $xtpl->assign('from', 'từ ngày ' . date('d/m/Y', $filter['from']));
      $xtpl->assign('to', 'đến ngày ' . date('d/m/Y', $filter['end']));
      $xtra = 'where time between ' . $filter['from'] . ' and ' . $filter['end'];
      break;
  }

  $p1 = 0;
  $sql = 'select sum(price) as p from `'. PREFIX .'_certify` ' . $xtra;
  $query = $db->query($sql);
  if ($row = $query->fetch()) {
    $p1 = $row['p'];
  }
  
  $p2 = 0;
  $sql2 = 'select sum(price) as p from `'. PREFIX .'_pay` ' . $xtra;
  $query = $db->query($sql2);
  if ($row = $query->fetch()) {
    $p2 = $row['p'];
  }

  $xtpl->assign('total_revenue', number_format($p1, 0, '', ','));
  $xtpl->assign('total_pay', number_format($p2, 0, '', ','));
  $xtpl->assign('sum', number_format($p1 - $p2, 0, '', ','));

  $xtpl->parse('main');
  return $xtpl->text();
}
