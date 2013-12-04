<?PHP
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]

==================== */

/*************************************/
/* "Reply for comments"              */
/*  Autor Dr2005alex                 */
/*  Dr2005alex@mail.ru               */
/*  Start Version: Siena   0.9.14    */
/*************************************/

defined('COT_PLUG') or die('Wrong URL');
require_once cot_incfile('comments', 'plug');
require_once(cot_langfile('rcomm'));
if(cot_plugin_active('ckeditor') && $cfg['plugin']['rcomm']['main_editor']) $rcomm_ckeditor = 'ckeditor: true, ';

$action  = cot_import('action', 'G', 'TXT');
if(empty($action))$action = cot_import('action', 'P', 'TXT');
$reply_id = cot_import('reply_id', 'G','INT');

$reply_userid = cot_import('reply_userid', 'G','INT');
if(empty($reply_userid))$reply_userid = cot_import('reply_userid', 'P','INT');

$R['i_reply']= cot_import('i_reply', 'G','INT');
$commlevel = cot_import('commlevel', 'P','INT');

$text  = cot_import('text', 'P', 'HTM');

// for ckeditor ajax
if(($cfg['parser'] == 'html') && (cot_plugin_active('ckeditor'))){

		$rtext2  = cot_import('rtext2', 'P', 'HTM');
		if(!empty($rtext2))$_POST['rtext'] = $rtext2;
		$rtext3  = cot_import('rtext3', 'P', 'HTM');
		if(!empty($rtext3))$_POST['rtext'] = $rtext3;

}

$rtext  = cot_import('rtext', 'P', 'HTM');

$rname  = cot_import('rname', 'P', 'TXT');



$ext_name  = cot_import('ext_name', 'G', 'TXT');
if(empty($ext_name))$ext_name = cot_import('ext_name', 'P', 'TXT');
$com_code  = cot_import('com_code', 'G', 'TXT');
if(empty($com_code))$com_code = cot_import('com_code', 'P', 'TXT');
$cat = cot_import('cat', 'G', 'TXT');
if(empty($cat))$cat = cot_import('cat', 'P', 'TXT');


cot_sendheaders();

if($action == 'delete'){ // удаляем комментарии

		  if($reply_id){		  	list($ext_name,$com_code) = rcomm_delete($reply_id);
		    $action = 'show'; $reply_id=$reply_id-1;
		    $_GET['reply_id'] = '';
		   }

       }

if($action == 'viewtext')echo cot_parse($text);
if($action == 'viewcaptcha')echo cot_captcha_generate();

if($action == 'show'){ // добавляем комментарии


   if(!cot_import('dcm', 'G', 'INT'))$_GET['dcm']= cot_import('dcm', 'P', 'INT');
   $R['smartcomments'] =  cot_import('smart', 'G','INT');
   $R['onlycomments'] = true;

   require_once cot_incfile('comments', 'plug');
   echo cot_comments_display($ext_name, $com_code, $cat);

}
if($action == 'send' || $action == 'update'){  // запись комментария и проверка на ошибки

   /* errors */
   require_once cot_langfile('comments');




	if (empty($rname) && $usr['id'] == 0)
	{
		cot_error($L['com_authortooshort'], 'rname');
	}
	if (mb_strlen($rtext) < $cfg['plugin']['comments']['minsize'])
	{
		cot_error($L['com_commenttooshort'], 'rtext');
	}
	if ($cfg['plugin']['comments']['commentsize'] && mb_strlen($rtext) > $cfg['plugin']['comments']['commentsize'])
	{
		cot_error($L['com_commenttoolong'], 'rtext');
	}
         // captcha
		    if ($usr['id'] == '0')
		{
			$rverify = cot_import('rverify', 'P', 'TXT');
			if (!cot_captcha_validate($rverify))
			{
				cot_error('captcha_verification_failed', 'rverify');
			}
		}


      	/* == Hook == */
	foreach (cot_getextplugins('rcomm.error') as $pl)
	{
		include $pl;
	}
	/* ===== */


     $errors = cot_get_messages('', 'error');

     	if (count($errors) > 0)
	{
		foreach ($errors as $msg)
		{
			 $text .=  cot_rc('rcomm_error_txt_only', array('txt' => isset($L[$msg['text']]) ? $L[$msg['text']] : $msg['text'] )) ;
		}
		$reply_error = cot_rc('rcomm_error_txt', array('txt' => $text )) ;
      cot_clear_messages();


    if($reply_id == 0){echo  $reply_error;
    if ($usr['id'] == '0'){    echo "<script>
            $('#commentform input[name=rverify]').attr('value', '');
	        rcomm_ajaxSend({".$rcomm_ckeditor." nonshowloading:'true',method: 'GET',url: '".cot_url('plug', 'r=rcomm','',true)."', data:'action=viewcaptcha', divId: 'rcomm_verify".$reply_id."', errMsg: '".$L['ajaxSenderror']."' });
         </script>";
        }

    }else{$action = ($action == 'update')? 'openformedit':'openform'; }


  }else{

  	  if($action == 'update'){

	   /* == Hook == */
		foreach (cot_getextplugins('rcomm.update.first') as $pl)
		{
			include $pl;
		}
		/* ===== */
	  	  	 $comarray['com_text'] = $rtext;
	  	  	 $comarray['com_author'] = $rname;
	         $sql = $db->update($db_com, $comarray, 'com_id=? AND com_code=?', array($reply_id, $com_code));

         echo "<script>
	         rcomm_ajaxSend({".$rcomm_ckeditor." nonshowloading:'true',method: 'POST', formId:'commentform',url: '".cot_url('plug', 'r=rcomm','',true)."', data:'action=viewtext&text=".urlencode($rtext)."', divId: 'commtxt".$reply_id."', errMsg: '".$L['ajaxSenderror']."' });
         </script>";  	  	}else{
       // запись коммента

       define('COT_PLUG', true);       $_GET['a'] = 'send';
       $_GET['area'] =  $ext_name;
       $_GET['item'] =  $com_code;
       $_GET['cat'] =  $cat;

       $R['onlycomments'] = true;
       $R['opencomments'] = true;


	    /* == Hook == */
		foreach (cot_getextplugins('rcomm.send.first') as $pl)
		{
			include $pl;
		}
		/* ===== */


       require_once $cfg['plugins_dir'] . '/comments/comments.php';
       }

   }}

