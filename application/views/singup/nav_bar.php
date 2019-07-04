<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="navbar navbar-fixed-top">

    <div class="navbar-inner">

        <div class="container">

            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <a class="brand" href="index.html">
                Bootstrap Admin Template				
            </a>		

            <div class="nav-collapse">
                <ul class="nav pull-right">
                    <li class="">						
                        <?= anchor('login', $this->lang->line('Already have an account? Login now'), []) ?>
                    </li>
                    <li class="">
                        <?= anchor('welcome', '<i class="icon-chevron-left"></i>' . $this->lang->line('Back to Homepage'), []) ?>
                    </li>
                </ul>

            </div><!--/.nav-collapse -->	

        </div> <!-- /container -->

    </div> <!-- /navbar-inner -->

</div> <!-- /navbar -->

