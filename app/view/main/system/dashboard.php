<section id="section-dashboard" class="view anim-scale-increase section dashboard" data-view="overview"
    data-title="<?php $this->echo('OVERVIEW'); ?>" data-refresh="Minitoring.Dashboard.refresh">
    
    <div class="dashboard">

        <!-- System -->
        <div class="block col mob-whole tab-half desk-large-third">
            <div class="header">
                <span class="title">General</span>
                <ul class="action-bar">
                    <li><a class="action-link" href="#" data-module="System" title="Refresh"><i
                                class="fa fa-refresh"></i></a></li>
                </ul>
            </div>
            <div class="content">
                <table class="data-table">
                    <tbody>
                        <tr>
                            <td class="color-light" data-column="title">Hostname:</td>
                            <td id="system-hostname" class="highlight"></td>
                        </tr>
                        <tr>
                            <td class="color-light" data-column="title">OS:</td>
                            <td id="system-os" class="highlight"></td>
                        </tr>
                        <tr>
                            <td class="color-light" data-column="title">Kernel version:</td>
                            <td id="system-kernel" class="highlight"></td>
                        </tr>
                        <tr>
                            <td class="color-light" data-column="title">Uptime:</td>
                            <td id="system-uptime" class="highlight"></td>
                        </tr>
                        <tr>
                            <td class="color-light" data-column="title">Last boot:</td>
                            <td id="system-last-boot" class="highlight"></td>
                        </tr>
                        <tr>
                            <td class="color-light" data-column="title">Server date & time:</td>
                            <td id="system-server-date" class="highlight"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cpu -->
        <div class="block col mob-whole tab-half desk-large-third">
            <div class="header">
                <span class="title">Cpu</span>
                <ul class="action-bar">
                    <li><a class="action-link" href="#" data-module="Cpu" title="Refresh"><i class="fa fa-refresh"></i></a>
                    </li>
                </ul>
            </div>
            <div class="content">
                <table class="data-table">
                    <tbody>
                        <tr>
                            <td  class="color-light" data-column="title">Model:</td>
                            <td id="cpu-model" class="highlight"></td>
                        </tr>
                        <tr>
                            <td  class="color-light" data-column="title">Cores:</td>
                            <td id="cpu-cores" class="highlight"></td>
                        </tr>
                        <tr>
                            <td  class="color-light" data-column="title">Speed:</td>
                            <td id="cpu-speed" class="highlight"></td>
                        </tr>
                        <tr>
                            <td  class="color-light" data-column="title">Cache:</td>
                            <td id="cpu-cache" class="highlight"></td>
                        </tr>
                        <tr>
                            <td  class="color-light" data-column="title">Bogomips:</td>
                            <td id="cpu-bogomips" class="highlight"></td>
                        </tr>
                        <tr>
                            <td  class="color-light" data-column="title">Temperature:</td>
                            <td id="cpu-temperature" class="highlight"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Uptime -->
        <div class="block col mob-whole tab-4 desk-3 desk-large-2 ">
            <div class="header">
                <span class="title">Uptime</span>
            </div>
            <div class="content align-center">
                <br>
                <p>
                    <span class="main color-status-ok" id="uptime-day">...</span>
                    <span class="right">days</span>
                </p>
                <p class="text-small">
                    Last boot <span id="uptime-full"></span>
                </p>
                <div id="dashboard-reboot-required"></div>
            </div>
        </div>


        <!-- Packages -->
        <div class="block col mob-whole tab-4 desk-3 desk-large-2 ">
            <div class="header">
                <span class="title"><?php $this->echo('PACKAGES'); ?></span>
            </div>
            <div class="content align-left">
                <br>
                <a href="<?php echo $this->baseUrl;?>packages" data-view="packages">
                    <table id="package-table" class="data-table">
                        <tbody>
                            <tr>
                                <td class="color-light">Total:</td>
                                <td class="align-right" id="dashboard_packages_total">...</td>
                            </tr>
                            <tr>
                                <td class="color-light">Installed:</td>
                                <td class="align-right" id="dashboard_packages_installed">...</td>
                            </tr>
                            <tr>
                                <td class="color-light">Update available:</td>
                                <td class="align-right" id="dashboard_packages_upgradable">...</td>
                            </tr>
                            <tr>
                                <td class="color-light">Error:</td>
                                <td class="align-right" id="dashboard_packages_error">...</td>
                            </tr>
                        </tbody>
                    </table>
                </a>    
            </div>
        </div>
        
        <!-- Load average -->
        <div class="block col mob-whole tab-8 desk-6  desk-large-4 ">
            <div class="header">
                <span class="title">Load average</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.LoadAverage.get" title="Refresh">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content align-center">
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
            <div class="header">
                <span class="title">Memory</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.Memory.get" title="Refresh">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content align-center">
                <div id="memory-gauge" class="gauge-container gauge-medium" data-bottom="...">
                    <div class="gauge-label"></div>
                </div>
            </div>
        </div>

        <!-- Swap -->
        <div class="block col mob-whole tab-4 desk-3  desk-large-2 ">
            <div class="header">
                <span class="title">Swap</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.Swap.get" title="Refresh">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content align-center">
                <div id="swap-gauge" class="gauge-container gauge-medium" data-bottom="...">
                    <div class="gauge-label"></div>
                </div>
            </div>
        </div>

       
        <!-- Disks -->
        <div class="block col mob-whole tab-4 desk-3 desk-large-2 ">
            <div class="header">
                <span class="title">Disks</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.Disks.getDisksUsage" title="Refresh">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content align-center">
                <a href="<?php echo $this->baseUrl;?>disks" data-view="disks">
                    <div id="disks-gauge" class="gauge-container gauge-medium" data-bottom="">
                        <div class="gauge-label-bottom"></div>
                    </div>
                </a>
                <div id="disks-alerts"></div>
            </div>
        </div>


         <!-- Inodes -->
         <div class="block col mob-whole tab-4 desk-3 desk-large-2 ">
            <div class="header">
                <span class="title">Inodes</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.Disks.getInodesUsage" title="Refresh">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content align-center">
                <a href="<?php echo $this->baseUrl;?>disks" data-view="disks">
                    <div id="inodes-gauge" class="gauge-container gauge-medium" data-bottom="">
                        <div class="gauge-label-bottom"></div>
                    </div>
                </a>
                <div id="inodes-alerts"></div>
            </div>
        </div>

       

       

        <!-- Network -->
        <div class="block col mob-whole tab-8 desk-6 desk-large-4 ">
            <div class="header">
                <span class="title">Network</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.Network.get">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content">
                <table id="network-table" class="data-table responsive">
                    <thead>
                        <tr>
                            <th class="light no-style">Interface</th>
                            <th class="light no-style">IP</th>
                            <th class="light no-style align-right padding-right-12">Receive</th>
                            <th class="light no-style align-right padding-right-12">Transmit</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>    
            </div>
        </div>


     
        <!-- System users -->
         <div class="block col mob-whole tab-4 desk-3 desk-large-2 ">
            <div class="header">
                <span class="title">Users</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.SystemUsers.getNumberActive" title="Refresh">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content align-center">
                <br>
                <p>
                    <a href="<?php echo $this->baseUrl;?>sysusers/currents" data-view="sysusers/currents">
                        <span class="main color-status-ok" id="current-users-number"></span>
                        <span class="right">connected user(s) </span>
                    </a>
                </p>
            </div>
        </div>

         <!-- Process -->
         <div class="block col mob-whole tab-4 desk-3 desk-large-2 ">
            <div class="header">
                <span class="title">Process</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.Process.get" title="Refresh">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content align-left">
                <br>
                <table id="process-table" class="data-table ">
                        <tbody>
                            <tr>
                                <td class="color-light">Total:</td>
                                <td class="align-right" id="dashboard_process_total">...</td>
                            </tr>
                            <tr>
                                <td class="color-light">Running:</td>
                                <td class="align-right" id="dashboard_process_running">...</td>
                            </tr>
                        </tbody>
                </table>
            </div>
        </div>

        <!-- Services -->
        <div class="block col mob-whole tab-8 desk-6  desk-large-4 ">
            <div class="header">
                <span class="title">Services</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind="Minitoring.Services.refresh" title="Refresh">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content">
                <table id="services-table" class="data-table">
                    <tbody></tbody>
                </table>
            </div>
        </div>




    </div>
    <br>
</section>