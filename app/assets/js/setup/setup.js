

// main application
Minitoring.Setup = {

    // init
    start: function () {

        var wiz = new Minikit.Wizard(document.querySelector('.wizard'));
        wiz.onIndexChanged(function (e) {

            // update progress
            var current = ((e.detail.newIndex + 1) / e.detail.total) * 100;
            wiz.html.querySelector('.wizard-progress-inner').style.width = current + '%';

            var nextbuttontext = 'Next';

            switch (e.detail.newIndex) {
                case 0:
                    break;
                case 1:
                    Minitoring.Setup.checkForInstall();
                    break;
                case 2:
                    Minitoring.Setup.checkInput();
                    break;
                case 6:
                    nextbuttontext = 'install'
                    break;
                case 7:
                    wiz.html.querySelector('.wizard-button-prev').style.display = 'none';
                    nextbuttontext = 'close'
                    Minitoring.Setup.install();
                    break;
            }

            //nextbuttontext = 'install';
            //nextbuttontext = 'close';

            wiz.html.querySelector('.wizard-button-next').innerHTML = nextbuttontext;
        });

        wiz.onClosed(function () {
            location.reload();
        });

        wiz.index(0);
        document.querySelector('.wizard-overlay').classList.add('active');

    },
    checkForInstall: function () {
        // clear message
        document.querySelector('#check-list').innerHTML = '';
        document.querySelector('#check-result').innerHTML = '';

        // perform query
        var args = '?requestDate=' + new Date().getTime();

        Minikit.ajax({
            url: window.location.origin + '/setup/check' + args,
            method: 'GET',
            callback: function (response) {
                switch (response.status) {
                    case 200:
                        var alertElmt = Minikit.Alerts.create('Fine, all checks passed.', { type: 'success' });
                        document.querySelector('#check-result').appendChild(alertElmt);

                        break;

                    default:
                        var errorMsg = '';
                        var result = JSON.parse(response.responseText);
                        for (var i = 0; i < result.errors.length; i++) {
                            errorMsg += '<br> -> '  + result.errors[i].message;
                        }
                        var alertElmt = Minikit.Alerts.create('Please fix error(s) bellow before continue:' + errorMsg, { type: 'error' });
                        document.querySelector('#check-result').appendChild(alertElmt);
                }
            },
            errCallback: function () {
                alert('TODO');
            }
        });
    },
    checkInput: function () {
      //  var valueDbType = document.getElementById("db_type").value;

    },
    install: function () {
        var valueDbName = document.getElementById("db_name").value;
        var valueAdminName = document.getElementById("admin_name").value;
        var valueAdminMail = document.getElementById("admin_email").value;
        var valueAdminPass = document.getElementById("admin_password").value;
        var requestData = "admin_name=" + valueAdminName + 
                          "&admin_email=" + valueAdminMail + 
                          "&admin_password=" + valueAdminPass +
                          "&db_name=" + valueDbName;

        Minikit.ajax({
            url: window.location.origin + '/setup/install',
            data: requestData,
            method: 'POST',
            callback: function (response) {
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
                document.querySelector('#install-result').appendChild(alertElmt);
            }
        });

    }

}

// start our application
Minikit.ready(function () {
    Minitoring.Setup.start();
});