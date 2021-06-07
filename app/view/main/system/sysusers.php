<section id="section-sysusers" class="view anim-scale-increase" 
         data-title="System Users" 
         data-view="sysusers" 
         data-subviews="all|currents|lasts|groups" 
         data-refresh="Minitoring.SystemUsers.refresh" 
>
    <section class="action-bar" id="sysusers-actions">
        <ul class="tab-items" data-style="flat">
            <li class="tab-item <?php echo (($this->data('currentAction') == 'all') || ( $this->data('currentAction') == 'index')) ? 'current' : '' ?>">
                <a href="<?php echo $this->baseUrl;?>sysusers/" data-view="sysusers">
                    <i class="fa fa-list-ol icon-left" aria-hidden="true"></i>All
                </a>
            </li>
            <li class="tab-item <?php echo $this->data('currentAction') == 'lasts'   ? 'current' : '' ?>">
                <a href="<?php echo $this->baseUrl;?>sysusers/lasts" data-view="sysusers/lasts">
                    <i class="fa fa-calendar icon-left" aria-hidden="true"></i>Last logins
                </a>
            </li>
            <li class="tab-item <?php echo $this->data('currentAction') == 'currents' ? 'current' : '' ?>">
                <a href="<?php echo $this->baseUrl;?>sysusers/currents" data-view="sysusers/currents">
                    <i class="fa fa-user icon-left" aria-hidden="true"></i>Currents
                </a>
            </li>
            <li class="tab-item <?php echo $this->data('currentAction') == 'groups' ? 'current' : '' ?>">
                <a href="<?php echo $this->baseUrl;?>sysusers/groups" data-view="sysusers/groups">
                    <i class="fa fa-users icon-left" aria-hidden="true"></i>Groups
                </a>
            </li>

            <li id="sysusers-top-paginator" class="paginator float-right" data-max-items="5"></li>
        </ul> 
    </section>
    <section class="section">
        <table id="sysusers-table"  class="data-table responsive alternative-row-style">
            <thead>
                <tr class="table-header">
                    <th data-column="User">User</th>
                    <th data-column="Port">Port</th>
                    <th data-column="Pid">Pid</th>
                    <th data-column="From">Connected from</th>
                    <th data-column="LastLogin">Last login</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <section class="section align-right">
            <div id="sysusers-bottom-paginator" class="paginator label-before" data-label=""></div>                
        </section>                
    </section>
</section>