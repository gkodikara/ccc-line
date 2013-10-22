
$(document).ready(function() {
   
    var div_name = "pane1";
    
    
     $("#"+div_name+"_start_date").datepicker({dateFormat: "yy-mm-dd"});
    $("#"+div_name+"_end_date").datepicker({dateFormat: "yy-mm-dd"});
    $('.time-field').timeEntry();
    $("select").chosen();
    
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1;
    var yy = today.getFullYear();
    
    
//    alert(dd+'-'+mm+'-'+yy);
    
    $("#"+div_name+"_start_date").val(yy+'-'+mm+'-'+dd);
    $("#"+div_name+"_end_date").val(yy+'-'+mm+'-'+dd);
    
    
    
    google.load("visualization", "1", {packages: ["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart(data1) {
        
        var i = 1;
        var total_call = 0;
        var a = moment($('#'+div_name+'_start_date').val(), 'YYYY-M-D');
        var b = moment($('#'+div_name+'_end_date').val(), 'YYYY-M-D');
        var diffMonths = b.diff(a, 'months');

        var Xmas95 = new Date($('#'+div_name+'_start_date').val());
        var month = Xmas95.getMonth();
        var d = new Date();
        var month = new Array();
        month[0] = "January";
        month[1] = "February";
        month[2] = "March";
        month[3] = "April";
        month[4] = "May";
        month[5] = "June";
        month[6] = "July";
        month[7] = "August";
        month[8] = "September";
        month[9] = "October";
        month[10] = "November";
        month[11] = "December";
        var n = month[Xmas95.getMonth()];



        if (diffMonths == 0)
        {
            var arr = [[]];
            arr[0][0] = 'Date';
            arr[0][1] = 'Number of Call';

            for (i = 1; i <= data1.length; i++)
            {

                var j = i - 1;
                total_call += parseInt(data1[j]['Number_of_call']);
                var temp = [data1[j]['Date1'], parseInt(data1[j]['Number_of_call'])];

                arr.push(temp);
            }
//        alert(total_call);
            var avg = total_call / data1.length;
//        alert(avg);
            var abc = 'Average Call per day :' + avg;

            $('#avg_call').html(abc);

            var data = google.visualization.arrayToDataTable(arr);

            var avg = total_call / data1.length;
//        alert(avg);
            
            var data = google.visualization.arrayToDataTable(arr);
            var options = {
                title: 'Call Rate',
                DataType: 'Month',
                hAxis: {title: 'Number of Calls', titleTextStyle: {color: 'red'}}
            };

            var chart = new google.visualization.BarChart(document.getElementById(div_name+'_chart_div'));
            
            if(!isNaN(avg))
            {
                var abc = 'Average Call per day :' + avg;

                 $('#'+div_name+'_avg_call').html(abc);

                chart.draw(data, options);
            }
        }

        else
        {
            var arr = [[]];

            var start = Xmas95.getMonth();
            var data = new google.visualization.DataTable();

            arr[0][0] = 'Date';
            arr[0][1] = 'Number of Call';

            for (var k = 0; k <= diffMonths; k++)
            {
                temp = [month[start], 0];
                arr.push(temp);
                start++;
            }
            for (i = 1; i <= data1.length; i++)
            {

                var j = i - 1;

                var Xmas95 = new Date(data1[j]['Date1']);
                var TEMP_month = Xmas95.getMonth();

                total_call += parseInt(data1[j]['Number_of_call']);
//                var temp = [,parseInt(data1[j]['Number_of_call'])];
                for (var l = 0; l <= diffMonths + 1; l++)
                {
                    if (arr[l][0] == month[TEMP_month])
                    {
                        arr[l][1] = parseInt(data1[j]['Number_of_call']) + parseInt(arr[l][1]);

                    }
                }
            }
            var data = google.visualization.arrayToDataTable(arr);

            var options = {
                title: 'Call Rate',
                DataType: 'string',
                hAxis: {title: 'Number of Calls', titleTextStyle: {color: 'red'}}
            };

            var chart = new google.visualization.BarChart(document.getElementById(div_name+'_chart_div'));

            var avg = total_call / (diffMonths + 1);
//        alert(avg);
        
            if(!isNaN(avg))
            {
                var abc = 'Average Call per Month :' + avg;

                $('#'+div_name+'_avg_call').html(abc);

                chart.draw(data, options);
            }
        }

    }
    oDataTable = $("table").dataTable({
        "sPaginationType": "full_numbers",
    });
    
   function fnToggleLoading() {
    //    alert('abc');
        $(".add-service-toggle").toggle();
    }
  
    $('#'+div_name+'_start_date').change(function() {
        if ($('#'+div_name+'_start_date').val() != "" && $('#'+div_name+'_end_date').val() != "")
        {
            var d = new Date()

            $.ajax({
                type: "POST",
                url: "averagecall/num_call",
                data: {"start_date": $('#'+div_name+'_start_date').val(), 'end_date': $('#'+div_name+'_end_date').val()},
                success: function(response) {
//                    alert(response['table_html']);

                    var data = jQuery.parseJSON(response);
                    $('#table_tab').css('margin-top', '10%');
                    $('#table_tab').html(data['table_html']);
                    var abc = "[['Date','Number of Call'] ," + data['chart'] + "]";

                    drawChart(data['chart']);
                }
            });
        }
    });

    $('#'+div_name+'_end_date').change(function() {

        if ($('#'+div_name+'_start_date').val() != "" && $('#'+div_name+'_end_date').val() != "")
        {

            $.ajax({
                type: "POST",
                url: "averagecall/num_call",
                data: {"start_date": $('#'+div_name+'_start_date').val(), 'end_date': $('#'+div_name+'_end_date').val()},
                success: function(response) {
//                    alert(response['table_html']);

                    var data = jQuery.parseJSON(response);
                    $('#table_tab').css('margin-top', '20%');
                    $('#table_tab').html(data['table_html']);

//                     alert(abc);
                    drawChart(data['chart']);
                }
            });
        }
    });
    
    $("#"+div_name+"_start_date").change();
    
    $('a').click(function() {

        var link = this.text;


        switch (link)
        {
            case 'Average Call Rate':
                {
                  
                    div_name = 'pane1';
                }
                break;

            case 'Caller Categories':
                {
                     div_name = 'pane2';
                    $.ajax({
                                type: "POST",
                                url: "averagecall/Caller_Categories",
                                
                                success: function(response) {
                                    var data = jQuery.parseJSON(response);
                                    $('#pane2').html(data['right']);
                                    $("#"+div_name+"_start_date").datepicker({dateFormat: "yy-mm-dd"});
                                    $("#"+div_name+"_end_date").datepicker({dateFormat: "yy-mm-dd"});
                                    $('.time-field').timeEntry();
                                    $("select").chosen();
                                    
                                     var today = new Date();
                                                            var dd = today.getDate();
                                                            var mm = today.getMonth()+1;
                                                            var yy = today.getFullYear();


                                                        //    alert(dd+'-'+mm+'-'+yy);

                                                            $("#"+div_name+"_start_date").val(yy+'-'+mm+'-'+dd);
                                                            $("#"+div_name+"_end_date").val(yy+'-'+mm+'-'+dd);
                                    
                                     $('#categories').change(function ()
                                        {
                                              if ($('#pane2_start_date').val() != "" && $('#pane2_end_date').val() != "" && $('#categories').val())
                                                {

                                                    $.ajax({
                                                        type: "POST",
                                                        url: "averagecall/num_caller_categories",
                                                        data: {"start_date": $('#pane2_start_date').val(), 'end_date': $('#pane2_end_date').val(),'categories':$('#categories').val()},
                                                        success: function(response) {

                                                            var data = jQuery.parseJSON(response);
                                                            $('#pane2_table_tab').css('margin-top', '20%');
                                                            $('#pane2_table_tab').html(data['table_html']);

                                                            drawChart(data['chart']);
                                                        }
                                                    });
                                                }
                                        });
                                      $('#pane2_start_date').change(function() {
                                                      
                                                  if ($('#pane2_start_date').val() != "" && $('#pane2_end_date').val() != "" && $('#categories').val())
                                                  {
                                                     
                                                      var d = new Date()

                                                      $.ajax({
                                                          type: "POST",
                                                          url: "averagecall/num_caller_categories",
                                                          data: {"start_date": $('#pane2_start_date').val(), 'end_date': $('#pane2_end_date').val(),'categories':$('#categories').val()},
                                                          success: function(response) {
                                          //                    alert(response['table_html']);

                                                              var data = jQuery.parseJSON(response);
                                                              $('#pane2_table_tab').css('margin-top', '20%');
                                                              $('#pane2_table_tab').html(data['table_html']);
                                                              
                                                              drawChart(data['chart']);
                                                          }
                                                      });
                                                  }
                                              });
                                           
                                    $('#pane2_end_date').change(function() {
                                      
                                        if ($('#pane2_start_date').val() != "" && $('#pane2_end_date').val() != "" && $('#categories').val())
                                        {

                                            $.ajax({
                                                type: "POST",
                                                url: "averagecall/num_caller_categories",
                                                data: {"start_date": $('#pane2_start_date').val(), 'end_date': $('#pane2_end_date').val(),'categories':$('#categories').val()},
                                                success: function(response) {
                                                    
                                                    var data = jQuery.parseJSON(response);
                                                    $('#pane2_table_tab').css('margin-top', '20%');
                                                    $('#pane2_table_tab').html(data['table_html']);

                                                    drawChart(data['chart']);
                                                }
                                            });
                                        }
                                    }); 
                                              
                                }
                            });
                            
                }
                break;
            case  'Caller Age Group':
                {
                    div_name = 'pane3';
                    
                    $.ajax({
                                type: "POST",
                                url: "averagecall/caller_age_categories",
                                
                                success: function(response) {
                                    var data = jQuery.parseJSON(response);
                                    $('#pane3').html(data['right']);
                                    $("#"+div_name+"_start_date").datepicker({dateFormat: "yy-mm-dd"});
                                    $("#"+div_name+"_end_date").datepicker({dateFormat: "yy-mm-dd"});
                                    
                                    var today = new Date();
                                    var dd = today.getDate();
                                    var mm = today.getMonth()+1;
                                    var yy = today.getFullYear();


                                //    alert(dd+'-'+mm+'-'+yy);

                                    $("#"+div_name+"_start_date").val(yy+'-'+mm+'-'+dd);
                                    $("#"+div_name+"_end_date").val(yy+'-'+mm+'-'+dd);
                                    
                                    $('.time-field').timeEntry();
                                    $("select").chosen();
                                     $('#age').change(function ()
                                        {
                                              if ($('#pane3_start_date').val() != "" && $('#pane3_end_date').val() != "" && $('#age').val())
                                                {

                                                    $.ajax({
                                                        type: "POST",
                                                        url: "averagecall/num_caller_age",
                                                        data: {"start_date": $('#pane3_start_date').val(), 'end_date': $('#pane3_end_date').val(),'age':$('#age').val()},
                                                        success: function(response) {

                                                            var data = jQuery.parseJSON(response);
                                                            $('#pane3_table_tab').css('margin-top', '20%');
                                                            $('#pane3_table_tab').html(data['table_html']);

                                                            drawChart(data['chart']);
                                                        }
                                                    });
                                                }
                                        });
                                      $('#pane3_start_date').change(function() {
                                                   
                                                  if ($('#pane3_start_date').val() != "" && $('#pane3_end_date').val() != "" && $('#age').val())
                                                  {
                                                     
                                                      var d = new Date()

                                                      $.ajax({
                                                          type: "POST",
                                                          url: "averagecall/num_caller_age",
                                                          data: {"start_date": $('#pane3_start_date').val(), 'end_date': $('#pane3_end_date').val(),'age':$('#age').val()},
                                                          success: function(response) {
                                          //                    alert(response['table_html']);

                                                              var data = jQuery.parseJSON(response);
                                                              $('#pane3_table_tab').css('margin-top', '20%');
                                                              $('#pane3_table_tab').html(data['table_html']);
                                                              if(data['chart'])
                                                                  {
                                                              drawChart(data['chart']);
                                                                  }
                                                              else
                                                                {
                                                                    $('#pane3_chart_div').html("");
                                                                }
                                                          }
                                                      });
                                                  }
                                              });
                                           
                    $("#pane3_start_date").change();
                                    $('#pane3_end_date').change(function() {
                                      
                                        if ($('#pane3_start_date').val() != "" && $('#pane3_end_date').val() != "" && $('#age').val())
                                        {
                                          
                                            $.ajax({
                                                type: "POST",
                                                url: "averagecall/num_caller_age",
                                                data: {"start_date": $('#pane3_start_date').val(), 'end_date': $('#pane3_end_date').val(),'age':$('#age').val()},
                                                success: function(response) {
                                                    
                                                    var data = jQuery.parseJSON(response);
                                                    $('#pane3_table_tab').css('margin-top', '20%');
                                                    $('#pane3_table_tab').html(data['table_html']);

                                                    drawChart(data['chart']);
                                                }
                                            });
                                        }
                                    }); 
                                              
                                }
                            });
                            
                }
                break;
            case 'Caller provinces':
                {
                    div_name = 'pane4';
                    $.ajax({
                                type: "POST",
                                url: "averagecall/province_Categories",
                                
                                success: function(response) {
                                    var data = jQuery.parseJSON(response);
                                    $('#pane4').html(data['right']);
                                    $("#"+div_name+"_start_date").datepicker({dateFormat: "yy-mm-dd"});
                                    $("#"+div_name+"_end_date").datepicker({dateFormat: "yy-mm-dd"});
                                    $('.time-field').timeEntry();
                                    $("select").chosen();
                                    
                                     var today = new Date();
                                                            var dd = today.getDate();
                                                            var mm = today.getMonth()+1;
                                                            var yy = today.getFullYear();


                                                        //    alert(dd+'-'+mm+'-'+yy);

                                                            $("#"+div_name+"_start_date").val(yy+'-'+mm+'-'+dd);
                                                            $("#"+div_name+"_end_date").val(yy+'-'+mm+'-'+dd);
                                    
                                     $('#district').change(function ()
                                        {
                                              if ($('#pane4_start_date').val() != "" && $('#pane4_end_date').val() != "" && $('#district').val())
                                                {

                                                    $.ajax({
                                                        type: "POST",
                                                        url: "averagecall/num_province_Categories",
                                                        data: {"start_date": $('#pane4_start_date').val(), 'end_date': $('#pane4_end_date').val(),'district':$('#district').val()},
                                                        success: function(response) {

                                                            var data = jQuery.parseJSON(response);
                                                            $('#pane4_table_tab').css('margin-top', '20%');
                                                            $('#pane4_table_tab').html(data['table_html']);
                                                            
                                                            drawChart(data['chart']);
                                                        }
                                                    });
                                                }
                                        });
                                      $('#pane4_start_date').change(function() {
                                                   
                                                  if ($('#pane4_start_date').val() != "" && $('#pane4_end_date').val() != "" && $('#district').val())
                                                  {
                                                     
                                                      var d = new Date()

                                                      $.ajax({
                                                          type: "POST",
                                                          url: "averagecall/num_province_Categories",
                                                          data: {"start_date": $('#pane4_start_date').val(), 'end_date': $('#pane4_end_date').val(),'district':$('#district').val()},
                                                          success: function(response) {
                                          //                    alert(response['table_html']);

                                                              var data = jQuery.parseJSON(response);
                                                              $('#pane4_table_tab').css('margin-top', '20%');
                                                              $('#pane4_table_tab').html(data['table_html']);
                                                              if(data['chart'])
                                                                  {
                                                              drawChart(data['chart']);
                                                                  }
                                                              else
                                                                {
                                                                    $('#pane4_chart_div').html("");
                                                                }
                                                          }
                                                      });
                                                  }
                                              });
                                           
                                    $('#pane4_end_date').change(function() {
                                      
                                        if ($('#pane4_start_date').val() != "" && $('#pane4_end_date').val() != "" && $('#district').val())
                                        {
                                          
                                            $.ajax({
                                                type: "POST",
                                                url: "averagecall/num_province_Categories",
                                                data: {"start_date": $('#pane4_start_date').val(), 'end_date': $('#pane4_end_date').val(),'district':$('#district').val()},
                                                success: function(response) {
                                                    
                                                    var data = jQuery.parseJSON(response);
                                                    $('#pane4_table_tab').css('margin-top', '20%');
                                                    $('#pane4_table_tab').html(data['table_html']);

                                                    drawChart(data['chart']);
                                                }
                                            });
                                        }
                                    }); 
                                              
                                }
                            });
                   
                }
                break;
        }
//        $(div_name).html();

    });

//	$('.question-container table').wrap('<div class="table-wrapper" />');
    
});
