<div class="container">
    <h2>Messwert anzeigen</h2>

    <p>
        <a class="btn btn-primary" href="index.php?r=measurement/update&id=<?= $model->getId() ?>">Aktualisieren</a>
        <a class="btn btn-danger" href="index.php?r=measurement/delete&id=<?= $model->getId() ?>">Löschen</a>
        <a class="btn btn-default" href="index.php">Zurück</a>
    </p>

    <table class="table table-striped table-bordered detail-view">
        <tbody>
            <tr>
                <th>Zeitpunkt</th>
                <td><?= $model->getTime()?></td>
            </tr>
            <tr>
                <th>Temperatur</th>
                <td><?= $model->getTemperature()?></td>
            </tr>
            <tr>
                <th>Regenmenge</th>
                <td><?= $model->getRain()?></td>
            </tr>
        </tbody>
    </table>
</div> <!-- /container -->
