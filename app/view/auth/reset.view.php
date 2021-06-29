<form id="frm_resetPassword" class="medium align-left" method="post" action="<?php echo $this->baseUrl; ?>auth/recovery/reset" name="new_password_form">

    <h5 class="u"><span class="theme-color">Mini</span>toring<span class="theme-color">.</span></h5>
    
    <?php  $this->renderFeedback(); ?>
    
    <section class="section">
        <input type='hidden' name='user_name' value='<?php echo $this->data('userName'); ?>' />
        <input type='hidden' name='user_password_reset_hash' value='<?php echo $this->data('userPasswordResetHash'); ?>' />
        
        <label for="reset_input_password_new"><?php $this->echo('USER_NEW_PASSWORD_FIELD');?></label>
        <input  id="reset_input_password_new" class="reset_input" type="password" name="user_password_new" pattern=".{8,}" placeholder="<?php $this->echo('USER_PASSWORD_CREATE_PLACEHOLDER');?>" required autocomplete="off" />
        <i class="fa toggle-password"></i>
     
        <label for="reset_input_password_repeat"><?php $this->echo('USER_PASSWORD_REPEAT_FIELD');?></label>
        <input  id="reset_input_password_repeat" class="reset_input" type="password" name="user_password_repeat" pattern=".{8,}" placeholder="<?php $this->echo('USER_PASSWORD_REPEAT_PLACEHOLDER');?>" required autocomplete="off" />
        <i class="fa toggle-password"></i>
     </section>
    <section class="section">
        <input type="submit" class="button large uppercase full-width theme" name="submit_new_password" value="<?php $this->echo('AUTH_RECOVERY_SUBMIT_PASSWORD');?>" />
    </section>

    <section class="align-center">
        <a id="" class="link text-small" href="<?php echo $this->baseUrl; ?>auth/signin"><?php $this->echo('AUTH_RECOVERY_BACK_TO_LOGIN'); ?></a>
    </section>

</form>
