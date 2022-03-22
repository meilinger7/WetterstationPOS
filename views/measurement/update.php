<div class="container">
    <div class="row">
        <h2>Messwert bearbeiten</h2>
    </div>

    <form class="form-horizontal" action="index.php?r=measurement/update&id=<?= $model['model']->getId() ?>" method="post">

        <?php
        include "_form.php";
        ?>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Aktualisieren</button>
            <a class="btn btn-default" href="index.php">Abbruch</a>
        </div>
    </form>

</div> <!-- /container -->
