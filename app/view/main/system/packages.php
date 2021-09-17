<section id="section-services" class="view anim-scale-increase" data-view="packages" data-title="<?php $this->echo('PACKAGES'); ?>" data-refresh="Minitoring.Packages.refresh">
    <section class="action-bar" id="packages-nav">
        <ul class="tab-items" data-style="flat">
            <li class="tab-item <?php echo (($this->data('currentAction') == '') || ($this->data('currentAction') == 'index')) ? 'current' : '' ?>"><a href="<?php echo $this->baseUrl; ?>packages/" data-view="packages"><i class="fa fa-list-ol icon-left" aria-hidden="true"></i>All</a></li>
            <li class="tab-item <?php echo $this->data('currentAction') == 'upgradable'   ? 'current' : '' ?>"><a href="<?php echo $this->baseUrl; ?>packages/upgradable" data-view="packages/upgradable"><i class="fa fa-plus icon-left" aria-hidden="true"></i>Upgradable<span id="packages-upgradable-menuitem"></span></a></li>
        </ul>
    </section>
    <br>
    <ul class="toolbar margin-top-6">
        <li>
            <a class="button button-small" href="#" data-bind="Minitoring.Packages.refresh">
                <i class="fa fa-refresh icon-left"></i><span class="bt-title"><?php $this->echo('ACTION_REFRESH'); ?></span>
            </a>
        </li>
        <li class="search">
            <input class="search" data-table-target="packages-table" type="text" placeholder="<?php $this->echo('ACTION_SEARCH'); ?>"><i class="search fa fa-search"></i>
        </li>
    </ul>
    <section class="section">
        <table id="packages-table" class="data-table responsive">
            <thead>
                <tr>
                    <th data-column="Name">Name</th>
                    <th class="align-center"></th>
                    <th class="align-center"></th>
                </tr>
            </thead>
            <tbody class=""></tbody>
        </table>
        <div id="packages-comment" class="need-active align-center padding-v-24"></div>

        <section class="section align-right">
            <div id="packages-bottom-paginator" class="paginator label-before" data-label=""></div>
        </section>
    </section>
</section>