<?php
/*************************************/
/* "Reply for comments"              */
/*  Autor Dr2005alex                 */
/*  Dr2005alex@mail.ru               */
/*  Start Version: Siena   0.9.14    */
/*************************************/


$R['reply_link'] = '<a href="#" {$ajax} class="reply_comments_link  clear" alt="'.$L['rcomm_reply'].'"  id="reply_link_ajax{$i}" >'.$L['rcomm_reply'].'</a>';
$R['show_link'] = '<a href="#" {$ajax}  alt="'.$L['rcomm_show_comm'].'">'.$L['rcomm_show_comm'].'</a>';
$R['show_link'] .= '<form name="form_show_link"  method="post" id="form_show_link"></form>';

$R['rcomm_comments_code_admin'] = $L['Ip'].': {$ipsearch}<span class="spaced">'.$cfg['separator'].'</span>
<a href="#" {$ajax} >'.$L['Delete'].'</a><span class="spaced">'.$cfg['separator'].'</span>';
$R['rcomm_comments_code_edit'] = '<a href="#"  {$ajax} id="rcomm_edit{$i}" >'.$L['rcomm_reply_edit'].'</a> {$allowed_time}';


$R['new_reply_box'] = '<div class="new_reply_box" id = "new_reply_box_{$id}" {$style} >{$editor_box}</div>';

$R['reply_comments_link'] = '<a href="{$url}"  class="rcomm_r" >'.$L['rcomm_reply_link_txt'].'{$num}</a>';
$R['reply_comments_link_jquery'] = '<a  class="rcomm_rl"   value1="{$val1}" value2={$val2}>'.$L['rcomm_reply_link_txt'].'{$num}</a>';

$R['rcomm_error_txt_only'] = '<li>{$txt}</li>';
$R['rcomm_error_txt'] = '<div class="alert alert-error"><ul class="rcomm_error">{$txt}</ul></div>';