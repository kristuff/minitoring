<section id="settings" class="view view anim-scale-increase" data-token="<?php echo $this->data('settingsToken'); ?>">
    <table>
        <tr class="title">
            <td><i class="fa fa-server fa-fw fa-2x "></i></td>
            <td colspan="2"><h5 class="title u">Disks</h5></td>
        </tr>
        <tr>
            <td></td>
            <td><input id="disks_show_tmpfs" type="checkbox" class="toggle" /></td>
            <td> Show temp file systems (tmpsfs)</td>
        </tr>
        <tr class="title">
            <td><i class="fa fa-cogs fa-fw fa-2x "></i></td>
            <td colspan="2"><h5 class="title u">Services</h5></td>
        </tr>
        <tr>
            <td></td>
            <td><input id="services_show_ports" type="checkbox" class="toggle" /></td>
            <td> Display services ports</td>
        </tr>
        <tr class="title">
            <td><i class="fa fa-exclamation-triangle fa-fw fa-2x "></i></td>
            <td colspan="2"><h5 class="title u">Danger section</h5></td>
        </tr>
       <tr>
            <td></td>
            <td><i class="fa fa-trash fa-fw"></i></td>
            <td>
                <b>Reset application settings</b>
                <br>Reset application's settings to defauts.
                <br>
                <button class="button large action-link" data-module="Settings" data-action="resetapp" data-color="theme">Reset application settings</button>
            </td>
        </tr>
    </table>
</section>
