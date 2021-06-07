<section id="section-fail2ban" class="view anim-scale-increase" 
    data-view="bans/fail2ban" 
    data-title="Fail2ban"
    data-refresh="Minitoring.Fail2ban.refresh">

    <section class="section">
        <h6 class="highlight">Fail2ban Server</h6>
        <table id="fail2ban-server" class="">
                <tbody>
                    <tr id="fail2ban-server-version" class="data-row">
                        <td data-column="Text" class="color-light padding-right-24">Version:</td>
                        <td data-column="Value">...</td>
                    </tr>
                    <tr id="fail2ban-server-status" class="data-row">
                        <td data-column="Text" class="color-light padding-right-24">Status:</td>
                        <td data-column="Value">...</td>
                    </tr>
                    <tr id="fail2ban-server-dbpath" class="data-row">
                        <td data-column="Text" class="color-light padding-right-24">Database path:</td>
                        <td data-column="Value">...</td>
                    </tr>
                    <tr id="fail2ban-server-dbsize" class="data-row">
                        <td data-column="Text" class="color-light padding-right-24">Database size:</td>
                        <td data-column="Value">...</td>
                    </tr>                
                </tbody>                        
        </table>
    </section>                  
    <br>
    <section class="section">
        <h6 class="highlight">Fail2ban Jails</h6>
        <table id="fail2ban-jails" class="data-table responsive">
                    <thead>
                        <tr>
                            <th data-column="Name" class="align-left">Name</th>
                            <th data-column="Status" class="align-center">Status</th>
                            <th data-column="Logs Files" class="align-right">Logs Files</th>
                            <th data-column="Total Bans" class="align-right">Total Bans*</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
        </table>
        <div id="fail2ban-jails-comment" class="color-light text-small padding-v-6"></div>
    </section>

</section>