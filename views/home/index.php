<div class="container">
    <div class="row">
        <h2>Awesome Wetterstation</h2>
    </div>
    <div class="row">
        <p class="form-inline">
            <select id="stationId" class="form-control" name="station_id" style="width: 200px">
                <?php
                foreach ($model as $station) :
                    echo '<option  value="' . $station->getId() . '">' . $station->getName() . '</option>';
                endforeach;
                ?>
            </select>
            <button id="btnSearch" onclick="loadChart()" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Messwerte anzeigen</button>
            <a class="btn btn-default" href="index.php?r=station/index"><span class="glyphicon glyphicon-pencil"></span> Messstationen bearbeiten</a>
            <br />
        <div>
            <canvas id="myChart" width="1200" height="600"></canvas>
        </div>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Zeitpunkt</th>
                    <th>Temperatur [C°]</th>
                    <th>Regenmenge [ml]</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="measurements"></tbody>
        </table>
    </div>
</div> <!-- /container -->

<script>
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
</script>