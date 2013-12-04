<?PHP
/* ====================
[BEGIN_COT_EXT]
Hooks=comments.delete
Order=5
[END_COT_EXT]

==================== */

/*************************************/
/* "Reply for comments"              */
/*  Autor Dr2005alex                 */
/*  Dr2005alex@mail.ru               */
/*  Start Version: Siena   0.9.14    */
/*************************************/

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('rcomm', 'plug', 'functions');

rcomm_delete($id);

?>
