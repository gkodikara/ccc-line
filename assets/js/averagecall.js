
$(document).ready(function() {
    var div_name = "";

    google.load("visualization", "1", {packages: ["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart(data1) {
        var arr = [[]];
        arr[0][0] = 'Date';
        arr[0][1] = 'Number of Call';
     
        var i =  1 ;
        var total_call = 0;
        
        for(i = 1 ; i<= data1.length ; i++)
            {
               
                var j = i - 1;
                total_call += parseInt(data1[j]['Number_of_call']);
//                arr[i][0] = data1[j]['Date1'];
//                arr[i][1] = data1[j]['Number_of_call'];
                var temp = [data1[j]['Date1'],parseInt(data1[j]['Number_of_call'])];
                
                arr.push(temp); 
            }
//        alert(total_call);
        var avg =  total_call / data1.length ;
//        alert(avg);
        var abc = 'Average Call per day :' + avg ;
        
        $('#avg_call').html(abc);
        
        var data = google.visualization.arrayToDataTable(arr);

        var options = {
            title: 'Call Rate',
            DataType: 'date',
            hAxis: {title: 'Number of Calls', titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

        chart.draw(data, options);
    }


    oDataTable = $("table").dataTable({
        "sPaginationType": "full_numbers",
    });

    $('#start_date').change(function() {

        if ($('#start_date').val() != "" && $('#end_date').val()!="")
        {
          
            $.ajax({
                type: "POST",
                url: "averagecall/num_call",
                data: {"start_date":$('#start_date').val(), 'end_date': $('#end_date').val()},
                success: function(response) {
//                    alert(response['table_html']);

                    var data = jQuery.parseJSON(response);
                   $('#table_tab').css('margin-top','10%'); 
                    $('#table_tab').html(data['table_html']);
                    var abc = "[['Date','Number of Call'] ," + data['chart'] + "]";
                     
                    drawChart(data['chart']);
                }
            });
        }
    });

    $('#end_date').change(function() {

        if ($('#start_date').val() != "" && $('#end_date').val()!="")
        {
          
            $.ajax({
                type: "POST",
                url: "averagecall/num_call",
                data: {"start_date":$('#start_date').val(), 'end_date': $('#end_date').val()},
                success: function(response) {
//                    alert(response['table_html']);

                    var data = jQuery.parseJSON(response);
                    $('#table_tab').css('margin-top','20%');
                    $('#table_tab').html(data['table_html']);
                   
//                     alert(abc);
                    drawChart(data['chart']);
                }
            });
        }
    });

    $('a').click(function() {

        var link = this.text;


        switch (link)
        {
            case 'Average Call Rate':
                {
                    div_name = '#pane1';
                }
                break;

            case 'Caller Categories':
                {
                    div_name = '#pane2';

                }
                break;
            case  'Caller Age Group':
                {
                    div_name = '#pane3';
                }
                break;
            case 'Caller provinces':
                {
                    div_name = '#pane4';
                }
                break;
        }



        $(div_name).html();

    });


//	$('.question-container table').wrap('<div class="table-wrapper" />');
    $("#start_date").datepicker({dateFormat: "yy-mm-dd"});
    $("#end_date").datepicker({dateFormat: "yy-mm-dd"});
    $('.time-field').timeEntry();
    $("select").chosen();
});
