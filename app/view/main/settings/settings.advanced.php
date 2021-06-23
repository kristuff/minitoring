<section id="settings-advanced" class="view anim-scale-increase" data-view="settings/advanced" data-title="<?php $this->echo('SETTINGS_ADVANCED');?>">

    <section class="section">
        <h6 class="highlight"><?php $this->echo('SETTINGS_SECURITY_TITLE') ;?></h6>
        <form class="large">
            <p><?php $this->echo('SETTINGS_TOKEN_TEXT');?></p>
            <br>
            <label><?php $this->echo('SETTINGS_TOKEN_FIELD');?></label>
            <input id="" type='text' name='' value="<?php echo $this->data('websocketToken'); ?>" readonly />
            <br>
            <button class="button" data-color="theme" data-style="flat" data-bind="Minitoring.Admin.resetApiKey">
                <i class="fa fa-refresh icon-left color-theme"></i><?php $this->echo('SETTINGS_TOKEN_RESET_BUTTON');?>
            </button>
        </form>
    </section>       
    <br>

    <section class="section">
        <h6 class="highlight"><?php $this->echo('SETTINGS_MISC_TITLE') ;?></h6>
        <div class="container medium no-padding">
            <div class="padding-bottom-6"><?php $this->echo('SETTINGS_IP_ACTION_FIELD'); ?></div>
            <div class="custom-select">
                <select id="select-log-max" data-bind="">
                    <option value="none"><?php $this->echo('SETTINGS_IP_ACTION_NONE'); ?></option>
                    <option value="geoip"><?php $this->echo('SETTINGS_IP_ACTION_GEOIP'); ?></option>
                    <option value="abuseipdb"><?php $this->echo('SETTINGS_IP_ACTION_ABUSEIPDB'); ?></option>
                </select>
            </div>
        </div>
    </section>
    <br>


</section>