 $(document).ready(function () {

	$("#ajax_display").ajaxComplete(function(request, settings){

		mySettings.previewAutorefresh = autorefresh;
		mySettings.previewParserPath = "plug.php?r=markitup&x=" + $("input[name=\'x\'][type=\'hidden\']").eq(0).val();
		mediSettings.previewAutorefresh = autorefresh;
		mediSettings.previewParserPath = mySettings.previewParserPath;
		miniSettings.previewAutorefresh = autorefresh;
		miniSettings.previewParserPath = mySettings.previewParserPath;
		$("textarea.editor[id^= rcomm_minieditor").markItUp(mySettings);
		$("textarea.medieditor[id^= rcomm_minieditor").markItUp(mediSettings);
		$("textarea.minieditor[id^= rcomm_minieditor").markItUp(miniSettings);

	});
});