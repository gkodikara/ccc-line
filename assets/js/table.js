fnApplyPagination();
fnInitDatatable();
fnInit();

function fnInitDatatable(bDestroyExisting) {

	if (bDestroyExisting) {
		oDataTable.fnDestroy();
	}

	oDataTable = $(".services-table-container .table-wrapper table").dataTable({
		"sPaginationType": "full_numbers"
	});

	var sAdditionalButtons = '<button class="btn add-service-button"><i class="icon-plus"></i> Add Service</button>' + 
	'<button rel="popover" class="btn option-popover" data-placement="bottom" data-html="true" data-original-title="Choose Fields"><i class="icon-th-list"></i> Choose Fields</button>';
	
	$(".dataTables_filter").after(sAdditionalButtons);
}

function fnInit() {
	$(".services-table-container").undelegate(".add-service-button", "click");
	$(".services-table-container").delegate(".add-service-button", "click", function(){
		fnAddUpdateService("add");
	});

	$(".services-table-container table tbody").undelegate("tr", "click");
	$(".services-table-container table tbody").delegate("tr", "click", function(){

		var sSelectedRowId = $(this).children("td:first-child").html();

		$(".service-modal .modal-body .service-form-container").html(fnGetTableHeads());

		fnPopulateModalInput($(this), sSelectedRowId);
		fnAddUpdateService("update", sSelectedRowId);
	});

	$(".services-table-container .service-modal").undelegate(".delete-button", "click");
	$(".service-modal").delegate(".delete-button", "click", function(){
		fnDeleteService();
	});

	$(".services-table-container").undelegate(".field-name-select", "click");
	$(".services-table-container").delegate(".field-name-select", "click", function(){

		//Update hidden div with our change
		$("#field_list").html($(".popover-content").html());
		
		var iColIndex = $(this).attr("col-index");
		if ($(this).attr("checked")) {
			oDataTable.fnSetColumnVis(iColIndex, true);
		} else {
			oDataTable.fnSetColumnVis(iColIndex, false);
		}
	});

	fnCheckFieldVisibility();

	//enable popovers
	$(".option-popover").popover({
		content: $("#field_list").html()
	});

	$(".option-popover").click(function(){
		fnCheckFieldVisibility();
	});
}

function fnCheckFieldVisibility() {
	$.each($(".field-name-select"), function(iIndex, oObj){
		var iCol = $(oObj).attr("col-index");
		var bVis = oDataTable.fnSettings().aoColumns[iCol].bVisible;
		if (bVis) {
			$(oObj).attr("checked", true);
		} else {
			$(oObj).attr("checked", false);
		}
	});
}

function fnToggleLoading() {
	$(".add-service-toggle").toggle();
}

function fnDeleteService() {
	var bConfirm = confirm("Are you sure you want to delete this service?");
	if (bConfirm) {
		fnToggleLoading();
		$.ajax({
			type: "POST",
			url: "remove_service/",
			data: { "service_id": $("#service_id").val() },
			dataType: "json",
			success: function(response) {
				fnToggleLoading();
				$(".services-table-container .table-wrapper").html(response.services_table);
				fnInitDatatable();
				fnInit();	
				$(".service-modal").modal("hide");			
			}
		});
	}
}

//For Codeigniter Pagination
function fnApplyPagination() {
$(".pagination a").unbind();
	$(".pagination a").click(function() {
		var url = $(this).attr("href");
		$.ajax({
			type: "POST",
			data: "ajax=1",
			url: url,
			dataType: "json",
			beforeSend: function() {
			},
			success: function(msg) {
				$(".services-table-container").html(msg);
				applyPagination();
			}
		});
		return false;
	});
}

