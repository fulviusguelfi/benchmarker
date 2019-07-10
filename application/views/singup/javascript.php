<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<script src="<?= base_url('js/jquery-1.7.2.min.js')?>"></script>
<script src="<?= base_url('js/bootstrap.js')?>"></script>
<script src="<?= base_url('js/signin.js')?>"></script>
<script>
    $(document).ready(function () {
        $('#agree_terms').detach();
        $('#agree_terms').appendTo('#from_login > div.login-actions > span');
        $('#from_login > div.login-fields > div:nth-child(6) > label').appendTo('#from_login > div.login-actions > span');
        $('#from_login > div.login-fields > div:nth-child(6) > p').appendTo('#from_login > div.login-actions > span');
        $('#from_login > div.login-fields > div:nth-child(6)').text($('#from_login > div.login-fields > div:nth-child(6)').text().trim());
        $('#from_login > div.login-fields > div:nth-child(6):empty').remove();
    });
</script>
