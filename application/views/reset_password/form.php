
<div class="account-container">

    <div class="content clearfix">

        <?= form_open($form_action, ['id' => 'reset_password', 'method' => 'post'], ($form_hidden_values ?? [])) ?>

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

            <?= form_submit('submit', $this->lang->line('Reset Password'), ['class' => 'button btn btn-success btn-large']) ?>
        </div> <!-- .actions -->

        <?= form_close() ?>

    </div> <!-- /content -->

</div> <!-- /account-container -->

<div class="login-extra">
    <?=$this->lang->line('Already have an account?') . ' '. anchor('login', $this->lang->line('Login to your account'), []) ?>
</div> <!-- /login-extra -->