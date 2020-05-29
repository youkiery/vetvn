<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12/31/2009 0:51
 */

if (!defined('NV_SYSTEM')) {
    die('Stop!!!');
}
if (!in_array($op, array(
    'viewcat',
    'detail'
))) {
    define('NV_IS_MOD_NEWS', true);
}
require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';
define('PREFIX', $db_config['prefix'] . '_' . $module_name . '_');
define('PATH', NV_ROOTDIR . "/modules/". $module_file ."/template");
define('PATH2', NV_ROOTDIR . "/modules/". $module_file ."/template/user/". $op);

global $global_array_cat;
$global_array_cat = array();
$catid = 0;
$parentid = 0;
$alias_cat_url = isset($array_op[0]) ? $array_op[0] : '';
$array_mod_title = array();

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE status IN(' . implode(',', $global_code_defined['cat_visible_status']) . ') ORDER BY sort ASC';
$list = $nv_Cache->db($sql, 'catid', $module_name);
if (!empty($list)) {
    foreach ($list as $l) {
        $global_array_cat[$l['catid']] = $l;
        $global_array_cat[$l['catid']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
        if ($alias_cat_url == $l['alias']) {
            $catid = $l['catid'];
            $parentid = $l['parentid'];
        }
    }
}

//Xac dinh RSS
if ($module_info['rss']) {
    $rss[] = array(
        'title' => $module_info['custom_title'],
        'src' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['rss']
    );
}

// foreach ($global_array_cat as $catid_i => $array_cat_i) {
//     if ($catid_i > 0 and $array_cat_i['parentid'] == 0) {
//         $act = 0;
//         $submenu = array();
//         if ($catid_i == $catid or $catid_i == $parentid) {
//             $act = 1;
//             if (!empty($global_array_cat[$catid_i]['subcatid'])) {
//                 $array_catid = explode(',', $global_array_cat[$catid_i]['subcatid']);
//                 foreach ($array_catid as $sub_catid_i) {
//                     $array_sub_cat_i = $global_array_cat[$sub_catid_i];
//                     $sub_act = 0;
//                     if ($sub_catid_i == $catid) {
//                         $sub_act = 1;
//                     }
//                     $submenu[] = array(
//                         $array_sub_cat_i['title'],
//                         $array_sub_cat_i['link'],
//                         $sub_act
//                     );
//                 }
//             }
//         }
//         $nv_vertical_menu[] = array(
//             $array_cat_i['title'],
//             $array_cat_i['link'],
//             $act,
//             'submenu' => $submenu
//         );
//     }

//     //Xac dinh RSS
//     if ($catid_i and $module_info['rss']) {
//         $rss[] = array(
//             'title' => $module_info['custom_title'] . ' - ' . $array_cat_i['title'],
//             'src' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['rss'] . '/' . $array_cat_i['alias']
//         );
//     }
// }
// unset($result, $catid_i, $parentid_i, $title_i, $alias_i);

$module_info['submenu'] = 0;

$page = 1;
$per_page = $module_config[$module_name]['per_page'];
$st_links = $module_config[$module_name]['st_links'];

$count_op = sizeof($array_op);
if (!empty($array_op) and $op == 'main') {
    $op = 'main';
    if ($count_op == 1 or substr($array_op[1], 0, 5) == 'page-') {
        if ($count_op > 1 or $catid > 0) {
            $op = 'viewcat';
            if (isset($array_op[1]) and substr($array_op[1], 0, 5) == 'page-') {
                $page = intval(substr($array_op[1], 5));
            }
        } elseif ($catid == 0) {
            $contents = $lang_module['nocatpage'] . $array_op[0];
            if (isset($array_op[0]) and substr($array_op[0], 0, 5) == 'page-') {
                $page = intval(substr($array_op[0], 5));
            }
        }
    } elseif ($count_op == 2) {
        $array_page = explode('-', $array_op[1]);
        $id = intval(end($array_page));
        $number = strlen($id) + 1;
        $alias_url = substr($array_op[1], 0, -$number);
        if ($id > 0 and $alias_url != '') {
            if ($catid > 0) {
                $op = 'detail';
            } else {
                //muc tieu neu xoa chuyen muc cu hoac doi ten alias chuyen muc thi van rewrite duoc bai viet
                $_row = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id = ' . $id)->fetch();
                if (!empty($_row) and isset($global_array_cat[$_row['catid']])) {
                    $url_Permanently = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$_row['catid']]['alias'] . '/' . $_row['alias'] . '-' . $_row['id'] . $global_config['rewrite_exturl'], true);
                    nv_redirect_location($url_Permanently);
                }
            }
        }
    }
    $parentid = $catid;
    while ($parentid > 0) {
        $array_cat_i = $global_array_cat[$parentid];
        $array_mod_title[] = array(
            'catid' => $parentid,
            'title' => $array_cat_i['title'],
            'link' => $array_cat_i['link']
        );
        $parentid = $array_cat_i['parentid'];
    }
    krsort($array_mod_title, SORT_NUMERIC);
}

