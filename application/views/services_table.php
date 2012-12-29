<div class="services-table-container">
	<h3>Services</h3>
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
    	<div class="add-service-toggle">
			<form class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="service_name">Service Name</label>
				<div class="controls">
					<input type="text" id="service_name" placeholder="Type Service Name...">
				</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="service_type">Service Type</label>
					<div class="controls">
						<input type="text" id="service_type" placeholder="Type Service Type...">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="service_location">Service Location</label>
					<div class="controls">
						<input type="text" id="service_location" placeholder="Type Service Location...">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="service_contact">Contact Name</label>
					<div class="controls">
						<input type="text" id="service_contact" placeholder="Type Contact Name...">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="service_contact_telephone">Contact Telephone</label>
					<div class="controls">
						<input type="text" id="service_contact_telephone" placeholder="Type Telephone Number...">
					</div>
				</div>
			</form>
		</div>

  	</div>
  	<div class="modal-footer">
	    <a href="#" style="display:none;" class="btn pull-left delete-button btn-danger" data-dismiss="modal"><i class="icon-trash icon-white"></i> Delete Service</a>
	    <a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Close</a>
  		<a href="#" class="btn service-save"><i class="icon-file"></i> Save</a>
	</div>
</div>
