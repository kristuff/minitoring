<section id="settings" class="view anim-scale-increase" data-view="settings" 
         data-title="<?php $this->echo('SETTINGS'); ?>" >

    <div class="wrap flex flex-wrap">
        <div class="rwd-box">
            <a class="box-inner" href="<?php echo $this->baseUrl;?>settings/customize" data-view="settings/customize" role="button">
               <span class="box-icon"><i class="fa fa-fw color-theme fa-2x fa-desktop"></i></span>
               <span class="box-title"><?php $this->echo('SETTINGS_CUSTOMIZE'); ?></span>
               <span class="box-subtitle"><?php $this->echo('SETTINGS_CUSTOMIZE_SUMMARY'); ?></span>
            </a>
        </div>
        <div class="rwd-box">
            <a class="box-inner" href="<?php echo $this->baseUrl;?>settings/profile" data-view="settings/profile" role="button">
               <span class="box-icon"><i class="fa fa-fw color-theme fa-2x fa-user"></i></span>
               <span class="box-title"><?php $this->echo('SETTINGS_PROFILE'); ?></span>
               <span class="box-subtitle"><?php $this->echo('SETTINGS_PROFILE_SUMMARY'); ?></span>
            </a>
        </div>

<?php if ($this->data('userIsAdmin') === true ) { ?>

        <div class="rwd-box">
            <a class="box-inner" href="<?php echo $this->baseUrl;?>settings/logreader" data-view="settings/logreader" role="button">
               <span class="box-icon"><i class="fa fa-fw color-theme fa-2x fa-file-text"></i></span>
               <span class="box-title"><?php $this->echo('SETTINGS_LOGREADER'); ?></span>
               <span class="box-subtitle"><?php $this->echo('SETTINGS_LOGREADER_SUMMARY'); ?></span>
            </a>
        </div>

        
        <div class="rwd-box">
            <a class="box-inner" href="<?php echo $this->baseUrl;?>settings/services" data-view="settings/services" role="button">
               <span class="box-icon"><i class="fa fa-fw color-theme fa-2x fa-tasks"></i></span>
               <span class="box-title"><?php $this->echo('SETTINGS_SERVICES'); ?></span>
               <span class="box-subtitle"><?php $this->echo('SETTINGS_SERVICES_SUMMARY'); ?></span>
            </a>
        </div>

                <?php if (false === true ) { // skip for now... ?>

        <div class="rwd-box">
            <a class="box-inner" href="<?php echo $this->baseUrl;?>settings/bans" data-view="settings/bans" role="button">
               <span class="box-icon"><i class="fa fa-fw color-theme fa-2x fa-ban"></i></span>
               <span class="box-title"><?php $this->echo('SETTINGS_BANS'); ?></span>
               <span class="box-subtitle"><?php $this->echo('SETTINGS_BANS_SUMMARY'); ?></span>
            </a>
        </div>


        <div class="rwd-box">
            <a class="box-inner" href="<?php echo $this->baseUrl;?>settings/data" data-view="settings/data" role="button">
               <span class="box-icon"><i class="fa fa-fw color-theme fa-2x fa-database"></i></span>
               <span class="box-title"><?php $this->echo('SETTINGS_DATA'); ?></span>
               <span class="box-subtitle"><?php $this->echo('SETTINGS_DATA_SUMMARY'); ?></span>
            </a>
        </div>

                <?php } ?>

        <div class="rwd-box">
            <a class="box-inner" href="<?php echo $this->baseUrl;?>settings/users" data-view="settings/users" role="button">
               <span class="box-icon"><i class="fa fa-fw color-theme fa-2x fa-users"></i></span>
               <span class="box-title"><?php $this->echo('SETTINGS_USERS'); ?></span>
               <span class="box-subtitle"><?php $this->echo('SETTINGS_USERS_SUMMARY'); ?></span>
            </a>
        </div>

<?php } ?>

        <div class="rwd-box">
            <a class="box-inner" href="<?php echo $this->baseUrl;?>settings/about" data-view="settings/about" role="button">
               <span class="box-icon"><i class="fa fa-fw color-theme fa-2x fa-info-circle"></i></span>
               <span class="box-title"><?php $this->echo('SETTINGS_INFOS'); ?></span>
               <span class="box-subtitle"><?php $this->echo('SETTINGS_INFOS_SUMMARY'); ?></span>
            </a>
        </div>

    </div>
</section>