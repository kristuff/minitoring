

<div id="setup" class="wizard-overlay active">
    <section class="section footer align-center bg-transp-light">
        <p class="text-xsmall">
            Made with <i class="fa fa-heart color-theme"></i> and <i class="fa fa-coffee color-theme"></i> in France
        </p>
    </section>
    <div id="wizard" class="wizard " data-wizard-current-index="0" data-theme="dark">
        <section class="wizard-inner ">
            <button class="wizard-button-close  need-active "><i class="fa fa-times"></i></button>
            <section class="wizard-bottom bg-transp-light" >
                <a href="#" class="button button-o theme uppercase wizard-button-prev" data-color="theme">Back</a>                    
                <a href="#" class="button uppercase theme wizard-button-next" data-color="theme" data-visible="true">Next</a>
            </section>
            
            <section class="wizard-progress" data-theme="light">
                <section class="wizard-progress-inner bg-theme" data-theme="none"></section>
            </section>
 
            <div class="wizard-panel" data-wizard-index="0" data-wizard-title="Welcome">
                <h5 class="wizard-title">Minitoring installer</h5>
                <p>L'application n'est pas configurée. Ce programme permet de créer une base de données pour votre application.</p> 
                <p>Appuyez sur 'suivant' pour démarrer le programme d'installation.</p>
                <?php  $this->renderFeedback(); // echo out the system feedback (error and success messages) ?>
            </div>

            <div class="wizard-panel anim-from-left" data-wizard-index="1">
                <div class="h6"><i class="fa fa-check-square-o icon-left"></i>Vérification des droits et des requirements</div>
                <div id="check-list"></div>
                <div id="check-result"></div>
            </div>

            <div class="wizard-panel anim-from-left" data-wizard-index="2">
                <div class="h6 wizard-panel-title"><i class="fa fa-database"></i> Configurer la base de données (1/3)</div>
                <p>Choisissez le type de base de données</p>
                <p></p>
                <form class="small" data-style="flat">
                    <div class="custom-select">
                        <select name="Provider" id="db-select">
                            <option value="">--Please choose an option--</option>
                            <option value="sqlite">Sqlite</option>
                            <option value="mysql">Mysql</option>
                            <option value="pgsql">Postgres</option>
                        </select>
                    </div>
                </form>
            </div>

        <div class="wizard-panel anim-from-left" data-wizard-index="3">
            <div class="h6 wizard-panel-title"><i class="fa fa-database"></i> Configurer la base de données (2/3)</div>
            <p>Veuillez renseignez vos identifiants serveur (pour une base de données Sqlite, vous pouvez passer cette étape).</p>
            <section class="section"></section>
           
               <form class="frm">
                <!--
                <label for="db-type">Database type:</label>
                <input id="db_type" type="text" name="db_type" placeholder="Database type" required value="mysql"/>
                -->
                <label for="db-host">Database host:</label>
                <input id="db_host" type="text" name="db_host" placeholder="Database host" required value="localhost" />
                <label for="root_pass">Mot de pass root:</label>
                <input id="root_pass" type="password" name="root_password" placeholder="Mot de passe root" required />
                <section class="section">
                    <a href="#" class="button button-o toggle-pwd toggle-pwd-hide">
                        <i class="fa fa-lock left-icon"></i>
                        <span class="text">Afficher/Masquer les mots de passe</span>
                    </a>
                </section>
            </form>
        </div>

        <div class="wizard-panel anim-from-left" data-wizard-index="4">
            <div class="h6 wizard-panel-title"><i class="fa fa-database"></i> Configurer la base de données (3/3)</div>
            <p>Choisissez un nom pour la base de données, un nom d'utilisateur et un mot de passe 
                (pour une base de données Sqlite, vous pouvez passer cette étape)
            </p>
            <form class="frm">
                <label for="db_name">Database name:</label>
                <input id="db_name" type="text" name="db_name" placeholder="Database name" required value="minitoring" />
                <label for="db_user">Database user name:</label>
                <input id="db_user" type="text" name="db_user" placeholder="Database user" required value="minitoring" />
                <label for="db_pass">Database password:</label>
                <input id="db_pass" type="password" name="db_password" placeholder="Mot de passe" required />
                <div>
                    <a href="#" class="button button-o toggle-pwd toggle-pwd-hide">
                        <i class="fa fa-lock left-icon"></i>
                        <span class="text">Afficher/Masquer les mots de passe</span>
                    </a>
                </div>
            </form>
            <div id="intall_result" class="install-panel"></div>
        </div>
        
        <div class="wizard-panel anim-from-left" data-wizard-index="5">
            <div class="h6 wizard-panel-title"><i class="fa fa-user"></i> Ajouter un utilisateur admin</div>
            <form class="frm">
                <label for="admin_name">Admin user name:</label>
                <input id="admin_name" type="text" name="admin_name" placeholder="Admin user name" required value="admin" />
                <label for="admin_email">Admin user email:</label>
                <input id="admin_email" type="text" name="admin_email" placeholder="admin email" required value="" />
                <label for="admin_pass">Admin password:</label>
                <input id="admin_password" type="password" name="admin_password" placeholder="Mot de passe admin" required />
                <div>
                    <a href="#" class="button button-o toggle-pwd toggle-pwd-hide">
                        <i class="fa fa-lock left-icon"></i>
                        <span class="text">Afficher/Masquer les mots de passe</span>
                    </a>
                </div>
            </form>
        </div>

        <div class="wizard-panel anim-from-left" data-wizard-index="6">
                <div class="h6">Terminer l'installation</div>
                <p>Appuyez sur installer pour démarrer l'installation.</p>
                <div class="alert" data-alert="warning" role="alert">
                    La configuration va prendre quelques instants.
                    <br>Veillez à maintenir la connexion pendant la durée du traitement.
                </div>
            </div>

            <div class="wizard-panel anim-from-left" data-wizard-index="7">
                <h2 class="wizard-title">Minitoring installer</h2>
                <div id="install-message"></div>
                <div id="install-result"></div>
            </div>

        </section>
    </div>
</div>