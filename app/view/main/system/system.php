<section id="system-section" class="view anim-scale-increase" data-view="system" data-title="System"
    data-refresh="Minitoring.System.refresh">

    <div class="dashboard ">

    <div class="block col mob-whole tab-half XXdesk-third">
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
                        <td data-column="title">Hostname:</td>
                        <td id="system-hostname" class="highlight"></td>
                    </tr>
                    <tr>
                        <td data-column="title">OS:</td>
                        <td id="system-os" class="highlight"></td>
                    </tr>
                    <tr>
                        <td data-column="title">Kernel version:</td>
                        <td id="system-kernel" class="highlight"></td>
                    </tr>
                    <tr>
                        <td data-column="title">Uptime:</td>
                        <td id="system-uptime" class="highlight"></td>
                    </tr>
                    <tr>
                        <td data-column="title">Last boot:</td>
                        <td id="system-last-boot" class="highlight"></td>
                    </tr>
                    <tr>
                        <td data-column="title">Server date & time:</td>
                        <td id="system-server-date" class="highlight"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="block col mob-whole tab-half XXdesk-third">
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
                        <td data-column="title">Model:</td>
                        <td id="cpu-model" class="highlight"></td>
                    </tr>
                    <tr>
                        <td data-column="title">Cores:</td>
                        <td id="cpu-cores" class="highlight"></td>
                    </tr>
                    <tr>
                        <td data-column="title">Speed:</td>
                        <td id="cpu-speed" class="highlight"></td>
                    </tr>
                    <tr>
                        <td data-column="title">Cache:</td>
                        <td id="cpu-cache" class="highlight"></td>
                    </tr>
                    <tr>
                        <td data-column="title">Bogomips:</td>
                        <td id="cpu-bogomips" class="highlight"></td>
                    </tr>
                    <tr>
                        <td data-column="title">Temperature:</td>
                        <td id="cpu-temperature" class="highlight"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Load average -->
    <div class="block col mob-whole tab-half">
        <div class="header">
            <span class="title">Load average</span>
            <ul class="action-bar">
                <li>
                    <a class="action-link" href="#" data-module="LoadAverage" title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="content align-center">
            <div id="load-average-1-gauge"  class="gauge-container gauge-medium" data-bottom="1 min"></div>
            <div id="load-average-5-gauge"  class="gauge-container gauge-medium" data-bottom="5 mins"></div>
            <div id="load-average-15-gauge" class="gauge-container gauge-medium" data-bottom="15 mins"></div>
        </div>
    </div>

    <!-- Memory -->
    <div class="block col mob-whole tab-half desk-fourth">
        <div class="header">
            <span class="title">Memory</span>
            <ul class="action-bar">
                <li>
                    <a class="action-link" href="#" data-module="Memory" title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="content align-center">
            <div id="memory-gauge" class="gauge-container gauge-medium" data-bottom="..."></div>
        </div>
    </div>

    <div class="block col mob-whole tab-half desk-fourth">
        <div class="header">
            <span class="title">Swap</span>
            <ul class="action-bar">
                <li><a class="action-link" href="#" data-module="Swap" title="Refresh"><i class="fa fa-refresh"></i></a>
                </li>
            </ul>
        </div>
        <div class="content align-center">
            <div id="swap-gauge" class="gauge-container gauge-medium" data-bottom="..."></div>
        </div>
    </div>

    </div>

    <br>
</section>