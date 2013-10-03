<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=rc
[END_COT_EXT]
==================== */
/*************************************/
/* "Light page"                      */
/*  Autor Dr2005alex                 */
/*  Dr2005alex@mail.ru               */
/*  Start Version: Siena   0.9.14    */
/*************************************/

defined('COT_CODE') or die('Wrong URL');



if ($cfg['jquery'] && $cfg['turnajax'] )
{


    cot_rc_embed('var lp_id = "'.$cfg['plugin']['light_page']['div_id'].'";');

   cot_rc_add_file($cfg['plugins_dir'] . '/light_page/js/light_page.js');
}