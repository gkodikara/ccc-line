<style>

body {
	font-family: tahoma;
}

.pagination a, .pagination strong {
	background: lightgray;
	border: 1px solid gray;
	text-decoration: none;
	padding: 4px 7px;
	color: black;
	font-size: 12px;
}

.pagination strong, .pagination a:hover {
	font-weight: normal;
	background: #e3e3e3;
}

table td{
	border-right: 1px solid lightgray;
	padding: 7px;
}

table th {
	border-right: 1px solid gray;
	border-bottom: 2px solid gray;
	padding: 5px;
	font-weight: normal;
}

td:last-child, th:last-child {
	border-right: none;
}

th {
	background: lightgray;
	color: #000;
}

tr:nth-child(even) {
  background-color: #e3e3e3;
}

tr:hover {
	background-color: #009ed5;
	color: white;
	cursor: pointer;
}

tr:first-child:hover {
	cursor: arrow;
}

table {
	margin-bottom: 10px;
	font-size: 13px;
	border: 1px solid #e3e3e3;
	box-shadow: 2px 2px 3px #999;
	max-height: 200px;
	overflow: auto;
}
</style>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    applyPagination();

    function applyPagination() {
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
  });
  </script>

<div class="container services-container">
	<?= $this->load->view("services_table", array("services_table"=>$services_table)); ?>
</div>