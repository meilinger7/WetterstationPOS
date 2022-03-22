<div class="row">
    <div class="col-md-2">
        <div class="form-group required <?= $model['model']->hasError('name') ? 'has-error' : ''; ?>">
            <label class="control-label">Zeitpunkt *</label>
            <input type="text" class="form-control" name="time" value="<?= $model['model']->getTime() ?>">

            <?php if ($model['model']->hasError('time')): ?>
                <div class="help-block"><?= $model['model']->getError('ntimeame') ?></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-2">
        <div class="form-group required <?= $model['model']->hasError('temperature') ? 'has-error' : ''; ?>">
            <label class="control-label">Temperatur *</label>
            <input type="text" class="form-control" name="temperature" value="<?= $model['model']->getTemperature() ?>">

            <?php if ($model['model']->hasError('temperature')): ?>
                <div class="help-block"><?= $model['model']->getError('temperature') ?></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-2">
        <div class="form-group required <?= $model['model']->hasError('rain') ? 'has-error' : ''; ?>">
            <label class="control-label">Regenmenge [ml] *</label>
            <input type="text" class="form-control" name="rain" value="<?= $model['model']->getRain() ?>">

            <?php if ($model['model']->hasError('rain')): ?>
                <div class="help-block"><?= $model['model']->getError('rain') ?></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-2">
        <div class="form-group required">
            <label class="control-label">Stationen *</label>
            <select id="stationId" class="form-control" name="station_id" style="width: 200px">
                <?php
                    foreach ($model['stations'] as $station) :
                        echo '<option  value="' . $station->getId() . '">' . $station->getName() . '</option>';
                    endforeach;
                ?>
            </select>
        </div>
       
        
    </div>

    
</div>
