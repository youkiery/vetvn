<?php

/**
 * @Project Mining 0.1
 * @Author Frogsis
 * @Createdate Mon, 28 Oct 2019 15:00:00 GMT
 */

if (!defined('NV_MAINFILE')) { die('Stop!!!'); }
define('PREFIX', $db_config['prefix'] . '_' . $module_name . '_');
define('PATH', NV_ROOTDIR . "/modules/". $module_file ."/template");

function totime($time) {
  if (preg_match("/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/", $time, $m)) {
    $time = mktime(0, 0, 0, $m[2], $m[1], $m[3]);
    if (!$time) {
      $time = time();
    }
  }
  else {
    $time = time();
  }
  return $time;
}

function totimev2($time) {
  if (preg_match("/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/", $time, $m)) {
    $time = mktime(0, 0, 0, $m[2], $m[1], $m[3]);
    if (!$time) {
      $time = 0;
    }
  }
  else {
    $time = 0;
  }
  return $time;
}

function getTestDataList() {
  global $db;

  $list = array();
  $query = $db->query('select * from `'. PREFIX .'test`');
  while ($row = $query->fetch()) {
    $list[$row['id']] = $row['name'];
  }
  return $list;
}

function checkCallNumber($number) {
  $number = intval($number);
  if ($number < 10) {
    return "0" . $number;
  } 
  return $number;
}

function checkSpecies($species) {
  global $db;
  $species = trim(mb_strtolower($species));
  $query = $db->query('select * from `'. PREFIX .'species` where name = "'. $species .'"');
  if ($row = $query->fetch()) {
    rateSpecies($row['id']);
    return $row['id'];
  }
  if ($db->query('insert into `'. PREFIX .'species` (name) values("'. $species .'")')) {
    $id = $db->lastInsertId();
    rateSpecies($id);
    return $id;
  }
  return 0;
}

function rateSpecies($id) {
  global $db;

  $query = $db->query('update `'. PREFIX .'species` set rate = rate + 1 where id = ' . $id);
  if ($query) return true;
  return false;
}

function getSpecies($id) {
  global $db;

  $query = $db->query('select * from `'. PREFIX .'species` where id = '. $id);
  if ($row = $query->fetch()) {
    return $row['name'];
  }
  return '';
}
