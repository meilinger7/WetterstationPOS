<div class="container">
    <div class="row">
        <h2>Messstationen</h2>
    </div>
    <div class="row">
        <p class="form-inline">
            <a href="index.php?r=station/create" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Erstellen</a>
            <a class="btn btn-default" href="index.php?r=home/index">Startseite</a>
        </p>

        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Ort</th>
                <th>Höhe [m]</th>
                <th></th>
            </tr>
            </thead>
            <tbody id="credentials">
            <?php
            foreach ($model as $c) {
                echo '<tr>';
                echo '<td>' . $c->getName() . '</td>';
                echo '<td>' . $c->getLocation() . '</td>';
                echo '<td>' . $c->getAltitude() . '</td>';
                echo '<td>';
                echo '<a class="btn btn-info" href="index.php?r=station/view&id=' . $c->getId() . '"><span class="glyphicon glyphicon-eye-open"></span></a>';
                echo '&nbsp;';
                echo '<a class="btn btn-primary" href="index.php?r=station/update&id=' . $c->getId() . '"><span class="glyphicon glyphicon-pencil"></span></a>';
                echo '&nbsp;';
                echo '<a class="btn btn-danger" href="index.php?r=station/delete&id=' . $c->getId() . '"><span class="glyphicon glyphicon-remove"></span></a>';
                echo '</td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</div> <!-- /container -->
