<section id="section-dashboard" class="view anim-scale-increase section dashboard" data-view="overview" data-title="<?php $this->echo('OVERVIEW'); ?>" data-refresh="Minitoring.Dashboard.refresh">

    <div class="dashboard">

        <!-- System -->
        <div class="block col mob-whole tab-half desk-large-third">
            <div class="header no-background">
                <span class="title text-light"><?php $this->echo('GENERAL'); ?></span>
                <ul class="action-bar">
                    <li><a class="action-link" href="#" data-bind="Minitoring.SystemInfos.get" title="<?php $this->echo('ACTION_REFRESH'); ?>"><i class="fa fa-refresh"></i></a></li>
                </ul>
            </div>
            <div class="content no-background">
                <table class="data-table no-border">
                    <tbody>
                        <tr>
                            <td class="color-light" data-column="title"><?php $this->echoField('HOSTNAME'); ?></td>
                            <td id="system-hostname" class="highlight"></td>
                        </tr>
                        <tr>
                            <td class="color-light" data-column="title"><?php $this->echoField('OS'); ?></td>
                            <td id="system-os" class="highlight"></td>
                        </tr>
                        <tr>
                            <td class="color-light" data-column="title"><?php $this->echoField('KERNEL_VERSION'); ?></td>
                            <td id="system-kernel" class="highlight"></td>
                        </tr>
                        <tr>
                            <td class="color-light" data-column="title"><?php $this->echoField('UPTIME'); ?></td>
                            <td id="system-uptime" class="highlight"></td>
                        </tr>
                        <tr>
                            <td class="color-light" data-column="title"><?php $this->echoField('LAST_BOOT'); ?></td>
                            <td id="system-last-boot" class="highlight"></td>
                        </tr>
                        <tr>
                            <td class="color-light" data-column="title"><?php $this->echoField('SERVER_DATE'); ?></td>
                            <td id="system-server-date" class="highlight"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cpu -->
        <div class="block col mob-whole tab-half desk-large-third">
            <div class="header no-background">
                <span class="title text-light"><?php $this->echo('CPU'); ?></span>
                <ul class="action-bar">
                    <li><a class="action-link" href="#" data-bind="Minitoring.Cpu.get" title="<?php $this->echo('ACTION_REFRESH'); ?>"><i class="fa fa-refresh"></i></a></li>
                </ul>
            </div>
            <div class="content no-background">
                <table id="dashboard_cpu_table" class="data-table no-border">
                    <tbody>
                        <tr>
                            <td class="color-light" data-column="title"><?php $this->echoField('MODEL'); ?></td>
                            <td id="cpu-model" class="highlight"></td>
                        </tr>
                        <tr>
                            <td class="color-light" data-column="title"><?php $this->echoField('CORES'); ?></td>
                            <td id="cpu-cores" class="highlight"></td>
                        </tr>
                        <tr>
                            <td class="color-light" data-column="title"><?php $this->echoField('SPEED'); ?></td>
                            <td id="cpu-speed" class="highlight"></td>
                        </tr>
                        <tr>
                            <td class="color-light" data-column="title"><?php $this->echoField('CACHE'); ?></td>
                            <td id="cpu-cache" class="highlight"></td>
                        </tr>
                        <tr>
                            <td class="color-light" data-column="title"><?php $this->echoField('BOGOMIPS'); ?></td>
                            <td id="cpu-bogomips" class="highlight"></td>
                        </tr>
                        <tr>
                            <td class="color-light" data-column="title"><?php $this->echoField('TEMPERATURE'); ?></td>
                            <td id="cpu-temperature" class="highlight"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Uptime -->
        <div class="block col mob-whole tab-4 desk-3 desk-large-2 ">
            <div class="header no-background">
                <span class="title text-light">Uptime</span>
            </div>
            <div class="content align-center no-background">
                <br>
                <p>
                    <span class="main color-status-ok" id="uptime-day">...</span>
                    <span class="right">days</span>
                </p>
                <p class="text-small"><?php $this->echoField('LAST_BOOT'); ?> <span id="uptime-full"></span>
                </p>
                <div id="dashboard-reboot-required"></div>
            </div>
        </div>


        <!-- Packages -->
        <div class="block col mob-whole tab-4 desk-3 desk-large-2 ">
            <div class="header no-background">
                <span class="title text-light"><?php $this->echo('PACKAGES'); ?></span>
                <ul class="action-bar">
                    <li><a class="action-link" href="#" data-bind="Minitoring.Packages.refreshAll" title="<?php $this->echo('ACTION_REFRESH'); ?>"><i class="fa fa-refresh"></i></a></li>
                </ul>
            </div>
            <div class="content align-left no-background">
                <br>
                <a href="<?php echo $this->baseUrl; ?>packages" data-view="packages">
                    <table id="package-table" class="data-table no-border">
                        <tbody>
                            <tr>
                                <td class="color-light"><?php $this->echoField('PACKAGES_TOTAL'); ?></td>
                                <td class="align-right" id="dashboard_packages_total">...</td>
                            </tr>
                            <tr>
                                <td class="color-light"><?php $this->echoField('PACKAGES_INSTALLED'); ?></td>
                                <td class="align-right" id="dashboard_packages_installed">...</td>
                            </tr>
                            <tr>
                                <td class="color-light"><?php $this->echoField('PACKAGES_UPGRADABLE'); ?></td>
                                <td class="align-right" id="dashboard_packages_upgradable">...</td>
                            </tr>
                            <tr>
                                <td class="color-light"><?php $this->echoField('PACKAGES_ERROR'); ?></td>
                                <td class="align-right" id="dashboard_packages_error">...</td>
                            </tr>
                        </tbody>
                    </table>
                </a>
            </div>
        </div>

        <!-- Load average -->
        <div class="block col mob-whole tab-8 desk-6  desk-large-4 ">
            <div class="header no-background">
                <span class="title text-light">Load average</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.LoadAverage.get" title="<?php $this->echo('ACTION_REFRESH'); ?>">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content align-center no-background">
                <div id="load-average-1-gauge" class="gauge-container gauge-medium" data-bottom="1 min">
                    <div class="gauge-label"></div>
                </div>
                <div id="load-average-5-gauge" class="gauge-container gauge-medium" data-bottom="5 mins">
                    <div class="gauge-label"></div>
                </div>
                <div id="load-average-15-gauge" class="gauge-container gauge-medium" data-bottom="15 mins">
                    <div class="gauge-label"></div>
                </div>
            </div>
        </div>

        <!-- Memory -->
        <div class="block col mob-whole tab-4 desk-3  desk-large-2 ">
            <div class="header no-background">
                <span class="title text-light">Memory</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.Memory.get" title="<?php $this->echo('ACTION_REFRESH'); ?>">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content align-center no-background">
                <div id="memory-gauge" class="gauge-container gauge-medium" data-bottom="...">
                    <div class="gauge-label"></div>
                </div>
            </div>
        </div>

        <!-- Swap -->
        <div class="block col mob-whole tab-4 desk-3  desk-large-2 ">
            <div class="header no-background">
                <span class="title text-light">Swap</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.Swap.get" title="<?php $this->echo('ACTION_REFRESH'); ?>">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content align-center no-background">
                <div id="swap-gauge" class="gauge-container gauge-medium" data-bottom="...">
                    <div class="gauge-label"></div>
                </div>
            </div>
        </div>


        <!-- Disks -->
        <div class="block col mob-whole tab-4 desk-3 desk-large-2 ">
            <div class="header no-background">
                <span class="title text-light"><?php $this->echo('DISKS'); ?></span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.Disks.getDisksUsage" title="<?php $this->echo('ACTION_REFRESH'); ?>">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content align-center no-background">
                <a href="<?php echo $this->baseUrl; ?>disks" data-view="disks">
                    <div id="disks-gauge" class="gauge-container gauge-medium" data-bottom="">
                        <div class="gauge-label-bottom"></div>
                    </div>
                </a>
                <div id="disks-alerts"></div>
            </div>
        </div>


        <!-- Inodes -->
        <div class="block col mob-whole tab-4 desk-3 desk-large-2 ">
            <div class="header no-background">
                <span class="title text-light">Inodes</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.Disks.getInodesUsage" title="<?php $this->echo('ACTION_REFRESH'); ?>">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content align-center no-background">
                <a href="<?php echo $this->baseUrl; ?>disks" data-view="disks">
                    <div id="inodes-gauge" class="gauge-container gauge-medium" data-bottom="">
                        <div class="gauge-label-bottom"></div>
                    </div>
                </a>
                <div id="inodes-alerts"></div>
            </div>
        </div>

        <!-- Network -->
        <div class="block col mob-whole tab-8 desk-6 desk-large-4 ">
            <div class="header no-background">
                <span class="title text-light"><?php $this->echo('NETWORK'); ?></span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.Network.get">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content no-background">
                <table id="network-table" class="data-table responsive no-border">
                    <thead>
                        <tr>
                            <th class="light no-style"><?php $this->echo('NETWORK_INTERFACE'); ?></th>
                            <th class="light no-style">IP</th>
                            <th class="light no-style align-right padding-right-12"><?php $this->echo('NETWORK_RECEIVED'); ?></th>
                            <th class="light no-style align-right padding-right-12"><?php $this->echo('NETWORK_TRANSMITTED'); ?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>



        <!-- System users -->
        <div class="block col mob-whole tab-4 desk-3 desk-large-2 ">
            <div class="header no-background">
                <span class="title text-light"><?php $this->echo('SYS_USERS'); ?></span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.SystemUsers.getNumberActive" title="<?php $this->echo('ACTION_REFRESH'); ?>">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content align-center no-background">
                <br>
                <p>
                    <a href="<?php echo $this->baseUrl; ?>sysusers/currents" data-view="sysusers/currents">
                        <span class="main color-status-ok" id="current-users-number"></span>
                        <span class="right"><?php $this->echo('SYS_USERS_CONNECTED'); ?></span>
                    </a>
                </p>
            </div>
        </div>

        <!-- Process -->
        <div class="block col mob-whole tab-4 desk-3 desk-large-2 ">
            <div class="header no-background">
                <span class="title text-light"><?php $this->echo('PROCESS'); ?></span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.Process.get" title="<?php $this->echo('ACTION_REFRESH'); ?>">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content align-left no-background">
                <br>
                <table id="process-table" class="data-table no-border">
                    <tbody>
                        <tr>
                            <td class="color-light"><?php $this->echoField('PROCESS_TOTAL'); ?></td>
                            <td class="align-right" id="dashboard_process_total">...</td>
                        </tr>
                        <tr>
                            <td class="color-light"><?php $this->echoField('PROCESS_RUNNING'); ?></td>
                            <td class="align-right" id="dashboard_process_running">...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Services -->
        <div class="block col mob-whole tab-8 desk-6  desk-large-4 ">
            <div class="header no-background">
                <span class="title text-light"><?php $this->echo('SERVICES'); ?></span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.Services.refresh" title="<?php $this->echo('ACTION_REFRESH'); ?>">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content no-background">
                <table id="services-table" class="data-table no-border">
                    <thead></thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>


        <!-- Ping -->
        <div class="block col mob-whole tab-8 desk-6  desk-large-4 ">
            <div class="header no-background">
                <span class="title text-light">Ping</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.Ping.refresh" title="<?php $this->echo('ACTION_REFRESH'); ?>">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content no-background">
                <table id="ping-table" class="data-table no-border">
                    <thead></thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

    </div>
    <br>
</section>