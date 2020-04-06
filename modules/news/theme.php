<?php

/**
 * @Project Petcoffee-tech
 * @Chistua (hchieuthua@gmail.com)
 * @Copyright (C) 2019
 * @Createdate 21-03-2019 13:15
 */

if (!defined('PREFIX')) {
  die('Stop!!!');
}

$buy_sex = array('Sao cũng được', 'Đực', 'Cái');

function cetiList() {
  global $db, $module_name, $op, $nv_Request;

  $xtpl = new XTemplate("ceti-list.tpl", "modules/". $module_name ."/template/block");
  $page = $nv_Request->get_int('page', 'get', '1');
  // $query = $db->query('select count(*) as number from `'. PREFIX .'_pet` where ceti = 1 order by ctime desc');
  $query = $db->query('select count(*) as number from `'. PREFIX .'_pet` order by ctime desc');
  $number = $query->fetch()['number'];
  // $query = $db->query('select * from `'. PREFIX .'_pet` where ceti = 1 order by ctime desc');
  $query = $db->query('select * from `'. PREFIX .'_pet` order by ctime desc limit 10 offset ' . ($page - 1) * 10);
  $xtpl->assign('module_name', $module_name);
  $xtpl->assign('nav', navListX($number, $page, 10, $module_name . '/' . $op . '/?page='));
  $index = ($page - 1) * 10 + 1;
  while ($row = $query->fetch()) {
    $xtpl->assign('index', $index++);
    $xtpl->assign('micro', $row['microchip']);
    $xtpl->assign('name', $row['name']);
    $xtpl->assign('species', $row['species']);
    $xtpl->assign('rid', $row['id']);
    $xtpl->parse('main.row');
  }
  $xtpl->parse('main');
  return $xtpl->text();
}

function adminCetiList() {
  global $db, $module_name, $nv_Request;

  $xtpl = new XTemplate("ceti-list.tpl", NV_ROOTDIR . "/modules/". $module_name ."/template/admin/block");
  $page = $nv_Request->get_int('page', 'get', '1');
  // $query = $db->query('select count(*) as number from `'. PREFIX .'_pet` where ceti = 1 order by ctime desc');
  $query = $db->query('select count(*) as number from `'. PREFIX .'_pet` where ceti = 1');
  $number = $query->fetch()['number'];
  // $query = $db->query('select * from `'. PREFIX .'_pet` where ceti = 1 order by ctime desc');
  $query = $db->query('select * from `'. PREFIX .'_pet` where ceti = 1 order by ctime desc limit 10 offset ' . ($page - 1) * 10);
  $xtpl->assign('module_name', $module_name);
  $xtpl->assign('nav', navListX($number, $page, 10, 'admin32/index.php?language=vi&nv=' . $module_name . '&op=ceti-print&page='));
  $index = ($page - 1) * 10 + 1;
  while ($row = $query->fetch()) {
    $xtpl->assign('index', $index++);
    $xtpl->assign('micro', $row['microchip']);
    $xtpl->assign('name', $row['name']);
    $xtpl->assign('species', $row['species']);
    $xtpl->assign('rid', $row['id']);
    $xtpl->parse('main.row');
  }
  $xtpl->parse('main');
  return $xtpl->text();
}

