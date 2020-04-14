<?php

/**
 * @Project Petcoffee-tech
 * @Chistua (hchieuthua@gmail.com)
 * @Copyright (C) 2019
 * @Createdate 21-03-2019 13:15
 */

if (!defined('NV_SYSTEM')) {
  die('Stop!!!');
}

define('NV_IS_FORM', true); 
define("PATH", 'modules/' . $module_file . '/template');
define("PATH2", NV_ROOTDIR . '/modules/' . $module_file . '/template/user/' . $op);

require NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';
$buy_sex = array('Sao cũng được', 'Đực', 'Cái');
$sex_data = array(0 => 'Đực', 'Cái');
$fc = array('sendinfo');
$fa = array('login', 'signup', 'recover', 'checking-key', 'change-pass', 'send-contact', 'filter', 'send-review');
$action = $nv_Request->get_string('action', 'post', '');

// kiểm tra các post ajax
if (!empty($action)) {
  // nếu thuộc mảng fc thì tiếp tục
  // nếu không, kiểm tra các post có phải là các action trong fa hoặc là thành viên
  if (in_array($op, $fc)) {
    // bỏ qua
  }
  else if ( !in_array($action, $fa) && empty($userinfo = getUserInfo())) {
    die('{"status": -1}');
  }
}

function mainContent() {
    global $db, $sex_array, $module_file;
    $index = 1;
    $xtpl = new XTemplate('list.tpl', PATH2);
    $xtpl->assign('module_file', $module_file);
  
    $sql = 'select * from `'. PREFIX .'_pet` where active > 0 order by time desc limit 12';
    $query = $db->query($sql);
  
    $time = time();
    $year = 60 * 60 * 24 * 365.25;
  
    while ($row = $query->fetch()) {
      $owner = getOwnerById($row['userid'], $row['type']);
      $xtpl->assign('index', $index++);
      $xtpl->assign('image', $row['image']);
      $xtpl->assign('name', $row['name']);
      $xtpl->assign('owner', $owner['fullname']);
      $xtpl->assign('id', $row['id']);
      $xtpl->assign('image', $row['image']);
      $xtpl->assign('microchip', $row['microchip']);
      $xtpl->assign('breed', $row['breed']);
      $xtpl->assign('species', $row['species']);
      $xtpl->assign('sex', $sex_array[$row['sex']]);
      $xtpl->assign('age', parseAgeTime($row['dateofbirth']));
      if ($row['ceti'] == 1) {
        $xtpl->parse('main.row.ddc');
      }
      // $xtpl->assign('dob', cdate($row['dateofbirth']));
      $xtpl->parse('main.row');
    }
    $xtpl->parse('main');
    return $xtpl->text();
}

function getPetListById($userid) {
  global $db;

  $query = $db->query($sql = 'select id from `'. PREFIX .'_pet` where userid = ' . $userid);
  $list = array();
  while ($row = $query->fetch()) {
    $list[] = $row['id'];
  }
  // die(var_dump($row));
  return implode(', ', $list);
}

function parseMonth($number) {
  $year = round($number / 12);
  $month = round($number - $year * 12);
  if ($year > 0) {
    return 'khoảng ' . $year . ' năm ' . $month . ' tháng';
  }
  return 'khoảng ' . $month . ' tháng';
}

function getUserInfo() {
  global $db, $_SESSION;
  $data = array();

  if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    // hash split username, password
    if (checkLogin($username, $password)) {
      $sql = 'select * from `'. PREFIX .'_user` where username = "' . $username . '" and password = "' . md5($password) . '"';
      $query = $db->query($sql);
      
      if (!empty($row = $query->fetch())) {
        return $row;
      }
    }
  }

  return $data;
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

function getPetRequest($petid, $type = -1) {
  global $db;

  if ($type >= 0) {
    $sql = 'select * from `'. PREFIX .'_request` where petid = ' . $petid . ' and type = 1 and value = ' . $type . ' order by time';
    $query = $db->query($sql);

    if (!empty($row = $query->fetch())) {
      return $row;
    }
    return array();
  }
  $list = array();
  $sql = 'select * from `'. PREFIX .'_request` where petid = ' . $petid . ' order by time';
  $query = $db->query($sql);

  while ($row = $query->fetch()) {
    $list[] = $row;
  }

  return $list;
}