function fnAddUpdateService(sType, sServiceId) {
	$(".service-modal .modal-body input[type=text]").css("border-color", "#ccc");
	
	switch(sType) {
		case "add":
			$(".service-modal-header").html("Add Service");
			$(".service-modal .modal-footer .delete-button").hide();
			$.each($(".service-modal .modal-body input"), function(iIndex, oObj){
				$(this).val("");
			});
		break;

		case "update":
			if (typeof sServiceId != "undefined") {
				$(".service-modal-header").html("Update Service");
				$(".service-modal .modal-footer .delete-button").show();				
			} else {
				$(".service-modal").modal("hide");
			}
		break;
	}

	$(".service-modal").modal();

	$(".service-modal").undelegate(".service-save", "click");
	$(".service-modal").delegate(".service-save", "click", function(){		
		if (fnValidation(".service-modal .modal-body form")) {
			fnToggleLoading();
			var oData = fnGetFormData();
			
			switch(sType) {
				case "add":
					$.ajax({
						url: "add_service",
						data: oData,
						type: "POST",
						dataType: "json",
						success: function(response) {
							fnToggleLoading();
							$(".services-table-container .table-wrapper").html(response.services_table);
							fnInitDatatable();
							fnInit();
							$(".service-modal").modal("hide");
						}
					});
				break;

				case "update":
					oData.service_id = sServiceId;
					oData.ajax = 1;
					$.ajax({
						url: "update_service",
						data: oData,
						type: "POST",
						dataType: "json",
						success: function(response) {
							fnToggleLoading();	
							$(".services-table-container .table-wrapper").html(response.services_table);
							fnInitDatatable();
							fnInit();
							$(".service-modal").modal("hide");
						}
					});
				break;
			}

		}
	});
}

function fnGetFormData() {
	var oData = {
		"service_name": $("#service_name").val(),
		"service_type": $("#service_type").val(),
		"service_location": $("#service_location").val(),
		"service_contact": $("#service_contact").val(),
		"service_contact_telephone": $("#service_contact_telephone").val(),

	};

	return oData;
}

function fnGetTableHeads() {
	var sModalInputLayout = 	'<div class="service-form-container">' +
									'<form class="form-horizontal">';

	$.each($(".services-table-container table thead th"), function(iIndex, oObj){
		var sHeadText = $(oObj).text();
		var sHeadId = sHeadText.replace(/ /g, "_").toLowerCase();
		sHeadText = sHeadText.replace(/_/g, " ");
		var sStyle = (sHeadId != "id" ? "" : "style='display:none;'");

		sModalInputLayout +=	'<div class="control-group">' +
									'<label class="control-label" '+sStyle+' for="'+sHeadId+'">'+sHeadText+': </label>' +
									'<div class="controls">' +
										'<input type="text" '+sStyle+' id="'+sHeadId+'" placeholder="Type '+sHeadText+'..."/>' +
									'</div>' +
								'</div>';

	});

	sModalInputLayout += 	'</form>' +
								'</div>';

	return sModalInputLayout;
}

//WHY DOESN'T THIS WORK!!!
function fnPopulateModalInput(oTableRow, sServiceId) {
	$("#id").val($(oTableRow).children("td").eq(0).html());
	$("#service_name").val($(oTableRow).children("td").eq(1).html());
	$("#service_type").val($(oTableRow).children("td").eq(2).html());
	$("#service_location").val($(oTableRow).children("td").eq(3).html());
	$("#service_contact").val($(oTableRow).children("td").eq(4).html());
	$("#service_contact_telephone").val($(oTableRow).children("td").eq(5).html());
}

//Simple Form Validator
function fnValidation(sContainerDivClass) {
		var iValidCount = 0;
		$.each($(sContainerDivClass + " input[type=text]"), function(iIndex, oObj){
			if ($.trim($(this).val()) == "") {
				$(this).css("border-color", "red");
			} else {
				$(this).css("border-color", "green");
				iValidCount++;
			}
		});
		if ($(sContainerDivClass + " input[type=text]").length == iValidCount) {
			return true;
		} else {
			return false;
		}
}

 