<section id="section-cron" class="view anim-scale-increase" data-view="crons" data-title="<?php $this->echo('CRONS');?>" data-refresh="Minitoring.Cron.getList">

    <section class="section">
        <h6 class="highlight"><?php $this->echo('CRONS_USER');?></h6>
        <table id="users-cron-list" class="data-table responsive">
            <thead>
                <tr>
                    <th data-column="<?php $this->echo('CRONS_USER_HEADER');?>"><?php $this->echo('CRONS_USER_HEADER');?></th>
                    <th data-column="<?php $this->echo('CRONS_TIME_HEADER');?>"><?php $this->echo('CRONS_TIME_HEADER');?></th>
                    <th data-column="<?php $this->echo('CRONS_COMMAND_HEADER');?>"><?php $this->echo('CRONS_COMMAND_HEADER');?></th>
                    <th data-column="<?php $this->echo('CRONS_NEXT_TIME_HEADER');?>"><?php $this->echo('CRONS_NEXT_TIME_HEADER');?></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </section>
    <br>

    <section class="section">
        <h6 class="highlight"><?php $this->echo('CRONS_SYSTEM');?></h6>
        <table id="system-cron-list" class="data-table responsive">
            <thead>
                <tr>
                    <th data-column="<?php $this->echo('CRONS_TIME_HEADER');?>"><?php $this->echo('CRONS_TIME_HEADER');?></th>
                    <th data-column="<?php $this->echo('CRONS_SCRIPT_HEADER');?>"><?php $this->echo('CRONS_SCRIPT_HEADER');?></th>
                    <th data-column="<?php $this->echo('CRONS_TYPE_HEADER');?>"><?php $this->echo('CRONS_TYPE_HEADER');?></th>
                    <th data-column="<?php $this->echo('CRONS_COMMAND_HEADER');?>"><?php $this->echo('CRONS_COMMAND_HEADER');?></th>
                    <th data-column="<?php $this->echo('CRONS_NEXT_TIME_HEADER');?>"><?php $this->echo('CRONS_NEXT_TIME_HEADER');?></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </section>
    <br>

    <section class="section">
        <h6 class="highlight"><?php $this->echo('CRONS_TIMER');?></h6>
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
            <tbody></tbody>
        </table>
    </section>
  


</section>