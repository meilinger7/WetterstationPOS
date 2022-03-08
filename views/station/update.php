<div class="container">
    <div class="row">
        <h2>Messstation bearbeiten</h2>
    </div>

    <form class="form-horizontal" action="index.php?r=station/update&id=<?= $model->getId() ?>" method="post">

        <?php
        include "_form.php";
        ?>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Aktualisieren</button>
            <a class="btn btn-default" href="index.php?r=station/index">Abbruch</a>
        </div>
    </form>

</div> <!-- /container -->
