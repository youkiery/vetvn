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

require NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';
require NV_ROOTDIR . '/modules/' . $module_file . '/theme.php';
$select_array = array('breed' => 'Loài', 'disease' => 'Bệnh', 'origin' => 'Nguồn gốc', 'request' => 'Yêu cầu', 'species' => 'Giống');
$trade_array = array('1' => 'Cần bán', '2' => 'Cần phối');

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
    if ((empty($filter['mobile'] || (mb_strpos($row['mobile'], $filter['mobile']) !== false))) && empty($filter['address'] || (mb_strpos($row['address'], $filter['address']) !== false))) {
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
    if ((empty($filter['mobile'] || (mb_strpos($row['mobile'], $filter['mobile']) !== false))) && empty($filter['address'] || (mb_strpos($row['address'], $filter['address']) !== false))) {
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

  $sql = 'select id, username, fullname, address, mobile from `'. PREFIX .'_user` where fullname like "%'. $filter['fullname'] .'%" and username like "%'. $filter['username'] .'%" ' . ($filter['status'] > 0 ? ' and active = ' . ($filter['status'] - 1) : '');
  $query = $db->query($sql);
  // $count = $query->fetch()['count'];
  // $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));

  // $sql = 'select * from `'. PREFIX .'_user` where fullname like "%'. $filter['keyword'] .'%"' . ($filter['status'] > 0 ? ' and active = ' . ($filter['status'] - 1) : '') . ' order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  // die($sql);
  // $query = $db->query($sql);
  $from = ($filter['page'] - 1) * $filter['limit'];
  $end = $from + $filter['limit'] + 1;
  $count = 0;

  while ($row = $query->fetch()) {
    $row['address'] = xdecrypt($row['address']);
    $row['mobile'] = xdecrypt($row['mobile']);
    if ((empty($filter['mobile'] || (mb_strpos($row['mobile'], $filter['mobile']) !== false))) && (empty($filter['address'] || (mb_strpos($row['address'], $filter['address']) !== false)))) {
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
    if (empty($filter['mobile'] || (mb_strpos($owner['mobile'], $filter['mobile']) !== false))) {
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
