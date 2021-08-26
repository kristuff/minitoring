

<div id="setup" class="wizard-overlay active">
    <section class="section footer align-center bg-transp-light">
        <p class="text-xsmall color-light"><?php echo $this->data("APP_NAME"); ?> | Copyright <i class="fa fa-copyright"></i> <?php echo $this->data('APP_COPYRIGHT');?> | Made with <i class="fa fa-heart color-theme"></i> and <i class="fa fa-coffee color-theme"></i> in France</p>
    </section>

    <div id="wizard" class="wizard " data-wizard-current-index="0" data-theme="dark">
        <section class="wizard-inner ">
            <button class="wizard-button-close need-active "><i class="fa fa-times"></i></button>
            <section class="wizard-bottom bg-transp-light" >
                <a href="#" class="button button-o fw XXtheme uppercase wizard-button-prev"><?php $this->echo("PREV"); ?></a>                    
                <a href="#" class="button uppercase fw theme wizard-button-next" data-visible="true" 
                    data-next-text="<?php $this->echo("NEXT"); ?>" 
                    data-close-text="<?php $this->echo("SETUP_WIZARD_BUTTON_CLOSE"); ?>"
                    data-install-text="<?php $this->echo("SETUP_WIZARD_BUTTON_INSTALL"); ?>"
                    ><?php $this->echo("NEXT"); ?></a>
            </section>
            
            <section class="wizard-progress">
                <section class="wizard-progress-inner bg-theme"></section>
            </section>
 
            <div class="wizard-panel" data-wizard-index="0" data-wizard-title="Welcome">
                <div class="h5 wizard-panel-title margin-bottom-24"><?php $this->echo("SETUP_TITLE"); ?></div>
                <form class="small">
                    <label><?php $this->echo("SETUP_SELECT_LANG"); ?></label>
                    <div class="custom-select block">
                        <select id="language-select" data-bind="Minitoring.Setup.languageChanged">
                            <option value="en-US" <?php echo $this->data("CURRENT_LANGUAGE") === 'en-US' ? 'selected' : ''; ?> >English</option>
                            <option value="fr-FR" <?php echo $this->data("CURRENT_LANGUAGE") === 'fr-FR' ? 'selected' : ''; ?> >Français</option>
                        </select>
                    </div>
                </form>
                <section>
                    <br>
                    <br>
                    <p><?php $this->echo("SETUP_INTRO_1"); ?></p> 
                    <p><?php $this->echo("SETUP_INTRO_2"); ?></p>
                    <br>
                    <?php  $this->renderFeedback(); // echo out the system feedback (error and success messages) ?>
                </section>
            </div>

            <div class="wizard-panel anim-from-left" data-wizard-index="1">
                <div class="h5 wizard-panel-title margin-bottom-24"><?php $this->echo("SETUP_CHECK_TITLE"); ?></div>
                <div id="check-list"></div>
                <div id="check-result"></div>
            </div>

            <div class="wizard-panel anim-from-left" data-wizard-index="2">
                <div class="h5 wizard-panel-title margin-bottom-24"><?php $this->echo("SETUP_DB_CONF_TITLE_1"); ?></div>
                <form>
                    <label><?php $this->echo("SETUP_DB_CONF_SELECT_TYPE"); ?></label>
                    <div class="custom-select">
                        <select name="Provider" id="db-select">
                            <option value="sqlite" selected>Sqlite</option>
                            <option value="mysql" disabled >Mysql</option>
                            <option value="pgsql" disabled >Postgres</option>
                        </select>
                    </div>

                    <section id="server-idents" class="need-active">
                        <div class="padding-top-36 padding-bottom-12"><?php $this->echo("SETUP_DB_CONF_SERVER_IDENT_TEXT"); ?></div>

                        <label><?php $this->echo("SQL_HOST_FIELD"); ?></label>
                        <input id="db_host" type="text" placeholder="<?php $this->echo("SQL_HOST_PLACEHOLDER"); ?>" required value="localhost" />

                        <label><?php $this->echo("SQL_ADMIN_NAME_FIELD"); ?></label>
                        <input id="db_admin_name" type="text" name="db_host" placeholder="<?php $this->echo("SQL_ADMIN_NAME_PLACEHOLDER"); ?>" required value="root" />
                        
                        <label><?php $this->echo("SQL_ADMIN_PASSWORD_FIELD"); ?></label>
                        <input id="db_admin_pass" type="password" name="root_password" placeholder="<?php $this->echo("SQL_ADMIN_PASSWORD_PLACEHOLDER"); ?>" required />
                        <i class="fa toggle-password"></i>
                    </section>    
                </form>
            </div>


            <div class="wizard-panel anim-from-left" data-wizard-index="3">
                <div class="h5 wizard-panel-title margin-bottom-24"><?php $this->echo("SETUP_DB_CONF_TITLE_2"); ?></div>
                <div class="padding-bottom-12"> <?php $this->echo("SETUP_DB_SET_NAME_NO_USER_TEXT"); ?></div>
                <form>
                    
                    <label for="db_name"><?php $this->echo("DB_NAME_FIELD"); ?></label>
                    <input id="db_name" type="text" name="db_name" placeholder="<?php $this->echo("DB_NAME_PLACEHOLDER"); ?>" required value="minitoring" />
                    
                    <section id="db-idents" class="section need-active">
                        <div class="padding-bottom-12 padding-top-36"> <?php $this->echo("SETUP_DB_SET_NAME_WITH_SUSER_TEXT"); ?></div>

                        <label for="db_user"><?php $this->echo("DB_USER_NAME_FIELD"); ?></label>
                        <input id="db_user" type="text" name="db_user" placeholder="<?php $this->echo("DB_USER_NAME_PLACEHOLDER"); ?>" required value="minitoring" />

                        <label for="db_pass"><?php $this->echo("DB_USER_PASSWORD_FIELD"); ?></label>
                        <input id="db_pass" type="password" name="db_password" placeholder="<?php $this->echo("DB_USER_PASSWORD_PLACEHOLDER"); ?>" required />
                        <i class="fa toggle-password"></i>
                    </section>    
                </form>
                <div id="intall_result" class="install-panel"></div>
            </div>
        
        <div class="wizard-panel anim-from-left" data-wizard-index="4">
            <div class="h5 wizard-panel-title margin-bottom-24"><?php $this->echo("SETUP_SET_ADMIN_ACCOUNT_TITLE"); ?></div>
            <div class="padding-bottom-12"> <?php $this->echo("SETUP_SET_ADMIN_ACCOUNT_TEXT"); ?></div>
            <form>
                <label for="admin_name"><?php $this->echo("DB_ADMIN_NAME_FIELD"); ?></label>
                <input id="admin_name" type="text" name="admin_name" placeholder="<?php $this->echo("DB_ADMIN_NAME_PLACEHOLDER"); ?>" required value="admin" />
                <label for="admin_email"><?php $this->echo("DB_ADMIN_EMAIL_FIELD"); ?></label>
                <input id="admin_email" type="text" name="admin_email" placeholder="<?php $this->echo("DB_ADMIN_EMAIL_PLACEHOLDER"); ?>" required value="" />
                <label for="admin_pass"><?php $this->echo("DB_ADMIN_PASSWORD_FIELD"); ?></label>
                <input id="admin_password" type="password" name="admin_password" placeholder="<?php $this->echo("DB_ADMIN_PASSWORD_PLACEHOLDER"); ?>" required />
                <i class="fa toggle-password"></i>
            </form>
        </div>

        <div class="wizard-panel anim-from-left" data-wizard-index="5">
            <div class="h5 wizard-panel-title margin-bottom-24"><?php $this->echo("SETUP_TERMINATE_TITLE"); ?></div>
            <div class="margin-bottom-12"><?php $this->echo("SETUP_TERMINATE_MESSAGE"); ?></div>
            <div class="alert" data-alert="warning" role="alert"><?php $this->echo("SETUP_TERMINATE_WARNING"); ?></div>
        </div>

        <div class="wizard-panel anim-from-left" data-wizard-index="6">
            <div class="h5 wizard-panel-title margin-bottom-24"><?php $this->echo("SETUP_TITLE"); ?></div>
            <div id="install-loader" class="padding-v-24 align-center need-active"><i class="fa fa-2x fa-circle-o-notch fa-spin fa-fw color-theme"></i></div>
            <div id="install-message"></div>
            <div id="install-result"></div>
        </div>

        </section>
    </div>
</div>