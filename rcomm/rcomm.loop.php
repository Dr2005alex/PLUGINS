<?PHP
/* ====================
[BEGIN_COT_EXT]
Hooks=comments.loop
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
require_once cot_incfile('rcomm', 'plug', 'resources');

if(cot_plugin_active('ckeditor') && $cfg['plugin']['rcomm']['main_editor']) $rcomm_ckeditor = 'ckeditor: true, ';

if ($cfg['jquery'] && $cfg['plugin']['rcomm']['ajax_send']){

  	$comm_reply_link = cot_rc('reply_link', array(
		'ajax' => "OnClick = \"$('.add_reply_comment').remove();return rcomm_ajaxSend({".$rcomm_ckeditor." method: 'GET', url: '".cot_url('plug', 'r=rcomm&action=openform&cat='.$cat.'&ext_name='.$ext_name.'&com_code='.$code.'&d='.$d.'&reply_id='.$row['com_id'].'&reply_userid='.$row['com_authorid'])."',ajaxId:'reply_link_ajax".$i."', divId: 'new_reply_box_".$row['com_id']."', errMsg: '".$L['ajaxSenderror']."' });\"",
	    'i'  => $i
	));

		// save url   //используем начальную ссылку
		$action = (cot_import('action', 'P', 'TXT')) ? cot_import('action', 'P', 'TXT') : cot_import('action', 'G', 'TXT');



		if( $action != 'show') $_SESSION['reply_comments_link'] = cot_url($link_area, $link_params);

		       if($cfg['plugin']['rcomm']['scroll_reply']){

		     	$reply_comments_link = cot_rc('reply_comments_link_jquery', array(
				'val1'=> $reply_index['id'][$row['com_reply']],
				'val2'=> $row['com_id'],
				'num' => $reply_index[$row['com_reply']]
			));
		       	}else{

		     	$reply_comments_link = cot_rc('reply_comments_link', array(
				'url' => ( $action != 'show') ? cot_url($link_area, $link_params, '#c'.$reply_index['id'][$row['com_reply']]): $_SESSION['reply_comments_link'].'#c'.$reply_index['id'][$row['com_reply']],
				'num' => $reply_index[$row['com_reply']]
			));
		         }

					$com_admin = ($auth_admin) ? cot_rc('rcomm_comments_code_admin', array(
							'ipsearch' => cot_build_ipsearch($row['com_authorip']),
							'ajax' => "OnClick = \"if(confirm('".$L['rcomm_delete_comments']."')){return rcomm_ajaxSend({".$rcomm_ckeditor." removeId:'rcomm_page',method: 'GET', url: '".cot_url('plug', 'r=rcomm&action=delete&cat='.$cat.'&reply_id='.$row['com_id'])."', divId: 'ajax_display', errMsg: '".$L['ajaxSenderror']."' });}else{return false;} \""
						)) : '';

					$com_edit = ($auth_admin || $usr['isowner_com']) ? cot_rc('rcomm_comments_code_edit', array(
							'ajax' => "OnClick = \"$('.add_reply_comment').remove();return rcomm_ajaxSend({".$rcomm_ckeditor." ajaxId:'rcomm_edit".$i."', method: 'GET', url: '".cot_url('plug', 'r=rcomm&action=openformedit&cat='.$cat.'&ext_name='.$ext_name.'&com_code='.$code.'&d='.$d.'&reply_id='.$row['com_id'])."', divId: 'new_reply_box_".$row['com_id']."', errMsg: '".$L['ajaxSenderror']."' });\"",
							'allowed_time' => $allowed_time,
							'i'  => $i
						)) : '';


 } else{
  	$comm_reply_link = cot_rc('reply_link', array(
		'ajax' => "OnClick = \"view_comm(".$row['com_id'].", ".$usr['id']."); return false;\"",
	    'i'  => $i
	));
   		     	$reply_comments_link = cot_rc('reply_comments_link', array(
				'url' =>  cot_url($link_area, $link_params, '#c'.$reply_index['id'][$row['com_reply']]),
				'num' => $reply_index[$row['com_reply']]
			));

        require_once(cot_langfile('rcomm'));
        require_once cot_incfile('rcomm', 'plug', 'functions');


        $rcomm_style = 'style = "display:none;"';
  		$rplt = new XTemplate(cot_tplfile('rcomm', true));
		$level = rcomm_level($code, $ext_name);


		  $rplt->assign(array(
		                   'COMMENTS_REPLY_NOAJAX' => true,
		                   'COMMENTS_REPLY_TITLE' => $L['rcomm_reply_rep'],
		                   'COMMENTS_REPLY_ID' =>$row['com_id'],
		                   'COMMENTS_REPLY_AUTHORID' =>$row['com_authorid'],
		                   'COMMENTS_REPLY_COMM_CODE' =>$code,
		                   'COMMENTS_REPLY_EXT_NAME' =>$ext_name,
		                   'COMMENTS_REPLY_CAT' =>$cat,
		                   'COMMENTS_REPLY_FORM_SEND' =>  cot_url('plug', "e=comments&a=send&area=$ext_name&cat=$cat&item=$code&reply_id=".$row['com_id']."&commlevel=".$level[$row['com_id']].'&reply_userid='.$row['com_authorid']) ,
		                   'COMMENTS_REPLY_LEVEL' => $level[$row['com_id']],
		                   'COMMENTS_REPLY_TEXTBOXER' => $auth_write ? cot_textarea('rtext', $rtext, 10, 120, 'id=rcomm_minieditor', 'input_textarea_minieditor'): '',
		                   'COMMENTS_REPLY_AUTHOR' => ($usr['id'] > 0) ? $usr['name'] : cot_inputbox('text', 'rname',$rname),
		                   'COMMENTS_REPLY_VERIFYIMG' => '',
		                   'COMMENTS_REPLY_VERIFY'    => cot_inputbox('text', 'rverify', '', 'size="10" maxlength="20" id="capcha_input'.$i.'"'),
		 ));

       $rplt->parse("REPLYFORM");
       $editor_box = $rplt->text("REPLYFORM");

      	/* == Hook == */
	foreach (cot_getextplugins('rcomm.openform') as $pl)
	{
		include $pl;
	}
	/* ===== */ }
      	/* == Hook == */
	foreach (cot_getextplugins('rcomm.loop') as $pl)
	{
		include $pl;
	}
	/* ===== */

  $t->assign(array(
                   'COMMENTS_ROW_REPLY' => ($auth_write && $enabled) ? $comm_reply_link : '',
                   'COMMENTS_ROW_REPLY_BOX' => cot_rc('new_reply_box', array('id' => $row['com_id'], 'style' => $rcomm_style, 'editor_box' => $editor_box)),
                   'COMMENTS_ROW_REPLY_MARGIN' => ($row['com_level'] >0 )? $cfg['plugin']['rcomm']['multipad_reply']* $row['com_level']:0,
                   'COMMENTS_ROW_LEVEL' => $row['com_level'],
                   'COMMENTS_ROW_REPLY_ID' => $row['com_reply'],
                   'COMMENTS_ROW_REPLY_NUM' => $reply_index[$row['com_reply']],
                   'COMMENTS_ROW_REPLY_LINK' => $reply_comments_link,
                   'COMMENTS_ROW_REPLY_LINK_ID' => $reply_index['id'][$row['com_reply']],
                   'COMMENTS_ROW_ADMIN' => $com_admin,
                   'COMMENTS_ROW_EDIT' => $com_edit,
                   'COMMENTS_ROW_WL' => $cfg['plugin']['rcomm']['multipad_reply']-$cfg['plugin']['rcomm']['margin_line'],
                   'COMMENTS_ROW_COLOR' => $cfg['plugin']['rcomm']['color_line']

  ));





?>
