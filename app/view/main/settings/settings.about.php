
<section id="settings-about" class="view anim-scale-increase" data-view="settings/about" 
    data-title="<?php $this->echo('SETTINGS_INFOS') ;?>">

    <br>
    <h5 class="highlight">
        M<span class="color-theme">i</span>nitoring
    </h5>
    <p class="">
        Version <span class="badge" data-badge="black">v<?php echo $this->data('APP_VERSION') ;?></span>
        <br>Copyright <i class="fa fa-copyright"></i> <?php echo $this->data('APP_COPYRIGHT');?>
        <br>Made with <i class="fa fa-heart color-theme"></i> and <i class="fa fa-coffee color-theme"></i> in France.
    </p>
    <br>

    <section class="section">
        <h6 class="highlight"><?php $this->echo('SETTINGS_INFOS_DEPENDENCIES') ;?></h6>
        <form class="large">
            <table id="dependencies-tables" class="data-table XXresponsive">
                <thead>
                    <tr class="table-header">
                        <th data-column="<?php $this->echo('DEPENDENCY_LIBRARY') ;?>"><?php $this->echo('DEPENDENCY_LIBRARY') ;?></th>
                        <th data-column="<?php $this->echo('DEPENDENCY_VERSION') ;?>"><?php $this->echo('DEPENDENCY_VERSION') ;?></th>
                    </tr>
                </thead>
            <tbody>
                <?php foreach ($this->data('installedPackages') as $package) { ?>
                    <tr>
                        <td data-column="Library"><?php echo $this->noHtml($package->getName()) ;?>    </td>
                        <td data-column="Version"><?php echo $this->noHtml($package->getVersion()) ;?> </td>
                    </tr>

                <?php } ?>
            </tbody>
            </table>
        </form>
    </section>
    <br>

</section>