function revenue($filter = array('page' => 1, 'limit' => 10)) {
  global $db, $sex_array;

  $index = ($filter['page'] - 1) * $filter['limit'] + 1;
  $xtpl = new XTemplate('statistic-list.tpl', PATH);

  $sql = 'select count(*) as count from `'. PREFIX .'_pet` where ceti = 1';
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit'], 'goPage'));

  $sql = 'select * from `'. PREFIX .'_pet` where ceti = 1 order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  // $data = getUserPetList($filter);

  while ($row = $query->fetch()) {
    // echo ($row['userid'] . '<br>');
    $owner = getOwnerById($row['userid']);
    $xtpl->assign('index', $index++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('price', number_format($row['price'], 0, '', ','));
    $xtpl->assign('name', $row['name']);
    $xtpl->assign('owner', $owner['fullname']);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('microchip', $row['microchip']);
    $xtpl->assign('breed', $row['breed']);
    $xtpl->assign('sex', $sex_array[$row['sex']]);
    $xtpl->parse('main.row');
  }
  $xtpl->parse('main');
  return $xtpl->text();
}

function revenue2($filter = array('page' => 1, 'limit' => 10)) {
  global $db, $sex_array;

  $index = ($filter['page'] - 1) * $filter['limit'] + 1;
  $xtpl = new XTemplate('statistic-list2.tpl', PATH);

  $sql = 'select count(*) as count from `'. PREFIX .'_pet` where ceti = 1';
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit'], 'goPage'));

  $sql = 'select * from `'. PREFIX .'_pet` where ceti = 1 order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  // $data = getUserPetList($filter);

  while ($row = $query->fetch()) {
    // echo ($row['userid'] . '<br>');
    $owner = getOwnerById($row['userid']);
    $xtpl->assign('index', $index++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('price', number_format($row['price'], 0, '', ','));
    $xtpl->assign('price2', $row['price']);
    $xtpl->assign('name', $row['name']);
    $xtpl->assign('owner', $owner['fullname']);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('microchip', $row['microchip']);
    $xtpl->assign('breed', $row['breed']);
    $xtpl->assign('sex', $sex_array[$row['sex']]);
    if ($row['ceti']) {
      $xtpl->parse('main.row.yes');
    }
    else {
      $xtpl->parse('main.row.no');
    }
    $xtpl->parse('main.row');
  }
  $xtpl->parse('main');
  return $xtpl->text();
}

function paylist($filter = array('page' => 1, 'limit' => 10)) {
  global $db, $sex_array;

  $index = ($filter['page'] - 1) * $filter['limit'] + 1;
  $xtpl = new XTemplate('pay-list.tpl', PATH);

  $sql = 'select count(*) as count from `'. PREFIX .'_pay`';
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList2($count, $filter['page'], $filter['limit'], 'goPage2'));

  $sql = 'select * from `'. PREFIX .'_pay` order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);
  // $data = getUserPetList($filter);

  while ($row = $query->fetch()) {
    $owner = getUserInfo($row['userid']);
    $xtpl->assign('index', $index++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('price', number_format($row['price'], 0, '', ','));
    $xtpl->assign('content', $row['content']);
    $xtpl->assign('name', $owner['fullname']);
    $xtpl->assign('time', date('d/m/Y', ($row['time'])));
    $xtpl->parse('main.row');
  }
  $xtpl->parse('main');
  return $xtpl->text();
}

function reserveList($userid, $filter = array('page' => 1, 'limit' => 10)) {
  global $db, $module_file;

  $xtpl = new XTemplate('reserve-list.tpl', PATH);

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

function vaccineList($petid) {
  global $db, $vaccine_array, $module_file;
  $xtpl = new XTemplate('vaccine.tpl', PATH);
  $xtpl->assign('module_file', $module_file);

  $sql = 'select * from `'. PREFIX .'_vaccine` where petid = ' . $petid . ' order by id desc';
  $query = $db->query($sql);
  $index = 1;
  $today = time(); 
  while ($row = $query->fetch()) {
    $pet = getPetById($petid);
    $xtpl->assign('index', $index ++);
    $xtpl->assign('pet', $pet['name']);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('time', date('d/m/Y', $row['time']));
    $xtpl->assign('recall', date('d/m/Y', $row['recall']));
    if ($row['type'] == 1) {
      $xtpl->assign('type', $vaccine_array[$row['val']]['title']);
    }
    else {
      $xtpl->assign('typeid', pickVaccineId($row['val'])['id']);
      $xtpl->assign('type', pickVaccineId($row['val'])['disease']);
    }
    if ($row['status'] == 0) {
      $xtpl->parse('main.row.recall');
      if ($today >= $row['recall']) {
        $xtpl->assign('color', 'red');
      }
      else {
        $xtpl->assign('color', '');
      }
    }
    $xtpl->parse('main.row');
  }

  $xtpl->parse('main');
  return $xtpl->text();
}

function DiseaseList($petid) {
  global $db, $request_array, $module_file;
  $xtpl = new XTemplate('disease.tpl', PATH);
  $xtpl->assign('module_file', $module_file);

  $sql = 'select * from `'. PREFIX .'_disease` where petid = ' . $petid . ' order by id desc';
  $query = $db->query($sql);
  $index = 1;
  while ($row = $query->fetch()) {
    $pet = getPetById($petid);
    $xtpl->assign('index', $index ++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('pet', $pet['name']);
    $xtpl->assign('treat', date('d/m/Y', $row['treat']));
    $xtpl->assign('treated', date('d/m/Y', $row['treated']));
    $xtpl->assign('disease', $row['disease']);
    $xtpl->assign('note', $row['note']);
    $xtpl->parse('main.row');
  }

  $xtpl->parse('main');
  return $xtpl->text();
}

function requestDetail($petid) {
  global $db, $request_array, $module_file;
  $xtpl = new XTemplate('request-detail.tpl', PATH);
  $xtpl->assign('module_file', $module_file);
  $list = array();

  $sql = 'select * from `'. PREFIX .'_remind` where type = "request" and visible = 1';
  $query = $db->query($sql);

  while ($row = $query->fetch()) {
    $xtpl->assign('title', $row['name']);
    $xtpl->assign('type', $row['id']);
    $xtpl->assign('id', $petid);
    if (!empty($request = getPetRequest($petid, $row['id']))) {
      $request['status'] = intval($request['status']);
      switch ($request['status']) {
        case 0:
          // decline
          $xtpl->parse('main.row.rerequest');
        break;
        case 1:
          // picking
          $xtpl->parse('main.row.cancel');
        break;
        default:
          // finish
          $xtpl->parse('main.row.request');
        break;
      }
    }
    else {
      $xtpl->parse('main.row.request');
    }
    $xtpl->parse('main.row');
  }

  $sql = 'select * from `'. PREFIX .'_request` where type = 2 and petid = ' . $petid . ' and status <> 2';
  $query = $db->query($sql);

  while ($row = $query->fetch()) {
    $sql = 'select * from `'. PREFIX .'_remind` where type = "request" and id = ' . $row['value'];
    $query2 = $db->query($sql);
    $remind = $query2->fetch();

    $xtpl->assign('title', $remind['name']);
    $xtpl->assign('type', $row['value']);
    $xtpl->assign('id', $petid);
    $status = intval($row['status']);
    switch ($status) {
      case 1:
        $xtpl->parse('main.row2.cancel2');
      break;
      case 0:
        $xtpl->parse('main.row2.rerequest2');
      break;
    }
    $xtpl->parse('main.row2');
  }

  $xtpl->parse('main');
  return $xtpl->text();
}

function userDogRowByList($userid, $tabber = array(0, 1, 2), $filter = array('page' => 1, 'limit' => 10, 'keyword' => '')) {
  global $db, $user_info, $sex_array, $module_file, $module_name;
  $index = 1;
  $xtpl = new XTemplate('dog-owner-list.tpl', PATH);
  $xtpl->assign('module_file', $module_file);
  $xtpl->assign('module_name', $module_name);

  $data = getUserPetList($userid, $tabber, $filter);

  foreach ($data['list'] as $row) {
    $xtpl->assign('index', $index++);
    $list = array();
    $list[] = $row;
    $parent = getParentTree($row);
    $list = array_merge($list, $parent);
    $ping = 1;
    $i = 1;
    foreach ($list as $check) {
      $xtpl->assign('pr', 'disabled');
      if ($ping) {
        $ping = 0;
        $xtpl->assign('display', 'table-row-group');
        $xtpl->assign('pc', '');
        if (count($parent)) {
          $xtpl->assign('pr', '');
        }
      }
      else {
        $xtpl->assign('display', 'none');
        $xtpl->assign('pc', 'i' . $row['id']);
      }

      $xtpl->assign('name', $check['name']);
      // $xtpl->assign('breeder', $check['breeder']);
      $xtpl->assign('id', $check['id']);
      $xtpl->assign('microchip', $check['microchip']);
      $xtpl->assign('breed', $check['breed']);
      $xtpl->assign('species', $check['species']);
      $xtpl->assign('sex', $sex_array[$check['sex']]);
      $xtpl->assign('dob', cdate($check['dateofbirth']));
      if ($row['sell']) {
        $xtpl->parse('main.row.unsell');
      }
      else {
        $xtpl->parse('main.row.sell');
      }
      $request = getPetRequest($check['id']);
        // if ($count = count($request) > 0) {
        //   $counter = 0;
        //   $scounter = 0;
        //   foreach ($request as $requester) {
        //     // request status: 0-fail, 1-requesting, 2-success
        //     if ($requester['status'] > 0) {
        //       if ($requester['status'] == 2) {
        //         ++$scounter;
        //       } 
        //       ++$counter;
        //     }
        //   }
        //   if ($counter == 0) {
        //     $xtpl->assign('request', 'danger');
        //   }
        //   else if ($counter == $count) {
        //     if ($scounter == $count) {
        //       $xtpl->assign('request', 'success');
        //     }
        //     else {
        //       $xtpl->assign('request', 'info');
        //     }
        //   }
        //   else {
        //     $xtpl->assign('request', 'warning');
        //   }
        // }
        // else {
        //   $xtpl->assign('request', 'info');
        // }

      $xtpl->parse('main.row');
    }
  }

  $xtpl->assign('nav', navList($data['count'], $filter['page'], $filter['limit']));
  $xtpl->parse('main');
  return $xtpl->text();
}

function mainPetList($keyword = '', $page = 1, $filter = 12) {
  global $db, $sex_array, $module_file;
  $index = ($page - 1) * $filter + 1;
  $xtpl = new XTemplate('dog-list.tpl', PATH);
  $xtpl->assign('module_file', $module_file);

  $sql = 'select count(*) as count from `'. PREFIX .'_pet` where active > 0 and (name like "%'.$keyword.'%" or microchip like "%'.$keyword.'%")';
  $query = $db->query($sql);
  $data['count'] = $query->fetch()['count'];
  $count = $data['count'];
  
  $sql = 'select * from `'. PREFIX .'_pet` where active > 0 and (name like "%'.$keyword.'%" or microchip like "%'.$keyword.'%") order by time desc limit ' . $filter . ' offset ' . (($page - 1) * $filter);
  $query = $db->query($sql);

  if (strlen(trim($keyword)) > 0) {
    $xtpl->assign('keyword', ' "' . $keyword . '",');
  }

  $xtpl->assign('from', ($page - 1) * $filter + 1);
  $xtpl->assign('end', ($count + $filter >= ($page * $filter) ? $count : $page * $filter));
  $xtpl->assign('count', $count);
  $xtpl->assign('nav', navList($count, $page, $filter));
  $xtpl->parse('main.msg');
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

function sellList($filter = array('species' => '', 'breed' => '', 'keyword' => '', 'page' => '1', 'limit' => '12')) {
  global $db, $module_name;

  $xtpl = new XTemplate('sell-list.tpl', PATH);
  $xtpl->assign('module_name', $module_name);

  // ??
  $sql = 'select count(*) as count from `'. PREFIX .'_trade` a inner join `'. PREFIX .'_pet` b on a.petid = b.id where a.status = 1 and a.type = 1 and b.name like "%'. $filter['keyword'] .'%" and b.breed like "%'. $filter['species'] .'%" and b.species like "%'. $filter['breed'] .'%"';
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));

  $sql = 'select * from `'. PREFIX .'_trade` a inner join `'. PREFIX .'_pet` b on a.petid = b.id where a.status = 1 and a.type = 1 and b.name like "%'. $filter['keyword'] .'%" and b.breed like "%'. $filter['species'] .'%" and b.species like "%'. $filter['breed'] .'%" order by a.time desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);

  while($row = $query->fetch()) {
    $owner = getOwnerById($row['userid'], $row['type']);
    $xtpl->assign('index', $index++);
    $xtpl->assign('age', parseAgeTime($row['dateofbirth']));
    $xtpl->assign('image', $row['image']);
    $xtpl->assign('name', $row['name']);
    $xtpl->assign('owner', $owner['fullname']);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('image', $row['image']);
    $xtpl->assign('microchip', $row['microchip']);
    $xtpl->assign('breed', $row['breed']);
    $xtpl->assign('species', $row['species']);
    $xtpl->assign('sex', $sex_array[$row['sex']]);
    if ($row['sell'] == 1) {
      $xtpl->parse('main.row.sell');
    }
    $xtpl->parse('main.row');
  }
  $xtpl->parse('main');
  return $xtpl->text();
}

function breedingList($filter = array('species' => '', 'breed' => '', 'keyword' => '', 'page' => '1', 'limit' => '12')) {
  global $db, $module_name;

  $xtpl = new XTemplate('breeding-list.tpl', PATH);
  $xtpl->assign('module_name', $module_name);

  $sql = 'select count(*) as count from `'. PREFIX .'_trade` a inner join `'. PREFIX .'_pet` b on a.petid = b.id where a.status = 1 and a.type = 2 and b.name like "%'. $filter['keyword'] .'%" and b.breed like "%'. $filter['species'] .'%" and b.species like "%'. $filter['breed'] .'%"';
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));

  $sql = 'select * from `'. PREFIX .'_trade` a inner join `'. PREFIX .'_pet` b on a.petid = b.id where a.status = 1 and a.type = 2 and b.name like "%'. $filter['keyword'] .'%" and b.breed like "%'. $filter['species'] .'%" and b.species like "%'. $filter['breed'] .'%" order by a.time desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);

  while($row = $query->fetch()) {
    $owner = getOwnerById($row['userid'], $row['type']);
    $xtpl->assign('index', $index++);
    $xtpl->assign('age', parseAgeTime($row['dateofbirth']));
    $xtpl->assign('image', $row['image']);
    $xtpl->assign('name', $row['name']);
    $xtpl->assign('owner', $owner['fullname']);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('image', $row['image']);
    $xtpl->assign('microchip', $row['microchip']);
    $xtpl->assign('breed', $row['breed']);
    $xtpl->assign('species', $row['species']);
    $xtpl->assign('sex', $sex_array[$row['sex']]);
    if ($row['sell'] == 1) {
      $xtpl->parse('main.row.sell');
    }
    $xtpl->parse('main.row');
  }
  $xtpl->parse('main');
  return $xtpl->text();
}

function statistic($filter = array('from' => '', 'to' => '')) {
  global $db;

  $xtpl = new XTemplate('statistic-content.tpl', PATH);

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
  $sql = 'select sum(price) as p, ctime as time from `'. PREFIX .'_pet` ' . $xtra;
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

function buyList($filter = array('species' => '', 'breed' => '', 'page' => '1', 'limit' => '12')) {
  global $db, $module_name, $buy_sex;

  $xtpl = new XTemplate('buy-list.tpl', PATH);
  $xtpl->assign('module_name', $module_name);

  $sql = 'select count(*) as count from `'. PREFIX .'_buy` where status = 1 and breed like "%'. $filter['species'] .'%" and species like "%'. $filter['breed'] .'%"';
  $query = $db->query($sql);
  $count = $query->fetch()['count'];
  $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));

  $sql = 'select * from `'. PREFIX .'_buy` where status = 1 and breed like "%'. $filter['species'] .'%" and species like "%'. $filter['breed'] .'%" order by time desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
  $query = $db->query($sql);

  while($row = $query->fetch()) {
    $owner = getOwnerById($row['userid'], $row['type']);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('species', ($row['species'] ? $row['species'] : 'Sao cũng được'));
    $xtpl->assign('breed', ($row['breed'] ? $row['breed'] : 'Sao cũng được'));
    $xtpl->assign('age', ($row['age'] ? parseMonth($row['age']) : 'Sao cũng được'));
    $xtpl->assign('sex', $buy_sex[$row['sex']]);
    if (count($price = explode('-', $row['price'])) == 2) {
      $xtpl->assign('price', number_format($price['0'] * 10000)  . ' đến ' . number_format($price['1'] * 100000));
    }
    else {
      $xtpl->assign('price', 'liên hệ');
    }
    // $xtpl->assign('index', $index++);
    // $xtpl->assign('name', $row['name']);
    // $xtpl->assign('owner', $owner['fullname']);
    // $xtpl->assign('id', $row['id']);
    // $xtpl->assign('image', $row['image']);
    // $xtpl->assign('microchip', $row['microchip']);
    // $xtpl->assign('breed', $row['breed']);
    // $xtpl->assign('species', $row['species']);
    // $xtpl->assign('sex', $sex_array[$row['sex']]);
    $xtpl->parse('main.row');
  }
  $xtpl->parse('main');
  return $xtpl->text();
}

