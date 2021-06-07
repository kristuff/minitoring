<form id="frm_resetPassword" class="small align-left" 
    method="post" action="<?php echo $this->baseUrl; ?>auth/recovery/reset" name="new_password_form">

    <h5 class="u"><span class="theme-color">Mini</span>toring<span class="theme-color">.</span></h5>
    <?php  $this->renderFeedback(); ?>
    
    <input type='hidden' name='user_name' value='<?php echo $this->data('userName'); ?>' />
    <input type='hidden' name='user_password_reset_hash' value='<?php echo $this->data('userPasswordResetHash'); ?>' />
    <label for="reset_input_password_new">New password (min. 8 characters)</label>
    <input id="reset_input_password_new" class="reset_input" type="password" name="user_password_new" pattern=".{8,}" required autocomplete="off" />
    <label for="reset_input_password_repeat">Repeat new password</label>
    <input id="reset_input_password_repeat" class="reset_input" type="password" name="user_password_repeat" pattern=".{8,}" required autocomplete="off" />
    <section class="section">
        <input type="submit" class="button large uppercase full-width theme" name="submit_new_password" 
             value="Submit new password" />
    </section>
</form>
