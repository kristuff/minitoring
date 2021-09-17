<section id="section-disks" class="view anim-scale-increase" data-view="disks" data-title="<?php $this->echo('DISKS'); ?>" data-refresh="Minitoring.Disks.refresh">

    <ul class="toolbar">
        <li>
            <a class="button button-small" href="#" data-bind="Minitoring.Disks.refresh">
                <i class="fa fa-refresh icon-left"></i><span class="bt-title"><?php $this->echo('ACTION_REFRESH'); ?></span>
            </a>
        </li>
    </ul>

    <h5 class="color-accent text-light"><?php $this->echo('DISK_SPACE'); ?></h5>
    <table id="disks-table" class="data-table responsive">
        <thead>
            <tr>
                <th data-column="filesystem"><?php $this->echo('DISK_FILESYSTEM');                      ?></th>
                <th data-column="type"><?php $this->echo('DISK_TYPE');                                  ?></th>
                <th data-column="mount"><?php $this->echo('DISK_MOUNT');                                ?></th>
                <th data-column="percent_used" class="align-center"><?php $this->echo('PERCENT_USED');  ?></th>
                <th data-column="used" class="align-right padding-right-12"><?php $this->echo('USED');  ?></th>
                <th data-column="free" class="align-right padding-right-12"><?php $this->echo('FREE');  ?></th>
                <th data-column="total" class="align-right padding-right-12"><?php $this->echo('TOTAL'); ?></th>
            </tr>
        </thead>
        <tbody class=""></tbody>
    </table>

    <br>
    <h5 class="color-accent text-light"><?php $this->echo('INODES'); ?></h5>
    <table id="inodes-table" class="data-table responsive">
        <thead>
            <tr>
                <th data-column="filesystem"><?php $this->echo('DISK_FILESYSTEM');                          ?></th>
                <th data-column="type"><?php $this->echo('DISK_TYPE');                                  ?></th>
                <th data-column="mount"><?php $this->echo('DISK_MOUNT');                                ?></th>
                <th data-column="percent_used" class="align-center"><?php $this->echo('PERCENT_USED');  ?></th>
                <th data-column="used" class="align-right padding-right-12"><?php $this->echo('USED');  ?></th>
                <th data-column="free" class="align-right padding-right-12"><?php $this->echo('FREE');  ?></th>
                <th data-column="total" class="align-right padding-right-12"><?php $this->echo('TOTAL'); ?></th>
        </thead>
        <tbody class=""></tbody>
    </table>

</section>