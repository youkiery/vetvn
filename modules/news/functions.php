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
  
    $sql = 'select * from `'. PREFIX .'_sendinfo` where active = 1 order by time desc limit 12';
    $query = $db->query($sql);
  
    while ($row = $query->fetch()) {
      $owner = getContactId($row['owner'], $row['userid']);
      $certify = checkCertify($row['id']);
      $xtpl->assign('id', $row['id']);
      $xtpl->assign('image', parseImage($row['image']));
      $xtpl->assign('name', $row['name']);
      $xtpl->assign('owner', $owner['fullname']);
      $xtpl->assign('microchip', $row['micro']);
      $xtpl->assign('species', getRemindId($row['species'])['name']);
      $xtpl->assign('sex', $sex_array[$row['sex']]);
      $xtpl->assign('age', parseAgeTime($row['birthtime']));
      if (!empty($certify)) {
        $xtpl->parse('main.row.ddc');
      }
      $xtpl->parse('main.row');
    }
    $xtpl->parse('main');
    return $xtpl->text();
}

function listContent() {
  global $db, $sex_array, $module_file, $filter;
  $xtpl = new XTemplate('list.tpl', PATH2);
  $xtpl->assign('module_file', $module_file);
  
  $sql = 'select count(*) as count from `'. PREFIX .'_sendinfo` where active = 1 and (name like "%'.$filter['keyword'].'%" or micro like "%'.$filter['keyword'].'%")';
  $query = $db->query($sql);
  $data['count'] = $query->fetch()['count'];
  $count = $data['count'];
  
  $sql = 'select * from `'. PREFIX .'_sendinfo` where active = 1 and (name like "%'.$filter['keyword'].'%" or micro like "%'.$filter['keyword'].'%") order by time desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);

  while ($row = $query->fetch()) {
    $owner = getContactId($row['owner'], $row['userid']);
    $certify = checkCertify($row['id']);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('image', parseImage($row['image']));
    $xtpl->assign('name', $row['name']);
    $xtpl->assign('owner', $owner['fullname']);
    $xtpl->assign('microchip', $row['micro']);
    $xtpl->assign('species', getRemindId($row['species'])['name']);
    $xtpl->assign('sex', $sex_array[$row['sex']]);
    $xtpl->assign('age', parseAgeTime($row['birthtime']));
    if (!empty($certify)) {
      $xtpl->parse('main.row.ddc');
    }
    $xtpl->parse('main.row');
  }
  $xtpl->assign('nav', nav_generater('/news/list/?keyword='.$filter['keyword'], $count, $filter['page'], $filter['limit']));
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
    $age = round( time() - $info['birthtime']) / 60 / 60 / 24 / 365.25;
    if ($age < 1) {
      $age = 1;
    }
    return 'Tên: '. $info['name'] .'<br>Tuổi: '. $age .'<br>Giống loài: '. $info['species'];
  }
  return 'chưa xác định';
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

