
$( "#date_of_call" ).datepicker({dateFormat: "dd-mm-yy"});
$('.time-field').timeEntry();
$("select").chosen();

$(".submit-form").click(function(e){
	var oData = {};
	
	oData.sLogDate = $("#log_date").val();
	oData.sCounsellorUserId = $("#counsellor_username").attr("user-id");
	oData.sDistrict = $("#district").val();
	oData.sDateOfCall = $("#date_of_call").datepicker({ dateFormat: 'dd-mm-yy' }).val();
	oData.sStartTime = $("#start_time").val();
	oData.sEndTime = $("#end_time").val();
	oData.sGender = $("#gender").val();
	oData.sLanguageSpoken = $("#language_spoken").val();
	oData.aChosenIssues = $("#major_issues").val();
	oData.aChosenOutcomes = $("#outcome_actions").val();
	oData.sCallerFeelings = $("#caller_feelings").val();
	oData.sCallerStory = $("#caller_story").val();
	oData.sSkillsUsed = $("#skills_used").val();
	oData.sDiscussion1 = $("#discussion_1").val();
	oData.sDiscussion2 = $("#discussion_2").val();
	oData.sDiscussion3 = $("#discussion_3").val();
	oData.sFurtherTraining = $("#further_training").val();
	

	$.ajax({
		type: "POST",
		data: oData,
		url: "new_call_log",
		dataType: "json",
		beforeSend: function() {

		},
		success: function(response) {
			console.debug(response);
		},
		error: function(error) {
			console.debug("error", error);

		}
	});
	e.preventDefault();
});
