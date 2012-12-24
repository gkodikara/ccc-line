fnApplyPagination();
fnInitDatatable();

function fnInitDatatable() {
	$("table").dataTable({
		"sPaginationType": "full_numbers"
	});
}

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
 