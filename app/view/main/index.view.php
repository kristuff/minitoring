<section id="main-container" class="container"
    data-current-view="<?php echo $this->data('viewId'); // required for ajax navigation ?>"
    
    >

<?php 
/* ----------------------------- */
    include 'inc/sidemenu.php'; 
    include 'inc/header.php';   
/* ----------------------------- */
?>
    <section id="main-content" class="main-content">
            <?php 
                    /* ----------------------------- */
                    include 'system/dashboard.php'; 
                    include 'system/disks.php'; 
                    include 'system/services.php'; 
                    include 'system/bans.php'; 
                    include 'system/bans.f2b.php'; 
                    include 'system/bans.iptables.php'; 
                    include 'system/bans.ip6tables.php'; 
                    include 'system/system.php'; 
                    include 'system/sysusers.php'; 
                    include 'system/logs.php'; 
                    include 'system/cron.php'; 
                    include 'system/tools.php'; 

                    include 'settings/settings.php';
                    include 'settings/settings.about.php';
                    include 'settings/settings.bans.php';
                    include 'settings/settings.profile.php';
                    include 'settings/settings.system.php';
                    include 'settings/settings.customize.php';
                    //include 'settings/settings.preferences.php';
                    include 'settings/settings.data.php';

                    /* ----------------------------- */
                    if ($this->data('userIsAdmin') === true ) { 

                        include 'settings/settings.users.php';
                        include 'settings/settings.logreader.php';
                        include 'settings/settings.services.php';
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
} else { 
    // TODO ?>
    <section class="need-active">
        <a href="#" class="dialog-button button button-o uppercase fw dialog-button-cancel" ><?php echo $this->text('BUTTON_CANCEL'); ?></a>
        <a href="#" class="dialog-button button uppercase fw dialog-button-ok"><?php echo $this->text('BUTTON_OK'); ?></a>
    </section>
<?php } ?>

    <div class="overlay"></div>
</section>
