<?PHP
/* ====================
[BEGIN_COT_EXT]
Hooks=comments.tags
Tags=comments.tpl:{COMMENTS_ROW_REPLY},{COMMENTS_ROW_REPLY_BOX},{COMMENTS_ROW_REPLY_LINK}, {COMMENTS_REPLY_SEND_AJAX}, {COMMENTS_REPLY_ADD_INPUT},{PHP.reply_error}
[END_COT_EXT]

==================== */

/*************************************/
/* "Reply for comments"              */
/*  Autor Dr2005alex                 */
/*  Dr2005alex@mail.ru               */
/*  Start Version: Siena   0.9.14    */
/*************************************/

defined('COT_CODE') or die('Wrong URL');

if(cot_plugin_active('ckeditor') && $cfg['plugin']['rcomm']['main_editor']) $rcomm_ckeditor = 'ckeditor: true, ';

if ($cfg['jquery'] && $cfg['plugin']['rcomm']['ajax_send']){
		$_SESSION['rcomm'][$ext_name][$code]['d'] = $d_tmp  ;

		    // отключаем паджинацию и форму
		    if($R['onlycomments']){

		        $t->assign(array("COMMENTS_EMPTYTEXT" => true));
		         $t->reset('COMMENTS.COMMENTS_CLOSED');
		         $t->reset('COMMENTS.PAGNAVIGATOR');
		         $t->reset('COMMENTS.COMMENTS_NEWCOMMENT');

		    	}


		$reply_id = cot_import('reply_id', 'G','INT');
		$rplt = new XTemplate(cot_tplfile('rcomm', true));

		if($reply_id && !$coord){			$rplt->assign("REPLY_ID_SHOW" , cot_import('reply_id', 'G','INT'));
			$rplt->parse("REPLYSCRIPT");
			$t->assign("COMMENTS_REPLY_SCRIPT", $rplt->text("REPLYSCRIPT"));		}

		if($coord){

			foreach ($coord as $key => $value) {
		    $rplt->assign(array("REPLY" =>( $ord[1] == 'ASC')? $key: $value['first'] ,
		                        "DESC" =>( $ord[1] == 'ASC')? 'no': 'yes' ,
		                        "START" =>( $ord[1] == 'ASC')?$value['first']: $key,
		                        "END" =>( $ord[1] == 'ASC')? $value['last']: $key,
		                        "COLOR" =>  $cfg['plugin']['rcomm']['color_line'],
		                        "REPLY_ID_SHOW" =>$reply_id,
		                        "M_LINE" =>$cfg['plugin']['rcomm']['margin_line'],
		                        "M_BOX" =>$cfg['plugin']['rcomm']['multipad_reply'],
		     ));
		    $rplt->parse("REPLYSCRIPT.ROW");
			}

		    $rplt->parse("REPLYSCRIPT");

		    /* pages */
		  	$show_link = cot_rc('show_link', array(
				'ajax' => "OnClick = \"return rcomm_ajaxSend({".$rcomm_ckeditor." removeId:'rcomm_page',append:true, method: 'POST', formId:'form_show_link', url: '".cot_url('plug', 'r=rcomm')."',data:'action=show&cat={$cat}&ext_name={$ext_name}&com_code={$code}&dcm={$pagenext}&link_area={$link_area}&link_params={$link_params}', divId: 'ajax_display', errMsg: '".$L['ajaxSenderror']."' });\""
			));


		      if($pagenav['nextlink']){
				    $rplt->assign(array(

									    "SHOW_LINK" =>$show_link,

				     ));
				    $rplt->parse("PAGES");

		     }
		    $t->assign(array("COMMENTS_REPLY_SCRIPT" => $rplt->text("REPLYSCRIPT"),
		                     "COMMENTS_REPLY_PAGES" => $rplt->text("PAGES")
		    ));
		    $t->reset('COMMENTS.PAGNAVIGATOR');



		}
}

?>