function contactContent() {
  global $db, $filter, $userinfo;

  $xtpl = new XTemplate('list.tpl', PATH2);
  $filter['keyword'] = mb_strtolower($filter['keyword']);

  $sql = 'select count(*) as count from `'. PREFIX .'_contact` where (LOWER(fullname) like "%'. $filter['keyword'] .'%" or LOWER(address) like "%'. $filter['keyword'] .'%" or LOWER(mobile) like "%'. $filter['keyword'] .'%") and userid = ' . $userinfo['id'];
  $query = $db->query($sql);
  $count = $query->fetch()['count'];

  $sql = 'select * from `'. PREFIX .'_contact` where (LOWER(fullname) like "%'. $filter['keyword'] .'%" or LOWER(address) like "%'. $filter['keyword'] .'%" or LOWER(mobile) like "%'. $filter['keyword'] .'%") and userid = '. $userinfo['id'] .' order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  $index = ($filter['page'] - 1) * $filter['limit'] + 1;

  while ($row = $query->fetch()) {
    $xtpl->assign('index', $index++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('fullname', $row['fullname']);
    $xtpl->assign('mobile', $row['mobile']);
    $xtpl->assign('address', $row['address']);
    $xtpl->assign('politic', $row['politic']);
    $xtpl->parse('main.row');
  }

  $xtpl->assign('nav', nav_generater('/news/contact/?keyword=' . $filter['keyword'], $count, $filter['page'], $filter['limit']));
  $xtpl->parse('main');
  return $xtpl->text();
}


function contactModal() {
  global $userinfo;
  $xtpl = new XTemplate('modal.tpl', PATH2);
  $xtpl->parse('main');
  return $xtpl->text();
}

function infoModal() {
  global $userinfo;
  $xtpl = new XTemplate('modal.tpl', PATH2);
  $xtpl->assign('today', date('d/m/Y', time()));
  $xtpl->assign('v', parseVaccineType($userinfo['id']));
  $xtpl->parse('main');
  return $xtpl->text();
}

// function contactContent($userid, $filter = array('page' => 1, 'limit' => 10)) {
//   global $db;

//   $xtpl = new XTemplate('contact-content.tpl', PATH);

//   $sql = 'select count(*) as count from `'. PREFIX .'_pet` where userid = ' . $userid . ' and type = 2';
//   $query = $db->query($sql);
//   $count = $query->fetch()['count'];
//   $xtpl->assign('nav', navList2($count, $filter['page'], $filter['limit'], 'goPage2'));

//   $sql = 'select * from `'. PREFIX .'_pet` where userid = '. $userid .' and type = 2 order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
//   $query = $db->query($sql);
//   $index = ($filter['page'] - 1) * $filter['limit'] + 1;

//   while ($row = $query->fetch()) {
//     $xtpl->assign('index', $index++);
//     $xtpl->assign('id', $row['id']);
//     $xtpl->assign('name', $row['name']);
//     $xtpl->assign('species', $row['species']);
//     $xtpl->assign('breed', $row['breed']);
//     $xtpl->parse('main.row');
//   }

//   $xtpl->parse('main');
//   return $xtpl->text();
// }

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
  global $db, $userinfo, $sex_data, $filter, $userinfo;
  $xtpl = new XTemplate('list.tpl', PATH2);
  $filter['status'] --;

  $sql = 'select * from `'. PREFIX .'_sendinfo` where userid = ' . $userinfo['id'] . ' '. ($filter['status'] >= 0 ? ' and active = ' . $filter['status'] : '') .' and active2 = 0 order by id desc';

  $query = $db->query($sql);
  $list = array();
  $number = 0;

  // nếu filter.keyword rỗng, không thực hiện lọc
  // kiểm tra owner, nếu không tồn tại dùng thông tin userinfo

  while ($row = $query->fetch()) {
    $owner = getContactId($row['owner']);
    if (empty($owner)) {
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
    $xtpl->assign('index', $i+1);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('fullname', $row['fullname']);
    $xtpl->assign('mobile', $row['mobile']);
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

  $today = time();
  $xtpl->assign('today', date('d/m/Y', $today));
  $xtpl->assign('recall', date('d/m/Y', $today + 60 * 60 * 24 * 21));
  $xtpl->assign('main', $userinfo['mail']);
  $xtpl->assign('v', parseVaccineType($userinfo['id']));
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


function trading($filter = array('page' => 1, 'limit' => 10, 'breed' => '', 'species' => '', 'status' => array(0 => 1, 1, 1), 'type' => array(0 => 1, 1, 1), 'contact' => array(0 => 1, 1))) {
  global $db, $buy_sex, $userinfo;
  $status_name = array('Đang chờ duyệt', 'Đã duyệt', 'Đã hủy');

  $xtpl = new XTemplate('list.tpl', PATH2);
  $x = array();
  $status = array();

  foreach ($filter['status'] as $id => $value) {
    if ($value) {
      $status[] = $id;
    }
  }

  if ($filter['type'][0]) {
    $x[] = 'select id, time, 1 as type from `'. PREFIX .'_buy` where userid = '. $userinfo['id'] .' and status in ('. implode(', ', $status) . ') and breed like "%'. $filter['breed'] .'%" and species like "%'. $filter['species'] .'%"';
  }
  if ($filter['type'][1] || $filter['type'][2]) {
    $tick = array();
    if ($filter['type'][1]) $tick[] = 1;
    if ($filter['type'][2]) $tick[] = 2;
    $x[] = 'select a.id, a.time, 2 as type from `'. PREFIX .'_trade` a inner join `'. PREFIX .'_pet` b on a.petid = b.id where b.userid = '. $userinfo['id'] .' and a.type in ('. implode(', ', $tick) .') and a.status in ('. implode(', ', $status) .') and b.breed like "%'. $filter['breed'] .'%" and b.species like "%'. $filter['species'] .'%"';
  }

  if (count($x) > 0) {
    if ($filter['type'][0] && ($filter['type'][1] || $filter['type'][2])) {
      $sql = 'select count(*) as count from (('. $x[0] .') union ('. $x[1] .')) as a';
      $sql2 = '('. $x[0] .') union ('. $x[1] .') order by time desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
    } 
    else {
      $sql = 'select count(*) as count from ('. $x[0] .') as a';
      $sql2 = $x[0] .' order by time desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
    }

    $query = $db->query($sql);
    $count = $query->fetch()['count'];
    $xtpl->assign('nav', navList($count, $page, $limit));

    $query = $db->query($sql2);

    while ($bank = $query->fetch()) {
      $xtpl->assign('id', $bank['id']);
      $xtpl->assign('type', $bank['type']);
      $query2 = $db->query($sql);
      if (!empty($query2->fetch())) {
        $xtpl->parse('main.info');
      }
      
      if ($bank['type'] == 1) {
        $sql = 'select * from `'. PREFIX .'_buy` where id = ' . $bank['id'];
        $query2 = $db->query($sql);
        $row = $query2->fetch();
        // buy
        $sql = 'select * from `'. PREFIX .'_info` where status = 1 and rid = ' . $bank['id'];
        $query2 = $db->query($sql);
        $info = $query2->fetch();
        $xtpl->assign('pid', $bank['id']);
        if (!empty($info)) $xtpl->parse('main.row.info');

        $xtpl->assign('name', '--');
        $xtpl->assign('breed', $row['breed']);
        $xtpl->assign('species', $row['species']);
        if (empty($row['breed'])) $xtpl->assign('breed', '--');
        if (empty($row['species'])) $xtpl->assign('species', '--');
        $xtpl->assign('cat', 'Cần mua');
      }
      else {
        $sql = 'select a.status, a.type, a.petid, b.name, b.breed, b.species from `'. PREFIX .'_trade` a inner join `'. PREFIX .'_pet` b on a.petid = b.id where a.id = ' . $bank['id'];
        $query2 = $db->query($sql);
        $row = $query2->fetch();
        // buy
        $sql = 'select * from `'. PREFIX .'_info` where status = 1 and rid = ' . $row['petid'];
        // echo $sql . "<br>";
        $query2 = $db->query($sql);
        $info = $query2->fetch();
        $xtpl->assign('pid', $row['petid']);
        if (!empty($info)) $xtpl->parse('main.row.info');

        $xtpl->parse('main.row.link');
        $xtpl->assign('name', $row['name']);
        $xtpl->assign('breed', $row['breed']);
        $xtpl->assign('species', $row['species']);
        $xtpl->assign('cat', 'Cần phối');
        if ($row['type'] == 1) {
          $xtpl->assign('cat', 'Cần bán');
        }
      }
      if ($row['status'] < 2) {
        $xtpl->parse('main.row.cancel');
      }
      else {
        $xtpl->parse('main.row.request');
      }
      $xtpl->assign('status', $status_name[$row['status']]);
      $xtpl->parse('main.row');
    }
  }
  else {

  }
  // die();

  $xtpl->parse('main');
  return $xtpl->text();
}

function introList($userid, $filter = array('page' => 1, 'limit' => 10)) {
  global $db, $module_file;

  $xtpl = new XTemplate('intro-list.tpl', PATH);
  $xtpl->assign('module_file', $module_file);

  $sql = 'select count(*) as count from ((select a.* from `'. PREFIX .'_info` a inner join `'. PREFIX .'_pet` b on a.rid = b.id where (a.type = 1 or a.type = 3) and b.userid = '. $userid . ' and status = 1) union (select a.* from `'. PREFIX .'_info` a inner join `'. PREFIX .'_buy` b on a.rid = b.id where a.type = 2 and b.userid = '. $userid . ' and a.status = 1)) as c';

  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));

  $sql = 'select * from ((select a.* from `'. PREFIX .'_info` a inner join `'. PREFIX .'_pet` b on a.rid = b.id where (a.type = 1 or a.type = 3) and b.userid = '. $userid . ' and status = 1) union (select a.* from `'. PREFIX .'_info` a inner join `'. PREFIX .'_buy` b on a.rid = b.id where a.type = 2 and b.userid = '. $userid . ' and a.status = 1) order by id desc) as c limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  $index = ($filter['page'] - 1) * $filter['limit'] + 1;

  while ($row = $query->fetch()) {
    $owner = getOwnerById($row['userid']);
    $pet = getPetById($row['rid']);
    $xtpl->assign('index', $index++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('target', $row['fullname']);
    $xtpl->assign('address', $row['address']);
    $xtpl->assign('mobile', $row['mobile']);
    $xtpl->assign('note', $row['note']);
    $xtpl->assign('name', $pet['name']);
    $xtpl->assign('breed', $pet['breed']);
    $xtpl->assign('species', $pet['species']);
    $xtpl->assign('pid', $pet['id']);

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

function transferList($userid, $filter = array('page' => 1, 'limit' => 10, 'type' => 'goPage')) {
  global $db, $module_file;

  $xtpl = new XTemplate('transfer-list.tpl', PATH);
  $xtpl->assign('module_file', $module_file);

  $sql = 'select count(*) as count from `pet_news_transfer` a inner join `pet_news_pet` b on a.petid = b.id inner join `pet_news_user` c on b.userid = c.id where fromid = ' . $userid;
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList2($count, $filter['page'], $filter['limit'], $filter['type']));

  $sql = 'select * from `pet_news_transfer` a inner join `pet_news_pet` b on a.petid = b.id inner join `pet_news_user` c on b.userid = c.id where fromid = ' . $userid . ' order by a.id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  $index = ($filter['page'] - 1) * $filter['limit'] + 1;

  $list = array();
  while ($row = $query->fetch()) {
    $target = checkUserinfo($row['targetid'], $row['type']);
    // echo $target['fullname'] . ' ('. $row['type'] .')<br>';
    $pet = getPetById($row['petid']);
    $target['mobile'] = xdecrypt($target['mobile']);
    $target['address'] = xdecrypt($target['address']);

    $xtpl->assign('index', $index++);
    $xtpl->assign('target', $target['fullname']);
    $xtpl->assign('address', $target['address']);
    $xtpl->assign('mobile', $target['mobile']);
    $xtpl->assign('id', $pet['id']);
    $xtpl->assign('pet', $pet['name']);
    $xtpl->assign('time', date('d/m/Y', $row['time']));
    $xtpl->parse('main.row');
  }

  $xtpl->parse('main');
  return $xtpl->text();
}

function transferedList($userid, $filter = array('page' => 1, 'limit' => 10, 'type' => 'goPage')) {
  global $db, $module_file;

  $xtpl = new XTemplate('transfered-list.tpl', PATH);
  $xtpl->assign('module_file', $module_file);

  $sql = 'select count(*) as count from `pet_news_transfer` a inner join `pet_news_pet` b on a.petid = b.id inner join `pet_news_user` c on b.userid = c.id where targetid = ' . $userid;
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList2($count, $filter['page'], $filter['limit'], $filter['type']));

  $sql = 'select * from `pet_news_transfer` a inner join `pet_news_pet` b on a.petid = b.id inner join `pet_news_user` c on b.userid = c.id where targetid = ' . $userid . ' order by a.id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  $index = ($filter['page'] - 1) * $filter['limit'] + 1;

  $list = array();
  while ($row = $query->fetch()) {
    $target = checkUserinfo($row['fromid'], $row['type']);
    // echo $target['fullname'] . ' ('. $row['type'] .')<br>';
    $pet = getPetById($row['petid']);
    $target['mobile'] = xdecrypt($target['mobile']);
    $target['address'] = xdecrypt($target['address']);

    $xtpl->assign('index', $index++);
    $xtpl->assign('target', $target['fullname']);
    $xtpl->assign('address', $target['address']);
    $xtpl->assign('mobile', $target['mobile']);
    $xtpl->assign('id', $pet['id']);
    $xtpl->assign('pet', $pet['name']);
    $xtpl->assign('time', date('d/m/Y', $row['time']));
    $xtpl->parse('main.row');
  }

  $xtpl->parse('main');
  return $xtpl->text();
}

function transferqList($userid, $filter = array('page' => 1, 'limit' => 10, 'type' => 'goPage2')) {
  global $db, $module_file;

  $xtpl = new XTemplate('transferq-list.tpl', PATH);

  $sql = 'select count(*) as count from `'. PREFIX .'_transfer_request` a inner join `'. PREFIX .'_pet` b on a.petid = b.id inner join `'. PREFIX .'_pet` c on b.userid = c.id where a.userid = ' . $userid;
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList2($count, $filter['page'], $filter['limit'], $filter['type']));

  $sql = 'select a.* from `'. PREFIX .'_transfer_request` a inner join `'. PREFIX .'_pet` b on a.petid = b.id inner join `'. PREFIX .'_pet` c on b.userid = c.id where a.userid = ' . $userid . ' order by a.id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  $index = ($filter['page'] - 1) * $filter['limit'] + 1;

  while ($row = $query->fetch()) {
    if(!empty($pet = getPetById($row['petid'])) && !empty($owner = checkUserinfo($pet['userid'], $pet['type']))) {
      // $xtpl->assign('index', $index++);
      $xtpl->assign('id', $row['id']);
      $xtpl->assign('image', $pet['image']);
      $xtpl->assign('species', $pet['species']);
      $xtpl->assign('name', $pet['name']);
      $xtpl->assign('breed', $pet['breed']);
      $xtpl->assign('owner', $owner['fullname']);
      $xtpl->assign('time', date('d/m/Y', $row['time']));
      $xtpl->parse('main.row');
    }
  }

  $xtpl->parse('main');
  return $xtpl->text();
}

function reserveList($userid, $filter = array('page' => 1, 'limit' => 10)) {
  global $db, $module_file;

  $xtpl = new XTemplate('list.tpl', PATH2);

  $sql = 'select count(*) as count from `'. PREFIX .'_pet` where userid = ' . $userid . ' and sell = 1';
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));

  $owner = getOwnerById($userid);
  $sql = 'select * from `'. PREFIX .'_pet` where userid = ' . $userid . ' and sell = 1 order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  $index = ($filter['page'] - 1) * $filter['limit'] + 1;

  while ($row = $query->fetch()) {
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('image', $row['image']);
    $xtpl->assign('species', $row['species']);
    $xtpl->assign('name', $row['name']);
    $xtpl->assign('breed', $row['breed']);
    $xtpl->assign('owner', $owner['fullname']);
    $xtpl->parse('main.row');
  }

  $xtpl->parse('main');
  return $xtpl->text();
}

