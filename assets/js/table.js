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
	
	$(".dataTables_filter").after("<button class='btn add-service-button'><i class='icon-plus'></i> Add Service</button>");
}

function fnInit() {
	$(".services-table-container").undelegate(".add-service-button", "click");
	$(".services-table-container").delegate(".add-service-button", "click", function(){
		fnAddUpdateService("add");
	});

	$(".services-table-container table").undelegate("tr", "click");
	$(".services-table-container table").delegate("tr", "click", function(){
		var sSelectedRowId = $(this).children("td:first-child").html();
		fnPopulateModalInput($(this), sSelectedRowId);
		fnAddUpdateService("update", sSelectedRowId);
	});

	$(".services-table-container .service-modal").undelegate(".delete-button", "click");
	$(".service-modal").delegate(".delete-button", "click", function(){
		fnDeleteService();
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

function fnPopulateModalInput(oTableRow, sServiceId) {
	$("#service_id").val($(oTableRow).children("td").eq(0).html());
	$("#service_name").val($(oTableRow).children("td").eq(1).html());
	$("#service_type").val($(oTableRow).children("td").eq(2).html());
	$("#service_location").val($(oTableRow).children("td").eq(3).html());
	$("#service_contact").val($(oTableRow).children("td").eq(4).html());
	$("#service_contact_telephone").val($(oTableRow).children("td").eq(5).html());

}


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

 