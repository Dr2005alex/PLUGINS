<?PHP
/* ====================
[BEGIN_COT_EXT]
Hooks=comments.send.first
Version=1.1
[END_COT_EXT]

==================== */

/*************************************/
/* "Reply for comments"              */
/*  Autor Dr2005alex                 */
/*  Dr2005alex@mail.ru               */
/*  Start Version: Siena   0.9.14    */
/*************************************/

defined('COT_CODE') or die('Wrong URL');
require_once cot_incfile('comments', 'plug');

if (!$cfg['jquery'] || !$cfg['plugin']['rcomm']['ajax_send']){	require_once cot_incfile('rcomm', 'plug', 'functions');
	$reply_id = cot_import('reply_id', 'G','INT');
    $commlevel = cot_import('commlevel', 'G','INT');
    $reply_userid = cot_import('reply_userid', 'G','INT');
	 }

 if($reply_id > 0){    // если ответ к комментарию, прописываем  com_reply_date, делаем сдвиг по com_reply_date

 $commlevel = (empty($commlevel)) ? 1 : $commlevel;

 $comarray['com_level'] = $commlevel;
 $comarray['com_reply'] = $reply_id;

    list($last_date,$rii,$arr_d) = rcomm_last_date($reply_id);

	$last_date++;
	// сдвиг
	$sql = $db->query("UPDATE $db_com  SET com_reply_date = com_reply_date+1 WHERE (com_code = '".$item."' AND com_area ='".$area."' AND com_reply_date >= ".$last_date.") ");

	$comarray['com_reply_date'] = $last_date;

}else{  // если обычный комментарий, прописываем  com_reply_date        $arrcomdate = $db->query("SELECT com_reply_date  FROM $db_com WHERE com_code = '".$item."' AND com_area ='".$area."'  ORDER BY com_reply_date DESC  LIMIT 1 ")->fetch();
		$arrcomdate['com_reply_date']++;
		if(empty($arrcomdate['com_reply_date']) OR $arrcomdate['com_reply_date']== 0 ) $arrcomdate['com_reply_date'] = 1;

        $comarray['com_reply_date'] = $arrcomdate['com_reply_date'];	}


?>
