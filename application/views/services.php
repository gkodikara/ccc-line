<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    applyPagination();

    function applyPagination() {
	$(".services-container a").unbind();
		$(".services-table-container a").click(function() {
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