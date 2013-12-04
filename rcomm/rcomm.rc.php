<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=rc
Order=100
[END_COT_EXT]
==================== */
/*************************************/
/* "Reply for comments"              */
/*  Autor Dr2005alex                 */
/*  Dr2005alex@mail.ru               */
/*  Start Version: Siena   0.9.14    */
/*************************************/

defined('COT_CODE') or die('Wrong URL');

 cot_rc_add_file($cfg['plugins_dir'] . '/rcomm/js/rcomm.css');

if ($cfg['jquery'] && $cfg['plugin']['rcomm']['ajax_send'])
{
    if(($cfg['parser'] == 'bbcode') && (cot_plugin_active('markitup'))){

			$autorefresh = ($cfg['plugin']['markitup']['autorefresh']) ? 'true' : 'false';

			cot_rc_embed_footer('var autorefresh = '.$autorefresh.';');
			cot_rc_add_file($cfg['plugins_dir'] . '/rcomm/js/markitup.js');

     }

	cot_rc_add_file($cfg['plugins_dir'] . '/rcomm/js/rcomm.js');


}else{

	cot_rc_embed_footer('

    function rcomm_remove_class() {
	var textareas = document.getElementsByClassName("new_reply_box");
		for (var i = 0; i < textareas.length; i++) {
			textareas[i].style.display = "none";
		}
}
    function view_comm( id, userid ) {

		var box = document.getElementById("new_reply_box_"+id);
		if(box.style.display == "none"){
			rcomm_remove_class();
			box.style.display = "inline";
			if(userid == 0){
			 var cbox = document.getElementById("rcomm_verify0");
			 document.getElementById("rcomm_verify"+id).innerHTML=cbox.innerHTML;
               }
			    }else{box.style.display = "none";}
	}


	');



}
