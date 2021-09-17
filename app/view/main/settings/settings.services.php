<section id="settings-services" class="view view anim-scale-increase" data-title="<?php $this->echo('SETTINGS_SERVICES');?>" data-refresh="Minitoring.Settings.Services.refresh" data-view="settings/services">
    <div id="settings-services-feedback"></div>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="" href="<?php echo $this->baseUrl;?>"><?php $this->echo('HOME');?></a></li>
        <li class="breadcrumb-item"><a class="" href="<?php echo $this->baseUrl;?>settings/" data-view="settings"><?php $this->echo('SETTINGS'); ?></a></li>
        <li class="breadcrumb-item active"><?php $this->echo('SETTINGS_SERVICES');?></li>
    </ol>
    <br>
    <section class="section">
        <h5 class="color-accent text-light"><?php $this->echo('SETTINGS_SERVICES_REGISTERED_TITLE'); ?></h5>
        <table id="settings-services-table" class="data-table responsive XXalternative-row-style" data-dialog-delete-text="<?php $this->echo('SETTINGS_SERVICES_DELETE_MESSAGE'); ?>">
            <thead>
                <tr class="table-header">
                    <th data-column="<?php $this->echo('SETTINGS_SERVICES_NAME_HEADER'); ?>" class="align-left"><?php $this->echo('SETTINGS_SERVICES_NAME_HEADER'); ?></th>
                    <th data-column="Actions" class="align-right"><?php $this->echo(''); ?></th>
                    <th data-column="<?php $this->echo('SETTINGS_SERVICES_PROTOCOL_HEADER'); ?>" class="align-center"><?php $this->echo('SETTINGS_SERVICES_PROTOCOL_HEADER'); ?></th>
                    <th data-column="<?php $this->echo('SETTINGS_SERVICES_HOST_HEADER'); ?>" class="align-left"><?php $this->echo('SETTINGS_SERVICES_HOST_HEADER'); ?></th>
                    <th data-column="<?php $this->echo('SETTINGS_SERVICES_PORT_HEADER'); ?>" class="align-right"><?php $this->echo('SETTINGS_SERVICES_PORT_HEADER'); ?></th>
                    <th data-column="<?php $this->echo('SETTINGS_SERVICES_CHECK_ENABLED_HEADER'); ?>" class="align-center"><?php $this->echo('SETTINGS_SERVICES_CHECK_ENABLED_HEADER'); ?></th>
                </tr>
            </thead>
            <tbody class=""></tbody>
        </table>
    </section>
    <div id="settings-services-feedback"></div>
    <ul id="settings-services-actions" class="tool-bar padding-top-12">
        <li>
            <a class="button fw" data-bind="Minitoring.Settings.Services.add" data-action-bar-id="settings-services-actions" href="#">
                <i class="fa fa-plus icon-left color-theme"></i><span class="bt-title"><?php $this->echo('SETTINGS_SERVICES_BUTTON_ADD'); ?></span>
            </a>
        </li>
    </ul>
    <br>
</section>