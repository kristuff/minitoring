<section id="section-services" class="view anim-scale-increase" data-view="packages" 
         data-title="Packages" 
         data-subviews="all|upgradable"
         data-refresh="Minitoring.Packages.refresh">

    <section class="action-bar" id="packages-actions">
        <ul class="tab-items" data-style="flat">
            <li class="tab-item <?php echo (($this->data('currentAction') == '') || ( $this->data('currentAction') == 'index')) ? 'current' : '' ?>"><a href="<?php echo $this->baseUrl;?>packages/" data-view="packages"><i class="fa fa-list-ol icon-left" aria-hidden="true"></i>All</a></li>
            <li class="tab-item <?php echo $this->data('currentAction') == 'upgradable'   ? 'current' : '' ?>"><a href="<?php echo $this->baseUrl;?>packages/upgradable" data-view="packages/upgradable"><i class="fa fa-plus icon-left" aria-hidden="true"></i>Upgradable<span id="packages-upgradable-menuitem"></span></a></li>
       </ul> 
    </section>

    <section class="section">
        <table id="packages-table" class="data-table responsive">
            <thead>
                <tr>
                    <th data-column="Name">Name</th>
                    <th class="align-center"></th>
                    <th class="align-center"></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div id="packages-comment" class="need-active align-center padding-v-24"></div>

          <section class="section align-right">
            <div id="packages-bottom-paginator" class="paginator label-before" data-label=""></div>                
        </section>

    </section>


</section>
