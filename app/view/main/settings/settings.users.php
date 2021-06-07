<section id="settings-users" class="view view anim-scale-increase" 
    data-view="settings/users" data-refresh="Minitoring.Users.getList" 
    data-title="<?php echo $this->text('SETTINGS_USERS'); ?>">

    <div id="users-data" class="panel-data">
        <h6><?php echo $this->text('SETTINGS_USERS_SECTION_CURRENT_ACCOUNTS'); ?></h6>
        <div id="users-feedback"></div>
        <table id="users-table" class="data-table responsive TODO_alternative-row-style">
            <thead>
                <tr class="table-header">
                    <th data-column="Avatar">Avatar</th>
                    <th data-column="Name">User name</th>
                    <th data-column="Actions"></th>
                    <th data-column="Type">Type</th>
                    <th data-column="Mail">Email</th>
                    <th data-column="Created on">Created on</th>
                    <th data-column="LastLogin">Last login</th>
                    <th data-column="Status">Status</th>
                    <th data-column="Suspended to">Suspended to</th>
                    <th data-column="Deleted on">Deleted on</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <section class="section align-right">
            <div id="users-bottom-paginator" class="paginator label-before" data-label=""></div>
        </section>
    </div>

    <section id="users-actions" class="section action-bar">
        <h6><?php echo $this->text('SETTINGS_USERS_SECTION_NEW_ACCOUNTS'); ?></h6>
        <section class="section">
            <div class="container medium"><?php echo $this->text('SETTINGS_USERS_CREATE_ACCOUNT_TEXT'); ?></div>
            <div class="padding-top-12 container x-small">
                <a href="#" class="button full-width" data-bind="Minitoring.Users.create">
                    <i class="fa fa-user-plus icon-left color-theme"></i><span class="bt-title"><?php echo $this->text('SETTINGS_USERS_CREATE_ACCOUNT_BUTTON'); ?></span>
                </a>
            </div>
        </section>
        <section class="section">
            <div class="container medium"><?php echo $this->text('SETTINGS_USERS_INVITE_TEXT'); ?></div>
            <div class="padding-top-12 container x-small">
               <a href="#" class="button full-width" data-bind="Minitoring.Users.invite">
                    <i class="fa fa-envelope icon-left color-theme"></i><span class="bt-title"><?php echo $this->text('SETTINGS_USERS_INVITE_BUTTON'); ?></span>
                </a>
            </div>
        </section>        
    </section>

   
</section>