if($action == 'openform' || $action == 'openformedit'){  // открытие формы ответа

		$rplt = new XTemplate(cot_tplfile('rcomm', true));

		$level = rcomm_level($com_code, $ext_name);

        list($auth_read, $auth_write, $auth_admin) = cot_auth('plug', 'comments');

        if($action == 'openformedit'){        	$form_title = $L['rcomm_reply_repedit'];
            $sql = $db->query("SELECT com_text,com_author  FROM $db_com WHERE com_id = ".$reply_id)->fetch();
            $rtext = $sql['com_text'];
            $rname = $sql['com_author'];
            $act = 'update';
             }else{             $form_title = $L['rcomm_reply_rep'];
             $act = 'send';             }

           require_once cot_incfile('forms');

		      	/* == Hook == */
			foreach (cot_getextplugins('rcomm.openform') as $pl)
			{
				include $pl;
			}
			/* ===== */
          //ckeditor
         if(($cfg['parser'] == 'html') && (cot_plugin_active('ckeditor')))$set_sc = 'ckeditor_id:'.$reply_id.',';
         $meditor = ($cfg['plugin']['rcomm']['main_editor']) ? 'input_textarea_minieditor' : 'input_textarea';
		  $rplt->assign(array(
		                   'COMMENTS_REPLY_TITLE' => $form_title,
		                   'COMMENTS_REPLY_ID' =>$reply_id,
		                   'COMMENTS_REPLY_AUTHORID' =>$reply_userid,
		                   'COMMENTS_REPLY_COMM_CODE' =>$com_code,
		                   'COMMENTS_REPLY_EXT_NAME' =>$ext_name,
		                   'COMMENTS_REPLY_CAT' =>$cat,
		                   'COMMENTS_REPLY_SEND_AJAX' => " id=\"comreply_box_form".$reply_id."\" onSubmit=\"return  rcomm_ajaxSend({".$rcomm_ckeditor." ".$set_sc." ajaxId:'button_ajax_loader".$reply_id."', method: 'POST', formId: 'comreply_box_form".$reply_id."', url: '".cot_url('plug', 'r=rcomm&cat='.$cat.'&ext_name='.$ext_name.'&action='.$act.'&com_code='.$com_code.'&d='.$d.'&reply_id='.$reply_id)."', divId: 'new_reply_box_".$reply_id."', errMsg: '".$L['ajaxSenderror']."' });\"",
		                   'COMMENTS_REPLY_LEVEL' => $level[$reply_id],
		                   'COMMENTS_REPLY_TEXTBOXER' => $auth_write ? cot_textarea('rtext', $rtext, 10, 120, 'id=rcomm_minieditor', $meditor): '',
		                   'COMMENTS_REPLY_AUTHOR' => ($usr['id'] > 0) ? $usr['name'] : cot_inputbox('text', 'rname',$rname),
		                   'COMMENTS_REPLY_VERIFYIMG' => cot_captcha_generate(),
		                   'COMMENTS_REPLY_VERIFY'    => cot_inputbox('text', 'rverify', '', 'size="10" maxlength="20"'),
		 ));

       $rplt->parse("REPLYFORM");
       echo $rplt->text("REPLYFORM");
}

?>
