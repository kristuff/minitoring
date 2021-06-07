<section id="section-bans" class="view anim-scale-increase" 
    data-view="bans" data-title="Bans">

    <div class="wrap flex flex-wrap">
        <div class="rwd-box">
            <a class="box-inner" href="<?php echo $this->baseUrl;?>bans/fail2ban" data-view="bans/fail2ban" role="button">
               <span class="box-icon"><i class="fa fa-fw color-theme fa-2x fa-ban"></i></span>
               <span class="box-title">Fail2ban</span>
               <span class="box-subtitle">Check Fail2ban status and get jails stats and status</span>
            </a>
        </div>
        <div class="rwd-box">
            <a class="box-inner" href="<?php echo $this->baseUrl;?>bans/iptables" data-view="bans/iptables" role="button">
               <span class="box-icon"><i class="fa fa-fw color-theme fa-2x fa-ban"></i></span>
               <span class="box-title">Iptables</span>
               <span class="box-subtitle">Get the content of Iptables</span>
            </a>
        </div>
        <div class="rwd-box">
            <a class="box-inner" href="<?php echo $this->baseUrl;?>bans/ip6tables" data-view="bans/ip6tables" role="button">
               <span class="box-icon"><i class="fa fa-fw color-theme fa-2x fa-ban"></i></span>
               <span class="box-title">Ip6tables</span>
               <span class="box-subtitle">Get the content of Ip6tables</span>
            </a>
        </div>
    </div>

</section>