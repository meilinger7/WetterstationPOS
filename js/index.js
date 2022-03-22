    var myChart = null;
    var temperature = [];
    var time = [];
    var rain = [];

    function loadChart() {
        var staionId = $("#stationId").val();
        console.log(staionId);
        $.get("api.php?r=/station/" + staionId + "/measurement", function(data) {
            $('#measurements').html(parseMeasurementTable(data));

            // $.each(data, function(index, measurements) {
            //     temperature.push(measurements.temperature);
            //     time.push(measurements.time);
            //     rain.push(measurements.rain);
            // });

            for (let i = 0; i <= 25; i++) {
                temperature.push(data[i].temperature);
                time.push(data[i].time);
                rain.push(data[i].rain);
            }

            if (myChart != null) {
                myChart.destroy();
            }

            console.log(temperature[0]);

            const ctx = document.getElementById('myChart').getContext('2d');
            myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: time,
                    datasets: [{
                            label: 'Temperatur in °C',
                            data: temperature
                        },
                        {
                            label: 'Regen in cm',
                            data: rain
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            temperature = [];
            time = [];
            rain = [];
        });
        
    }

    function parseMeasurementTable(data){
        var tmp = "";
        $.each(data, function(i,measurement){
            tmp += "<tr>";
            tmp += "<td>" + measurement.time + "</td>";
            tmp += "<td>" + measurement.temperature + "</td>";
            tmp += "<td>" + measurement.rain + "</td>";
            tmp += "<td>";
            tmp += '<a class="btn btn-info" href="index.php?r=measurement/view&id=' + measurement.id + '"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;'
            tmp += '<a class="btn btn-primary" href="index.php?r=measurement/update&id=' + measurement.id + '"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;'
            tmp += '<a class="btn btn-danger" href="index.php?r=measurement/delete&id=' + measurement.id + '"><span class="glyphicon glyphicon-remove"></span></a>';
            tmp += "</td>";
            tmp += "</tr>"
        });
        return tmp;
    }