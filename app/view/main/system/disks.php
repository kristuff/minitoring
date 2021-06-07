<section id="section-disks" class="view anim-scale-increase" 
         data-view="disks" 
         data-title="Disks" 
         data-refresh="Minitoring.Disks.get" >

    <?php $this->renderFeedback(); ?>

    <section id="disks-actions" class="section action-bar">
        <input id="disks_show_tmpfs" type="checkbox" class="switch" 
               data-bind="Minitoring.Disks.get" data-bind-event="change"/>
        <label for="disks_show_tmpfs"></label>
        <label>Show tmpfs</label>

    </section>

    <h6>Disks space</h6>
    <table id="disks-table" class="data-table responsive">
        <thead>
            <tr>
                <th>Filesystem</th>
                <th>Type</th>
                <th>Mount</th>
                <th class="align-center">% used</th>
                <th class="align-center">Free</th>
                <th class="align-center">Used</th>
                <th class="align-center">Total</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>   

    <br>
    <h6>Inodes</h6>
    <table id="inodes-table" class="data-table responsive">
        <thead>
            <tr>
                <th>Filesystem</th>
                <th>Type</th>
                <th>Mount</th>
                <th class="align-center">% used</th>
                <th class="align-center">Free</th>
                <th class="align-center">Used</th>
                <th class="align-center">Total</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>    

</section>