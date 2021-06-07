<section id="settings-logreader" class="view view anim-scale-increase" data-title="<?php echo $this->text('SETTINGS_LOGREADER'); ?>"
    data-refresh="Minitoring.Settings.Logs.getLogFilesDetails" data-view="settings/logreader">

    <section class="section">
        <h6><?php echo $this->text('SETTINGS_LOGREADER_LIST_TITLE'); ?></h6>

        <table id="settings-logs-table" class="data-table responsive alternative-row-style">
            <colgroup>
                <col>
                <col>
                <col>
                <col>
                <col>
            </colgroup>
            <thead>
                <tr class="table-header">
                    <th data-column="<?php echo $this->text('SETTINGS_LOGREADER_NAME_HEADER'); ?>"   ><?php echo $this->text('SETTINGS_LOGREADER_NAME_HEADER');   ?></th>
                    <th data-column="<?php echo $this->text('SETTINGS_LOGREADER_ACTION_HEADER'); ?>" ></th>
                    <th data-column="<?php echo $this->text('SETTINGS_LOGREADER_TYPE_HEADER'); ?>"   ><?php echo $this->text('SETTINGS_LOGREADER_TYPE_HEADER');   ?></th>
                    <th data-column="<?php echo $this->text('SETTINGS_LOGREADER_PATH_HEADER'); ?>"   ><?php echo $this->text('SETTINGS_LOGREADER_PATH_HEADER');   ?></th>
                    <th data-column="<?php echo $this->text('SETTINGS_LOGREADER_FORMAT_HEADER'); ?>" ><?php echo $this->text('SETTINGS_LOGREADER_FORMAT_HEADER'); ?></th>
                </tr>
            </thead>
            <tbody class=""></tbody>
        </table>
    </section>
    <div id="logreader-feedback"></div>
    <ul id="log-list-actions" class="tool-bar padding-top-12">
        <li>
            <a class="button fw" data-bind="Minitoring.Settings.Logs.add" data-action-bar-id="log-list-actions" href="#">
                <i class="fa fa-plus icon-left color-theme"></i><span class="bt-title"><?php echo $this->text('SETTINGS_LOGREADER_BUTTON_ADD'); ?></span>
            </a>
        </li>
    </ul>
    <br>

    <section class="section">
        <h6><?php echo $this->text('SETTINGS_LOGREADER_ADVANCED'); ?></h6>
        <div class="container medium no-padding">
            <div class="padding-bottom-6"><?php echo $this->text('SETTINGS_LOGREADER_IP_ACTION_FIELD'); ?></div>
            <div class="custom-select">
                <select id="select-log-max" data-bind="">
                    <option value="none"><?php echo $this->text('SETTINGS_LOGREADER_IP_ACTION_NONE'); ?></option>
                    <option value="geoip"><?php echo $this->text('SETTINGS_LOGREADER_IP_ACTION_GEOIP'); ?></option>
                    <option value="abuseipdb"><?php echo $this->text('SETTINGS_LOGREADER_IP_ACTION_ABUSEIPDB'); ?></option>
                </select>
            </div>
        </div>
    </section>

    <br>
    <br>


</section>