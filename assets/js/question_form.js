$(document).ready(function(){
	oDataTable = $("table").dataTable({
		"sPaginationType": "full_numbers",

	});
//	$('.question-container table').wrap('<div class="table-wrapper" />');
});
$( "#date_of_call" ).datepicker({dateFormat: "dd-mm-yy"});
$('.time-field').timeEntry();
$("select").chosen();


$('#referral_chzn').click(function ()
{
   $(".service-modal").modal();
});

$("table tbody").delegate("tr", "click", function() {

        var sSelectedRowId = $(this).children("td:first-child").html();
//        alert($(this).children('td').eq(1));
        var service_name = $(this).children("td:first-child").next().html();
        $(".service-modal .modal-body .service-form-container").html(fnGetTableHeads());
    var add = 1;
        $('#referral option').each(function() {
    if ($(this).val() == sSelectedRowId)
        {   
            this.selected = true;
            add = 0;
        }
        });
        
    if(add == 1)
        $('#referral').append('<option selected value='+sSelectedRowId+'>'+service_name+'</option>');
        $('#referral').trigger("liszt:updated");
        
    });



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
	oData.referral = $("#referral").val();

       
        
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
