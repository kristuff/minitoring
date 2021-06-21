<form id="frm_login" class="align-left" action="<?php echo $this->baseUrl; ?>auth/signin/perform" method="post">
    
    <h5 class="u"> <span class="theme-color">Mini</span>toring<span class="theme-color">.</span></h5>
    <section class="section">

        <label><?php $this->echo('USER_NAME_OR_EMAIL_FIELD');?></label>
        <input type="text"      id="user_name_or_email" name="user_name_or_email" placeholder="<?php $this->echo('USER_NAME_OR_EMAIL_PLACEHOLDER');?>" required />
        
        <label><?php $this->echo('USER_PASSWORD_FIELD');?></label>
        <input type="password"  id="user_password"      name="user_password" class="password" placeholder="<?php $this->echo('USER_PASSWORD_PLACEHOLDER');?>" required />

<?php if (!empty($this->data('redirect'))) { ?>
        <input type="hidden" name="redirect" value="<?php echo $this->noHTML($this->data('redirect')); ?>" />
<?php } ?>

        <input type="hidden" name="token" value="<?php echo $this->data('token'); ?>"/>

<?php if ($this->data('allowCookie')){  ?>
        <div>
            <input type="checkbox" id="set_remember_me_cookie" name="set_remember_me_cookie" class="checkbox" value="on" />
            <label for="set_remember_me_cookie" class="remember-me-label"><?php $this->echo('AUTH_LOGIN_REMEMBER_ME');?></label>
       </div>
<?php } ?>

    </section>

    <?php $this->renderFeedback(); ?>

    <section class="section">
        <input type="submit" class="button large uppercase full-width theme" value="<?php $this->echo('AUTH_LOGIN_BUTTON_TEXT');?>" title="<?php $this->echo('AUTH_LOGIN_BUTTON_TEXT');?>"/>
    </section>

<?php if ($this->data('allowRecovery')){  ?>
    <section class="align-center">
        <a id="pass_reset" class="link text-small" href="<?php echo $this->baseUrl; ?>auth/recovery"><?php $this->echo('AUTH_FORGOT_PASSWORD_LINK');?></a>
    </section>
<?php } ?>

</form>
