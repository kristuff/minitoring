<section id="section-cron" class="view anim-scale-increase" data-view="crons" data-title="<?php $this->echo('CRONS'); ?>" data-refresh="Minitoring.Cron.getList">

    <ul class="toolbar section">
        <li>
            <a class="button button-small" href="#" data-bind="Minitoring.Cron.getList">
                <i class="fa fa-refresh color-theme icon-left"></i><span class="bt-title"><?php $this->echo('ACTION_REFRESH'); ?></span>
            </a>
        </li>
    </ul>

    <section class="section">
        <h5 class="color-accent text-light"><?php $this->echo('CRONS_USER'); ?></h5>
            <table id="users-cron-list" class="data-table responsive">
                <thead>
                    <tr>
                        <th data-column="<?php $this->echo('CRONS_USER_HEADER'); ?>"><?php $this->echo('CRONS_USER_HEADER'); ?></th>
                        <th data-column="<?php $this->echo('CRONS_TIME_HEADER'); ?>"><?php $this->echo('CRONS_TIME_HEADER'); ?></th>
                        <th data-column="<?php $this->echo('CRONS_COMMAND_HEADER'); ?>"><?php $this->echo('CRONS_COMMAND_HEADER'); ?></th>
                        <th data-column="<?php $this->echo('CRONS_NEXT_TIME_HEADER'); ?>"><?php $this->echo('CRONS_NEXT_TIME_HEADER'); ?></th>
                    </tr>
                </thead>
                <tbody class=""></tbody>
            </table>
    </section>
    <br>

    <section class="section">
        <h5 class="color-accent text-light"><?php $this->echo('CRONS_SYSTEM'); ?></h5>
            <table id="system-cron-list" class="data-table responsive">
                <thead>
                    <tr>
                        <th data-column="<?php $this->echo('CRONS_TIME_HEADER'); ?>"><?php $this->echo('CRONS_TIME_HEADER'); ?></th>
                        <th data-column="<?php $this->echo('CRONS_SCRIPT_HEADER'); ?>"><?php $this->echo('CRONS_SCRIPT_HEADER'); ?></th>
                        <th data-column="<?php $this->echo('CRONS_TYPE_HEADER'); ?>"><?php $this->echo('CRONS_TYPE_HEADER'); ?></th>
                        <th data-column="<?php $this->echo('CRONS_COMMAND_HEADER'); ?>"><?php $this->echo('CRONS_COMMAND_HEADER'); ?></th>
                        <th data-column="<?php $this->echo('CRONS_NEXT_TIME_HEADER'); ?>"><?php $this->echo('CRONS_NEXT_TIME_HEADER'); ?></th>
                    </tr>
                </thead>
                <tbody class=""></tbody>
            </table>
    </section>
    <br>

    <section class="section">
        <h5 class="color-accent text-light"><?php $this->echo('CRONS_TIMER'); ?></h5>
            <table id="system-timer-list" class="data-table responsive">
                <thead>
                    <tr>
                        <th data-column="Unit">Unit</th>
                        <th data-column="Activates">Activates</th>
                        <th data-column="Passed">Passed</th>
                        <th data-column="Last">Last</th>
                        <th data-column="Left">Left</th>
                        <th data-column="Next">Next</th>
                    </tr>
                </thead>
                <tbody class=""></tbody>
            </table>
    </section>
</section>