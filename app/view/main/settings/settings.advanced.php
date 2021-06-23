<section id="settings-advanced" class="view anim-scale-increase" data-view="settings/advanced" data-title="<?php $this->echo('SETTINGS_ADVANCED');?>">

    <section class="section">
        <form id="" class="small">
            <label><?php $this->echo('SETTINGS_TOKEN_FIELD');?></label>
            <input id="" type='text' name='' value="<?php echo $this->data('websocketToken'); ?>" readonly />
            <br>
            <button class="button Xuppercase" data-color="theme" data-style="flat" data-bind="">
                <i class="fa fa-trash icon-left color-theme"></i><?php $this->echo('SETTINGS_TOKEN_RESET_BUTTON');?>
            </button>
        </form>
    </section>       
    <br>

    <section class="section">
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