<div id="users-dialog" class="dialog closable">
    <div id="users-create" class="dialog-inner">
        <div class="dialog-header">
            <a href="#" class="dialog-button-close"><i class="fa fa-times"></i></a>
        </div>
        <section class="dialog-part" data-part="create">
            <h5>Create a new account</h5>
            <div class="padding-bottom-12">This will create and activate a new account.</div>
            <div class="align-center">
                <form id="frm_user_new" class="">
                    <input type="text" pattern="[a-zA-Z0-9]{2,64}" id="user-create-name" name="user-create-name"
                        placeholder="Username (letters/numbers, 2-64 chars)" required />
                    <input class="mail" type="text" id="user-create-email" name="user-create-email"
                        placeholder="Email address" required />
                    <input type="password" id="user-create-password" name="user-create-password" pattern=".{8,}"
                        placeholder="Password (6+ characters)" required autocomplete="off" />
                    <input type="password" id="user-create-password-repeat" name="user-create-password-repeat"
                        pattern=".{8,}" placeholder="Repeat password" required autocomplete="off" />
                </form>
            </div>
        </section>
        <section class="dialog-part" data-part="invite">
            <h5><i class="fa fa-envelope margin-right-12"></i>Invite a user</h5>
            <form id="frm_user_invite" class="">
                <label>Send an invitation by email to:</label>
                <input id="user-invite-email" class="mail" type="text" name="user_email" placeholder="email address" />
            </form>
        </section>
        <section class="dialog-part" data-part="delete">
            <h5>Delete a user</h5>
            <p>What do you want to do?</p>
            <form>
                <div class="section">
                    <label class="h6">
                        <input id="user-delete-soft" type="radio" name="action" value="soft" checked /> 
                        Soft delete user
                    </label>
                    <p class="color-light">This will mark the user as deleted. The user won't be able to login anymore and won't be able
                        to create new account with same email eddress.</p>
                </div>

                <div class="section">
                    <label class="h6">
                        <input id="user-delete-full" type="radio" name="action" value="full" /> 
                        Delete user
                    </label>
                    <p class="color-light">This will delete user and setting from database. This action cannot be canceled.</p>

                </div>
            </form>
        </section>
        <section class="dialog-part" data-part="suspend">
            <h5>Suspend a user</h5>
            <p>This will suspend a user</p>
            <br>
            <form>
                <label>Suspension days:</label>
                <div class="padding-top-6"><input id="user-suspend-days" type="number" value="10"></div>
            </form>
            <br>
        </section>
        <section class="dialog-actions">
            <a href="#" class="dialog-button button button-o uppercase fw dialog-button-cancel" ><?php echo $this->text('BUTTON_CANCEL'); ?></a>
            <a href="#" class="dialog-button button uppercase fw dialog-button-ok"><?php echo $this->text('BUTTON_OK'); ?></a>
    </section>
    </div>
</div>