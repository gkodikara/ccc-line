$(document).ready(function() {


    var div_name = "pane1";


    $("#" + div_name + "_start_date").datepicker({dateFormat: "yy-mm-dd"});
    $("#" + div_name + "_end_date").datepicker({dateFormat: "yy-mm-dd"});
    $('.time-field').timeEntry();
    $("select").chosen();

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yy = today.getFullYear();


//    alert(dd+'-'+mm+'-'+yy);
    
    $("#" + div_name + "_start_date").val(yy + '-' + mm + '-' + dd);
    $("#" + div_name + "_end_date").val(yy + '-' + mm + '-' + dd);



    google.load("visualization", "1", {packages: ["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart(data1) {

        var i = 1;
        var total_call = 0;
        var a = moment($('#' + div_name + '_start_date').val(), 'YYYY-M-D');
        var b = moment($('#' + div_name + '_end_date').val(), 'YYYY-M-D');
        var diffMonths = b.diff(a, 'months');

        var Xmas95 = new Date($('#' + div_name + '_start_date').val());
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

            var chart = new google.visualization.BarChart(document.getElementById(div_name + '_chart_div'));

            if (!isNaN(avg))
            {
                var abc = 'Average Call per day :' + avg;

                $('#' + div_name + '_avg_call').html(abc);

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
            
            if(div_name == 'pane1')
                {
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
            }}
            else
            {
                    for (i = 1; i <= data1.length; i++)
            {

                var j = i - 1;
                total_call += parseInt(data1[j]['Number_of_call']);
                var temp = [data1[j]['Date1'], parseInt(data1[j]['Number_of_call'])];

                arr.push(temp);
            }
            }
            
            
            var data = google.visualization.arrayToDataTable(arr);

            var options = {
                title: 'Call Rate',
                DataType: 'string',
                hAxis: {title: 'Number of Calls', titleTextStyle: {color: 'red'}}
            };

            var chart = new google.visualization.BarChart(document.getElementById(div_name + '_chart_div'));

            var avg = total_call / (diffMonths + 1);
//        alert(avg);

            if (!isNaN(avg))
            {
                var abc = 'Average Call per Month :' + avg;

                $('#' + div_name + '_avg_call').html(abc);

                chart.draw(data, options);
            }
        }

    }
    oDataTable = $("table").dataTable({
        "sPaginationType": "full_numbers",
    });



    $('#' + div_name + '_start_date').change(function() {
        if ($('#' + div_name + '_start_date').val() != "" && $('#' + div_name + '_end_date').val() != "")
        {
            fnToggleLoading();
            var d = new Date()

            $.ajax({
                type: "POST",
                url: "averagecall/num_call",
                data: {"start_date": $('#' + div_name + '_start_date').val(), 'end_date': $('#' + div_name + '_end_date').val()},
                success: function(response) {
//                    alert(response['table_html']);

                    var data = jQuery.parseJSON(response);
                    $('#table_tab').css('margin-top', '20%');
                    $('#table_tab').html(data['table_html']);
                    var abc = "[['Date','Number of Call'] ," + data['chart'] + "]";

                    if (data['chart'] != "")
                    {
                        drawChart(data['chart']);
                    }
                    else
                    {
                        $('#pane1_chart_div').html("");
                    }
                    fnToggleLoading();
                },
                error: function() {
                    fnToggleLoading();
                }
            });
        }
    });

    $('#' + div_name + '_end_date').change(function() {

        if ($('#' + div_name + '_start_date').val() != "" && $('#' + div_name + '_end_date').val() != "")
        {
            fnToggleLoading();
            $.ajax({
                type: "POST",
                url: "averagecall/num_call",
                data: {"start_date": $('#' + div_name + '_start_date').val(), 'end_date': $('#' + div_name + '_end_date').val()},
                success: function(response) {
//                    alert(response['table_html']);

                    var data = jQuery.parseJSON(response);
                    $('#table_tab').css('margin-top', '20%');
                    $('#table_tab').html(data['table_html']);

                    if (data['chart'] != "")
                    {
                        drawChart(data['chart']);
                    }
                    else
                    {
                        $('#pane1_chart_div').html("");
                    }
                    fnToggleLoading()
                },
                error: function()
                {
                    fnToggleLoading();
                }
            });
        }
    });

    $("#" + div_name + "_start_date").change();

    $('a').click(function() {

        var link = this.text;


        switch (link)
        {
            case 'Average Call Rate':
                {

                    div_name = 'pane1';
                }
                break;

            case 'Caller Issues':
                {
                    div_name = 'pane2';
                    if( !$('#pane2_table_tab').html() && $('#pane2_table_tab').html()!="")
                       { 
                    $.ajax({
                        type: "POST",
                        url: "averagecall/Caller_Categories",
                        success: function(response) {
                            var data = jQuery.parseJSON(response);
                            $('#pane2').html(data['right']);
                            $("#" + div_name + "_start_date").datepicker({dateFormat: "yy-mm-dd"});
                            $("#" + div_name + "_end_date").datepicker({dateFormat: "yy-mm-dd"});
                            $('.time-field').timeEntry();
                            $("select").chosen();

                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1;
                            var yy = today.getFullYear();


                            //    alert(dd+'-'+mm+'-'+yy);

                            $("#" + div_name + "_start_date").val(yy + '-' + mm + '-' + dd);
                            $("#" + div_name + "_end_date").val(yy + '-' + mm + '-' + dd);

                            $('#categories').change(function()
                            {
                                if ($('#pane2_start_date').val() != "" && $('#pane2_end_date').val() != "")
                                {
                                    
                                     div_name = 'pane2';
                                        all_fun('pane2');
                                }
                            });
                            $('#pane2_start_date').change(function() {

                                if ($('#pane2_start_date').val() != "" && $('#pane2_end_date').val() != "")
                                {
                                        div_name = 'pane2';
                                        all_fun('pane2');
                                }
                            });

                            $('#pane2_end_date').change(function() {

                                if ($('#pane2_start_date').val() != "" && $('#pane2_end_date').val() != "")
                                {
                                        div_name = 'pane2';
                                        all_fun('pane2');
                                    
                                }
                            });
                            $("#pane2_start_date").change();
                        }
                    });
                }

                }
                break;
            case  'Caller Age Group':
                {
                    div_name = 'pane3';
                     if( !$('#pane3_table_tab').html() && $('#pane3_table_tab').html()!="")
                       { 
                    $.ajax({
                        type: "POST",
                        url: "averagecall/caller_age_categories",
                        success: function(response) {
                            var data = jQuery.parseJSON(response);
                            $('#pane3').html(data['right']);
                            $("#" + div_name + "_start_date").datepicker({dateFormat: "yy-mm-dd"});
                            $("#" + div_name + "_end_date").datepicker({dateFormat: "yy-mm-dd"});

                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1;
                            var yy = today.getFullYear();


                            //    alert(dd+'-'+mm+'-'+yy);

                            $("#" + div_name + "_start_date").val(yy + '-' + mm + '-' + dd);
                            $("#" + div_name + "_end_date").val(yy + '-' + mm + '-' + dd);

                            $('.time-field').timeEntry();
                            $("select").chosen();
                            $('#age').change(function()
                            {
                                if ($('#pane3_start_date').val() != "" && $('#pane3_end_date').val() != "")
                                {
                                         div_name = 'pane3';
                                        all_fun('pane3');
                                    
                                }
                            });
                            $('#pane3_start_date').change(function() {

                                if ($('#pane3_start_date').val() != "" && $('#pane3_end_date').val() != "")
                                {
                                     div_name = 'pane3';
                                        all_fun('pane3');
                                }
                            });

                            $("#pane3_start_date").change();
                            $('#pane3_end_date').change(function() {

                                if ($('#pane3_start_date').val() != "" && $('#pane3_end_date').val() != "" )
                                {
                                        div_name = 'pane3';
                                        all_fun('pane3');
                                }
                            });

                        }
                    });
                    }
                }
                break;
            case 'Caller provinces':
                {
                    div_name = 'pane4';
                     if( !$('#pane4_table_tab').html() && $('#pane4_table_tab').html()!="")
                       { 
                    $.ajax({
                        type: "POST",
                        url: "averagecall/province_Categories",
                        success: function(response) {
                            var data = jQuery.parseJSON(response);
                            $('#pane4').html(data['right']);
                            $("#" + div_name + "_start_date").datepicker({dateFormat: "yy-mm-dd"});
                            $("#" + div_name + "_end_date").datepicker({dateFormat: "yy-mm-dd"});
                            $('.time-field').timeEntry();
                            $("select").chosen();

                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1;
                            var yy = today.getFullYear();


                            //    alert(dd+'-'+mm+'-'+yy);

                            $("#" + div_name + "_start_date").val(yy + '-' + mm + '-' + dd);
                            $("#" + div_name + "_end_date").val(yy + '-' + mm + '-' + dd);

                            $('#district').change(function()
                            {
                                if ($('#pane4_start_date').val() != "" && $('#pane4_end_date').val() != "")
                                {
                                     div_name = 'pane4';
                                        all_fun('pane4');
                                }
                            });
                            $('#pane4_start_date').change(function() {

                                if ($('#pane4_start_date').val() != "" && $('#pane4_end_date').val() != "")
                                {
                                         div_name = 'pane4';
                                        all_fun('pane4');
                                }
                            });

                            $('#pane4_end_date').change(function() {

                                if ($('#pane4_start_date').val() != "" && $('#pane4_end_date').val() != "")
                                {
                                         div_name = 'pane4';
                                        all_fun('pane4');
                                }
                            });
                            $('#pane4_start_date').change();
                        }
                    });
                       }
                }
                break;
        }
    });


function all_fun(div_name)
{
    var link = "";
    fnToggleLoading();
    switch (div_name)
    {
        case 'pane1' :
            {
               
               var data_val = {
                   start_date : $('#'+div_name+'_start_date').val(),
                   end_date : $('#'+div_name+'_end_date').val()       
               };
               
               link = 'averagecall/num_call';
            }break;
        case 'pane2':
        {
            var data_val = {
                   start_date : $('#'+div_name+'_start_date').val(),
                   end_date : $('#'+div_name+'_end_date').val() ,
                   categories : $('#categories').val()
               };
               
               link = 'averagecall/num_caller_categories';
        }break;
        case 'pane3':
            {
                 var data_val = {
                   start_date : $('#'+div_name+'_start_date').val(),
                   end_date : $('#'+div_name+'_end_date').val() ,
            };
               
               link = 'averagecall/num_caller_age';
            }break;
         case 'pane4':
         {
              var data_val = {
                   start_date : $('#'+div_name+'_start_date').val(),
                   end_date : $('#'+div_name+'_end_date').val() ,
                   district: $('#district').val()
               };
               
               link = 'averagecall/num_province_Categories';
         }break;
    }
    
     $.ajax({
                type: "POST",
                url: link,
                data: data_val,
                success: function(response) {
//                    alert(response['table_html']);

                    var data = jQuery.parseJSON(response);
                    $('#'+div_name+'_table_tab').css('margin-top', '20%');
                    $('#'+div_name+'_table_tab').html(data['table_html']);
                    var abc = "[['Date','Number of Call'] ," + data['chart'] + "]";

                    if (data['chart'] != "")
                    {
                        drawChart(data['chart']);
                    }
                    else
                    {
                        $('#'+div_name+'_chart_div').html("");
                    }
                    fnToggleLoading();
                },
                error: function() {
                    fnToggleLoading();
                }
            });
}

});

function fnToggleLoading() {
    $(".add-service-toggle").toggle();
}

