<div class="services-table-container">
	<h3>Services</h3>
	<br/>
	<div class="table-wrapper">
		<?= $services_table; ?>
	</div>
</div>
<div style="display:none;" class="service-modal modal fade">
<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="service-modal-header">Add Service</h4>
  	</div>
    <div class="modal-body">
    	<div class="service-form-container">
		</div>
		<div class="service-type-form-container">	
		</div>

  	</div>
  	<div class="modal-footer">
	    <a href="#" style="display:none;" class="btn pull-left delete-button btn-danger" data-dismiss="modal"><i class="icon-trash icon-white"></i> Delete Service</a>
	    <a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Close</a>
  		<a href="#" class="btn service-save"><i class="icon-file"></i> Save</a>
	</div>
	<div class="loader add-service-toggle"></div>
</div>
<div id="field_list" style="display:none;"><?= $field_names_data["field_name_html"]; ?></div>