function managerContent() {
  global $db, $userinfo, $filter, $sex_array, $module_file, $module_name;
  $xtpl = new XTemplate('list.tpl', PATH2);
  $xtpl->assign('module_file', $module_file);
  $xtpl->assign('module_name', $module_name);

  $filter['keyword'] = mb_strtolower($filter['keyword']);
  // $data = getUserPetList($userid, $tabber, $filter);
  $sql = 'select count(*) as count from `'. PREFIX .'_sendinfo` where LOWER(name) like "%'. $filter['keyword'] .'%" and active2 = 1 and userid = ' . $userinfo['id'];
  $query = $db->query($sql);
  $number = $query->fetch()['count'];

  $sql = 'select * from `'. PREFIX .'_sendinfo` where LOWER(name) like "%'. $filter['keyword'] .'%" and active2 = 1 and userid = ' . $userinfo['id'] . ' order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);

  $index = ($filter['page'] - 1) * $filter['limit'] + 1;
  while ($row = $query->fetch()) {
    $lock = checkPetlock($row['id']);
    $owner = getContactId($row['owner'], $row['userid']);
    $xtpl->assign('index', $index++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('name', $row['name']);
    $xtpl->assign('owner', $owner['fullname'] . ', ' . $owner['address']);
    $xtpl->assign('sex', $sex_array[$row['sex']]);
    $xtpl->assign('species', getRemindId($row['species'])['name']);
    $xtpl->assign('lock', '');
    if (!empty($lock)) $xtpl->assign('lock', 'disabled');
    $xtpl->parse('main.row');
  }

  $xtpl->assign('nav', nav_generater('/news/private/?keyword=' . $filter['keyword'], $number, $filter['page'], $filter['limit']));
  $xtpl->parse('main');
  return $xtpl->text();
}

function statisticCollect() {
  global $db, $sex_array, $filter;

  $index = ($filter['page'] - 1) * $filter['limit'] + 1;
  $xtpl = new XTemplate('list.tpl', PATH2);

  $sql = 'select count(*) as count from `'. PREFIX .'_certify` where price > 0';
  $query = $db->query($sql);
  $count = $query->fetch()['count'];

  $sql = 'select * from `'. PREFIX .'_certify` where price > 0 order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  // $data = getUserPetList($filter);

  while ($row = $query->fetch()) {
    $pet = getPetinfoId($row['petid']);
    $user = getUserinfoId($pet['userid']);
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

  $xtpl->assign('nav', nav_generater('/news/statistic/?type=' . $filter['type'], $count, $filter['page'], $filter['limit']));
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
    $xtpl->assign('name', $owner['fullname']);
    $xtpl->assign('time', date('d/m/Y', ($row['time'])));
    $xtpl->parse('main.row');
  }
  $xtpl->assign('nav', nav_generater('/news/statistic/?type=' . $filter['type'], $count, $filter['page'], $filter['limit']));
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
