<section id="section-services" class="view anim-scale-increase" 
         data-view="services" 
         data-title="Services" 
         data-refresh="Minitoring.Services.refresh">

    <section class="action-bar" id="services-actions">
        <ul class="tab-items" data-style="flat">
            <li class="tab-item <?php echo (($this->data('currentAction') == '') || ( $this->data('currentAction') == 'index')) ? 'current' : '' ?>"><a href="<?php echo $this->baseUrl;?>service/"><i class="fa fa-list-ol icon-left" aria-hidden="true"></i>Services</a></li>
            <li class="tab-item <?php echo $this->data('currentAction') == 'history'   ? 'current' : '' ?>"><a href="<?php echo $this->baseUrl;?>service/history"><i class="fa fa-calendar icon-left" aria-hidden="true"></i>History</a></li>
            <li id="services-top-paginator" class="paginator float-right" data-max-items="5"></li>
       </ul> 
    </section>

    <section class="section">
        <table id="services-table" class="data-table responsive">
            <thead>
                <tr>
                        <th class="align-left">Service</th>
<?php if($this->data('currentAction') === 'historyxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx') { ?>
                        <th class="align-right"></th>
                        <th class="align-right">Port</th>
                        <th class="align-center">Check enabled</th>
<?php } ?>
                        <th>Last check</th>
                        <th class="align-center">Status</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
          <section class="section align-right">
            <div id="services-bottom-paginator" class="paginator" data-label-before=""></div>                
        </section>         
    </section>
    
</section>