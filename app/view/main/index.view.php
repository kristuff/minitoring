<section id="main-container" class="container" data-current-view="<?php echo $this->data('viewId'); // required for ajax navigation ?>">

<?php 
/* ----------------------------- */
    include 'inc/sidemenu.php'; 
    include 'inc/header.php';   
/* ----------------------------- */
?>
    <section id="main-content" class="main-content bg-darker">
            <?php 
                    /* ----------------------------- */
                    include 'system/dashboard.php'; 
                    include 'system/disks.php'; 
                    include 'system/bans.php'; 
                    include 'system/bans.f2b.php'; 
                    include 'system/bans.iptables.php'; 
                    include 'system/bans.ip6tables.php'; 
                    include 'system/sysusers.php'; 
                    include 'system/logs.php'; 
                    include 'system/cron.php';  
                    include 'system/packages.php';

                    include 'settings/settings.php';
                    include 'settings/settings.about.php';
                    include 'settings/settings.profile.php';
                    include 'settings/settings.customize.php';

                    /* ----------------------------- */
                    if ($this->data('userIsAdmin') === true ) { 
                        include 'settings/settings.users.php';
                        include 'settings/settings.advanced.php';
                        include 'settings/settings.logreader.php';
                        include 'settings/settings.services.php';
                        include 'settings/settings.ping.php';
                    }

                ?>
    </section>

<?php 
/* ----------------------------- */
/* --- MODAL DIALOG ------------ */
/* ----------------------------- */
if ($this->data('userIsAdmin') === true ) { 
    include 'settings/settings.users.dialog.php';
    include 'settings/settings.logs.dialog.php';
    include 'settings/settings.services.dialog.php';
    include 'settings/settings.ping.dialog.php';
} else { 
    // TODO hidden section to be able to retreive localized button texts... ?>
    <section class="need-active">
        <a href="#" class="dialog-button button button-o uppercase fw dialog-button-cancel" ><?php $this->echo('BUTTON_CANCEL'); ?></a>
        <a href="#" class="dialog-button button uppercase fw dialog-button-ok"><?php $this->echo('BUTTON_OK'); ?></a>
    </section>
<?php } ?>

    <div class="overlay"></div>
</section>
