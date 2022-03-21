    var myChart = null;
    var temperature = [];
    var time = [];
    var rain = [];

    function loadChart() {
        var staionId = $("#stationId").val();
        console.log(staionId);
        $.get("api.php?r=/station/" + staionId + "/measurement", function(data) {

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