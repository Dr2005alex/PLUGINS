<?php
/*************************************/
/* "Reply for comments"              */
/*  Autor Dr2005alex                 */
/*  Dr2005alex@mail.ru               */
/*  Start Version: Siena   0.9.14    */
/*************************************/

defined('COT_CODE') or die('Wrong URL');

global $db_com, $db_users, $R;
require_once cot_incfile('comments', 'plug');

// ищем есть ли столбец "com_reply"
$dbres = $db->query("SHOW COLUMNS FROM $db_com WHERE `Field` = 'com_reply'");
if ($dbres->rowCount() == 0)
{
	$db->query("ALTER TABLE $db_com ADD COLUMN `com_reply` int(20) NOT NULL default '0' ");
}


// ищем есть ли столбец "com_reply_date"
$dbres = $db->query("SHOW COLUMNS FROM $db_com WHERE `Field` = 'com_reply_date'");
if ($dbres->rowCount() == 0)
{
	$db->query("ALTER TABLE $db_com ADD COLUMN `com_reply_date` int(20) NOT NULL default '0' ");
}


// Пропишем зачения даты
$db->query("UPDATE $db_com  SET com_reply_date = com_date  ");


// ищем есть ли столбец "com_level"
$dbres = $db->query("SHOW COLUMNS FROM $db_com WHERE `Field` = 'com_level'");
if ($dbres->rowCount() == 0)
{
	$db->query("ALTER TABLE $db_com ADD COLUMN `com_level` int(5) NOT NULL default '0' ");
}


cot_extrafield_add($db_users, 'rcomm_pm_notify', 'inputint', $R['input_radio'],'','','','', 'rcomm_pm_notify','');
cot_extrafield_add($db_users, 'rcomm_mail_notify', 'inputint', $R['input_radio'],'','','','', 'rcomm_mail_notify','');

// включим уведомления
$db->query("UPDATE $db_users  SET user_rcomm_pm_notify = 1 , user_rcomm_mail_notify = 1 ");




?>
