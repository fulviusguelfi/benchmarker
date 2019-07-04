
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
                $label_text = $this->lang->line('Agree with the Terms & Conditions.');
                $id = 'agree-terms';
                $name = 'agree_terms';
                ?>
                <?= form_checkbox($name, true, set_value($name, false), ['id' => $id, 'class' => "field login-checkbox", 'tabindex' => "4"]) ?>
                <?= form_label($label_text, $id, ['class' => "choice"]) ?>
            </span>

            <?= form_submit('submit', $this->lang->line('Register'), ['class' => 'button btn btn-success btn-large']) ?>
        </div> <!-- .actions -->

        <?= form_close() ?>

    </div> <!-- /content -->

</div> <!-- /account-container -->

<div class="login-extra">
    <?=$this->lang->line('Already have an account?') . ' '. anchor('login', $this->lang->line('Login to your account'), []) ?>
</div> <!-- /login-extra -->