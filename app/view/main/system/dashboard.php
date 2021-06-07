<section id="section-dashboard" class="view anim-scale-increase section dashboard" data-view="dashboard"
    data-title="Dashboard" data-refresh="Minitoring.Dashboard.refresh">
    
    <div class="dashboard">

        <!-- Uptime -->
        <div class="block col mob-whole tab-4 desk-3">
            <div class="header">
                <span class="title"><i class="fa fa-calendar-o icon-left"></i>Uptime</span>
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
            </div>
        </div>

        <!-- Load average -->
        <div class="block col mob-whole tab-8 desk-6">
            <div class="header">
                <span class="title"><i class="fa fa-line-chart icon-left"></i>Load average</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-module="LoadAverage" title="Refresh">
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
        <div class="block col mob-whole tab-4 desk-3">
            <div class="header">
                <span class="title"><i class="fa fa-server icon-left"></i>Memory</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-module="Memory" title="Refresh">
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
        <div class="block col mob-whole tab-4 desk-3">
            <div class="header">
                <span class="title"><i class="fa fa-server icon-left"></i>Swap</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-module="Memory" title="Refresh">
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

        <!-- Services -->
        <div class="block col mob-whole tab-8 desk-6">
            <div class="header">
                <span class="title"><i class="fa fa-cogs icon-left"></i>Services</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-module="Services" title="Refresh">
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

        <!-- Disks -->
        <div class="block col mob-whole tab-4 desk-3">
            <div class="header">
                <span class="title"><i class="fa fa-pie-chart icon-left"></i>Disks</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-module="Disks" title="Refresh">
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

        <!-- System users -->
        <div class="block col mob-whole tab-4 desk-3">
            <div class="header">
                <span class="title"><i class="fa fa-users icon-left"></i>Users</span>
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

        <!-- Network -->
        <div class="block col mob-whole tab-8 desk-6">
            <div class="header">
                <span class="title"><i class="fa fa-signal icon-left"></i>Network</span>
                <ul class="action-bar">
                    <li>
                        <a class="action-link" href="#" data-bind_TODO="">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <table id="network-table" class="data-table responsive">
                <thead>
                    <tr>
                        <th>Interface</th>
                        <th>IP</th>
                        <th>Receive</th>
                        <th>Transmit</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>    
        </div>

    </div>
    <br>
</section>