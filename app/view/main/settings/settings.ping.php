<section id="settings-pings" class="view view anim-scale-increase" data-title="<?php $this->echo('SETTINGS_PING');?>" data-refresh="Minitoring.Settings.Pings.refresh" data-view="settings/pings">
    <div id="settings-pings-feedback-top"></div>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="" href="<?php echo $this->baseUrl;?>"><?php $this->echo('HOME');?></a></li>
        <li class="breadcrumb-item"><a class="" href="<?php echo $this->baseUrl;?>settings/" data-view="settings"><?php $this->echo('SETTINGS'); ?></a></li>
        <li class="breadcrumb-item active"><?php $this->echo('SETTINGS_PING');?></li>
    </ol>
    <br>
    <section class="section">
        <h5 class="color-accent text-light"><?php $this->echo('SETTINGS_PING_REGISTERED_TITLE'); ?></h5>
        <table id="settings-pings-table" class="data-table responsive">
            <thead>
                <tr class="table-header">
                    <th data-column="<?php $this->echo('SETTINGS_PING_HOST'); ?>" class="align-left"><?php $this->echo('SETTINGS_PING_HOST'); ?></th>
                    <th data-column="Actions" class="align-right"><?php $this->echo(''); ?></th>
                    <th data-column="<?php $this->echo('SETTINGS_PING_CHECK_ENABLED'); ?>" class="align-center"><?php $this->echo('SETTINGS_PING_CHECK_ENABLED'); ?></th>
                </tr>
            </thead>
            <tbody class=""></tbody>
        </table>
    </section>
    <div id="settings-pings-feedback-bottom"></div>
    <ul id="settings-pings-actions" class="tool-bar padding-top-12">
        <li>
            <a class="button fw" data-bind="Minitoring.Settings.Pings.add" href="#">
                <i class="fa fa-plus icon-left color-theme"></i><span class="bt-title"><?php $this->echo('SETTINGS_PING_BUTTON_ADD'); ?></span>
            </a>
        </li>
    </ul>
    <br>
</section>