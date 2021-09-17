<section id="section-ip6tables" class="view anim-scale-increase" data-view="bans/ip6tables" data-title="Ip6tables" data-refresh="Minitoring.Iptables.refreshIp6tables">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="" href="<?php echo $this->baseUrl; ?>"><?php $this->echo('HOME'); ?></a></li>
        <li class="breadcrumb-item"><a class="" href="<?php echo $this->baseUrl; ?>bans/" data-view="bans"><?php $this->echo('FIREWALL'); ?></a></li>
        <li class="breadcrumb-item active">Ipt6ables</li>
    </ol>
    <ul class="toolbar">
        <li>
            <a class="button button-small" href="#" data-bind="Minitoring.Iptables.refresh6Iptables">
                <i class="fa fa-refresh icon-left"></i><span class="bt-title"><?php $this->echo('ACTION_REFRESH'); ?></span>
            </a>
        </li>
        <li class="search">
            <input class="search" data-table-target="ip6tables-data" type="text" placeholder="<?php $this->echo('ACTION_SEARCH'); ?>"><i class="search fa fa-search"></i>
        </li>
    </ul>
    <section class="section">
        <table id="ip6tables-data" class="data-table responsive">
            <thead>
                <tr>
                    <th data-column="Group" class="group"></th>
                    <th data-column="Target" class="">Target</th>
                    <th data-column="Protocol" class="">Protocol</th>
                    <th data-column="Source" class="">Source</th>
                    <th data-column="Destination" class="">Destination</th>
                    <th data-column="Options" class="">Options</th>
                </tr>
            </thead>
            <tbody class=""></tbody>
        </table>
    </section>
</section>