<section id="settings" class="view view anim-scale-increase" 
         data-view ="settings/customize" data-title="<?php echo $this->text('SETTINGS_CUSTOMIZE') ;?>" 
         data-token="<?php echo $this->data('settingsToken'); ?>">

    <section class="section">
        <form class="small">
            <h6><?php echo $this->text('SETTINGS_CUSTOMIZE_LANGUAGE') ;?></h6>
            <div class="padding-bottom-6"><?php echo $this->text('SETTINGS_CUSTOMIZE_LANGUAGE_FIELD') ;?></div>
            <div class="custom-select full-width">
                <select id="select-language" data-bind="Minitoring.Settings.languageChanged">
                    <option value="en-US" <?php echo $this->data('UI_LANG') === 'en-US' ? ' selected' : '' ;?> >en-US</option>
                    <option value="fr-FR"  <?php echo $this->data('UI_LANG') === 'fr-FR'  ? ' selected' : '' ;?> >fr-FR</option>
                </select>
            </div>
            <div class="alert alert-no-icon" data-alert="info"><?php echo $this->text('SETTINGS_CUSTOMIZE_LANGUAGE_TEXT') ;?></div>
        </form>
    </section>
    <br>

    <section class="section">
        <h6 class="highlight"><?php echo $this->text('SETTINGS_CUSTOMIZE_APPEARANCE') ;?></h6>
        <form class="small">

            <div class="padding-bottom-6"><?php echo $this->text('SETTINGS_CUSTOMIZE_APPEARANCE_THEME_FIELD') ;?></div>
            <div class="custom-select full-width">
                <select id="select-theme" data-bind="Minitoring.Settings.themeChanged">
                    <option value="light" <?php echo $this->data('UI_THEME') === 'light' ? ' selected' : '' ;?> ><?php echo $this->text('THEME_LIGHT');?></option>
                    <option value="dark"  <?php echo $this->data('UI_THEME') === 'dark'  ? ' selected' : '' ;?> ><?php echo $this->text('THEME_DARK');?></option>
                </select>
            </div>

            <div class="padding-top-12 padding-bottom-6"><?php echo $this->text('SETTINGS_CUSTOMIZE_APPEARANCE_THEME_COLOR_FIELD') ;?></div>
            <div class="custom-select full-width">
                <select id="select-theme-color" data-bind="Minitoring.Settings.themeColorChanged">
                    <option value="red"     <?php echo $this->data('UI_THEME_COLOR') === 'red'     ? ' selected' : '' ;?> ><?php echo $this->text('COLOR_RED');    ?></option>
                    <option value="green"   <?php echo $this->data('UI_THEME_COLOR') === 'green'   ? ' selected' : '' ;?> ><?php echo $this->text('COLOR_GREEN');  ?></option>
                    <option value="blue"    <?php echo $this->data('UI_THEME_COLOR') === 'blue'    ? ' selected' : '' ;?> ><?php echo $this->text('COLOR_BLUE');   ?></option>
                    <option value="orange"  <?php echo $this->data('UI_THEME_COLOR') === 'orange'  ? ' selected' : '' ;?> ><?php echo $this->text('COLOR_ORANGE'); ?></option>
                    <option value="yellow"  <?php echo $this->data('UI_THEME_COLOR') === 'yellow'  ? ' selected' : '' ;?> ><?php echo $this->text('COLOR_YELLOW'); ?></option>
                    <option value="magenta" <?php echo $this->data('UI_THEME_COLOR') === 'magenta' ? ' selected' : '' ;?> ><?php echo $this->text('COLOR_MAGENTA');?></option>
                </select>
            </div>


        </form>
    </section>
    <br>

    <section class="section">
        <h6 class="highlight"><?php echo $this->text('SETTINGS_CUSTOMIZE_RESET_TITLE') ;?></h6>
        <form class="small">
            <div class="padding-bottom-6"><?php echo $this->text('SETTINGS_CUSTOMIZE_RESET_TEXT') ;?></div>   
            <button id="reset-settings-button" class="button" data-bind="Minitoring.Settings.resetCurrent" data-dialog-text="<?php echo $this->text('SETTINGS_CUSTOMIZE_RESET_DIALOG') ;?>"> 
                <i class="fa fa-trash fa-fw icon-left color-theme"></i><?php echo $this->text('SETTINGS_CUSTOMIZE_RESET_BUTTON') ;?>
            </button>
            <br>
            <div id="reset-user-settings-feedback"></div>   
        </form>
    </section>

</section>