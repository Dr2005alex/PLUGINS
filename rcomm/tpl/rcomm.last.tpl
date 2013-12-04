<!-- BEGIN: MAIN -->
<ul>
<!-- BEGIN: ROW -->
     <li>
       <span class="ft-autor">{COMMENTS_ROW_AUTHOR}</span>
       <div class="ft-comment">
         {COMMENTS_ROW_TEXT|cot_string_truncate($this, 100)}
       </div>
       <p class="ft-meta">
		    <a href="{COMMENTS_ROW_PAGE_URL}#c{COMMENTS_ROW_ID}" >{COMMENTS_ROW_PAGE_CATTITLE} &raquo; {COMMENTS_ROW_PAGE_SHORTTITLE}</a>
       </p>
     </li>
<!-- END: ROW -->
</ul>
<!-- END: MAIN -->