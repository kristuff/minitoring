<div id="users-dialog" class="dialog closable">
    <div id="users-create" class="dialog-inner">
        <div class="dialog-header">
            <a href="#" class="dialog-button-close"><i class="fa fa-times"></i></a>
        </div>
        <section class="dialog-part" data-part="create">
            <h5><?php $this->echo('SETTINGS_USERS_CREATE_ACCOUNT_DIALOG_TITLE'); ?></h5>
            <form id="frm_user_new" class="">
                    
                <label><?php $this->echo('USER_NAME_FIELD');?></label>
                <input type="text" pattern="[a-zA-Z0-9]{2,64}" id="user-create-name" name="user-create-name" placeholder="<?php $this->echo('USER_NAME_CREATE_PLACEHOLDER');?>" required />
                    
                <label><?php $this->echo('USER_EMAIL_FIELD');?></label>
                <input class="mail" type="text" id="user-create-email" name="user-create-email" placeholder="<?php $this->echo('USER_EMAIL_PLACEHOLDER');?>" required />
                    
                <label><?php $this->echo('USER_PASSWORD_FIELD');?></label>
                <input type="password" id="user-create-password" name="user-create-password" pattern=".{8,}" placeholder="<?php $this->echo('USER_PASSWORD_CREATE_PLACEHOLDER');?>" required autocomplete="off" />

                <label><?php $this->echo('USER_PASSWORD_REPEAT_FIELD');?></label>
                <input type="password" id="user-create-password-repeat" name="user-create-password-repeat" pattern=".{8,}" placeholder="<?php $this->echo('USER_PASSWORD_REPEAT_PLACEHOLDER');?>" required autocomplete="off" />
            </form>
        </section>

        <section class="dialog-part" data-part="invite">
            <h5><?php $this->echo('SETTINGS_USERS_INVITE_DIALOG_TITLE'); ?></h5>
            <form id="frm_user_invite" class="">
                <label><?php $this->echo('SETTINGS_USERS_INVITE_DIALOG_MAIL_FIELD'); ?></label>
                <input id="user-invite-email" class="mail" type="text" name="user_email" placeholder="<?php $this->echo('USER_EMAIL_PLACEHOLDER'); ?>" />
            </form>
        </section>

        <section class="dialog-actions">
            <a href="#" class="dialog-button button button-o fw dialog-button-cancel" ><?php $this->echo('BUTTON_CANCEL'); ?></a>
            <a href="#" class="dialog-button button fw dialog-button-ok"><?php $this->echo('BUTTON_OK'); ?></a>
    </section>
    </div>
</div>