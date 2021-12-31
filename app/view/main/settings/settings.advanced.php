<section id="settings-advanced" class="view anim-scale-increase" data-view="settings/advanced" data-title="<?php $this->echo('SETTINGS_ADVANCED');?>">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="" href="<?php echo $this->baseUrl;?>"><?php $this->echo('HOME');?></a></li>
        <li class="breadcrumb-item"><a class="" href="<?php echo $this->baseUrl;?>settings/" data-view="settings"><?php $this->echo('SETTINGS'); ?></a></li>
        <li class="breadcrumb-item active"><?php $this->echo('SETTINGS_ADVANCED');?></li>
    </ol>
    <br>

    <section class="section">
        <h5 class="color-accent text-light"><?php $this->echo('SETTINGS_SECURITY_TITLE') ;?></h5>
        <div class="container container-medium">
            <form>
                <p class="margin-bottom-12"><?php $this->echo('SETTINGS_TOKEN_TEXT');?></p>
                <label><?php $this->echo('SETTINGS_TOKEN_FIELD');?></label>
                <input class="block" id="settings-websocket-token" type='text' value="<?php echo $this->data('websocketToken'); ?>" readonly />
                <br>
                <button class="button" data-color="theme" data-style="flat" data-bind="Minitoring.Admin.resetApiKey">
                    <i class="fa fa-refresh color-theme icon-left color-theme"></i><?php $this->echo('SETTINGS_TOKEN_RESET_BUTTON');?>
                </button>
            </form>
        </div>
    </section>       

    <section class="section">
        <h5 class="color-accent text-light"><?php $this->echo('CPU'); ?></h5>
        <div class="container container-medium">

            <div class="padding-top-6 position-relative">
                <input id="cpu_show_temp" type="checkbox" class="switch"  <?php echo $this->data('appSettings')['CPU_SHOW_TEMPERATURE'] ? ' checked ' : ''; ?> data-bind="Minitoring.Admin.cpuShowTempChanged" data-bind-event="change"/>
                <label for="cpu_show_temp"></label>
                <label><?php $this->echo('SETTINGS_CPU_SHOW_TEMPERATURE'); ?></label>
            </div>
            
        </div>
    </section>

    <section class="section">
        <h5 class="color-accent text-light"><?php $this->echo('DISKS'); ?></h5>
        <div class="container container-medium">
            <div class="padding-top-6 position-relative">
                <input id="disks_show_tmpfs" type="checkbox" class="switch"  <?php echo $this->data('appSettings')['DISKS_SHOW_TMPFS'] ? ' checked ' : ''; ?> data-bind="Minitoring.Admin.diskShowTmpfsChanged" data-bind-event="change"/>
                <label for="disks_show_tmpfs"></label>
                <label><?php $this->echo('SETTINGS_DISK_SHOW_TMPFS'); ?></label>
            </div>
            <div class="padding-top-12 position-relative">
                <input id="disks_show_loop" type="checkbox" class="switch"  <?php echo $this->data('appSettings')['DISKS_SHOW_LOOP'] ? ' checked ' : ''; ?> data-bind="Minitoring.Admin.diskShowLoopChanged" data-bind-event="change"/>
                <label for="disks_show_loop"></label>
                <label><?php $this->echo('SETTINGS_DISK_SHOW_LOOP'); ?></label>
            </div>
            
            <div class="padding-top-12 position-relative need-active">
                <input id="disks_show_fs" type="checkbox" class="switch" <?php echo $this->data('appSettings')['DISKS_SHOW_FILE_SYSTEM'] ? ' checked ' : ''; ?> data-bind="Minitoring.Admin.diskShowFileSystemChanged" data-bind-event="change"/>
                <label for="disks_show_fs"></label>
                <label><?php $this->echo('SETTINGS_DISK_SHOW_FILE_SYSTEM'); ?></label>
            </div>
        </div>
    </section>

    <section class="section">
        <h5 class="color-accent text-light"><?php $this->echo('SERVICES'); ?></h5>
        <div class="padding-top-6 position-relative">
            <input id="services_show_port" type="checkbox" class="switch" <?php echo $this->data('appSettings')['SERVICES_SHOW_PORT_NUMBER'] ? ' checked ' : ''; ?> data-bind="Minitoring.Admin.serviceShowPortChanged" data-bind-event="change"/>
            <label for="services_show_port"></label>
            <label><?php $this->echo('SETTINGS_SERVICES_SHOW_PORT_NUMBER'); ?></label>
        </div>
    </section>

    <section class="section">
        <h5 class="color-accent text-light"><?php $this->echo('SETTINGS_MISC_TITLE') ;?></h5>
        <div class="container container-medium">
            <div class="padding-bottom-6"><?php $this->echo('SETTINGS_IP_ACTION_FIELD'); ?></div>
            <div class="custom-select">
                <select id="select-ip-action" data-bind="Minitoring.Admin.ipActionChanged">
                    <option value="none" <?php echo empty($this->data('appSettings')['IP_ACTION']) || $this->data('appSettings')['IP_ACTION'] == 'none' ? ' selected ' : ''; ?>><?php $this->echo('SETTINGS_IP_ACTION_NONE'); ?></option>
                    <option value="geoip" <?php echo $this->data('appSettings')['IP_ACTION'] == 'geoip' ? ' selected ' : ''; ?>><?php $this->echo('SETTINGS_IP_ACTION_GEOIP'); ?></option>
                    <option value="abuseipdb" <?php echo $this->data('appSettings')['IP_ACTION'] == 'abuseipdb' ? ' selected ' : ''; ?>><?php $this->echo('SETTINGS_IP_ACTION_ABUSEIPDB'); ?></option>
                </select>
            </div>
        </div>
    </section>
  
    <section class="section">
        <h5 class="color-accent text-light"><?php $this->echo('SETTINGS_DEFAULT_TITLE') ;?></h5>
        <div class="container container-medium">
            <p><?php $this->echo('SETTINGS_DEFAULT_TEXT') ;?></p>
            <form class="padding-top-12">
                <div class="padding-bottom-6"><?php $this->echo('SETTINGS_CUSTOMIZE_LANGUAGE_FIELD') ;?></div>
                <div class="custom-select full-width">
                    <select id="select-default-language" data-bind="Minitoring.Admin.defaultlangChanged">
                        <option value="en-US" <?php echo $this->data('appSettings')['UI_LANG'] === 'en-US' ? ' selected' : '' ;?> >English (en-US)</option>
                        <option value="fr-FR" <?php echo $this->data('appSettings')['UI_LANG'] === 'fr-FR'  ? ' selected' : '' ;?> >Français (fr-FR)</option>
                    </select>
                </div>
            </form>
        </div>
    </section>
    <br>

</section>