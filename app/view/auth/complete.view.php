<form id="frm_auth_complete" class="small align-left" method="post" 
      action="<?php echo $this->baseUrl . 'auth/invite/register/' . $this->data('userId') .'/' . $this->data('actionHash') ; ?>">

    <h5 class="u"><span class="theme-color">Mini</span>toring<span class="theme-color">.</span></h5>
    <?php  $this->renderFeedback(); ?>
    
    <p>Welcome!</p>
    <p>Set your user name and password to complete your registration.</p>
    
    <input name="uid" type="hidden" value="<?php echo $this->data('userId'); ?>"/>
    <input name="uac" type="hidden" value="<?php echo $this->data('actionHash'); ?>"/>
    
    <input type="text" pattern="[a-zA-Z0-9]{2,64}"    name="user_name"      placeholder="Username (letters/numbers, 2-64 chars)" required />
    
    <input type="password" id="user_password_new"     name="user_password"        pattern=".{8,}" placeholder="Password (8+ characters)" required autocomplete="off" />
    
    <input type="password" id="user_password_repeat"  name="user_password_repeat" pattern=".{8,}" placeholder="Repeat your password" required autocomplete="off" />
    
    <section class="section">
        <input type="submit" class="button large uppercase full-width theme" value="Register" title="Register"></input>
    </section>
</form>