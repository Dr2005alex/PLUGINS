<?PHP
/* ====================
[BEGIN_COT_EXT]
Hooks=comments.main
[END_COT_EXT]

==================== */

/*************************************/
/* "Reply for comments"              */
/*  Autor Dr2005alex                 */
/*  Dr2005alex@mail.ru               */
/*  Start Version: Siena   0.9.14    */
/*************************************/

defined('COT_CODE') or die('Wrong URL');


if ($cfg['jquery'] && $cfg['plugin']['rcomm']['ajax_send']){

		unset($link_params['e']);
		$action  = cot_import('action', 'G', 'TXT');
		if(empty($action))$action = cot_import('action', 'P', 'TXT');

		if( empty($action)){		$_SESSION[$ext_name][$code]['link_area'] = $link_area;
		$_SESSION[$ext_name][$code]['link_params'] = $link_params;

		}else{
		      $link_area = $_SESSION[$ext_name][$code]['link_area'];
		      $link_params = $_SESSION[$ext_name][$code]['link_params'];

		      }
		$_SESSION['cot_com_back'][$ext_name][$cat][$code] = array($link_area, $link_params);




	/*--------------------- pagenav -----------------------------------------------------*/

          $totalitems = cot_comments_count($ext_name, $code);
           //$R['i_reply'] = 6;

          // smart pagnav
         if(!empty($R['i_reply'])){

           $page_d = ceil($R['i_reply'] / $cfg['plugin']['comments']['maxcommentsperpage']);		   $pagenav = cot_pagenav($link_area, $link_params, $d, $totalitems,$cfg['plugin']['comments']['maxcommentsperpage'], $d_var, '#comments');           if($pagenav['current'] < $page_d) $d = (($page_d - 1) * $cfg['plugin']['comments']['maxcommentsperpage']) ;
           $R['opencomments'] = true;
                                     }

          // end smart pagnav

          if($_SESSION['rcomm'][$ext_name][$code]['d'] > $d && $cfg['plugin']['rcomm']['open_comments']){		       	 $d = $_SESSION['rcomm'][$ext_name][$code]['d'];
		       	 $R['opencomments'] = true;
         }


			$pagenav = cot_pagenav($link_area, $link_params, $d, $totalitems,$cfg['plugin']['comments']['maxcommentsperpage'], $d_var, '#comments');

                  // $pagenav['onpage']

        $pagenext = ($cfg['easypagenav']) ? $pagenav['current']+1 : $pagenav['current'] * $cfg['plugin']['comments']['maxcommentsperpage'];
        $d_tmp = $d;
	/*--------------------------------------------------------------------------------*/
   if(cot_plugin_active('ckeditor') && $cfg['plugin']['rcomm']['main_editor']) $rcomm_ckeditor = 'ckeditor: true, ';
   $t->assign(array(
		      "COMMENTS_REPLY_SEND_AJAX" => "  onSubmit=\"return  rcomm_ajaxSend({".$rcomm_ckeditor." ajaxId:'button_ajax_loader_main',method: 'POST', formId: 'commentform', url: '".cot_url('plug', 'r=rcomm&cat='.$cat.'&ext_name='.$ext_name.'&action=send&com_code='.$code.'&reply_id=0')."', divId: 'rcomm_mes', errMsg: '".$L['ajaxSenderror']."' });\"",
              "COMMENTS_REPLY_ADD_INPUT" => ($rcomm_ckeditor) ? cot_inputbox('hidden', 'rtext2', $rtext2):''
                  ));

 }
?>
