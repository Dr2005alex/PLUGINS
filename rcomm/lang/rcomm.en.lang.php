<?PHP
/*************************************/
/* "Reply for comments"              */
/*  Autor Dr2005alex                 */
/*  Dr2005alex@mail.ru               */
/*  Start Version: Siena   0.9.14    */
/*************************************/

$L['rcomm_writes']="writes";
$L['rcomm_reply']="reply";
$L['rcomm_reply_send']="Send reply";
$L['rcomm_reply_rep']="Write a response";
$L['rcomm_reply_g_name']="Write your name";
$L['rcomm_reply_repedit']="Edit comment";

$L['rcomm_reply_link_txt']="Reply to comment #";
$L['rcomm_show_comm']="Show more ..";
$L['rcomm_delete_comments'] = "And location sure you want to delete this comment??  Keep in mind that when you remove the comment deleted and answers to it!";
$L['rcomm_reply_edit'] = "Edit";
$L['rcomm_pm_viewlink'] = "View the answer";
//pm
$L['rcomm_pm_title'] = "You responded in the comments";
$L['rcomm_pm_text'] = 'User %1$s
 replied to your comment. To view, go to this link. %2$s';

$L['rcomm_mail_notifytitle'] = "You responded in the comments";
$L['rcomm_mail_text'] = 'Respected %3$s.
ПUser %1$s replied to your comment.
To view comments, go to this link. %2$s';

//profile
$L['rcomm_pf_pm_title'] = "Receive private messages, when the answer to the left a comment";
$L['rcomm_pf_mail_title'] = "To recieve a notification email, when the answer to the left a comment";

// errors
$L['rcomm_reply_text_min']="Comment is too short or absent";
$L['rcomm_reply_text_long']="Comment is too long";

$L['cfg_multipad_reply'] = array("Modifier depth",'Used to indent a response. formula [Modifier] * [depth] = indent. Result margin-left: [Modifier] * [depth] px');
$L['cfg_color_line'] = array("Color lines connecting the answers ", 'css format. Example: # C09, red, blue, etc. Only works when the jquery.');
$L['cfg_open_comments'] = array("Open comments viewed", "Renee comments reviews when re-viewing the page will be opened.");
$L['cfg_scroll_reply'] = array("Enable 'pulling' comments to the answer by clicking on the link ","Comment, to which the answer was, will be shown next to the answer. Method jquery scroll ");
$L['cfg_pm_send'] = array(" Send a <u>private message </u> user who responded to the comments?");
$L['cfg_mail_send'] = array("Send messages to users on <u>email</u>, which responded to the comments?");
$L['cfg_ajax_send'] = array("Use jquery to submit forms, etc. ?");
$L['cfg_main_editor'] = array("Use a text editor installed by default on the site?");
?>