function parseLink($info) {
  global $module_name;
  if (!empty($info['id'])) {
    return '<a href="/'.$module_name.'/detail/?id=' . $info['id'] . '">' . $info['name'] . '</a>';
  }
  return '-';
}

function parseLink2($info) {
  global $module_name;
  if (!empty($info['id'])) {
    return '<a href="/'.$module_name.'/info/?id=' . $info['id'] . '">' . $info['name'] . '</a>';
  }
  return '-';
}

function parseInfo($info) {
  if (!empty($info['id'])) {
    $age = round( time() - $info['dateofbirth']) / 60 / 60 / 24 / 365.25;
    if ($age < 1) {
      $age = 1;
    }
    return 'Tên: '. $info['name'] .'<br>Tuổi: '. $age .'<br>Giống: '. $info['species'] .'<br>Loài: '. $info['breed'] .'<br>';
  }
  return '';
}

function userRowList($filter = array()) {
  global $db, $user_info, $module_file;

  $xtpl = new XTemplate('user-list.tpl', PATH);
  $xtpl->assign('module_file', $module_file);
  $sql = 'select * from `'. PREFIX .'_user` where fullname like "%'. $filter['keyword'] .'%"' . ($filter['status'] > 0 ? ' and active = ' . ($filter['status'] - 1) : '') . ' order by id desc';
  $query = $db->query($sql);
  $index = 1;

  while ($row = $query->fetch()) {
    $data['mobile'] = xdecrypt($data['mobile']);
    $data['address'] = xdecrypt($data['address']);
    $xtpl->assign('index', $index ++);
    $xtpl->assign('fullname', $row['fullname'] ++);
    $xtpl->assign('address', $row['address']);
    $xtpl->assign('mobile', $row['mobile']);
    $xtpl->assign('id', $row['id']);

    if (!empty($user_info) && !empty($user_info['userid']) && (in_array('1', $user_info['in_groups']) || in_array('2', $user_info['in_groups']))) {

      if ($row['active']) {
        $xtpl->parse('main.row.uncheck');
      }
      else {
        $xtpl->parse('main.row.check');
      }
    }
    $xtpl->parse('main.row');
  }

  $xtpl->parse('main');
  return $xtpl->text();
}

