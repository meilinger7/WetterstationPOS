<div class="container">
    <div class="row">
        <h2>Awesome Wetterstation</h2>
    </div>
    <div class="row">
        <p class="form-inline">
            <select class="form-control" name="station_id" style="width: 200px">
                <?php
                foreach ($model as $station) :
                    echo '<option value="' . $station->getId() . '">' . $station->getName() . '</option>';
                endforeach;
                ?>
            </select>
            <button id="btnSearch" onclick="loadChart()" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Messwerte anzeigen</button>
            <a class="btn btn-default" href="index.php?r=station/index"><span class="glyphicon glyphicon-pencil"></span> Messstationen bearbeiten</a>
            <br />
        <div style="width:700px">
            <canvas id="myChart" width="400" height="400"></canvas>
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
        $.get("api.php?r=/station/2/measurement", function(data) {

            $.each(data, function(index, measurements) {
                temperature.push(measurements.temperature);
                time.push(measurements.time);
                rain.push(measurements.rain);
            });

            console.log(temperature[0]);

            const ctx = document.getElementById('myChart').getContext('2d');
            myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: time,
                    datasets: [{
                        label: 'Temperatur in °C',
                        data: temperature,
                        label: 'rain in °C',
                        data: rain
                    }]
                    
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    }
</script>