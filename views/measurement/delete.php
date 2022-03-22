<div class="container">
    <h2>Messwert löschen</h2>

    <form class="form-horizontal" action="index.php?r=measurement/delete&id=<?= $model->getId() ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $model->getId(); ?>"/>
        <p class="alert alert-error">Wollen Sie die Zugangsdaten
            vom <?= $model->getTime()?> wirklich löschen?</p>
        <div class="form-actions">
            <button type="submit" class="btn btn-danger">Löschen</button>
            <a class="btn btn-default" href="index.php">Abbruch</a>
        </div>
    </form>

</div> <!-- /container -->
