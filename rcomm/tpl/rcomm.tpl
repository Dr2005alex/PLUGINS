<!-- BEGIN: REPLYFORM -->

<div id="add_reply_{COMMENTS_REPLY_ID}"  class="add_reply_comment" >
    <form  action="{COMMENTS_REPLY_FORM_SEND}" {COMMENTS_REPLY_SEND_AJAX} method="post" name="newreplycomment">

        <!-- IF !{COMMENTS_REPLY_NOAJAX} -->
	        <input name="rtext3" type="hidden" value="">
	        <input name="commlevel" type="hidden" value="{COMMENTS_REPLY_LEVEL}">
	        <input name="reply_userid" type="hidden" value="{COMMENTS_REPLY_AUTHORID}">
	        <input name="com_code" type="hidden" value="{COMMENTS_REPLY_COMM_CODE}">
	        <input name="ext_name" type="hidden" value="{COMMENTS_REPLY_EXT_NAME}">
	        <input name="cat" type="hidden" value="{COMMENTS_REPLY_CAT}">
        <!-- ENDIF -->

        <strong>{COMMENTS_REPLY_TITLE}:</strong>
        <!-- IF !{PHP.usr.id} -->
        <div class="rcomm_name">{PHP.L.rcomm_reply_g_name}: {COMMENTS_REPLY_AUTHOR}</div>
        <!-- ENDIF -->
        <div class="rcommenttxtarea" >{COMMENTS_REPLY_TEXTBOXER}</div>
        <!-- IF !{PHP.usr.id} -->
        <div class="rcomm_ver" ><span id="rcomm_verify{COMMENTS_REPLY_ID}" >{COMMENTS_REPLY_VERIFYIMG}</span> : {COMMENTS_REPLY_VERIFY}</div>
        <!-- ENDIF -->
        <!-- IF {PHP.reply_error} -->
		    {PHP.reply_error}
	    <!-- ENDIF -->

        <button type="submit"  class="btn btn-success" id="button_ajax_loader{PHP.reply_id}">{PHP.L.rcomm_reply_send}</button>

         <!-- IF !{COMMENTS_REPLY_NOAJAX} -->
	        <a class="rcommClose" OnClick="$('#add_reply_{COMMENTS_REPLY_ID}').remove();return false;"></a>
	        <!-- ELSE -->
		        <a class="rcommClose" OnClick="document.getElementById('new_reply_box_{COMMENTS_REPLY_ID}').style.display = 'none';return false;"></a>
		        <!-- ENDIF -->
    </form>
</div>

<!-- END: REPLYFORM -->

<!-- BEGIN: PAGES -->

<div id="rcomm_page">
    {SHOW_LINK}
</div>

<!-- END: PAGES -->


<!-- BEGIN: REPLYSCRIPT -->

  <script>
// <![CDATA[

<!-- IF !{PHP.R.onlycomments} -->
 $(document).ready(function () {
<!-- ENDIF -->

	<!-- IF {REPLY_ID_SHOW} -->

	    var  showid = '{REPLY_ID_SHOW}';
	    scroll_to_elem('pos'+showid ,1300,1000);

	<!-- ENDIF -->

   <!-- BEGIN: ROW -->

    insert_line ({REPLY}, {START}, {END},'{COLOR}', '{PHP.R.onlycomments}','{DESC}',{M_LINE},{M_BOX});


   <!-- END: ROW -->
console.log("----------------");

<!-- IF !{PHP.R.onlycomments} -->
});
<!-- ENDIF -->
// ]]>
   </script>

<!-- END: REPLYSCRIPT -->