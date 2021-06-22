<section id="settings-advanced" class="view anim-scale-increase" data-view="settings/advanced" data-title="<?php $this->echo('SETTINGS_ADVANCED');?>">

    <section class="section">
        <form id="" class="small">
            <h6 class="title light"><?php $this->echo('SETTINGS_APP_KEY_TITLE');?></h6>
            <input id="" type='text' name='' value="<?php echo $this->data('websocketToken'); ?>" readonly />
            <br>
            <button class="button Xuppercase" data-color="theme" data-style="flat" data-bind="">
                <i class="fa fa-trash icon-left color-theme"></i><?php $this->echo('SETTINGS_XXXXXXXXXXXXXX');?>
            </button>
        </form>
    </section>       
    <br>

</section>