function sendbackList($userid, $filter = array('page' => '1', 'limit' => '10')) {
  global $db;

  $xtpl = new XTemplate('sendback-list.tpl', PATH);
  $petid_list = selectPetidOfOwner($userid);

  if (!empty($petid_list)) {
    $sql = 'select count(*) as count from `'. PREFIX .'_trade` where status = 2 and petid in ('. $petid_list .')';
    $query = $db->query($sql);
    $count = $query->fetch()['count'];
    $xtpl->assign('nav', navList($count, $filter['page'], $filter['limit']));

    $sql = 'select * from `'. PREFIX .'_trade` where status = 2 and petid in ('. $petid_list .') order by id desc limit ' . $filter['limit'] . ' offset ' . ($filter['page'] - 1) * $filter['limit'];
    $query = $db->query($sql);

    while($row = $query->fetch()) {
      $pet = getPetById($row['petid']);
      $xtpl->assign('id', $row['id']);
      $xtpl->assign('name', $pet['name']);
      $xtpl->assign('species', $pet['species']);
      $xtpl->assign('breed', $pet['breed']);
      $xtpl->assign('image', $pet['image']);
      $xtpl->assign('note', $row['note']);
      $xtpl->parse('main.row');
    }
  }
  $xtpl->parse('main');
  return $xtpl->text();
}

