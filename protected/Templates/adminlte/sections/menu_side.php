                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="header">MAIN NAVIGATION</li>
                        <li class="<?php echo (in_array($this->route->is(), array('/', 'index2')))? "active " : '' ?>treeview">
                            <a href="#">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo ($this->route->is('/'))? "active " : '' ?>"><a href="<?php $url->to(''); ?>"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                                <li class="<?php echo ($this->route->is('index2'))? "active " : '' ?>"><a href="<?php $url->to('index2'); ?>?p=index2"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                            </ul>
                        </li>
                        <li class="<?php echo (in_array($this->route->is(), array('layout/top-nav', 'layout/boxed', 'layout/fixed', 'layout/sidebar')))? "active " : '' ?>treeview">
                            <a href="#">
                                <i class="fa fa-files-o"></i>
                                <span>Layout Options</span>
                                <span class="label label-primary pull-right">4</span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo ($this->route->is('layout/top-nav'))? "active " : '' ?>">><a href="<?php $url->to('layout/top-nav'); ?>?layout=top-nav"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
                                <li class="<?php echo ($this->route->is('layout/boxed'))? "active " : '' ?>">><a href="<?php $url->to('layout/boxed'); ?>?layout=boxed"><i class="fa fa-circle-o"></i> Boxed</a></li>
                                <li class="<?php echo ($this->route->is('layout/fixed'))? "active " : '' ?>">><a href="<?php $url->to('layout/fixed'); ?>?layout=fixed"><i class="fa fa-circle-o"></i> Fixed</a></li>
                                <li class="<?php echo ($this->route->is('layout/sidebar'))? "active " : '' ?>">><a href="<?php $url->to('layout/sidebar'); ?>?layout=sidebar-collapse_fixed"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
                            </ul>
                        </li>
                        <li class="<?php echo ($this->route->is('widgets'))? "active " : '' ?>treeview">
                            <a href="<?php $url->to('widgets'); ?>?p=widgets">
                                <i class="fa fa-th"></i> <span>Widgets</span> <small class="label pull-right bg-green">new</small>
                            </a>
                        </li>
                        <li class="<?php echo (in_array($this->route->is(), array('charts/morris', 'charts/flot', 'charts/inline')))? "active " : '' ?>treeview">
                            <a href="#">
                                <i class="fa fa-pie-chart"></i>
                                <span>Charts</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo ($this->route->is('charts/morris'))? "active " : '' ?>"><a href="<?php $url->to('charts/morris'); ?>?p=morris"><i class="fa fa-circle-o"></i> Morris</a></li>
                                <li class="<?php echo ($this->route->is('charts/flot'))? "active " : '' ?>"><a href="<?php $url->to('charts/flot'); ?>?p=flot"><i class="fa fa-circle-o"></i> Flot</a></li>
                                <li class="<?php echo ($this->route->is('charts/inline'))? "active " : '' ?>"><a href="<?php $url->to('charts/inline'); ?>?p=charts"><i class="fa fa-circle-o"></i> Inline charts</a></li>
                            </ul>
                        </li>
                        <li class="<?php echo (in_array($this->route->is(), array('ui/general', 'ui/icons', 'ui/buttons', 'ui/sliders', 'ui/timeline', 'ui/modals')))? "active " : '' ?>treeview">
                            <a href="#">
                                <i class="fa fa-laptop"></i>
                                <span>UI Elements</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo ($this->route->is('ui/general'))? "active " : '' ?>"><a href="<?php $url->to('ui/general'); ?>?p=ui-general"><i class="fa fa-circle-o"></i> General</a></li>
                                <li class="<?php echo ($this->route->is('ui/icons'))? "active " : '' ?>"><a href="<?php $url->to('ui/icons'); ?>?p=ui-icons"><i class="fa fa-circle-o"></i> Icons</a></li>
                                <li class="<?php echo ($this->route->is('ui/buttons'))? "active " : '' ?>"><a href="<?php $url->to('ui/buttons'); ?>?p=ui-buttons"><i class="fa fa-circle-o"></i> Buttons</a></li>
                                <li class="<?php echo ($this->route->is('ui/sliders'))? "active " : '' ?>"><a href="<?php $url->to('ui/sliders'); ?>?p=sliders"><i class="fa fa-circle-o"></i> Sliders</a></li>
                                <li class="<?php echo ($this->route->is('ui/timeline'))? "active " : '' ?>"><a href="<?php $url->to('ui/timeline'); ?>?p=ui-timeline"><i class="fa fa-circle-o"></i> Timeline</a></li>
                                <li class="<?php echo ($this->route->is('ui/modals'))? "active " : '' ?>"><a href="<?php $url->to('ui/modals'); ?>?p=ui-modals"><i class="fa fa-circle-o"></i> Modals</a></li>
                            </ul>
                        </li>
                        <li class="<?php echo (in_array($this->route->is(), array('forms/general', 'forms/advanced', 'forms/editors')))? "active " : '' ?>treeview">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Forms</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo ($this->route->is('forms/general'))? "active " : '' ?>"><a href="<?php $url->to('forms/general'); ?>?p=forms-general"><i class="fa fa-circle-o"></i> General Elements</a></li>
                                <li class="<?php echo ($this->route->is('forms/advanced'))? "active " : '' ?>"><a href="<?php $url->to('forms/advanced'); ?>?p=forms-advanced"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
                                <li class="<?php echo ($this->route->is('forms/editors'))? "active " : '' ?>"><a href="<?php $url->to('forms/editors'); ?>?p=forms-editors"><i class="fa fa-circle-o"></i> Editors</a></li>
                            </ul>
                        </li>
                        <li class="<?php echo (in_array($this->route->is(), array('tables/simple', 'tables/data')))? "active " : '' ?>treeview">
                            <a href="#">
                                <i class="fa fa-table"></i> <span>Tables</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo ($this->route->is('tables/sample'))? "active " : '' ?>"><a href="<?php $url->to('tables/simple'); ?>?p=tables-simple"><i class="fa fa-circle-o"></i> Simple tables</a></li>
                                <li class="<?php echo ($this->route->is('tables/data'))? "active " : '' ?>"><a href="<?php $url->to('tables/data'); ?>?p=tables-data"><i class="fa fa-circle-o"></i> Data tables</a></li>
                            </ul>
                        </li>
                        <li class="<?php echo ($this->route->is('calendar'))? "active " : '' ?>treeview">
                            <a href="<?php $url->to('calendar'); ?>?p=calendar">
                                <i class="fa fa-calendar"></i> <span>Calendar</span>
                                <small class="label pull-right bg-red">3</small>
                            </a>
                        </li>
                        <li class="<?php echo ($this->route->is('mailbox'))? "active " : '' ?>treeview">
                            <a href="<?php $url->to('mailbox'); ?>?p=mailbox">
                                <i class="fa fa-envelope"></i> <span>Mailbox</span>
                                <small class="label pull-right bg-yellow">12</small>
                            </a>
                        </li>
                        <li class="<?php echo (in_array($this->route->is(), array('examples/invoice', 'examples/login', 'examples/register', 'examples/lockscreen', 'examples/404', 'examples/500', 'examples/blank')))? "active " : '' ?>treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>Examples</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo ($this->route->is('examples/invoice'))? "active " : '' ?>"><a href="<?php $url->to('examples/invoice'); ?>?p=invoices"><i class="fa fa-circle-o"></i> Invoice</a></li>
                                <li class="<?php echo ($this->route->is('examples/login'))? "active " : '' ?>"><a href="<?php $url->to('examples/login'); ?>?p=login"><i class="fa fa-circle-o"></i> Login</a></li>
                                <li class="<?php echo ($this->route->is('examples/reqister'))? "active " : '' ?>"><a href="<?php $url->to('examples/register'); ?>?p=register"><i class="fa fa-circle-o"></i> Register</a></li>
                                <li class="<?php echo ($this->route->is('examples/lockscreen'))? "active " : '' ?>"><a href="<?php $url->to('examples/lockscreen'); ?>?p=lockscreen"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
                                <li class="<?php echo ($this->route->is('examples/404'))? "active " : '' ?>"><a href="<?php $url->to('examples/404'); ?>?p=404"><i class="fa fa-circle-o"></i> 404 Error</a></li>
                                <li class="<?php echo ($this->route->is('examples/500'))? "active " : '' ?>"><a href="<?php $url->to('examples/500'); ?>?p=500"><i class="fa fa-circle-o"></i> 500 Error</a></li>
                                <li class="<?php echo ($this->route->is('examples/blank'))? "active " : '' ?>"><a href="<?php $url->to('examples/blank'); ?>?p=blank"><i class="fa fa-circle-o"></i> Blank Page</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-share"></i> <span>Multilevel</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                                <li>
                                    <a href="#"><i class="fa fa-circle-o"></i> Level One <i class="fa fa-angle-left pull-right"></i></a>
                                      <ul class="treeview-menu">
                                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                                        <li>
                                            <a href="#"><i class="fa fa-circle-o"></i> Level Two <i class="fa fa-angle-left pull-right"></i></a>
                                            <ul class="treeview-menu">
                                                <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                                <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                            </ul>
                        </li>
                        <li class="header">LABELS</li>
                        <li><a href="#"><i class="fa fa-circle-o text-danger"></i> Important</a></li>
                        <li><a href="#"><i class="fa fa-circle-o text-warning"></i> Warning</a></li>
                        <li><a href="#"><i class="fa fa-circle-o text-info"></i> Information</a></li>
                    </ul>