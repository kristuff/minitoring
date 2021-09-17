<div id="ping-dialog" class="dialog closable">
    <div class="dialog-inner">
        <div class="dialog-header">
            <a href="#" class="dialog-button-close"><i class="fa fa-times"></i></a>
        </div>
        <section class="dialog-part" data-part="add" data-add-title="<?php $this->echo('SETTINGS_PING_DIALOG_CREATE_TITLE'); ?>" data-edit-title="<?php $this->echo('SETTINGS_PING_DIALOG_EDIT_TITLE'); ?>" >
            <div class="h5" id="ping-dialog-title"></div>
            <form id="" class="">
                <label><?php $this->echoField('SETTINGS_PING_HOST'); ?></label>
                <input type="text" id="ping-dialog-host" placeholder="" />
            </form>
        </section>
        <section class="dialog-actions">
            <a href="#" class="dialog-button button button-o fw dialog-button-cancel" ><?php $this->echo('BUTTON_CANCEL'); ?></a>
            <a href="#" class="dialog-button button fw dialog-button-ok" data-bind="Minitoring.Settings.Pings.handleDialog"><?php $this->echo('BUTTON_OK'); ?></a>
        </section>
    </div>
</div>