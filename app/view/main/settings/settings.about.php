
<section id="settings-about" class="view anim-scale-increase" data-view="settings/about" 
    data-title="<?php $this->echo('SETTINGS_INFOS') ;?>">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="" href="<?php echo $this->baseUrl;?>"><?php $this->echo('HOME');?></a></li>
        <li class="breadcrumb-item"><a class="" href="<?php echo $this->baseUrl;?>settings/" data-view="settings"><?php $this->echo('SETTINGS'); ?></a></li>
        <li class="breadcrumb-item active"><?php $this->echo('SETTINGS_INFOS');?></li>
    </ol>
    <br>

    <div class="h3 color-accent">
        <img src="<?php echo $this->baseUrl;?>assets/img/favicon.ico" width="25px" height="25px" alt="">
        M<span class="color-theme">i</span>nitoring
    </div>
    <p class="">
        Version <span class="badge" data-badge="info">v<?php echo $this->data('APP_VERSION') ;?></span>
        <br>Copyright <i class="fa fa-copyright"></i> <?php echo $this->data('APP_COPYRIGHT');?>
        <br>Made with <i class="fa fa-heart color-theme"></i> and <i class="fa fa-coffee color-theme"></i> in France.
    </p>
    <br>

    <section class="section">
        <h5 class="color-accent text-light"><?php $this->echo('SETTINGS_INFOS_DEPENDENCIES') ;?></h5>
        <form class="large">
            <table id="dependencies-tables" class="data-table no-border">
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