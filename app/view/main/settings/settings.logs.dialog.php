    <div id="system-logs-dialog" class="dialog closable">
        <div class="dialog-inner dialog-xlarge">
            <div class="dialog-header">
                <a href="#" class="dialog-button-close"><i class="fa fa-times"></i></a>
            </div>

            <section class="dialog-part" data-part="create">
                <h5><?php $this->echo('SETTINGS_LOGREADER_DIALOG_CREATE_TITLE'); ?></h5>
                <div class="">
                    <form id="frm_log_new" class="color-light">
                        
                    <label><?php $this->echo('SETTINGS_LOGREADER_NAME_FIELD'); ?></label>
                        <input type="text" id="log-create-name" placeholder="<?php $this->echo('SETTINGS_LOGREADER_NAME_HEADER'); ?>" required />
                        
                        <label><?php $this->echo('SETTINGS_LOGREADER_PATH_FIELD'); ?></label>
                        <input type="text" id="log-create-path" placeholder="<?php $this->echo('SETTINGS_LOGREADER_PATH_HEADER'); ?>" required />
                        
                        <label><?php $this->echo('SETTINGS_LOGREADER_TYPE_FIELD'); ?></label>
                        <div class="custom-select margin-top-6">
                            <select id="log-create-format-name" data-bind="Minitoring.Settings.Logs.dialogCreateFormatChanged" required ></select>   
                        </div>
                        <input type="hidden" id="log-create-type" value=""/>

                        <label class="padding-top-6"><?php $this->echo('SETTINGS_LOGREADER_FORMAT_FIELD'); ?></label>
                        <input type="text" id="log-create-format" placeholder="<?php $this->echo('SETTINGS_LOGREADER_FORMAT_PLACEHOLDER'); ?>"  />
                    </form>
                </div>
            </section>

            <section class="dialog-part" data-part="edit">
                <h5><?php $this->echo('SETTINGS_LOGREADER_DIALOG_EDIT_TITLE'); ?></h5>
                <div class="">
                    <form id="frm_log_new" class="color-light">
                        
                        <label><?php $this->echo('SETTINGS_LOGREADER_NAME_FIELD'); ?></label>
                        <input type="text" id="log-edit-name" placeholder="<?php $this->echo('SETTINGS_LOGREADER_NAME_HEADER'); ?>" required />
                        
                        <label><?php $this->echo('SETTINGS_LOGREADER_PATH_FIELD'); ?></label>
                        <input type="text" id="log-edit-path" placeholder="<?php $this->echo('SETTINGS_LOGREADER_PATH_HEADER'); ?>" required />
                        
                        <label><?php $this->echo('SETTINGS_LOGREADER_TYPE_FIELD'); ?></label>
                        <div class="custom-select margin-top-6">
                            <select id="log-edit-format-name" data-bind="Minitoring.Settings.Logs.dialogEditFormatChanged" required ></select>   
                        </div>
                        <input type="hidden" id="log-edit-type" value=""/>

                        <label class="padding-top-6"><?php $this->echo('SETTINGS_LOGREADER_FORMAT_FIELD'); ?></label>
                        <input type="text" id="log-edit-format" placeholder="<?php $this->echo('SETTINGS_LOGREADER_FORMAT_PLACEHOLDER'); ?>"  />
                    </form>
                </div>

            </section>

            <section class="dialog-actions">
                <a href="#" class="dialog-button button button-o fw dialog-button-cancel" ><?php $this->echo('BUTTON_CANCEL'); ?></a>
                <a href="#" class="dialog-button button fw dialog-button-ok" data-bind="Minitoring.Settings.Logs.handleDialog" data-visible="true"><?php $this->echo('BUTTON_OK'); ?></a>
            </section>
        </div>
    </div>
