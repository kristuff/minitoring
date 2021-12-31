<section id="section-logs" class="view anim-scale-increase" data-title="<?php $this->echo('LOGS');?>" data-view="logs" data-refresh="Minitoring.Logs.refresh">

    <ul class="toolbar">
            <li>
                <a class="button button-small" href="#" data-bind="Minitoring.Logs.refresh">
                    <i class="fa fa-refresh color-theme icon-left"></i><span class="bt-title"><?php $this->echo('ACTION_REFRESH');?></span>
                </a>
            </li>
            <li class="search">
                <input class="search" data-table-target="system-logs-table" type="text" placeholder="<?php $this->echo('ACTION_SEARCH');?>"><i class="search fa fa-search"></i>
            </li>
    </ul>
    <section class="xxaction-bar padding-bottom-12" id="logs-actions">

        <div class="wrapper mob-whole tab-half desk-half">
        
            <div class="wrappitem mob-padding-bottom-6 tab-padding-right-6 desk-padding-right-12">
                <div class="custom-select">
                    <select id="select-log" data-bind="Minitoring.Logs.refresh"></select>
                </div>
            </div>

            <div class="wrappitem">
                <div class="wrapper mob-half ">
                    <div class="wrappitem mob-padding-right-6 tab-padding-right-6 desk-padding-right-12">
                        <div class="custom-select">
                            <select id="select-log-refresh" data-bind="Minitoring.Logs.setAutoRefresh">
                                <option value="0"><?php  $this->echo('LOGS_REFRESH_NONE');?></option>  
                                <option value="5"><?php  echo sprintf($this->text('LOGS_REFRESH_XSECONDS'), '5');?></option>  
                                <option value="10"><?php echo sprintf($this->text('LOGS_REFRESH_XSECONDS'), '10');?></option>  
                                <option value="30"><?php echo sprintf($this->text('LOGS_REFRESH_XSECONDS'), '30');?></option>  
                                <option value="60"><?php echo sprintf($this->text('LOGS_REFRESH_XSECONDS'), '60');?></option>  
                            </select>
                        </div>
                    </div>
                    <div class="wrappitem mob-align-center desk-align-left">
                        <div class="custom-select  ">
                            <select id="select-log-max" data-bind="Minitoring.Logs.refresh">
                                <option value="10"><?php echo sprintf($this->text('LOGS_DISPLAY_XLINES'), '10');?></option>  
                                <option value="20"><?php echo sprintf($this->text('LOGS_DISPLAY_XLINES'), '20');?></option>  
                                <option value="50" selected><?php echo sprintf($this->text('LOGS_DISPLAY_XLINES'), '50');?></option>  
                                <option value="100"><?php echo sprintf($this->text('LOGS_DISPLAY_XLINES'), '100');?></option>  
                                <option value="200"><?php echo sprintf($this->text('LOGS_DISPLAY_XLINES'), '200');?></option>  
                                <option value="500"><?php echo sprintf($this->text('LOGS_DISPLAY_XLINES'), '500');?></option>  
                            </select>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <table id="system-logs-table" class="data-table responsive XXalternative-row-style">
        <thead></thead>
        <tbody class=""></tbody>
    </table>                
    <section class="section">
        <div id="system-logs-msg" class="text-small"></div>
    </section>
    <section id="system-logs-loadmore" class="section need-active align-center">
        <a class="button button-small" href="#" data-bind="Minitoring.Logs.loadMore">
            <i class="fa fa-plus icon-left color-theme"></i><span class="bt-title"><?php $this->echo('LOGS_LOAD_MORE_BUTTON');?></span>
        </a>
    </section>
 
</section>