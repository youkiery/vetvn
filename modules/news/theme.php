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



function sellList($filter = array('species' => '', 'breed' => '', 'keyword' => '', 'page' => '1', 'limit' => '12')) {
  global $db, $module_name;

  $xtpl = new XTemplate('list.tpl', PATH2);
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

  $xtpl = new XTemplate('list.tpl', PATH2);
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

function buyList($filter = array('species' => '', 'breed' => '', 'page' => '1', 'limit' => '12')) {
  global $db, $module_name, $buy_sex;

  $xtpl = new XTemplate('list.tpl', PATH2);
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

function nav_generater($url, $number, $page, $limit) {
  $html = '';
  $total = floor($number / $limit) + ($number % $limit ? 1 : 0);
  for ($i = 1; $i <= $total; $i++) {
    if ($page == $i) {
      $html .= '<a class="btn btn-default">' . $i . '</a>';
    } 
    else {
      $html .= '<a class="btn btn-info" href="'. $url .'&page='. $i .'&limit='. $limit .'">' . $i . '</a>';
    }
  }
  return $html;
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

