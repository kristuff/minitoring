<section id="section-iptables" class="view anim-scale-increase" 
    data-view="bans/iptables" 
    data-title="Iptables"
    data-refresh="Minitoring.Iptables.refreshIptables">


    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="" href="<?php echo $this->baseUrl;?>"><?php $this->echo('HOME');?></a></li>
        <li class="breadcrumb-item"><a class="" href="<?php echo $this->baseUrl;?>bans/" data-view="bans"><?php $this->echo('FIREWALL'); ?></a></li>
        <li class="breadcrumb-item active">Iptables</li>
    </ol>
    <ul class="toolbar">
            <li>
                <a class="button button-small" href="#" data-bind="Minitoring.Iptables.refreshIptables">
                    <i class="fa fa-refresh icon-left"></i><span class="bt-title"><?php $this->echo('ACTION_REFRESH');?></span>
                </a>
            </li>
            <li class="search">
                <input class="search" data-table-target="iptables-data" type="text" placeholder="<?php $this->echo('ACTION_SEARCH');?>"><i class="search fa fa-search"></i>
            </li>
    </ul>

    <section class="section">
        <table id="iptables-data" class="data-table grouped group-row-caret responsive">
                    <thead>
                        <tr>
                            <th data-column="Group"      class="group"></th>
                            <th data-column="Target"     class="">Target</th>
                            <th data-column="Protocol"   class="">Protocol</th>
                            <th data-column="Source"     class="">Source</th>
                            <th data-column="Destination" class="">Destination</th>
                            <th data-column="Options" class="">Options</th>
                        </tr>
                    </thead>
                    <tbody class=""></tbody>
        </table>
    </section>
</section>