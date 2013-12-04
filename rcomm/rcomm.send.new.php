<?PHP
/* ====================
[BEGIN_COT_EXT]
Hooks=comments.send.new
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

  if($reply_id > 0 ||  $reply_id == 0){

       // send PM ajax
      if( $cfg['plugin']['rcomm']['pm_send'] && $arr_d['com_authorid'] > 0 && cot_module_active('pm') && $reply_userid >0){

	      	rcomm_pm_send($reply_userid, $_SESSION[$area][$item]['link_area'], $_SESSION[$area][$item]['link_params'],$id);

      	}
      // send MAIL ajax
      if( $cfg['plugin']['rcomm']['mail_send'] && $arr_d['com_authorid'] > 0 && cot_module_active('pm') && $reply_userid >0){

	      	rcomm_cot_send_translated_mail($reply_userid, $_SESSION[$area][$item]['link_area'], $_SESSION[$area][$item]['link_params'],$id);

      	}

     /*   for smart   */
    $comments_order = ' com_reply_date ASC,  com_id ASC '; // принудительная сортировка по com_reply_date
	$sql = $db->query("SELECT com_id FROM $db_com WHERE com_area = ? AND com_code = ?  ORDER BY $comments_order ",array($area, $item));
             $i = 0;
      		foreach ($sql->fetchAll() as $row){            $i++;
            if($row['com_id'] == $id)$i_reply = $i;
      		}
    /*-----------------------------------*/


		// sceditor
       if(($cfg['parser'] == 'html') && (cot_plugin_active('ckeditor')))$set_sc = 'ckeditor_clr: true ,';
       //redir если все в норме показываем результат
       echo "
      	    <script type=\"text/javascript\" >
              rcomm_ajaxSend({".$rcomm_ckeditor." ".$set_sc." clearTxT:'true', nonshowloading:'true' ,removeId:'rcomm_page',append:false,method: 'GET', url: '".cot_url('plug', 'r=rcomm&action=show&cat='.$cat.'&ext_name='.$area.'&com_code='.$item.'&i_reply='.$i_reply.'&reply_id='.$id,'', true)."', divId: 'ajax_display', errMsg: '".$L['ajaxSenderror']."' });

			</script>";

        exit;
      }
 }else{
      // send PM, no ajax
      if($reply_id > 0 && $cfg['plugin']['rcomm']['pm_send'] && $arr_d['com_authorid'] > 0 && cot_module_active('pm') && $reply_userid >0){
            require_once(cot_langfile('rcomm'));
	      	rcomm_pm_send($reply_userid, $url_area , $url_params, $id);

      	}
      // send MAIL, no ajax
      if($reply_id > 0 && $cfg['plugin']['rcomm']['mail_send'] && $arr_d['com_authorid'] > 0 && cot_module_active('pm') && $reply_userid >0){

	      	rcomm_cot_send_translated_mail($reply_userid, $url_area , $url_params, $id);

      	} }






?>
