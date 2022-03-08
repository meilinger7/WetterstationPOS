<div class="row">
    <div class="col-md-4">
        <div class="form-group required <?= $model->hasError('name') ? 'has-error' : ''; ?>">
            <label class="control-label">Name *</label>
            <input type="text" class="form-control" name="name" value="<?= $model->getName() ?>">

            <?php if ($model->hasError('name')): ?>
                <div class="help-block"><?= $model->getError('name') ?></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-3">
        <div class="form-group required <?= $model->hasError('location') ? 'has-error' : ''; ?>">
            <label class="control-label">Ort *</label>
            <input type="text" class="form-control" name="location" value="<?= $model->getLocation() ?>">

            <?php if ($model->hasError('location')): ?>
                <div class="help-block"><?= $model->getError('location') ?></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-3">
        <div class="form-group required <?= $model->hasError('altitude') ? 'has-error' : ''; ?>">
            <label class="control-label">Höhe [m] *</label>
            <input type="text" class="form-control" name="altitude" value="<?= $model->getAltitude() ?>">

            <?php if ($model->hasError('altitude')): ?>
                <div class="help-block"><?= $model->getError('altitude') ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>
