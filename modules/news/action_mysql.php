<?php

/**
 * @Project Petcoffee-tech
 * @Chistua (hchieuthua@gmail.com)
 * @Copyright (C) 2019
 * @Createdate 21-03-2019 13:15
 */

if (!defined('NV_IS_FILE_MODULES')) {
    die('Stop!!!');
}

define("PREFIX", $db_config['prefix'] . "_" . $module_name);

$sql_drop_module = array();
// $sql_drop_module[] = "DROP TABLE IF EXISTS `" . PREFIX . "_row`";
// $sql_create_module = $sql_drop_module;
// $sql_create_module[] = "CREATE TABLE `" . PREFIX . "_row` (
//   `id` int(11) NOT NULL AUTO_INCREMENT,
//   `type` int(11) NOT NULL,
//   `date_type` int(11) NOT NULL,
//   `user_id` int(11) NOT NULL,
//   `time` int(11) NOT NULL,
//   PRIMARY KEY (`id`)
// ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";



// CREATE TABLE `pet_biograph_pet` (
//   `id` int(11) NOT NULL,
//   `name` text NOT NULL,
//   `dateofbirth` text NOT NULL,
//   `species` text NOT NULL,
//   `breed` text NOT NULL,
//   `sex` int(11) NOT NULL DEFAULT '0',
//   `color` text NOT NULL,
//   `microchip` text NOT NULL,
//   `image` text NOT NULL,
//   `active` int(11) NOT NULL DEFAULT '0',
//   `userid` int(11) NOT NULL DEFAULT '0',
//   `fid` varchar(11) NOT NULL,
//   `mid` varchar(11) NOT NULL
// ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
// ALTER TABLE `pet_biograph_pet`
//   ADD PRIMARY KEY (`id`);
// ALTER TABLE `pet_biograph_pet`
//   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
// CREATE TABLE `pet_biograph_remind` (
//   `id` int(11) NOT NULL,
//   `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
//   `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
//   `rate` int(11) NOT NULL DEFAULT '0',
//   `visible` int(11) DEFAULT '0'
// ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
// ALTER TABLE `pet_biograph_remind`
//   ADD PRIMARY KEY (`id`);
// ALTER TABLE `pet_biograph_remind`
//   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
// CREATE TABLE `pet_biograph_user` (
//   `id` int(11) NOT NULL,
//   `username` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
//   `password` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
//   `fullname` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
//   `mobile` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
//   `politic` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
//   `address` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
//   `active` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
//   `image` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
//   `center` int(11) NOT NULL DEFAULT '0'
// ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
// ALTER TABLE `pet_biograph_user`
//   ADD PRIMARY KEY (`id`);
// ALTER TABLE `pet_biograph_user`
//   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

