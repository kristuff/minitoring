

// main application
Minitoring.Setup = {

    // init
    start: function () {

        document.querySelector('#db-select').addEventListener('change', Minitoring.Setup.checkserverIdentVisiblity, false);

        var wiz = new Minikit.Wizard(document.querySelector('.wizard'));
        wiz.onIndexChanged(function (e) {

            // update progress
            var current = ((e.detail.newIndex + 1) / e.detail.total) * 100;
            wiz.html.querySelector('.wizard-progress-inner').style.width = current + '%';

            var nextbuttontext = wiz.html.querySelector('.wizard-button-next').getAttribute('data-next-text');

            switch (e.detail.newIndex) {
                case 0:
                    break;
                case 1:
                    Minitoring.Setup.checkForInstall();
                    break;
                case 2:
                    Minitoring.Setup.checkDatabaseType();
                    break;
                case 3:
                    Minitoring.Setup.checkDatabaseCredentials();
                    break;
                case 4:
                    Minitoring.Setup.checkAdminCredentials();
                    break;
                case 5:
                    nextbuttontext = wiz.html.querySelector('.wizard-button-next').getAttribute('data-install-text');
                    break;
                case 6:
                    wiz.html.querySelector('.wizard-button-prev').style.display = 'none';
                    nextbuttontext = wiz.html.querySelector('.wizard-button-next').getAttribute('data-close-text');
                    Minitoring.Setup.install();
                    break;
            }

            wiz.html.querySelector('.wizard-button-next').innerHTML = nextbuttontext;
        });

        wiz.onClosed(function () {
            location.reload();
        });

        wiz.index(0);
        document.querySelector('.wizard-overlay').classList.add('active');

    },

    languageChanged: function() {
        var selectedLang = document.querySelector('select#language-select').value,
            currentLanguage = document.querySelector('body').getAttribute('data-language');
        if (selectedLang && currentLanguage != selectedLang){
            window.location.href =  window.location.origin + '/setup?language=' + selectedLang;
        }
    },

    checkDatabaseType: function () {

    },
    checkDatabaseCredentials: function () {

    },
    checkAdminCredentials: function () {

    },
    
    checkForInstall: function () {
        var selectedLang = document.querySelector('select#language-select').value,
            args = '?requestDate=' + new Date().getTime() +
                   '&language=' + selectedLang ;

        // clear message
        document.querySelector('#check-list').innerHTML = '';
        document.querySelector('#check-result').innerHTML = '';
                           
        Minikit.ajax({
            url: window.location.origin + '/setup/check' + args,
            method: 'GET',
            callback: function (response) {
                switch (response.status) {
                    case 200:
                        var result = JSON.parse(response.responseText),
                            alertElmt = Minikit.Alerts.create(result.message, { type: 'success' });
                        document.querySelector('#check-result').appendChild(alertElmt);
                        break;

                    default:
                        var errorMsg = '';
                        var result = JSON.parse(response.responseText);
                        for (var i = 0; i < result.errors.length; i++) {
                            errorMsg += '<br> -> '  + result.errors[i].message;
                        }
                        var alertElmt = Minikit.Alerts.create(result.message + errorMsg, { type: 'error' });
                        document.querySelector('#check-result').appendChild(alertElmt);
                }
            },
            errCallback: function () {
                alert('TODO');
            }
        });
    },
 
    checkserverIdentVisiblity: function () {
        var valueDbType = document.getElementById("db-select").value;
        if (valueDbType == 'mysql' || valueDbType == 'pgsql' ){
            document.querySelector('#server-idents').classList.add('active');
            document.querySelector('#db-idents').classList.add('active');
        } else {
            document.querySelector('#server-idents').classList.remove('active');
            document.querySelector('#db-idents').classList.remove('active');
        }
    },

    install: function () {
        document.querySelector('#install-loader').classList.add('active');
        var selectedLang    = document.querySelector('select#language-select').value,
            valueDbName     = document.getElementById("db_name").value,
            valueAdminName  = document.getElementById("admin_name").value,
            valueAdminMail  = document.getElementById("admin_email").value,
            valueAdminPass  = document.getElementById("admin_password").value,
            requestData     = "admin_name=" + valueAdminName + 
                              "&admin_email=" + valueAdminMail + 
                              "&admin_password=" + valueAdminPass +
                              "&db_name=" + valueDbName +
                              '&language=' + selectedLang ;

        Minikit.ajax({
            url: window.location.origin + '/setup/install',
            data: requestData,
            method: 'POST',
            callback: function (response) {
                document.querySelector('#install-loader').classList.remove('active');
                switch (response.status) {
                    case 200:
                        var result = JSON.parse(response.responseText);
                        var alertElmt = Minikit.Alerts.create(result.message, { type: 'success' });
                        document.querySelector('#install-result').appendChild(alertElmt);
                        break;

                    default:
                        var errorMsg = '';
                        var result = JSON.parse(response.responseText);
                        for (var i = 0; i < result.errors.length; i++) {
                            errorMsg += '<br> -> '  + result.errors[i].message;
                        }
                        var alertElmt = Minikit.Alerts.create('Oops! Something was wrong somewhere...' + errorMsg, { type: 'error' });
                        document.querySelector('#install-result').appendChild(alertElmt);
                }
            },
            errCallback: function () {
                var alertElmt = Minikit.Alerts.create('Oops! Something was wrong somewhere...', { type: 'error' });
                document.querySelector('#install-loader').classList.remove('active');
                document.querySelector('#install-result').appendChild(alertElmt);
            }
        });

    }

}

// start our application
Minikit.ready(function () {
    Minitoring.Setup.start();
});