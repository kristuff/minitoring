<form id="frm_passResetRequest" data-style="flat" class="medium align-left" method="post" action="<?php echo $this->baseUrl; ?>auth/recovery/request">

    <div class="h6 highlight"><?php $this->echo('AUTH_RECOVERY_TITLE'); ?></div>
    <p> <?php $this->echo('AUTH_RECOVERY_TEXT'); ?></p>
    
    <section class="section">
        <label for="user_name_or_email"><?php $this->echo('USER_NAME_OR_EMAIL_FIELD');?></label>
        <input type="text" placeholder="<?php $this->echo('USER_NAME_OR_EMAIL_PLACEHOLDER');?>" name="user_name_or_email" required />
    </section>
    
    <section class="section">
        <div class="columns-2">
            <img width="190px" height="60px" alt="captcha..." id="captcha" src="<?php echo $this->baseUrl ; ?>auth/recovery/captcha" />
            <a id="captcha_reload"  class="link txt-small" href="" onclick="document.getElementById('captcha').src = '<?php echo $this->baseUrl; ?>auth/recovery/captcha?' + Math.random(); return false">
                <i class="fa fa-refresh icon-left"></i><?php $this->echo('CAPTCHA_RELOAD_LINK');?>
            </a>
        </div>
        <label><?php $this->echo('CAPTCHA_FIELD'); ?></label> 
        <input type="text" name="captcha_value" placeholder="<?php $this->echo('CAPTCHA_PLACEHOLDER'); ?>" required />
    </section>

    <?php  $this->renderFeedback(); ?>

    <section class="section">
        <input type="submit" class="button large uppercase full-width theme" data-color="theme" value="<?php $this->echo('AUTH_RECOVERY_BUTTON'); ?>" />
    </section>
    <section class="align-center">
        <a id="" class="link text-small" href="<?php echo $this->baseUrl; ?>auth/signin"><?php $this->echo('AUTH_RECOVERY_BACK_TO_LOGIN'); ?></a>
    </section>

</form>