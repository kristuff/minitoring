<form id="frm_auth_complete" class="medium align-left" method="post" action="<?php echo $this->baseUrl . 'auth/invite/register/' . $this->data('userId') .'/' . $this->data('actionHash') ; ?>">
    <h5 class="u"><span class="theme-color">Mini</span>toring<span class="theme-color">.</span></h5>
    
    <?php  $this->renderFeedback(); ?>
    
    <p><?php $this->echo('AUTH_REGISTER_TITLE');?></p>
    
    <input name="uid" type="hidden" value="<?php echo $this->data('userId'); ?>"/>
    <input name="uac" type="hidden" value="<?php echo $this->data('actionHash'); ?>"/>
    
    <label><?php $this->echo('USER_NAME_FIELD');?></label>
    <input type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" placeholder="<?php $this->echo('USER_NAME_CREATE_PLACEHOLDER');?>" required />
    
    <label><?php $this->echo('USER_PASSWORD_FIELD');?></label>
    <input type="password" id="user_password_new"     name="user_password"        pattern=".{8,}" placeholder="<?php $this->echo('USER_PASSWORD_CREATE_PLACEHOLDER');?>" required autocomplete="off" />
    <i class="fa toggle-password"></i>
     
    <label><?php $this->echo('USER_PASSWORD_REPEAT_FIELD');?></label>
    <input type="password" id="user_password_repeat"  name="user_password_repeat" pattern=".{8,}" placeholder="<?php $this->echo('USER_PASSWORD_REPEAT_PLACEHOLDER');?>" required autocomplete="off" />
    <i class="fa toggle-password"></i>
     
    <section class="section">
        <input type="submit" class="button large uppercase full-width theme" value="<?php $this->echo('AUTH_REGISTER_BUTTON');?>" title="<?php $this->echo('AUTH_REGISTER_BUTTON');?>"></input>
    </section>
</form>