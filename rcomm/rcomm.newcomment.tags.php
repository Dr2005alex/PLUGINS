<?PHP
/* ====================
[BEGIN_COT_EXT]
Hooks=comments.newcomment.tags
[END_COT_EXT]

==================== */

/*************************************/
/* "Reply for comments"              */
/*  Autor Dr2005alex                 */
/*  Dr2005alex@mail.ru               */
/*  Start Version: Siena   0.9.14    */
/*************************************/

defined('COT_CODE') or die('Wrong UR');


if(!$cfg['plugin']['rcomm']['main_editor']) {
	$t->assign('COMMENTS_FORM_TEXT' , $auth_write && $enabled ? cot_textarea('rtext', $rtext, 10, 120, '', 'input_textarea'): '');

    }
?>
