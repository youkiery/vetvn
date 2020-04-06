<?php
function summaryByDisease($disease = '', $keyword = '', $filter = array('page' => 1, 'limit' => 10)) {
  global $db, $userinfo, $module_name;
  $xtpl = new XTemplate("summary-detail.tpl", "modules/". $module_name ."/template");
  $xtpl->assign('keyword', $keyword);
  $xtpl->assign('disease', $disease);
  $pet_list = getPetListById($userinfo['id']);
  if (empty($pet_list)) {
    $xtpl->parse('main.nodata');
  }
  else if (!empty($disease)) {
    $disease_query = $db->query('select a.*, b.name from `'. PREFIX .'_disease` a inner join `'. PREFIX .'_pet` b on a.petid = b.id where petid in ('. $pet_list .') and disease like "'. $disease .'" and b.name like "%'. $keyword .'%" group by disease order by petid, treat, treated');
    while ($row = $disease_query->fetch()) {
      $xtpl->assign('start', date('d/m/Y', $row['treat']));
      $xtpl->assign('end', date('d/m/Y', $row['treated']));
      $xtpl->assign('pet', $row['name']);
      $xtpl->assign('note', $row['note']);
      $xtpl->parse('main.treat.row');
    }
    $xtpl->parse('main.treat');
  }
  else {
    $disease_query = $db->query('select disease from `'. PREFIX .'_disease` where petid in ('. $pet_list .') and disease like "%'. $keyword .'%" group by disease');
    while ($disease = $disease_query->fetch()) {
      $xtpl->assign('disease', $disease['disease']);
      $xtpl->parse('main.disease.row');
    }
    $xtpl->parse('main.disease');
  }
  $xtpl->parse('main');
  return $xtpl->text();
} 

