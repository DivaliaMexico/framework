                        <!-- Start Navigation List -->
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a <?php echo (in_array($this->route->is(), ['/', 'index1', 'index2', 'index3', 'index4', 'index5', 'index6', 'index7']))? 'class="active"':'' ?> href="<?php $url->to('') ?>">Home</a>
                                <ul class="dropdown">
                                    <li><a <?php echo ($this->route->is('/'))? 'class="active"':'' ?> href="<?php $url->to('') ?>">Home Main Version</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('/'))? 'class="active"':'' ?> href="<?php $url->to('') ?>">Home Version 1</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('index2'))? 'class="active"':'' ?> href="<?php $url->to('index2') ?>">Home Version 2</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('index3'))? 'class="active"':'' ?> href="<?php $url->to('index3') ?>">Home Version 3</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('index4'))? 'class="active"':'' ?> href="<?php $url->to('index4') ?>">Home Version 4</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('index5'))? 'class="active"':'' ?> href="<?php $url->to('index5') ?>">Home Version 5</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('index6'))? 'class="active"':'' ?> href="<?php $url->to('index6') ?>">Home Version 6</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('index7'))? 'class="active"':'' ?> href="<?php $url->to('index7') ?>">Home Version 7</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a <?php echo (in_array($this->route->is(), array('about', 'services', 'right-sidebar', 'left-sidebar', '404')))? 'class="active"':'' ?> href="<?php $url->to('about') ?>">Pages</a>
                                <ul class="dropdown">
                                    <li><a <?php echo ($this->route->is('about'))? 'class="active"':'' ?> href="<?php $url->to('about') ?>">About</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('services'))? 'class="active"':'' ?> href="<?php $url->to('services') ?>">Services</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('right-sidebar'))? 'class="active"':'' ?> href="<?php $url->to('right-sidebar') ?>">Right Sidebar</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('left-sidebar'))? 'class="active"':'' ?> href="<?php $url->to('left-sidebar') ?>">Left Sidebar</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('404'))? 'class="active"':'' ?> href="<?php $url->to('404') ?>">404 Page</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a <?php echo (in_array($this->route->is(), array('tabs', 'action-box', 'lastest-testimonials', 'lastest-posts', 'lastest-projects', 'pricing', 'accordion-toggles')))? 'class="active"':'' ?> href="#">Shortcodes</a>
                                <ul class="dropdown">
                                    <li><a <?php echo ($this->route->is('tabs'))? 'class="active"':'' ?> href="<?php $url->to('tabs') ?>">Tabs</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('buttons'))? 'class="active"':'' ?> href="<?php $url->to('buttons') ?>">Buttons</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('action-box'))? 'class="active"':'' ?> href="<?php $url->to('action-box') ?>">Action Box</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('lastest-testimonials'))? 'class="active"':'' ?> href="<?php $url->to('lastest-testimonials') ?>">Testimonials</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('lastest-posts'))? 'class="active"':'' ?> href="<?php $url->to('lastest-posts') ?>">Latest Posts</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('lastest-projects'))? 'class="active"':'' ?> href="<?php $url->to('lastest-projects') ?>">Latest Projects</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('pricing'))? 'class="active"':'' ?> href="<?php $url->to('pricing') ?>">Pricing Tables</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('accordion-toggles'))? 'class="active"':'' ?> href="<?php $url->to('accordion-toggles') ?>">Accordion & Toggles</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a <?php echo (in_array($this->route->is(), array('portfolio2', 'portfolio3', 'portfolio4', 'single-project')))? 'class="active"':'' ?> href="<?php $url->to('portfolio3') ?>">Portfolio</a>
                                <ul class="dropdown">
                                    <li><a <?php echo ($this->route->is('portfolio2'))? 'class="active"':'' ?> href="<?php $url->to('portfolio2') ?>">2 Columns</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('portfolio3'))? 'class="active"':'' ?> href="<?php $url->to('portfolio3') ?>">3 Columns</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('portfolio4'))? 'class="active"':'' ?> href="<?php $url->to('portfolio4') ?>">4 Columns</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('portfolio5'))? 'class="active"':'' ?> href="<?php $url->to('single-project') ?>">Single Project</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a <?php echo (in_array($this->route->is(), array('blog-right-sidebar', 'blog-left-sidebar', 'single-post')))? 'class="active"':'' ?> href="<?php $url->to('blog-right-sidebar') ?>">Blog</a>
                                <ul class="dropdown">
                                    <li><a <?php echo ($this->route->is('blog-right-sidebar'))? 'class="active"':'' ?> href="<?php $url->to('blog-right-sidebar') ?>">Blog - right Sidebar</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('blog-left-sidebar'))? 'class="active"':'' ?> href="<?php $url->to('blog-left-sidebar') ?>">Blog - Left Sidebar</a>
                                    </li>
                                    <li><a <?php echo ($this->route->is('single-post'))? 'class="active"':'' ?> href="<?php $url->to('single-post') ?>">Blog Single Post</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a <?php echo ($this->route->is('contact'))? 'class="active"':'' ?> href="<?php $url->to('contact') ?>">Contact</a>
                            </li>
                        </ul>
                        <!-- End Navigation List -->