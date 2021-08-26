<section id="settings-users" class="view view anim-scale-increase" data-view="settings/users" data-refresh="Minitoring.Users.getList" data-title="<?php $this->echo('SETTINGS_USERS'); ?>">

    <div id="users-data" class="panel-data">
        <h6><?php $this->echo('SETTINGS_USERS_SECTION_CURRENT_ACCOUNTS'); ?></h6>
        <div id="users-feedback"></div>
        <table id="users-table" class="data-table responsive TODO_alternative-row-style">
            <thead>
                <tr class="table-header">
                    <th data-column="<?php $this->echo('USER_AVTAR_HEADER');?>"><?php $this->echo('USER_AVATAR_HEADER');?></th>
                    <th data-column="<?php $this->echo('USER_NAME_HEADER');?>"><?php $this->echo('USER_NAME_HEADER');?></th>
                    <th data-column="Actions"></th>
                    <th data-column="<?php $this->echo('USER_TYPE_HEADER') ;?>"><?php $this->echo('USER_TYPE_HEADER') ;?></th>
                    <th data-column="<?php $this->echo('USER_EMAIL_HEADER');?>"><?php $this->echo('USER_EMAIL_HEADER');?></th>
                    <th data-column="<?php $this->echo('USER_CREATED_DATE_HEADER');?>"><?php $this->echo('USER_CREATED_DATE_HEADER');?></th>
                    <th data-column="<?php $this->echo('USER_LAST_LOGIN_DATE_HEADER');?>"><?php $this->echo('USER_LAST_LOGIN_DATE_HEADER');?></th>
                    <th data-column="<?php $this->echo('USER_STATUS_HEADER');?>"><?php $this->echo('USER_STATUS_HEADER');?></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <section class="section align-right">
            <div id="users-bottom-paginator" class="paginator label-before" data-label=""></div>
        </section>
        <form>
            <input id="users-delete-message" type="hidden" value="<?php $this->echo('SETTINGS_USERS_FULL_DELETE_TEXT'); ?>"/>
        </form>
    </div>

    <section id="users-actions" class="section action-bar">
        <h6><?php $this->echo('SETTINGS_USERS_SECTION_NEW_ACCOUNTS'); ?></h6>
        <section class="section">
            <div class="container-medium"><?php $this->echo('SETTINGS_USERS_CREATE_ACCOUNT_TEXT'); ?></div>
            <div class="padding-top-12 container x-small">
                <a href="#" class="button full-width" data-bind="Minitoring.Users.create">
                    <i class="fa fa-user-plus icon-left color-theme"></i><span class="bt-title"><?php $this->echo('SETTINGS_USERS_CREATE_ACCOUNT_BUTTON'); ?></span>
                </a>
            </div>
        </section>
        <section class="section">
            <div class="container-medium"><?php $this->echo('SETTINGS_USERS_INVITE_TEXT'); ?></div>
            <div class="padding-top-12 container x-small">
               <a href="#" class="button full-width" data-bind="Minitoring.Users.invite">
                    <i class="fa fa-envelope icon-left color-theme"></i><span class="bt-title"><?php $this->echo('SETTINGS_USERS_INVITE_BUTTON'); ?></span>
                </a>
            </div>
        </section>        
    </section>

   
</section>
