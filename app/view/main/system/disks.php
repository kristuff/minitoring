<section id="section-disks" class="view anim-scale-increase" data-view="disks" data-title="<?php $this->echo('DISKS'); ?>" data-refresh="Minitoring.Disks.refresh" >

    <section id="disks-actions" class="section action-bar">
        <input id="disks_show_tmpfs" type="checkbox" class="switch" data-bind="Minitoring.Disks.refresh" data-bind-event="change"/>
        <label for="disks_show_tmpfs"></label>
        <label><?php $this->echo('DISK_SHOW_TMPFS'); ?></label>
    </section>

    <h6><?php $this->echo('DISK_SPACE'); ?></h6>
    <table id="disks-table" class="data-table responsive">
        <thead>
            <tr>
                <th data-column="filesystem"><?php $this->echo('DISK_FILESYSTEM');                      ?></th>
                <th data-column="type"><?php $this->echo('DISK_TYPE');                                  ?></th>
                <th data-column="mount"><?php $this->echo('DISK_MOUNT');                                ?></th>
                <th data-column="percent_used" class="align-center"><?php $this->echo('PERCENT_USED');  ?></th>
                <th data-column="used" class="align-right padding-right-12"><?php $this->echo('USED');  ?></th>
                <th data-column="free" class="align-right padding-right-12"><?php $this->echo('FREE');  ?></th>
                <th data-column="total" class="align-right padding-right-12"><?php $this->echo('TOTAL');?></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>   

    <br>
    <h6><?php $this->echo('INODES'); ?></h6>
    <table id="inodes-table" class="data-table responsive">
        <thead>
            <tr>
            <th data-column="filesystem"><?php $this->echo('DISK_FILESYSTEM');                          ?></th>
                <th data-column="type"><?php $this->echo('DISK_TYPE');                                  ?></th>
                <th data-column="mount"><?php $this->echo('DISK_MOUNT');                                ?></th>
                <th data-column="percent_used" class="align-center"><?php $this->echo('PERCENT_USED');  ?></th>
                <th data-column="used" class="align-right padding-right-12"><?php $this->echo('USED');  ?></th>
                <th data-column="free" class="align-right padding-right-12"><?php $this->echo('FREE');  ?></th>
                <th data-column="total" class="align-right padding-right-12"><?php $this->echo('TOTAL');?></th>
        </thead>
        <tbody></tbody>
    </table>    

</section>