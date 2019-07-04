
<div class="account-container">

    <div class="content clearfix">

        <?= form_open('', ['id' => 'from_login', 'method' => 'post'], []) ?>

        <h1><?= ($form_title ?? '') ?></h1>

        <div class="login-fields">

            <p><?= ($form_description ?? '') ?></p>
            
            <?php foreach ($display_values as $key => $value) : ?>
                <div class="field">
                    <?= $key ?>
                    <?= $value ?>
                </div>
            <?php endforeach; ?>

        </div> <!-- /login-fields -->

        <div class="login-actions">

            <span class="login-checkbox">
                <?php
                $label_text = $this->lang->line('Keep me signed in');
                $id = 'keep-signed';
                $name = 'keep_signed';
                ?>
                <?= form_checkbox($name, true, set_value($name, false), ['id' => $id, 'class' => "field login-checkbox", 'tabindex' => "4"]) ?>
                <?= form_label($label_text, $id, ['class' => "choice"]) ?>
            </span>

            <?= form_submit('submit', $this->lang->line('Sign In'), ['class' => 'button btn btn-success btn-large']) ?>
        </div> <!-- .actions -->

        <?= form_close() ?>

    </div> <!-- /content -->

</div> <!-- /account-container -->

<div class="login-extra">
    <?= anchor('reset_password', $this->lang->line('Reset Password'), []) ?>
</div> <!-- /login-extra -->