function getMarketContent($id) {
  $html = '';
  $pet = getTradeById($id);

  $data['1'] = array(
    'act' => 'sellSubmit()',
    'text' => 'Cần bán',
    'class' => 'info',
    'note' => ''
  );
  $data['2'] = array(
    'act' => 'breedingSubmit()',
    'text' => 'Cần Phối',
    'class' => 'info',
    'note' => ''
  );

  if (!empty($pet['1'])) {
    if ($pet['1']['status'] == 0) {
      $data['1'] = array(
        'act' => 'unsellSubmit()',
        'text' => 'Hủy',
        'class' => 'warning'
      );
    }
    else if ($pet['1']['status'] == 1) {
      $data['1'] = array(
        'act' => 'unsellSubmit()',
        'text' => 'Hủy',
        'class' => 'danger'
      );
    }
    $data['1']['note'] = $pet['1']['note'];
  }

  if (!empty($pet['2'])) {
    if ($pet['2']['status'] == 0) {
      $data['2'] = array(
        'act' => 'unbreedingSubmit()',
        'text' => 'Hủy',
        'class' => 'warning'
      );
    }
    else if ($pet['2']['status'] == 1) {
      $data['2'] = array(
        'act' => 'unbreedingSubmit()',
        'text' => 'Hủy',
        'class' => 'danger'
      );
    }
    $data['2']['note'] = $pet['2']['note'];
  }

  $html .= '
    <hr>
    <label class="row">
      <div class="col-sm-6">
        Đăng bán
        <p>
          '. $data['1']['note'] .'
        </p>
      </div>
      <div class="col-sm-6" style="text-align: right;">
        <button class="btn btn-'. $data['1']['class'] .'" onclick="'. $data['1']['act'] .'">
          '. $data['1']['text'] .'
        </button>
      </div>
    </label>
    <hr>
    <label class="row">
      <div class="col-sm-6">
        Đăng cho phối
        <p>
          '. $data['2']['note'] .'
        </p>
      </div>
      <div class="col-sm-6" style="text-align: right;">
        <button class="btn btn-'. $data['2']['class'] .'" onclick="'. $data['2']['act'] .'">
          '. $data['2']['text'] .'
        </button>
      </div>
    </label>';
  return $html;
}

