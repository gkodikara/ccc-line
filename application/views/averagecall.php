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
        
        <div id="chart_div" style="float:right;width: 50%; height:700px"></div>
    </div>
    <div id="pane2" class="tab-pane">
       
    </div>
    <div id="pane3" class="tab-pane">
 
    </div>
    <div id="pane4" class="tab-pane">
    
    </div><!-- /.tab-content -->
</div><!-- /.tabbable -->
</div>


<script type="text/javascript" src="<?= base_url(); ?>assets/js/averagecall.js"></script>