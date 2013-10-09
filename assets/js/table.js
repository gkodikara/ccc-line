fnApplyPagination();
fnInitDatatable();
fnInit();
$("select").chosen();

function fnInitDatatable(bDestroyExisting) {

    if (bDestroyExisting) {
        oDataTable.fnDestroy();
    }

    oDataTable = $(".services-table-container .table-wrapper table").dataTable({
        "sPaginationType": "full_numbers"
    });

    var sAdditionalButtons = '<button class="btn add-service-button"><i class="icon-plus"></i> Add Referrer</button>' +
            '<button rel="popover" class="btn option-popover" data-placement="bottom" data-html="true" data-original-title="Choose Fields"><i class="icon-th-list"></i> Choose Fields</button>';

    $(".dataTables_filter").after(sAdditionalButtons);
}

function fnInit() {
    $(".services-table-container").undelegate(".add-service-button", "click");
    $(".services-table-container").delegate(".add-service-button", "click", function() {
        $(".service-modal .modal-body .service-form-container").html(fnGetTableHeads());
        fnAddUpdateservice("add");
    });

    $(".services-table-container table tbody").undelegate("tr", "click");
    $(".services-table-container table tbody").delegate("tr", "click", function() {

        var sSelectedRowId = $(this).children("td:first-child").html();
        $(".service-modal .modal-body .service-form-container").html(fnGetTableHeads());

        fnPopulateModalInput($(this), sSelectedRowId);
        fnAddUpdateservice("update", sSelectedRowId);
    });

    $(".services-table-container .service-modal").undelegate(".delete-button", "click");
    $(".service-modal").delegate(".delete-button", "click", function() {
        fnDeleteservice();
    });

    $(".services-table-container").undelegate(".field-name-select", "click");
    $(".services-table-container").delegate(".field-name-select", "click", function() {
        //Update hidden div with our change
        $("#field_list").html($(".popover-content").html());

        var iColIndex = $(this).attr("col-index");
        if ($(this).attr("checked") == "checked") {
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

    $(".option-popover").click(function() {
        fnCheckFieldVisibility();
    });
}

function fnCheckFieldVisibility() {
    $.each($(".services-table-container .field-name-select"), function(iIndex, oObj) {
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
//    alert('abc');
    $(".add-service-toggle").toggle();
}

function fnDeleteservice() {
    if (confirm("Are you sure you want to delete this service?")) {
        fnToggleLoading();
        $.ajax({
            type: "POST",
            url: "referrers/remove_service",
            data: {"service_id": $(".modal-body #id").val()},
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

function fnAddUpdateservice(sType, sserviceId) {
    $(".service-modal .modal-body input[type=text]").css("border-color", "#ccc");
    switch (sType) {
        case "add":
            
            $(".service-modal-header").html("Add Refferer");
            $(".service-modal .modal-footer .delete-button").hide();
            $.each($(".service-modal .modal-body input"), function(iIndex, oObj) {
                $(this).val("");
            });
             $("select").chosen();
            $("#service_type_chzn").css('width','67%');
            break;

        case "update":
            if (typeof sserviceId != "undefined") {
                $(".service-modal-header").html("Update service");
                $(".service-modal .modal-footer .delete-button").show();
            } else {
                $(".service-modal").modal("hide");
            }
             $("select").chosen();
            $("#service_type_chzn").css('width','67%');
            break;
    }

    $(".service-modal").modal();

    $(".service-modal").undelegate(".service-save", "click");
    $(".service-modal").delegate(".service-save", "click", function() {
        if (fnValidation(".service-modal .modal-body form")) {
            fnToggleLoading();
            var oData = fnGetFormData();
            switch (sType) {
                case "add":
                    $.ajax({
                        url: "referrers/add_service",
                        data: oData,
                        type: "POST",
                        dataType: "json",
                        success: function(response) {
                            fnToggleLoading();
                            alert(response.service_type);
                            $(".services-table-container .table-wrapper #dropdown_div").html(response.service_type);
                            $(".services-table-container .table-wrapper").html(response.services_table + response.service_type);
                            fnInitDatatable();
                            fnInit();
                            $(".service-modal").modal("hide");
                        },
                        error:function (res)
                        {
                            fnToggleLoading();
                        }
                    });
                    
                    break;

                case "update":
                    oData.service_id = sserviceId;
                    oData.ajax = 1;
                    $.ajax({
                        url: "referrers/update_service",
                        data: oData,
                        type: "POST",
                        dataType: "json",
                        success: function(response) {
                            fnToggleLoading();
                            $(".services-table-container .table-wrapper").html(response.services_table+response.service_type);
                            fnInitDatatable();
                            fnInit();
                            $(".service-modal").modal("hide");
                        },
                         error:function (res)
                        {
                            fnToggleLoading();
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
        "service_address": $("#service_address").val(),
        "service_contact": $("#service_contact").val(),
        "service_fax": $("#service_contact").val(),
        "services_offered": $("#services_offered").val(),
        "service_website": $("#service_website").val(),
        "service_comments": $("#service_comments").val(),
        "service_contact_telephone": $("#service_contact_telephone").val()

    };
    console.debug(oData);
    return oData;
}



function fnGetTableHeads() {
    var sModalInputLayout = '<div class="service-form-container">' +
            '<form class="form-horizontal">';

    $.each($(".services-table-container table thead th"), function(iIndex, oObj) {
        var sHeadText = $(oObj).attr("data-id");
        var sHeadId = sHeadText.replace(/ /g, "_").toLowerCase();
        sHeadText = sHeadText.replace(/_/g, " ");
        var sStyle = (sHeadId != "id" ? "" : "style='display:none;'");
        
        
        if (sHeadId == 'service_type')
        {

            var temp = $('#dropdown_div').html();
            
             sModalInputLayout += '<div class="control-group">' +
                    '<label class="control-label" ' + sStyle + ' for="' + sHeadId + '">' + sHeadText + ': </label>' +
                    '<div class="controls">' +
                    '<select multiple="" required="" data-placeholder="Choose a ' + sHeadText + '..." class="chosen-select" style="width:350px;" tabindex="4" id="' + sHeadId + '" name="' + sHeadText + '" >' +
                    ' <option></option>'+
                        temp + '</select>' +
                    '</div>' +
                    '</div>';
        }
        else
        {
            sModalInputLayout += '<div class="control-group">' +
                    '<label class="control-label" ' + sStyle + ' for="' + sHeadId + '">' + sHeadText + ': </label>' +
                    '<div class="controls">' +
                    '<input type="text" ' + sStyle + ' id="' + sHeadId + '" placeholder="Type ' + sHeadText + '..."/>' +
                    '</div>' +
                    '</div>';
        }

    });

    sModalInputLayout += '</form>' +
            '</div>';
    return sModalInputLayout;
       
}

//WHY DOESN'T THIS WORK!!!
function fnPopulateModalInput(oTableRow, sServiceId) {
    $.each($(oTableRow).children("td"), function(iIndex, oObj) {
        var sId = $(oObj).attr("data-id");
        var sVal = $(oObj).html();
        if(sId == 'service_type')
            {
                var n=sVal.split(",");
               for(var i =0 ; i< n.length ; i++) 
                $("#service_type option:contains(" + n[i] + ")").attr('selected', 'selected');
            }
        else
        {
        $("#" + sId).val(sVal);
        }
        console.debug($("#" + sId));
    });
}

//Simple Form Validator
function fnValidation(sContainerDivClass) {
    //REMEMBER - we're not including ID - but it will be counted as it is in the field list
    var iValidCount = -1;
    $.each($(sContainerDivClass + " input[type=text]"), function(iIndex, oObj) {
        if ($.trim($(this).val()) == "" && typeof $(oObj).attr("required") != "undefined") {
            $(this).css("border-color", "red");
        } else {
            $(this).css("border-color", "green");
            iValidCount++;
        }
    });
    if (($(sContainerDivClass + " input[type=text]").length - 1) == iValidCount) {
        return true;
    } else {
        return false;
    }
}

 