function confirmModal() {
  global $module_file, $db, $op;
  $xtpl = new XTemplate("confirm-modal.tpl", PATH2);
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

  $xtpl = new XTemplate("confirm-list.tpl", PATH2);

  $query = $db->query("select count(*) as count from `". PREFIX ."regist` where active = 1 ". ($xtra ? " and " . $xtra : "") ." order by id desc");
  $number = $query->fetch()['count'];

  // die("select * from `". PREFIX ."regist` where active = 1 ". ($xtra ? " and " . $xtra : "") ." order by id desc limit $filter[limit] offset " . ($filter['page'] - 1) * $filter['limit']);
  $query = $db->query("select * from `". PREFIX ."regist` where active = 1 ". ($xtra ? " and " . $xtra : "") ." order by id desc limit $filter[limit] offset " . ($filter['page'] - 1) * $filter['limit']);
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

function courtBlock() {
  global $db, $module_name;
  $xtpl = new XTemplate("court-block.tpl", PATH2);
  $xtpl->assign('module_name', $module_name);

  $sql = 'select * from pet_vi_contest_1 order by id desc limit 4';
  $query = $db->query($sql);
  $xtpl->assign('type', 1);
  $index = 0;
  while ($row = $query->fetch()) {
    $xtpl->assign('index', $index++);
    $xtpl->assign('title', $row['title']);
    $xtpl->assign('img', $row['homeimgfile']);
    $xtpl->assign('short_intro', $row['hometext']);
    $xtpl->parse('main.block');
  }
  $xtpl->parse('main');
  return $xtpl->text();
}

function helpBlock() {
  global $db, $module_name;
  $xtpl = new XTemplate("help-block.tpl", PATH2);
  $xtpl->assign('module_name', $module_name);

  $sql = 'select * from pet_vi_contest_3 order by id desc limit 4';
  $query = $db->query($sql);
  $xtpl->assign('type', 3);
  $index = 0;
  while ($row = $query->fetch()) {
    $xtpl->assign('index', $index++);
    $xtpl->assign('title', $row['title']);
    $xtpl->assign('img', $row['homeimgfile']);
    $xtpl->assign('short_intro', $row['hometext']);
    $xtpl->parse('main.block');
  }
  $xtpl->parse('main');
  return $xtpl->text();
}

function eduBlock() {
  global $db, $module_name;
  $xtpl = new XTemplate("edu-block.tpl", PATH2);
  $xtpl->assign('module_name', $module_name);

  $sql = 'select * from pet_vi_contest_5 order by id desc limit 2';
  $query = $db->query($sql);
  $xtpl->assign('type', 5);
  $index = 0;
  while ($row = $query->fetch()) {
    $xtpl->assign('index', $index++);
    $xtpl->assign('title', $row['title']);
    $xtpl->assign('img', $row['homeimgfile']);
    $xtpl->assign('short_intro', $row['hometext']);
    $xtpl->parse('main.block');
  }
  $xtpl->parse('main');
  return $xtpl->text();
}

function homeModal() {
  global $db;
  $xtpl = new XTemplate("modal.tpl", PATH2);
  $xtpl->parse('main');
  return $xtpl->text();
}
