<?php

/**
 * @Project Mining 0.1
 * @Author Frogsis
 * @Createdate Mon, 28 Oct 2019 15:00:00 GMT
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) die('Stop!!!');
define('NV_IS_FILE_ADMIN', true);
include_once(NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php');
include_once(NV_ROOTDIR . '/modules/' . $module_file . '/theme.php');

function testModal() {
  global $module_file, $op;
  $xtpl = new XTemplate("test-modal.tpl", NV_ROOTDIR . "/modules/". $module_file ."/template/admin/" . $op);
  $xtpl->assign('content', testList());
  $xtpl->parse('main');
  return $xtpl->text();
}

function contestModal() {
  global $module_file, $db, $op;
  $xtpl = new XTemplate("contest-modal.tpl", NV_ROOTDIR . "/modules/". $module_file ."/template/admin/" . $op);

  $query = $db->query("select * from `". PREFIX ."test` where active = 1");
  while ($row = $query->fetch()) {
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('name', $row['name']);
    $xtpl->parse('main.test');
  }
  $xtpl->parse('main');
  return $xtpl->text();
}

function removeModal() {
  global $module_file, $op;
  $xtpl = new XTemplate("remove-contest-modal.tpl", NV_ROOTDIR . "/modules/". $module_file ."/template/admin/" . $op);
  $xtpl->parse('main');
  return $xtpl->text();
}

function removeAllModal() {
  global $module_file, $op;
  $xtpl = new XTemplate("remove-all-contest-modal.tpl", NV_ROOTDIR . "/modules/". $module_file ."/template/admin/" . $op);
  $xtpl->parse('main');
  return $xtpl->text();
}

function testList() {
  global $module_file, $db, $op;
  $xtpl = new XTemplate("test-content.tpl", NV_ROOTDIR . "/modules/". $module_file ."/template/admin/" . $op);
  $query = $db->query("select * from `". PREFIX ."test` order by id desc");
  $index = 1;
  while ($row = $query->fetch()) {
    $xtpl->assign('index', $index ++);
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('name', $row['name']);
    if ($row['active']) $xtpl->parse('main.row.toggleon');
    else $xtpl->parse('main.row.toggleoff');
    $xtpl->parse('main.row');
  }
  $xtpl->parse('main');
  return $xtpl->text();
}

function contestList() {
  global $module_file, $nv_Request, $db, $op;

  $filter = $nv_Request->get_array('filter', 'post');
  if (empty($filter['page'])) $filter['page'] = 1;
  if (empty($filter['limit'])) $filter['limit'] = 10;

  $xtra = array();

  if (!empty($filter['species'])) {
    $xtra[]= 'species = ' . $filter['species'];
  }
  if (!empty($filter['contest'])) {
    $list = array();
    foreach ($filter['contest'] as $id) {
      $list[]= '(test like \'%"' . $id .'"%\')';
    }
    $xtra[]= implode(' or ', $list);
  }
  $xtra = implode(' and ', $xtra);

  $xtpl = new XTemplate("contest-list.tpl", NV_ROOTDIR . "/modules/". $module_file ."/template/admin/" . $op);

  $query = $db->query("select count(*) as count from `". PREFIX ."row`  ". ($xtra ? " where " . $xtra : "") ." order by id desc");
  $number = $query->fetch()['count'];

  $query = $db->query("select * from `". PREFIX ."row` ". ($xtra ? " where " . $xtra : "") ." order by id desc limit 10 offset " . ($filter['page'] - 1) * $filter['limit']);
  $index = 1;
  $test_data = getTestDataList();
  // var_dump($test_data);die();
  while ($row = $query->fetch()) {
    $xtpl->assign('index', $index ++);
    $contest = json_decode($row['test']);
    $test = array();
    foreach ($contest as $id) {
      if ($test_data[$id]) $test[]= $test_data[$id];
    }

    $xtpl->assign('id', $row['id']);
    $xtpl->assign('species', ucwords(getSpecies($row['species'])));
    $xtpl->assign('name', $row['name']);
    $xtpl->assign('petname', $row['petname']);
    $xtpl->assign('address', $row['address']);
    $xtpl->assign('mobile', $row['mobile']);
    $xtpl->assign('contest', implode(', ', $test));
    if ($row['active']) $xtpl->parse('main.row.done');
    else $xtpl->parse('main.row.undone');
    $xtpl->parse('main.row');
  }
  $xtpl->assign('nav', navList($number, $filter['page'], $filter['limit'], 'goPage'));
  $xtpl->parse('main');
  return $xtpl->text();
}
