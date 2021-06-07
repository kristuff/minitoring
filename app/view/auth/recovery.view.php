<form id="frm_passResetRequest" data-style="flat" class="medium align-left" method="post" 
      action="<?php echo $this->baseUrl; ?>auth/recovery/request">

    <h5 class="u"><span class="theme-color">Mini</span>toring<span class="theme-color">.</span></h5>

    <p class="h6"><?php echo $this->textSection('LOGIN_RECOVERY_TITLE', 'miniweb-auth'); ?></p>
    <p> <?php echo $this->textSection('LOGIN_RECOVERY_TEXT', 'miniweb-auth'); ?></p>
    
    <label for="user_name_or_email"></label>
    <input type="text" placeholder="Enter adresse email or user name" name="user_name_or_email" required />
   
    <section class="section">
        <img width="260px" height="80px" alt="captcha..." id="captcha" src="<?php echo $this->baseUrl ; ?>auth/recovery/captcha" />
        <div class="padding-bottom-6">
            <a id="captcha_reload"  class="link txt-small" href="" onclick="document.getElementById('captcha').src = '<?php echo $this->baseUrl; ?>auth/recovery/captcha?' + Math.random(); return false">
                <i class="fa fa-refresh"></i> Reload Captcha
            </a>
        </div>
        <input type="text" name="captcha_value" placeholder="Enter captcha above" required />
    </section>

    <?php  $this->renderFeedback(); ?>

    <section class="section">
        <input type="submit" class="button large uppercase full-width theme" data-color="theme" value="<?= $this->textSection('LOGIN_RECOVERY_BUTTON', 'miniweb-auth'); ?>" />
    </section>
    <section class="section align-center">
        <a id="" class="link text-small" href="<?php echo $this->baseUrl; ?>auth/signin">Back to login</a>
    </section>

</form>