<?php

/**
 * @Project Mining 0.1
 * @Author Frogsis
 * @Createdate Mon, 28 Oct 2019 15:00:00 GMT
 */

if (!defined('NV_SYSTEM')) die('Stop!!!');
define('NV_IS_MOD_CONGVAN', true);
include_once(NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php');


function confirmModal() {
  global $module_file, $db, $op;
  $xtpl = new XTemplate("confirm-modal.tpl", NV_ROOTDIR . "/modules/". $module_file ."/template/" . $op);
  $query = $db->query('select * from `'. PREFIX .'species` order by rate desc');
  while ($row = $query->fetch()) {
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('species', ucwords($row['name']));
    $xtpl->parse('main.species');
  }

  $query = $db->query('select * from `'. PREFIX .'test`');
  while ($row = $query->fetch()) {
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('contest', $row['name']);
    $xtpl->parse('main.contest');
  }

  $xtpl->assign('content', confirmList());
  $xtpl->parse('main');
  return $xtpl->text();
}

function confirmList() {
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
    $xtra[]= '(' . implode(' or ', $list) . ')';
  }
  $xtra = implode(' and ', $xtra);

  $xtpl = new XTemplate("confirm-list.tpl", NV_ROOTDIR . "/modules/". $module_file ."/template/" . $op);

  $query = $db->query("select count(*) as count from `". PREFIX ."row` where active = 1 ". ($xtra ? " and " . $xtra : "") ." order by id desc");
  $number = $query->fetch()['count'];

  // die("select * from `". PREFIX ."row` where active = 1 ". ($xtra ? " and " . $xtra : "") ." order by id desc limit $filter[limit] offset " . ($filter['page'] - 1) * $filter['limit']);
  $query = $db->query("select * from `". PREFIX ."row` where active = 1 ". ($xtra ? " and " . $xtra : "") ." order by id desc limit $filter[limit] offset " . ($filter['page'] - 1) * $filter['limit']);
  $index = ($filter['page'] - 1) * $filter['limit'] + 1;
  $count = 0;
  $test_data = getTestDataList();
  while ($row = $query->fetch()) {
    $count ++;
    $xtpl->assign('index', $index ++);
    $contest = json_decode($row['test']);
    $test = array();
    foreach ($contest as $id) {
      if ($test_data[$id]) $test[]= $test_data[$id];
    }

    $xtpl->assign('species', ucwords(getSpecies($row['species'])));
    $xtpl->assign('name', $row['name']);
    $xtpl->assign('petname', $row['petname']);
    $xtpl->assign('address', $row['address']);
    $xtpl->assign('mobile', $row['mobile']);
    $xtpl->assign('contest', implode(', ', $test));
    $xtpl->parse('main.row');
  }
  $xtpl->assign('from', ($filter['page'] - 1) * $filter['limit'] + ($count ? 1 : 0));
  $xtpl->assign('to', ($filter['page'] - 1) * $filter['limit'] + $count);
  $xtpl->assign('total', $number);
  $xtpl->assign('nav', navList($number, $filter['page'], $filter['limit'], 'goPage'));
  $xtpl->parse('main');
  return $xtpl->text();
}
