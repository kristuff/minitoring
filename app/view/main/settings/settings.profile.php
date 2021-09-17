<section id="settings-profile" class="view view anim-scale-increase" data-view="settings/profile" data-title="<?php $this->echo('SETTINGS_PROFILE'); ?>">
  
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="" href="<?php echo $this->baseUrl;?>"><?php $this->echo('HOME');?></a></li>
        <li class="breadcrumb-item"><a class="" href="<?php echo $this->baseUrl;?>settings/" data-view="settings"><?php $this->echo('SETTINGS'); ?></a></li>
        <li class="breadcrumb-item active"><?php $this->echo('SETTINGS_PROFILE');?></li>
    </ol>
    <br>
    <section class="section">
        <h5 class="color-accent text-light"><?php $this->echo('SETTINGS_PROFILE_CARD_TITLE');?></h5>
        <div class="container-small bg-content padding-12">
            <img id="profile-card-avatar" class="float-left margin-right-10 margin-bottom-10" width="90px" height="90px" alt="avatar" src="<?php echo $this->data('userAvatarUrl'); ?>"/>    
            <div id="profile-card-name"><?php echo $this->data('userName'); ?></div>
            <span class="badge" data-badge="dark"><?php echo $this->data('userType'); ?></span>
            <div class="text-small">
                <p><i class="fa fa-envelope-o icon-left"></i><span id="profile-card-email"><?php echo $this->data('userEmail'); ?></span></p> 
                <p class="no-margin"><i class="fa fa-history icon-left"></i>Member since <?php echo $this->data('userMemberSince'); ?></p>
            </div>
        </div>
    </section>
   
    <section class="section">
        <form id="frm-user-edit" class="small">
            <h5 class="color-accent text-light"><?php $this->echo('SETTINGS_PROFILE_EDIT_TITLE');?></h5>
            <input type="hidden" name="token" value="<?php echo $this->data('token'); ?>"/>
            <label class=""><?php $this->echo('SETTINGS_PROFILE_NAME_FIELD');?></label>
            <input type="text" pattern="[a-zA-Z0-9]{2,64}" id="profile_user_name" name="user_name" placeholder="Username (letters/numbers, 2-64 chars)" required value="<?php echo $this->data('userName'); ?>"/>
            <label class=""><?php $this->echo('SETTINGS_PROFILE_EMAIL_FIELD');?></label>
            <input type="text" id="profile_user_email" name="user_email" placeholder="<?php $this->echo('SETTINGS_PROFILE_EMAIL_PLACEHOLDER');?>" 
                required value="<?php echo $this->data('userEmail'); ?>" />
            <div class="padding-top-24">
                <button class="button Xuppercase" data-color="theme" data-style="flat" data-bind="Minitoring.Profile.editUserNameOrEmail">
                    <i class="fa fa-save icon-left color-theme"></i><?php $this->echo('SETTINGS_PROFILE_EDIT_NAME_OR_EMAIL_BUTTON');?>
                </button>
            </div>       
        </form>
    </section>       
    <br>

    <section class="section">
        <form id="frm-user-password" class="small">
            <h5 class="color-accent text-light"><?php $this->echo('SETTINGS_PROFILE_EDIT_PASS_TITLE');?></h5>
            <input type="hidden" name="token" value="<?php echo $this->data('token'); ?>"/>
            
            <label class="" for="input_change_password_current"><?php $this->echo('SETTINGS_PROFILE_EDIT_PASS_CURRENT');?></label>
            <input id="input_change_password_current" class="reset_input" type="password" name='user_password_current' pattern=".{8,}" autocomplete="off" />
            <i class="fa toggle-password"></i>

            <label class="" for="input_change_password_new"><?php $this->echo('SETTINGS_PROFILE_EDIT_PASS_NEW');?></label>
            <input id="input_change_password_new" class="reset_input" type="password" name="user_password_new" pattern=".{8,}" autocomplete="off" />
            <i class="fa toggle-password"></i>

            <label class="" for="input_change_password_repeat"><?php $this->echo('SETTINGS_PROFILE_EDIT_PASS_NEW_REPEAT');?></label>
            <input id="input_change_password_repeat" class="reset_input" type="password" name="user_password_repeat" pattern=".{8,}" autocomplete="off" />
            <i class="fa toggle-password"></i>

            <div class="padding-top-24">
                <button class="button Xuppercase" data-color="theme" data-style="flat" data-bind="Minitoring.Profile.editPassword">
                    <i class="fa fa-save icon-left color-theme"></i><?php $this->echo('SETTINGS_PROFILE_EDIT_PASS_BUTTON');?>
                </button>
            </div>       
        </form>
    </section>       
    <br>

    <section class="section">
         <form id="frm-user-avatar" class="small">
            <h5 class="color-accent text-light"><?php $this->echo('SETTINGS_PROFILE_EDIT_AVATAR_TITLE');?></h5>
            <img id="avatar-preview" class="image-preview" width="90px" height="90px" alt="avatar" src="<?php echo $this->data('userAvatarUrl');  ?> "/>
            <div class="padding-bottom-12"><?php $this->echo('SETTINGS_PROFILE_EDIT_AVATAR_TEXT');?></div>
            <div id="avatar-file-upload"  class="file-upload" data-text="<?php $this->echo('SETTINGS_PROFILE_EDIT_AVATAR_FILE_SELECT');?>">
                <input type="file" id="USER_AVATAR_file" name="USER_AVATAR_file" data-bind="Minitoring.Profile.avatarPreviewChanged" data-bind-event="change" />
                <label class="label-file" for="USER_AVATAR_file"><?php $this->echo('SETTINGS_PROFILE_EDIT_AVATAR_FILE_SELECT');?></label>
                <button class="button button-upload uppercase" data-color="theme" data-style="flat" data-bind="Minitoring.Profile.editAvatar">
                    <i class="fa fa-cloud-upload icon-left color-theme"></i>
                    <?php $this->echo('SETTINGS_PROFILE_EDIT_AVATAR_BUTTON');?>
                </button>
            </div>
            <section id="section-avatar-progress" class="section">
                <div id="avatar-upload-progress" class="text-light"></div>
                <progress id="avatar-upload-progressbar" value="0" max="100" class="full-width need-active"></progress>                 
            </section>
        </form>
    </section>
    <br>
    
    <section class="section">
        <form class="small">
            <h5 class="color-accent text-light"><?php $this->echo('SETTINGS_PROFILE_DELETE_AVATAR_TITLE');?></h5>
            <div class="margin-bottom-12"><?php $this->echo('SETTINGS_PROFILE_DELETE_AVATAR_TEXT');?></div>
            <button id="delete-avatar-button" class="button Xuppercase" data-bind="Minitoring.Profile.deleteAvatar">
                <i class="fa fa-times icon-left color-theme"></i><?php $this->echo('SETTINGS_PROFILE_DELETE_AVATAR_BUTTON');?>
            </button>
        </form>
    </section>
    <br>

</section>
