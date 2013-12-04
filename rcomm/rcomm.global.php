<?PHP
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]

==================== */

/*************************************/
/* "Reply for comments"              */
/*  Autor Dr2005alex                 */
/*  Dr2005alex@mail.ru               */
/*  Start Version: Siena   0.9.14    */
/*************************************/

defined('COT_CODE') or die('Wrong URL');

function rcomm_last_comm($count, $ext_name = 'page',$order_tab = 'com_id', $order = 'DESC')
{  global $cfg, $db, $db_com, $db_users, $db_pages;

        if(empty($db_com))require_once cot_incfile('comments', 'plug');

        $rpglt = new XTemplate(cot_tplfile(array('rcomm','last'), true));

        $comments_order = $order_tab." ".$order;

    	$sql_rgl = $db->query("SELECT c.*, u.* , p.*
		FROM $db_com AS c LEFT JOIN $db_users AS u ON u.user_id = c.com_authorid
		LEFT JOIN $db_pages AS p ON p.page_id = c.com_code
		WHERE com_area = ?   ORDER BY $comments_order LIMIT ?, ?",
		array($ext_name,  (int) 0, (int) $count));

        $totalitems = $sql_rgl->rowCount();

	if ($totalitems > 0 )
	{
	    $kk = 0;$i=0;
	    foreach ($sql_rgl->fetchAll() as $row)
			{
			  $i++;
			  $kk++;
	          $com_text = cot_parse($row['com_text'], $cfg['plugin']['comments']['markup']);
	          $rpglt->assign(array(
					'COMMENTS_ROW_ID' => $row['com_id'],
					'COMMENTS_ROW_ORDER' => $cfg['plugin']['comments']['order'] == 'Recent' ? $totalitems - $i + 1 : $i,
					'COMMENTS_ROW_AUTHOR' => cot_build_user($row['com_authorid'], htmlspecialchars($row['com_author'])),
					'COMMENTS_ROW_AUTHORID' => $row['com_authorid'],
					'COMMENTS_ROW_TEXT' => $com_text,
					'COMMENTS_ROW_DATE' => cot_date('datetime_medium', $row['com_date']),
					'COMMENTS_ROW_DATE_STAMP' => $row['com_date'],
					'COMMENTS_ROW_ODDEVEN' => cot_build_oddeven($kk),
					'COMMENTS_ROW_NUM' => $kk,
				));
				$rpglt->assign(cot_generate_pagetags($row, 'COMMENTS_ROW_PAGE_'));
			 $rpglt->parse("MAIN.ROW");
	         }
	 }

    $rpglt->parse("MAIN");
    return $rpglt->text("MAIN");
}
?>
