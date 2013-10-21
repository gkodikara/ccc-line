<style>
    .nav li a {
    color: #333333;
}

.nav > li> a:hover,.nav>li>a:focus
{
    background-color: snow!important;
}
.field
{
    border: 1px double!important; 
    margin: 0;
    padding: 0;
}
.leg
{
     border-style: none!important;
     margin-bottom: 0px;
     width:auto ;
     margin-left:10px;
     margin-right: 10px;
     padding: 5px;
}
</style>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/jsapi.js"></script>
<script>

    
   
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
    </script>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/averagecall.js"></script>



<div class="tabbable container">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#pane1" data-toggle="tab">Average Call Rate</a></li>
    <li><a href="#pane2" data-toggle="tab">Caller Categories</a></li>
    <li><a href="#pane3" data-toggle="tab">Caller Age Group</a></li>
    <li><a href="#pane4" data-toggle="tab">Caller provinces</a></li>
  </ul>
    <div class="tab-content" style="overflow: inherit">
    <div id="pane1" class="tab-pane active">
        <?= $right; ?>
        <div id="pane1_chart_div" style="float:right;width: 50%; height:700px"></div>
    </div>
    <div id="pane2" class="tab-pane">
       
    </div>
    <div id="pane3" class="tab-pane">
 
    </div>
    <div id="pane4" class="tab-pane">
        <div class="control-group">
					<label class="control-label" for="district">Caller District: </label>
					<div class="controls">
						<select id="district" class="span7" data-placeholder="Select District">
							<option value></option>
							<option value="Ampara">Ampara</option>
							<option value="Anuradhapura">Anuradhapura</option>
							<option value="Badulla">Badulla</option>
							<option value="Batticaloa">Batticaloa</option>
							<option value="Colombo">Colombo</option>
							<option value="Galle">Galle</option>
							<option value="Gampaha">Gampaha</option>
							<option value="Hambantota">Hambantota</option>
							<option value="Jaffna">Jaffna</option>
							<option value="Kalutara">Kalutara</option>
							<option value="Kandy">Kandy</option>
							<option value="Kegalle">Kegalle</option>
							<option value="Kilinochchi">Kilinochchi</option>
							<option value="Kurunegala">Kurunegala</option>
							<option value="Matale">Matale</option>
							<option value="Matara">Matara</option>
							<option value="Moneragala">Moneragala</option>
							<option value="Mullaitivu">Mullaitivu</option>
							<option value="Nuwara Eliya">Nuwara Eliya</option>
							<option value="Polonnaruwa">Polonnaruwa</option>
							<option value="Puttalam">Puttalam</option>
							<option value="Ratnapura">Ratnapura</option>
							<option value="Trincomalee">Trincomalee</option>
							<option value="Vavuniya">Vavuniya</option>
						</select>
					</div>
				</div>
    </div><!-- /.tab-content -->
</div><!-- /.tabbable -->
</div>

