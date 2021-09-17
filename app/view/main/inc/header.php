<header class="main-header bg-darker">

<a href="#" class="side-menu-trigger"><i class="fa fa-bars"></i></a><span id="header-title" class="h4 text-light no-margin"><?php echo $this->data('viewTitle'); ?></span>
<a id="current-user" href="<?php echo $this->baseUrl;?>settings/profile" data-view="settings/profile">
    <img class="avatar" src="<?php echo $this->data('userAvatarUrl'); ?>" alt="Profile picture"/>
        <div>
            <span class="user-name"><?php echo $this->data('userName'); ?></span>
            <span class="user-email color-light"><?php echo $this->data('userEmail'); ?></span>
        </div>
</a>

</header>