function filterPet($filter = array('keyword', 'breed' => '', 'species' => '')) {
  global $db, $userinfo;

  $xtpl = new XTemplate('pet.tpl', PATH . '/list');
  $sql = 'select * from `'. PREFIX .'_pet` where name like "%'. $filter['keyword'] .'%" and microchip like "%'. $filter['keyword'] .'%" and miear like "%'. $filter['keyword'] .'%" and breed like "%'. $filter['breed'] .'%" and species like "%'. $filter['species'] .'%" and userid = ' . $userinfo['id'];
  $query = $db->query($sql);

  while ($row = $query->fetch()) {
    $sql = 'select * from `'. PREFIX .'_trade` where petid = ' . $row['id'];
    $query2 = $db->query($sql);
    
    $x = array(1 => 1, 2);
    while ($trade = $query2->fetch()) {
      unset($x[$trade['type']]);
    }

    $xtpl->assign('id', $row['id']);
    $xtpl->assign('name', $row['name']);
    $xtpl->assign('breed', $row['breed']);
    $xtpl->assign('species', $row['species']);
    $xtpl->assign('micro', $row['microchip']);
    $xtpl->assign('miear', $row['miear']);
    if (empty($row['microchip'])) $xtpl->assign('micro', '--');
    if (empty($row['miear'])) $xtpl->assign('miear', '--');
    if (in_array(1, $x)) $xtpl->parse('main.row.sell');
    if (in_array(2, $x)) $xtpl->parse('main.row.breed');
    $xtpl->parse('main.row');
  }

  $xtpl->parse('main');
  return $xtpl->text();
}

