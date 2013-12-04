<?PHP

/*************************************/
/* "Reply for comments"              */
/*  Autor Dr2005alex                 */
/*  Dr2005alex@mail.ru               */
/*  Start Version: Siena   0.9.14    */
/*************************************/
require_once cot_incfile('comments', 'plug');

function rcomm_level($code, $area)
{
global   $db_com,$db_users,$db;

 $sql = $db->query("SELECT c.*, u.* FROM $db_com AS c
		LEFT JOIN $db_users AS u ON u.user_id=c.com_authorid
		WHERE  com_code='$code' AND com_area = '$area' ORDER BY  com_reply_date ASC,  com_id ASC ");

//определение глубины
while ($lrow = $sql->fetch())
		{
			if(empty($level[$lrow['com_id']])) $level[$lrow['com_id']]=1;
			if(empty($level[$lrow['com_reply']])) $level[$lrow['com_reply']]=0;
			if($level[$lrow['com_reply']]>0 ) $level[$lrow['com_id']]= $level[$lrow['com_reply']]+1;

    }

 return  $level;
 }

 function rcomm_last_date($id)
{	global   $db,$db_com ;

    $arrcomdate = $db->query("SELECT com_date,com_authorid, com_code, com_area, com_reply, com_reply_date, com_level  FROM $db_com WHERE com_id = ".$id." OR  com_reply = ".$id."  ORDER BY com_id asc  LIMIT 1 ")->fetch();
    $delarrdt = $db->query("SELECT com_reply_date  FROM $db_com WHERE  (com_reply_date > ".$arrcomdate['com_reply_date'].") AND  ( com_level <= ".$arrcomdate['com_level'].") AND (com_area = '".$arrcomdate['com_area']."') AND (com_code = '".$arrcomdate['com_code']."' ) ORDER BY com_reply_date ASC LIMIT 1" )->fetch();
    if($delarrdt['com_reply_date'] && $arrcomdate['com_level'] >=0 )$addddt = " AND (com_reply_date <= ".$delarrdt['com_reply_date'].") ";
    $arrcomdate2 = $db->query("SELECT com_id, com_reply_date  FROM $db_com WHERE   ((com_area = '".$arrcomdate['com_area']."') AND (com_code = '".$arrcomdate['com_code']."' ) AND (com_reply_date > ".$arrcomdate['com_reply_date'].") AND  ( com_level > ".$arrcomdate['com_level'].")) $addddt ORDER BY com_id ASC ");
    $rii=1;

            $last_date = $arrcomdate['com_reply_date'];
            foreach ($arrcomdate2->fetchAll() as $lrow)
			{
				 $rii++;
				 if($lrow['com_reply_date'] > $last_date) $last_date =  $lrow['com_reply_date'];

			}
 return   array($last_date,$rii,$arrcomdate);
 }

 function rcomm_delete($id)
  {
  global   $db, $db_com;

        // Check permissions and enablement
	    list($auth_read, $auth_write, $auth_admin) = cot_auth('plug', 'comments');
     if($auth_admin)
	{
			list($last_date,$rii,$arrcomdate) = rcomm_last_date($id);
            $sql = $db->query("DELETE FROM $db_com WHERE  (com_area = '".$arrcomdate['com_area']."') AND (com_code = '".$arrcomdate['com_code']."') AND (com_reply_date >= ".$arrcomdate['com_reply_date']." AND  com_reply_date <= ".$last_date."  )");
			// сдвиг
			$sql = $db->query("UPDATE $db_com  SET com_reply_date = com_reply_date-".$rii." WHERE (com_area = '".$arrcomdate['com_area']."') AND (com_code = '".$arrcomdate['com_code']."') AND (com_reply_date >= ".$arrcomdate['com_reply_date'].") ");
		}

      	/* == Hook == */
	foreach (cot_getextplugins('rcomm.delete') as $pl)
	{
		include $pl;
	}
	/* ===== */

   return array($arrcomdate['com_area'], $arrcomdate['com_code']);  }

 function rcomm_pm_send($userid,$area,$item,$id)
  { global  $db_users, $db_x, $db_pm, $usr, $cfg, $db, $sys;

          $pmsql = $db->query("SELECT  user_name, user_lang
						FROM $db_users WHERE user_id = $userid AND user_rcomm_pm_notify = 1 ");

          if ($row = $pmsql->fetch()){
          require_once cot_langfile('rcomm', 'plug', $cfg['defaultlang'], $row['user_lang']);

			    if (!$L || !isset($L['pm_notify']))
				{
					global $L;
				}


          }else return;

     $db_pm = (isset($db_pm)) ? $db_pm : $db_x . 'pm';

                $url = COT_ABSOLUTE_URL .cot_url($area, $item, '#c'.$id);
                // no parser
                $text  = sprintf($L['rcomm_pm_text'], $usr['name'],$url);

                if($cfg['pm']['markup']){
		                // parser bbcode
		                if($sys['parser'] == 'bbcode')$text  = sprintf($L['rcomm_pm_text'],'[url='.cot_url('users', 'm=details&id='.$usr['id'].'&u='.$usr['name']).']'.$usr['name'].'[/url]','[url='.$url.']'.$L['rcomm_pm_viewlink'].'[/url]' );
		                // parser html
		                if($sys['parser'] == 'html')$text  = sprintf($L['rcomm_pm_text'],cot_build_user($usr['id'], htmlspecialchars($usr['name'])), cot_rc_link($url, $L['rcomm_pm_viewlink']) );
                     }



     			$pm['pm_title'] = $L['rcomm_pm_title'];
				$pm['pm_date'] = (int)$sys['now'];
				$pm['pm_text'] =  $text;

				$pm['pm_fromstate'] = "3";
				$pm['pm_fromuserid'] = (int)$usr['id'];
				$pm['pm_fromuser'] = $usr['name'];
				$pm['pm_touserid'] = $userid;
				$pm['pm_tostate'] = 0;
				$pmsql = $db->insert($db_pm, $pm);
                $pmsql = $db->update($db_users, array('user_newpm' => '1'), "user_id = $userid");

  }

function rcomm_cot_send_translated_mail($userid,$area,$item, $id)
{
	global $cfg, $usr, $db_users, $db ;


          $pmsql = $db->query("SELECT  user_name, user_email, user_lang
						FROM $db_users WHERE user_id = $userid AND user_rcomm_mail_notify = 1 ");

          if ($row = $pmsql->fetch()){
          require_once cot_langfile('rcomm', 'plug', $cfg['defaultlang'], $row['user_lang']);

			    if (!$L || !isset($L['pm_notify']))
				{
					global $L;
				}


          }else return;

	$rsubject = $L['rcomm_mail_notifytitle'];
    $url = COT_ABSOLUTE_URL .cot_url($area, $item, '#c'.$id);
	$rbody = sprintf($L['rcomm_mail_text'], htmlspecialchars($usr['name']), $url, $row['user_name']);

	if($row['user_email'])cot_mail($row['user_email'], $rsubject, $rbody);
}

?>
