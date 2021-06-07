<section id="side-menu" class="side-menu expanded">
    <div class="side-menu-header">
        <a href="#" class="side-menu-trigger"><i class="fa fa-bars"></i></a>
        <a href="#" class="side-menu-pin-trigger"><i class="fa fa-thumb-tack"></i></a>
    </div>
    <ul id="side-menus" class="side-menu-items">
        <li class="menu-item">
            <a class="side-menu-item" href="<?php echo $this->baseUrl;?>dashboard" data-view="dashboard">
                <i class="item-icon fa fa-line-chart fa-fw"></i>
                <span class="item-title">Dashboard</span>
            </a>
        </li>
        <li class="menu-item">
            <a class="side-menu-item" href="<?php echo $this->baseUrl;?>system"  data-view="system">
                <i class="item-icon fa fa-server fa-fw"></i>
                <span class="item-title">System</span>
            </a>
        </li>
        <li class="menu-item">
            <a class="side-menu-item" href="<?php echo $this->baseUrl;?>disks" data-view="disks">
                <i class="item-icon fa fa-pie-chart fa-fw"></i>
                <span class="item-title">Disks</span>
            </a>
        </li>
        <li class="menu-item">
            <a class="side-menu-item" href="<?php echo $this->baseUrl;?>sysusers" data-view="sysusers">
                <i class="item-icon fa fa-users fa-fw"></i>
                <span class="item-title">Users</span>
            </a>
        </li>
        <li class="menu-item">
            <a class="side-menu-item" href="<?php echo $this->baseUrl;?>services" data-view="services">
                <i class="item-icon fa fa-tags fa-fw"></i>
                <span class="item-title">Services</span>
            </a>
        </li>
        <li class="menu-item">
            <a class="side-menu-item" href="<?php echo $this->baseUrl;?>bans" data-view="bans">
                <i class="item-icon fa fa-ban fa-fw"></i>
                <span class="item-title">Bans</span>
            </a>
        </li>
        <li class="menu-item">
            <a class="side-menu-item" href="<?php echo $this->baseUrl;?>crons" data-view="crons">
                <i class="item-icon fa fa-calendar fa-fw"></i>
                <span class="item-title">Crons</span>
            </a>
        </li>

        <li class="menu-item">
            <a class="side-menu-item" href="<?php echo $this->baseUrl;?>logs" data-view="logs">
                <i class="item-icon fa fa-file-text fa-fw"></i>
                <span class="item-title"><?php echo $this->text('LOGS');?></span>
            </a>
        </li>
        <li class="menu-item">
            <a class="side-menu-item" href="<?php echo $this->baseUrl;?>settings" data-view="settings">
                <i class="item-icon fa fa-cog fa-fw"></i>
                <span class="item-title"><?php echo $this->text('SETTINGS'); ?></span>
            </a>
        </li>
        <li>
            <a class="side-menu-item" href="<?php echo $this->baseUrl; ?>auth/logout">
                <i class="item-icon fa fa-sign-out fa-fw"></i>
                <span class="item-title"><?php echo $this->text('AUTH_LOGOUT_BUTTON_TEXT'); ?></span>
            </a>
        </li>
    </ul>
</section>
