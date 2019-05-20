<!-- /widget -->
<div class="widget widget-box">
    <div class="widget-header"> <i class="icon-edit-sign"></i>
        <h3><?= ($form_title ?? '') ?></h3>
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        <?= form_open($form_action, $form_attributes) ?>
        <?php foreach ($hidden_values as $value) : ?>
            <?= $value ?>
        <?php endforeach; ?>
        <?php foreach ($display_values as $key => $value) : ?>
            <div class="form-group">
                <?=$key?>
                <?=$value?>
            </div> <!-- /field -->
        <?php endforeach; ?>
        <?= form_submit('submit', 'Salvar', ['class'=>'btn btn-success']) ?>
        <?= form_reset('reset', 'Limpar', ['class'=>'btn btn-danger']) ?>
        <?= form_close() ?>
    </div>
    <!-- /widget-content --> 
</div>
