<div id="services-dialog" class="dialog closable">
    <div class="dialog-inner">
        <div class="dialog-header">
            <a href="#" class="dialog-button-close"><i class="fa fa-times"></i></a>
        </div>

        <section class="dialog-part" data-part="add" data-add-title="<?php $this->echo('SETTINGS_SERVICES_DIALOG_CREATE_TITLE'); ?>" data-edit-title="<?php $this->echo('SETTINGS_SERVICES_DIALOG_EDIT_TITLE'); ?>" >
            <div class="h5" id="service-dialog-title"></div>
            <form id="frm_user_new" class="">
        
                <label><?php $this->echo('SETTINGS_SERVICES_NAME_FIELD'); ?></label>
                <input type="text" id="service-dialog-name" placeholder="<?php $this->echo('SETTINGS_SERVICES_NAME_PLACEHOLDER'); ?>" />
                    
                <label><?php $this->echo('SETTINGS_SERVICES_PROTOCOL_FIELD'); ?></label>
                <div class="custom-select margin-top-6">
                        <select id="service-dialog-protocol" required >
                            <option value="tcp">TCP</option>
                            <option value="udp">UDP</option>
                        </select>   
                </div>

                <label><?php $this->echo('SETTINGS_SERVICES_HOST_FIELD'); ?></label>
                <input type="text" id="service-dialog-host" placeholder="<?php $this->echo('SETTINGS_SERVICES_HOST_PLACEHOLDER'); ?>" />
                    
                <label><?php $this->echo('SETTINGS_SERVICES_PORT_FIELD'); ?></label>
                <input type="text" id="service-dialog-port" placeholder="<?php $this->echo('SETTINGS_SERVICES_PORT_PLACEHOLDER'); ?>" />
            </form>
        </section>

        <section class="dialog-part" data-part="delete">
            <br>
        </section>

        <section class="dialog-actions">
            <a href="#" class="dialog-button button button-o fw dialog-button-cancel" ><?php $this->echo('BUTTON_CANCEL'); ?></a>
            <a href="#" class="dialog-button button fw dialog-button-ok" data-bind="Minitoring.Settings.Services.handleDialog"><?php $this->echo('BUTTON_OK'); ?></a>
        </section>
    </div>
</div>