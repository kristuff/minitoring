<section id="settings" class="view view anim-scale-increase" 
         data-view ="settings/customize" data-title="<?php $this->echo('SETTINGS_CUSTOMIZE') ;?>" 
         data-token="<?php echo $this->data('settingsToken'); ?>">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="" href="<?php echo $this->baseUrl;?>"><?php $this->echo('HOME');?></a></li>
        <li class="breadcrumb-item"><a class="" href="<?php echo $this->baseUrl;?>settings/" data-view="settings"><?php $this->echo('SETTINGS'); ?></a></li>
        <li class="breadcrumb-item active"><?php $this->echo('SETTINGS_CUSTOMIZE');?></li>
    </ol>
    <br>
    <section class="section">
        <form class="small">
            <h5 class="color-accent text-light"><?php $this->echo('SETTINGS_CUSTOMIZE_LANGUAGE') ;?></h5>
            <div class="padding-bottom-6"><?php $this->echo('SETTINGS_CUSTOMIZE_LANGUAGE_FIELD') ;?></div>
            <div class="custom-select full-width">
                <select id="select-language" data-bind="Minitoring.Settings.languageChanged">
                    <option value="en-US" <?php echo $this->data('UI_LANG') === 'en-US' ? ' selected' : '' ;?> >English (en-US)</option>
                    <option value="fr-FR" <?php echo $this->data('UI_LANG') === 'fr-FR'  ? ' selected' : '' ;?> >Français (fr-FR)</option>
                </select>
            </div>
        </form>
    </section>
    <br>

    <section class="section">
        <h5 class="color-accent text-light"><?php $this->echo('SETTINGS_CUSTOMIZE_APPEARANCE') ;?></h5>
        <form class="small">

            <div class="padding-bottom-6"><?php $this->echo('SETTINGS_CUSTOMIZE_APPEARANCE_THEME_FIELD') ;?></div>
            <div class="custom-select full-width">
                <select id="select-theme" data-bind="Minitoring.Settings.themeChanged">
                    <option value="light" <?php echo $this->data('UI_THEME') === 'light' ? ' selected' : '' ;?> ><?php $this->echo('THEME_LIGHT');?></option>
                    <option value="dark"  <?php echo $this->data('UI_THEME') === 'dark'  ? ' selected' : '' ;?> ><?php $this->echo('THEME_DARK');?></option>
                    <option value="darkblue"  <?php echo $this->data('UI_THEME') === 'darkblue'  ? ' selected' : '' ;?> ><?php $this->echo('THEME_DARK_BLUE');?></option>
                </select>
            </div>

            <div class="padding-top-12 padding-bottom-6"><?php $this->echo('SETTINGS_CUSTOMIZE_APPEARANCE_THEME_COLOR_FIELD') ;?></div>
            <div class="custom-select full-width">
                <select id="select-theme-color" data-bind="Minitoring.Settings.themeColorChanged">
                    <option value="red"     <?php echo $this->data('UI_THEME_COLOR') === 'red'     ? ' selected' : '' ;?> ><?php $this->echo('COLOR_RED');    ?></option>
                    <option value="green"   <?php echo $this->data('UI_THEME_COLOR') === 'green'   ? ' selected' : '' ;?> ><?php $this->echo('COLOR_GREEN');  ?></option>
                    <option value="blue"    <?php echo $this->data('UI_THEME_COLOR') === 'blue'    ? ' selected' : '' ;?> ><?php $this->echo('COLOR_BLUE');   ?></option>
                    <option value="orange"  <?php echo $this->data('UI_THEME_COLOR') === 'orange'  ? ' selected' : '' ;?> ><?php $this->echo('COLOR_ORANGE'); ?></option>
                    <option value="yellow"  <?php echo $this->data('UI_THEME_COLOR') === 'yellow'  ? ' selected' : '' ;?> ><?php $this->echo('COLOR_YELLOW'); ?></option>
                    <option value="magenta" <?php echo $this->data('UI_THEME_COLOR') === 'magenta' ? ' selected' : '' ;?> ><?php $this->echo('COLOR_MAGENTA');?></option>
                </select>
            </div>


        </form>
    </section>
    <br>

    <section class="section">
        <h5 class="color-accent text-light"><?php $this->echo('SETTINGS_CUSTOMIZE_RESET_TITLE') ;?></h5>
        <form class="small">
            <div class="padding-bottom-6"><?php $this->echo('SETTINGS_CUSTOMIZE_RESET_TEXT') ;?></div>   
            <button id="reset-settings-button" class="button" data-bind="Minitoring.Settings.resetCurrent" data-dialog-text="<?php $this->echo('SETTINGS_CUSTOMIZE_RESET_DIALOG') ;?>"> 
                <i class="fa fa-trash fa-fw icon-left color-theme"></i><?php $this->echo('SETTINGS_CUSTOMIZE_RESET_BUTTON') ;?>
            </button>
            <br>
            <div id="reset-user-settings-feedback"></div>   
        </form>
    </section>

</section>