function trading($filter = array('page' => 1, 'limit' => 10, 'breed' => '', 'species' => '', 'status' => array(0 => 1, 1, 1), 'type' => array(0 => 1, 1, 1), 'contact' => array(0 => 1, 1))) {
  global $db, $buy_sex, $userinfo;
  $status_name = array('Đang chờ duyệt', 'Đã duyệt', 'Đã hủy');

  $xtpl = new XTemplate('trading.tpl', PATH . '/list');
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

function navList ($number, $page, $limit) {
  global $lang_global;
  $total_pages = ceil($number / $limit);

  $on_page = $page;
  $page_string = "";
  if ($total_pages > 10) {
    $init_page_max = ($total_pages > 3) ? 3 : $total_pages;
    for ($i = 1; $i <= $init_page_max; $i ++) {
      $page_string .= ($i == $on_page) ? '<div class="btn">' . $i . "</div>" : '<button class="btn btn-info" onclick="goPage('.$i.')">' . $i . '</button>';
      if ($i < $init_page_max) $page_string .= " ";
    }
    if ($total_pages > 3) {
      if ($on_page > 1 && $on_page < $total_pages) {
        $page_string .= ($on_page > 5) ? " ... " : ", ";
        $init_page_min = ($on_page > 4) ? $on_page : 5;
        $init_page_max = ($on_page < $total_pages - 4) ? $on_page : $total_pages - 4;
        for ($i = $init_page_min - 1; $i < $init_page_max + 2; $i ++) {
          $page_string .= ($i == $on_page) ? '<div class="btn">' . $i . "</div>" : '<button class="btn btn-info" onclick="goPage('.$i.')">' . $i . '</button>';
          if ($i < $init_page_max + 1)  $page_string .= " ";
        }
        $page_string .= ($on_page < $total_pages - 4) ? " ... " : ", ";
      }
      else {
        $page_string .= " ... ";
      }
      
      for ($i = $total_pages - 2; $i < $total_pages + 1; $i ++) {
        $page_string .= ($i == $on_page) ? '<div class="btn">' . $i . "</div>" : '<button class="btn btn-info" onclick="goPage('.$i.')">' . $i . '</button>';
        if ($i < $total_pages) $page_string .= " ";
      }
    }
  }
  else {
    if ($total_pages) {
      for ($i = 1; $i < $total_pages + 1; $i ++) {
        $page_string .= ($i == $on_page) ? '<div class="btn">' . $i . "</div>" : '<button class="btn btn-info" onclick="goPage('.$i.')">' . $i . '</button>';
        if ($i < $total_pages) $page_string .= " ";
      }
    }
    else {
      $page_string .= '<div class="btn">' . 1 . "</div>";
    }
  }
  return $page_string;
}

function navList2 ($number, $page, $limit, $type) {
  global $lang_global;
  $total_pages = ceil($number / $limit);

  $on_page = $page;
  $page_string = "";
  if ($total_pages > 10) {
    $init_page_max = ($total_pages > 3) ? 3 : $total_pages;
    for ($i = 1; $i <= $init_page_max; $i ++) {
      $page_string .= ($i == $on_page) ? '<div class="btn">' . $i . "</div>" : '<button class="btn btn-info" onclick="'. $type .'('.$i.')">' . $i . '</button>';
      if ($i < $init_page_max) $page_string .= " ";
    }
    if ($total_pages > 3) {
      if ($on_page > 1 && $on_page < $total_pages) {
        $page_string .= ($on_page > 5) ? " ... " : ", ";
        $init_page_min = ($on_page > 4) ? $on_page : 5;
        $init_page_max = ($on_page < $total_pages - 4) ? $on_page : $total_pages - 4;
        for ($i = $init_page_min - 1; $i < $init_page_max + 2; $i ++) {
          $page_string .= ($i == $on_page) ? '<div class="btn">' . $i . "</div>" : '<button class="btn btn-info" onclick="'. $type .'('.$i.')">' . $i . '</button>';
          if ($i < $init_page_max + 1)  $page_string .= " ";
        }
        $page_string .= ($on_page < $total_pages - 4) ? " ... " : ", ";
      }
      else {
        $page_string .= " ... ";
      }
      
      for ($i = $total_pages - 2; $i < $total_pages + 1; $i ++) {
        $page_string .= ($i == $on_page) ? '<div class="btn">' . $i . "</div>" : '<button class="btn btn-info" onclick="'. $type .'('.$i.')">' . $i . '</button>';
        if ($i < $total_pages) $page_string .= " ";
      }
    }
  }
  else {
    if ($total_pages) {
      for ($i = 1; $i < $total_pages + 1; $i ++) {
        $page_string .= ($i == $on_page) ? '<div class="btn">' . $i . "</div>" : '<button class="btn btn-info" onclick="'. $type .'('.$i.')">' . $i . '</button>';
        if ($i < $total_pages) $page_string .= " ";
      }
    }
    else {
      $page_string .= '<div class="btn">' . 1 . "</div>";
    }
  }
  return $page_string;
}

function navListX ($number, $page, $limit, $module_name) {
  global $lang_global, $op;
  $total_pages = ceil($number / $limit);

  $on_page = $page;
  $page_string = "";
  if ($total_pages > 10) {
    $init_page_max = ($total_pages > 3) ? 3 : $total_pages;
    for ($i = 1; $i <= $init_page_max; $i ++) {
      $page_string .= ($i == $on_page) ? '<div class="btn">' . $i . "</div>" : '<a class="btn btn-info" href="/'. $module_name . $i .'">' . $i . '</a>';
      if ($i < $init_page_max) $page_string .= " ";
    }
    if ($total_pages > 3) {
      if ($on_page > 1 && $on_page < $total_pages) {
        $page_string .= ($on_page > 5) ? " ... " : ", ";
        $init_page_min = ($on_page > 4) ? $on_page : 5;
        $init_page_max = ($on_page < $total_pages - 4) ? $on_page : $total_pages - 4;
        for ($i = $init_page_min - 1; $i < $init_page_max + 2; $i ++) {
          $page_string .= ($i == $on_page) ? '<div class="btn">' . $i . "</div>" : '<a class="btn btn-info" href="/'. $module_name . $i .'">' . $i . '</a>';
          if ($i < $init_page_max + 1)  $page_string .= " ";
        }
        $page_string .= ($on_page < $total_pages - 4) ? " ... " : ", ";
      }
      else {
        $page_string .= " ... ";
      }
      
      for ($i = $total_pages - 2; $i < $total_pages + 1; $i ++) {
        $page_string .= ($i == $on_page) ? '<div class="btn">' . $i . "</div>" : '<a class="btn btn-info" href="/'. $module_name . $i .'">' . $i . '</a>';
        if ($i < $total_pages) $page_string .= " ";
      }
    }
  }
  else {
    if ($total_pages) {
      for ($i = 1; $i < $total_pages + 1; $i ++) {
        $page_string .= ($i == $on_page) ? '<div class="btn">' . $i . "</div>" : '<a class="btn btn-info" href="/'. $module_name . $i .'">' . $i . '</a>';
        if ($i < $total_pages) $page_string .= " ";
      }
    }
    else {
      $page_string .= '<div class="btn">' . 1 . "</div>";
    }
  }
  return $page_string;
}

// function navList2 ($number, $page, $limit, $nv, $op) {
//   global $lang_global;
//   $total_pages = ceil($number / $limit);

//   $on_page = $page;
//   $page_string = "";
//   if ($total_pages > 10) {
//     $init_page_max = ($total_pages > 3) ? 3 : $total_pages;
//     for ($i = 1; $i <= $init_page_max; $i ++) {
//       $page_string .= ($i == $on_page) ? '<div class="btn">' . $i . "</div>" : '<a href="/'. $nv .'/'. $op .'/?id='. $i .'">'. $i .'</a>';
//       if ($i < $init_page_max) $page_string .= " ";
//     }
//     if ($total_pages > 3) {
//       if ($on_page > 1 && $on_page < $total_pages) {
//         $page_string .= ($on_page > 5) ? " ... " : ", ";
//         $init_page_min = ($on_page > 4) ? $on_page : 5;
//         $init_page_max = ($on_page < $total_pages - 4) ? $on_page : $total_pages - 4;
//         for ($i = $init_page_min - 1; $i < $init_page_max + 2; $i ++) {
//           $page_string .= ($i == $on_page) ? '<div class="btn">' . $i . "</div>" : '<a href="/'. $nv .'/'. $op .'/?id='. $i .'">'. $i .'</a>';
//           if ($i < $init_page_max + 1)  $page_string .= " ";
//         }
//         $page_string .= ($on_page < $total_pages - 4) ? " ... " : ", ";
//       }
//       else {
//         $page_string .= " ... ";
//       }
      
//       for ($i = $total_pages - 2; $i < $total_pages + 1; $i ++) {
//         $page_string .= ($i == $on_page) ? '<div class="btn">' . $i . "</div>" : '<a href="/'. $nv .'/'. $op .'/?id='. $i .'">'. $i .'</a>';
//         if ($i < $total_pages) $page_string .= " ";
//       }
//     }
//   }
//   else {
//     if ($total_pages) {
//       for ($i = 1; $i < $total_pages + 1; $i ++) {
//         $page_string .= ($i == $on_page) ? '<div class="btn">' . $i . "</div>" : '<a href="/'. $nv .'/'. $op .'/?id='. $i .'">'. $i .'</a>';
//         if ($i < $total_pages) $page_string .= " ";
//       }
//     }
//     else {
//       $page_string .= '<div class="btn">' . 1 . "</div>";
//     }
//   }
//   return $page_string;
// }

