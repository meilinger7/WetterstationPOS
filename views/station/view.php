<div class="container">
    <h2>Messstation anzeigen</h2>

    <p>
        <a class="btn btn-primary" href="index.php?r=station/update&id=<?= $model->getId() ?>">Aktualisieren</a>
        <a class="btn btn-danger" href="index.php?r=station/delete&id=<?= $model->getId() ?>">Löschen</a>
        <a class="btn btn-default" href="index.php?r=station/index">Zurück</a>
    </p>

    <table class="table table-striped table-bordered detail-view">
        <tbody>
            <tr>
                <th>Name</th>
                <td><?= $model->getName() ?></td>
            </tr>
            <tr>
                <th>Höhe</th>
                <td><?= $model->getAltitude() ?> m</td>
            </tr>
            <tr>
                <th>Ort</th>
                <td><a target="_blank" href="https://www.google.at/maps/@"<?= $model->getLocation() ?>"><?= $model->getLocation() ?></a></td>
            </tr>
        </tbody>
    </table>
</div> <!-- /container -->
