<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">   
      google.load("visualization", "1", {packages:["corechart"]});
      // google.setOnLoadCallback(drawChart);  
</script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/averagecall.js"></script>



<div class="tabbable container">
    <h3>Reports</h3>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#pane1" data-toggle="tab">Average Call Rate</a></li>
        <li><a href="#pane2" data-toggle="tab">Issue stats</a></li>
        <li><a href="#pane3" data-toggle="tab">Caller Age Group</a></li>
        <li><a href="#pane4" data-toggle="tab">Caller provinces</a></li>
    </ul>
    <div class="tab-content" style="overflow: inherit">
        <div id="pane1" class="tab-pane active">
            <?= $right; ?>
            <div id="pane1_chart_div" style="float:right;width: 70%; height:700px"></div>
        </div>
        <div id="pane2" class="tab-pane">

        </div>
        <div id="pane3" class="tab-pane">

        </div>
        <div id="pane4" class="tab-pane">

        </div><!-- /.tabbable -->
        <div class="loader add-service-toggle"></div>
    </div></DIV>

