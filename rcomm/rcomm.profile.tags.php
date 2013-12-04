<?PHP
/* ====================
[BEGIN_COT_EXT]
Hooks=users.profile.tags
Tags=users.profile.tpl:{USERS_PROFILE_RCOMM_PM_SEND_TITLE},{USERS_PROFILE_RCOMM_PM_SEND},{USERS_PROFILE_RCOMM_MAIL_SEND_TITLE},{USERS_PROFILE_RCOMM_MAIL_SEND}
[END_COT_EXT]

==================== */

/*************************************/
/* "Reply for comments"              */
/*  Autor Dr2005alex                 */
/*  Dr2005alex@mail.ru               */
/*  Start Version: Siena   0.9.14    */
/*************************************/

defined('COT_CODE') or die('Wrong URL');
    require_once(cot_langfile('rcomm'));

	$t->assign(array(
	    'USERS_PROFILE_RCOMM_PM_SEND_TITLE' => $L['rcomm_pf_pm_title'],
		'USERS_PROFILE_RCOMM_PM_SEND' => cot_radiobox($urr['user_rcomm_pm_notify'], 'ruserrcomm_pm_notify', array(1, 0), array($L['Yes'], $L['No'])),
		'USERS_PROFILE_RCOMM_MAIL_SEND_TITLE' => $L['rcomm_pf_mail_title'],
		'USERS_PROFILE_RCOMM_MAIL_SEND' => cot_radiobox($urr['user_rcomm_mail_notify'], 'ruserrcomm_mail_notify', array(1, 0), array($L['Yes'], $L['No']))
	));

?>
