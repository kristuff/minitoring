<section id="side-menu" class="side-menu expanded">
    <div class="side-menu-header">
        <a href="#" class="side-menu-trigger"><i class="fa fa-bars"></i></a>
        <div class="side-menu-title text-light">M<span class="color-theme">i</span>nitoring</div>
    </div>
    <ul id="side-menus" class="side-menu-items">
        <li class="menu-item">
            <a class="side-menu-item" href="<?php echo $this->baseUrl;?>overview" data-view="overview">
                <i class="item-icon fa fa-dashboard Xfa-line-chart fa-fw"></i>
                <span class="item-title"><?php $this->echo('OVERVIEW'); ?></span>
            </a>
        </li>
        <li class="menu-item">
            <a class="side-menu-item" href="<?php echo $this->baseUrl;?>disks" data-view="disks">
                <i class="item-icon fa fa-pie-chart fa-fw"></i>
                <span class="item-title"><?php $this->echo('DISKS'); ?></span>
            </a>
        </li>
        <li class="menu-item">
            <a class="side-menu-item" href="<?php echo $this->baseUrl;?>sysusers" data-view="sysusers">
                <i class="item-icon fa fa-users fa-fw"></i>
                <span class="item-title"><?php $this->echo('SYS_USERS'); ?></span>
            </a>
        </li>
        <li class="menu-item">
            <a class="side-menu-item" href="<?php echo $this->baseUrl;?>packages" data-view="packages">
                <i class="item-icon fa fa-shopping-bag fa-fw"></i>
                <span class="item-title"><?php $this->echo('PACKAGES'); ?></span>
            </a>
        </li>
        <li class="menu-item">
            <a class="side-menu-item" href="<?php echo $this->baseUrl;?>bans" data-view="bans">
                <i class="item-icon fa fa-ban fa-fw"></i>
                <span class="item-title"><?php $this->echo('FIREWALL'); ?></span>
            </a>
        </li>
        <li class="menu-item">
            <a class="side-menu-item" href="<?php echo $this->baseUrl;?>crons" data-view="crons">
                <i class="item-icon fa fa-calendar fa-fw"></i>
                <span class="item-title"><?php $this->echo('CRONS');?></span>
            </a>
        </li>

        <li class="menu-item">
            <a class="side-menu-item" href="<?php echo $this->baseUrl;?>logs" data-view="logs">
                <i class="item-icon fa fa-file-text fa-fw"></i>
                <span class="item-title"><?php $this->echo('LOGS');?></span>
            </a>
        </li>
        <li class="menu-item">
            <a class="side-menu-item" href="<?php echo $this->baseUrl;?>settings" data-view="settings">
                <i class="item-icon fa fa-cog fa-fw"></i>
                <span class="item-title"><?php $this->echo('SETTINGS'); ?></span>
            </a>
        </li>
        <li>
            <a class="side-menu-item" href="<?php echo $this->baseUrl; ?>auth/logout">
                <i class="item-icon fa fa-sign-out fa-fw"></i>
                <span class="item-title"><?php $this->echo('AUTH_LOGOUT_BUTTON_TEXT'); ?></span>
            </a>
        </li>
    </ul>
</section>
