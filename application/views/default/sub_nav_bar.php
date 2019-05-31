<?php
$this->lang->load('controller/Dashboard', $this->config->item('language'));
?>
<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">
            <ul class="mainnav">
                <li class="active"><?= anchor('dashboard', '<i class="icon-dashboard"></i><span>' . $this->lang->line('Dashboard') . '</span>') ?></li>
                <li><a href="reports.html"><i class="icon-list-alt"></i><span>Reports</span> </a> </li>
                <li><a href="guidely.html"><i class="icon-facetime-video"></i><span>App Tour</span> </a></li>
                <li><a href="charts.html"><i class="icon-bar-chart"></i><span>Charts</span> </a> </li>
                <li><a href="shortcodes.html"><i class="icon-code"></i><span>Shortcodes</span> </a> </li>
                <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-long-arrow-down"></i><span>Drops</span> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="icons.html">Icons</a></li>
                        <li><a href="faq.html">FAQ</a></li>
                        <li><a href="pricing.html">Pricing Plans</a></li>
                        <li><a href="login.html">Login</a></li>
                        <li><a href="signup.html">Signup</a></li>
                        <li><a href="error.html">404</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> 
                        <i class="icon-long-arrow-down"></i><span><?= $this->lang->line('Admnistration') ?></span> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <?= anchor('user', $this->lang->line('Users'), []) ?>
                        </li>
                        <li>
                            <?= anchor('role', $this->lang->line('Roles'), []) ?>
                        </li>
                        <li>
                            <?= anchor('permission', $this->lang->line('Permissions'), []) ?>
                        </li>
                        <li>
                            <?= anchor('#', $this->lang->line('Restrictions'), []) ?>
                        </li>
                        <li>
                            <?= anchor('element', $this->lang->line('Elements'), []) ?>
                        </li>
                        <li>
                            <?= anchor('behavior', $this->lang->line('Behaviors'), []) ?>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /container --> 
    </div>
    <!-- /subnavbar-inner --> 
</div>
<!-- /subnavbar -->
