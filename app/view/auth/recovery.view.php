<form id="frm_passResetRequest" data-style="flat" class="medium align-left" method="post" action="<?php echo $this->baseUrl; ?>auth/recovery/request">

    <div class="h6 highlight"><?php $this->echo('AUTH_RECOVERY_TITLE'); ?></div>
    <p> <?php $this->echo('AUTH_RECOVERY_TEXT'); ?></p>
    
    <section class="section">
        <label for="user_name_or_email"><?php $this->echo('USER_NAME_OR_EMAIL_FIELD');?></label>
        <input type="text" placeholder="" name="user_name_or_email" required />
    </section>
    
    <section class="section">
        <label><?php $this->echo('CAPTCHA_FIELD'); ?></label> 
        <div class="margin-v-6 flex flex-wrap">
            <a class="button button-flat button-small" title="Reload captcha" href="#!" data-bind="Minitoring.App.getNewRecoveryCaptcha"><i class="fa fa-refresh"></i></a>
            <img height="35" alt="captcha" id="recovery_captcha_img" class="margin-h-6" src="<?php echo $this->baseUrl; ?>auth/recovery/captcha" />
            <input type="text" class="inline-block width-50px" name="captcha_value" placeholder="" required />
        </div>
    </section>

    <?php  $this->renderFeedback(); ?>

    <section class="section">
        <input type="submit" class="button large uppercase full-width theme" data-color="theme" value="<?php $this->echo('AUTH_RECOVERY_BUTTON'); ?>" />
    </section>
    <section class="align-center">
        <a id="" class="link text-small" href="<?php echo $this->baseUrl; ?>auth/signin"><?php $this->echo('AUTH_RECOVERY_BACK_TO_LOGIN'); ?></a>
    </section>

</form>