<html>

<head>
    <!--Load the AJAX API-->
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
        let filterType = 1; //1- hour , 2- 3 hour ,3- 12 hour, 4-1 day,5-3 day
        let buttonTap=true;
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);


        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Day');
            data.addColumn('number', 'Temp');
            data.addColumn('number', 'Humidity');

            var options = {
                title: 'Temperature & Humidity Chart',
                titleTextStyle: {
                    fontSize: 18,
                    color: "#383a3d",
                    bold: true,
                    textAlign: 'center',
                },

                curveType: 'function',
                legend: {
                    position: 'right'
                },
                // tooltip: {
                //     trigger: 'none'
                // },

                backgroundColor: '#383a3d',
                hAxis: {
                    textStyle: {
                        color: 'white'
                    },
                    gridlines: {
                        count: 6
                    }
                },
                vAxis: {
                    textStyle: {
                        color: 'white'
                    },
                    gridlines: {
                        count: 6
                    }
                },
                colors: ['red', '#1e9df7'],
                lineWidth: 2,
                legend: {
                    textStyle: {
                        color: 'white'
                    }
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

            function getData() {
                switch (filterType) {
                    case 1:
                        var date = new Date();
                        date.setHours(date.getHours() - 1);
                        console.log('incase 1');
                        refreshChart(date);


                        break;

                    case 2:
                        console.log('incase 2');
                        var date = new Date();
                        date.setHours(date.getHours() - 3);

                        refreshChart(date);


                        break;
                    case 3:
                        console.log('incase 3');
                        var date = new Date();
                        date.setHours(date.getHours() - 12);

                        refreshChart(date);


                        break;
                    case 4:
                        console.log('incase 4');
                        var date = new Date();
                        date.setHours(date.getHours() - 24);

                        refreshChart(date);


                        break;
                    case 5:
                        console.log('incase 5');
                        var date = new Date();
                        date.setHours(date.getHours() - 72);

                        refreshChart(date);


                        break;

                    default:
                        console.log('default');
                        var date = new Date();
                        date.setHours(date.getHours() - 1);

                        refreshChart(date);



                }


            }

            getData();
            setInterval(getData, 5000);

            window.onresize = function() {
                getData();
            };

            function refreshChart(date) {

                $.ajax({
                    url: 'fetch_temp.php',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        date: date.toISOString()
                    },
                    success: function(response) {
                        // var last8Data = response.slice(-8);
                         if(buttonTap){
                            buttonTap=false;
                            $("#overlay").hide();
                         }
                        // Clear the previous data from the chart
                        data.removeRows(0, data.getNumberOfRows());

                        // Add the last 8 data points to the chart
                        data.addRows(response);

                        // Draw the chart
                        chart.draw(data, options);


                    }
                });

                $.ajax({
                    url: 'fetch_bulb_status.php',
                    dataType: 'json',

                    success: function(response) {

                        response == 1 ? $('.bulb').removeClass('off').addClass('on') : $('.bulb').removeClass('on').addClass('off');

                    }
                });
            }



        }



        function changePeriod(newfilterType) {
            $("#overlay").show();
            buttonTap=true;
            filterType = newfilterType;
            console.log(newfilterType);
            drawChart();
        }
    </script>
    <script>
        function changeButtonState(state) {
            $("#overlay").show();
            $.ajax({
                url: 'send_bulb_data.php',
                dataType: 'json',
                type: 'POST',
                data: {
                    id: 1,
                    status: state
                },
                success: function(response) {

                    state == 1 ? $('.bulb').removeClass('off').addClass('on') : $('.bulb').removeClass('on').addClass('off');
                    $("#overlay").hide();

                }
            });
        }
    </script>

    <title>IOT</title>
    <link rel="icon" href="./images/logo.png" type="image/icon type">
</head>

<body>

    <div class="main">
        <div id="chart_div"></div>

        <div class="btn-row">
            <button id="one-hour" onclick="changePeriod(1)">
                1 Hour
            </button>
            <button id="three-hour" onclick="changePeriod(2)">
                3 Hours
            </button>
            <button id="twelve-hour" onclick="changePeriod(3)">
                12 Hours
            </button>
            <button id="one-days" onclick="changePeriod(4)">
                1 Day
            </button>
            <button id="three-days" onclick="changePeriod(5)">
                3 Days
            </button>
        </div>

        <div class="bulb-row">
            <div class="bulb">

            </div>

            <button id="on-btn" onclick="changeButtonState(1)">ON</button>
            <button id="off-btn" onclick="changeButtonState(0)">OFF</button>

        </div>
        


    </div>

    <div id="overlay">
            <div class="spinner"></div>
        </div>

</body>

</html>