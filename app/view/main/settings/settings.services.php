<section id="settings-services" class="view view anim-scale-increase" data-title="Services" 
    data-refresh="Minitoring.Settings.Services.refresh" data-view="settings/services">
    <div id="settings-services-feedback"></div>

    <section class="section">
        <h6>Registered services</h6>

        <table id="settings-services-table" class="data-table responsive alternative-row-style">
            <thead>
                <tr class="table-header">
                    <th data-column="Service"       class="align-left">Service</th>
                    <th data-column="Actions"       class="align-right"></th>
                    <th data-column="Port"          class="align-right">Port</th>
                    <th data-column="Check Enabled" class="align-center">Check enabled</th>
                </tr>
            </thead>
            <tbody class="color-light"></tbody>
        </table>
    </section>
    <div id="settings-services-feedback"></div>
    <ul id="settings-services-actions" class="tool-bar padding-top-12">
        <li>
            <a class="button fw" data-bind="Minitoring.Settings.Services.add" data-action-bar-id="settings-services-actions" href="#">
                <i class="fa fa-plus icon-left color-theme"></i><span class="bt-title">Add</span>
            </a>
        </li>
    </ul>
    <br>

   

</section>