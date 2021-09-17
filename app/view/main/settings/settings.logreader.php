<section id="settings-logreader" class="view view anim-scale-increase" data-title="<?php $this->echo('SETTINGS_LOGREADER'); ?>"
    data-refresh="Minitoring.Settings.Logs.getLogFilesDetails" data-view="settings/logreader">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="" href="<?php echo $this->baseUrl;?>"><?php $this->echo('HOME');?></a></li>
        <li class="breadcrumb-item"><a class="" href="<?php echo $this->baseUrl;?>settings/" data-view="settings"><?php $this->echo('SETTINGS'); ?></a></li>
        <li class="breadcrumb-item active"><?php $this->echo('SETTINGS_LOGREADER');?></li>
    </ol>
    <br>

    <section class="section">
        <h5 class="color-accent text-light"><?php $this->echo('SETTINGS_LOGREADER_LIST_TITLE'); ?></h5>

        <table id="settings-logs-table" class="data-table responsive XXalternative-row-style">
            <colgroup>
                <col>
                <col>
                <col>
                <col>
                <col>
            </colgroup>
            <thead>
                <tr class="table-header">
                    <th data-column="<?php $this->echo('SETTINGS_LOGREADER_NAME_HEADER'); ?>"   ><?php $this->echo('SETTINGS_LOGREADER_NAME_HEADER');   ?></th>
                    <th data-column="<?php $this->echo('SETTINGS_LOGREADER_ACTION_HEADER'); ?>" ></th>
                    <th data-column="<?php $this->echo('SETTINGS_LOGREADER_PATH_HEADER'); ?>"   ><?php $this->echo('SETTINGS_LOGREADER_PATH_HEADER');   ?></th>
                    <th data-column="<?php $this->echo('SETTINGS_LOGREADER_TYPE_HEADER'); ?>"   ><?php $this->echo('SETTINGS_LOGREADER_TYPE_HEADER');   ?></th>
                    <th data-column="<?php $this->echo('SETTINGS_LOGREADER_FORMAT_HEADER'); ?>" ><?php $this->echo('SETTINGS_LOGREADER_FORMAT_HEADER'); ?></th>
                </tr>
            </thead>
            <tbody class=""></tbody>
        </table>
    </section>
    <div id="logreader-feedback"></div>
    <ul id="log-list-actions" class="tool-bar padding-top-12">
        <li>
            <a class="button fw" data-bind="Minitoring.Settings.Logs.add" data-action-bar-id="log-list-actions" href="#">
                <i class="fa fa-plus icon-left color-theme"></i><span class="bt-title"><?php $this->echo('SETTINGS_LOGREADER_BUTTON_ADD'); ?></span>
            </a>
        </li>
    </ul>
    <br>

  
    <br>


</section>