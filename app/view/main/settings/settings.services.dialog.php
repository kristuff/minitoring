<div id="services-dialog" class="dialog closable">
    <div class="dialog-inner">
        <div class="dialog-header">
            <a href="#" class="dialog-button-close"><i class="fa fa-times"></i></a>
        </div>

        <section class="dialog-part" data-part="add">
            <h5><i class="fa fa-user-plus icon-left"></i>Add a service</h5>
            <div>This will add and register a service check.</div>
            <div class="align-center">
                <form id="frm_user_new" class="">
                    <input type="text" id="service-add-friendly-name" name="service-add-friendly-name" placeholder="Service Name" />
                    <input type="text" id="service-add-name" name="service-add-name" placeholder="Service name" />
                    <input type="text" id="service-add-port" name="service-add-port" placeholder="Port" />
                </form>
            </div>
        </section>

        <section class="dialog-part" data-part="delete">
            <h5><i class="fa fa-trash icon-left"></i>Delete a user</h5>
            <p>What do you want to do?</p>
            <form>
                <div><input id="" type="radio" name="action" value="full"> Soft delete</div>
                <div><input id="" type="radio" name="action" value="soft" checked> Delete user</div>
            </form>
            <br>
        </section>

        <section class="dialog-actions">
            <a href="#" class="dialog-button button button-o uppercase fw dialog-button-cancel" ><?php echo $this->text('BUTTON_CANCEL'); ?></a>
            <a href="#" class="dialog-button button uppercase fw dialog-button-ok" data-bind="Minitoring.Settings.Services.handleDialog"><?php echo $this->text('BUTTON_OK'); ?></a>
        </section>
    </div>
</div>