function userDogRow($userid = 0, $filter = array('keyword' => '', ), $limit = array('page' => 0, 'limit' => 10)) {
  global $db, $user_info, $module_file;
  $index = 1;
  $xtpl = new XTemplate('dog-list.tpl', PATH);
  $xtpl->assign('module_file', $module_file);

  $data = getUserPetList($userid, $filter, $limit);

  foreach ($data as $row) {
    $xtpl->assign('index', $index++);
    $xtpl->assign('name', $row['name']);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('microchip', $row['microchip']);
    $xtpl->assign('breed', $row['breed']);
    $xtpl->assign('sex', $row['sex']);
    $xtpl->assign('dob', cdate($row['dateofbirth']));
    if (!empty($user_info) && !empty($user_info['userid']) && (in_array('1', $user_info['in_groups']) || in_array('2', $user_info['in_groups']))) {
      if ($row['active']) {
        $xtpl->parse('main.row.mod.uncheck');
      }
      else {
        $xtpl->parse('main.row.mod.check');
      }
    }
    $xtpl->parse('main.row.mod');
    $xtpl->parse('main.row');
  }
  $xtpl->parse('main');
  return $xtpl->text();
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

// checkMost($row, $stat) {
//   if (in_array($row['species'], $stat['species'])) {
//     if (empty($stat['species'])) {
//       $stat['species'][$row['species']] = 0;
//     }
//     $stat['species'][$row['species']] ++;
//   }

// }

// function checkUser($username) {
//   global $db;

//   $sql = 'select * from ' . PREFIX . '_user where username = "' . $username . '"';
//   die($sql);

//   if (!empty($checker = $query->fetch())) {
//     return $checker;
//   }
//   return false;
// }

function breederList($petid) {
  global $db, $module_file;

  $sql = 'select * from `'. PREFIX .'_breeder` where petid = '. $petid .' order by time desc';
  $query = $db->query($sql);
  $xtpl = new XTemplate('breeder.tpl', PATH);
  $xtpl->assign('module_file', $module_file);
  $index = 1;

  while (!empty($row = $query->fetch())) {
    $pet = getPetById($row['targetid']);
    $owner = getOwnerById($pet['userid'], $pet['type']);

    $xtpl->assign('index', $index++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('time', date('d/m/Y', $row['time']));
    $xtpl->assign('target', $pet['name']);
    $xtpl->assign('owner', $owner['fullname']);
    $xtpl->assign('number', $row['number']);
    $xtpl->assign('note', ($row['note']));
    $xtpl->parse('main.row');
  }
  $xtpl->parse('main');
  return $xtpl->text();
}

function checkTransferRequest($id) {
  global $db;

  $sql = 'select * from `'. PREFIX .'_transfer_request` where id = ' . $id;
  $query = $db->query($sql);

  if ($row = $query->fetch()) {
    return $row;
  }
  return false;
}

function getUserPetList($userid, $tabber, $filter) {
  global $db;

  $list = array();
  $sql = 'select count(*) as count from `'. PREFIX .'_pet` where id not in ( select id from ((select mid as id from `'. PREFIX .'_pet`) union (select fid as id from `'. PREFIX .'_pet`)) as a) and userid = ' . $userid . ' and type = 1 and sell = 0 and name like "%'. $filter['keyword'] .'%" and breeder in ('. implode(', ', $tabber) .') order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  $count = $query->fetch();

  // $sql = 'select * from `'. PREFIX .'_pet` where userid = ' . $userid . ' and type = 1 and name like "%'. $filter['keyword'] .'%" and breeder in ('. implode(', ', $tabber) .') order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $sql = 'select * from `'. PREFIX .'_pet` where id not in ( select id from ((select mid as id from `'. PREFIX .'_pet`) union (select fid as id from `'. PREFIX .'_pet`)) as a) and userid = ' . $userid . ' and type = 1 and sell = 0 and name like "%'. $filter['keyword'] .'%" and breeder in ('. implode(', ', $tabber) .') order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  // die($sql);
  $query = $db->query($sql);

  while ($row = $query->fetch()) {
    $list[] = $row;
  }

  return array(
    'count' => $count['count'],
    'list' => $list
  );
}

function getParent($data) {
  return array('f' => getPetById($data['fid']), 'm' => getPetById($data['mid']));
}

function getAllParent($data) {
  $parent = array();
  $list = array();
  $parent['f1'] = array('p' => checkParent(getParent($data)));
  $parent['f2'] = array (
    'f21' => checkParent((!empty($parent['f1']['f'])) ? getParent($parent['f1']['f']) : 0),
    'f22' => checkParent((!empty($parent['f1']['f'])) ? getParent($parent['f1']['m']) : 0)
  );
  $parent['f3'] = array (
    'f31' => checkParent((!empty($parent['f2']['f21']['f'])) ? getParent($parent['f2']['f21']['f']) : 0),
    'f32' => checkParent((!empty($parent['f2']['f21']['m'])) ? getParent($parent['f2']['f21']['m']) : 0),
    'f33' => checkParent((!empty($parent['f2']['f22']['f'])) ? getParent($parent['f2']['f22']['f']) : 0),
    'f34' => checkParent((!empty($parent['f2']['f22']['m'])) ? getParent($parent['f2']['f22']['m']) : 0)
  );

  return $parent;
}

function checkParent($data) {
  if (!empty($data) && (!empty($data['f'] || !empty($data['m'])))) {
    return $data;
  }
  return false;
}

function getParentTree($data) {
  global $db;

  $list = array();
  $papa = getPetById($data['mid']);
  $mama = getPetById($data['fid']);

  if (!empty($papa)) {
    $list[] = $papa;
  }
  if (!empty($mama)) {
    $list[] = $mama;
  }
  return $list;
}

function contactList($userid, $filter = array('page' => 1, 'limit' => 10)) {
  global $db;

  $xtpl = new XTemplate('contact-list.tpl', PATH);

  $sql = 'select count(*) as count from `'. PREFIX .'_contact` where userid = ' . $userid;
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));

  $sql = 'select * from `'. PREFIX .'_contact` where userid = '. $userid .' order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  $index = ($filter['page'] - 1) * $filter['limit'] + 1;

  while ($row = $query->fetch()) {
    $row['address'] = xdecrypt($row['address']);
    $row['mobile'] = xdecrypt($row['mobile']);
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

function contactContent($userid, $filter = array('page' => 1, 'limit' => 10)) {
  global $db;

  $xtpl = new XTemplate('contact-content.tpl', PATH);

  $sql = 'select count(*) as count from `'. PREFIX .'_pet` where userid = ' . $userid . ' and type = 2';
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList2($count, $filter['page'], $filter['limit'], 'goPage2'));

  $sql = 'select * from `'. PREFIX .'_pet` where userid = '. $userid .' and type = 2 order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  $index = ($filter['page'] - 1) * $filter['limit'] + 1;

  while ($row = $query->fetch()) {
    $xtpl->assign('index', $index++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('name', $row['name']);
    $xtpl->assign('species', $row['species']);
    $xtpl->assign('breed', $row['breed']);
    $xtpl->parse('main.row');
  }

  $xtpl->parse('main');
  return $xtpl->text();
}

function getNoteGroupByUserid() {
  return 0;
}

function generateRandomString($length = 8) {
    // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function sendinfoModal() {
  global $userinfo;
  $xtpl = new XTemplate('modal.tpl', PATH2);
  // var_dump($userinfo);die();

  $str = $userinfo['fullname'] .', '. $userinfo['address'] . ', ' . $userinfo['a1'] . ', ' . $userinfo['a2'];
  $xtpl->assign('info', mytrim($str));

  $xtpl->parse('main');
  return $xtpl->text();
}

function sendinfoList() {
  global $db, $userinfo, $sex_data, $filter;
  $xtpl = new XTemplate('list.tpl', PATH2);
  $filter['status'] --;
  $sql = 'select count(*) as count from `'. PREFIX .'_sendinfo` where name like "%'. $filter['keyword'] .'%" and userid = ' . $userinfo['id'] . ' '. ($filter['status'] >= 0 ? ' and active = ' . $filter['status'] : '');
  $query = $db->query($sql);
  $number = $query->fetch()['count'];

  $sql = 'select * from `'. PREFIX .'_sendinfo` where name like "%'. $filter['keyword'] .'%" and userid = ' . $userinfo['id'] . ' '. ($filter['status'] >= 0 ? ' and active = ' . $filter['status'] : '') .' order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];

  $index = ($filter['page'] - 1) * $filter['limit'] + 1;
  $query = $db->query($sql);
  while ($row = $query->fetch()) {
    $species = getRemindId($row['species']);
    $user = checkUserinfo($row['userid'], 1);
    $user['mobile'] = xdecrypt($user['mobile']);
    $xtpl->assign('index', $index++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('fullname', $user['fullname']);
    $xtpl->assign('mobile', $user['mobile']);
    $xtpl->assign('name', $row['name']);
    if (!$row['active']) $xtpl->parse('main.row.edit');
    else if (!empty($row['petid'])) {
      $xtpl->assign('petid', $row['petid']);
      $xtpl->parse('main.row.info');
    }
    $xtpl->parse('main.row');
  }

  $xtpl->assign('nav', nav_generater('/news/sendinfo?', $number, $filter['page'], $filter['limit']));
  $xtpl->parse('main');
  return $xtpl->text();
}

function privateModal() {
  global $position, $userinfo;
  $xtpl = new XTemplate("modal.tpl", PATH2);

  $xtpl->assign('main', $userinfo['mail']);
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
    if ($l1i != '0') {
      $xtpl->assign('active', 'style="display: none;"');
    }
    $xtpl->parse('main.l2');
  }
  $xtpl->parse('main');
  return $xtpl->text();
}
