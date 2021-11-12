/*
 *        _      _ _           _
 *  _ __ (_)_ _ (_) |_ ___ _ _(_)_ _  __ _
 * | '  \| | ' \| |  _/ _ \ '_| | ' \/ _` |
 * |_|_|_|_|_||_|_|\__\___/_| |_|_||_\__, |
 *                                   |___/
 * 
 * This file is part of Kristuff\Minitoring.
 * (c) Kristuff <kristuff@kristuff.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @version    0.1.20
 * @copyright  2017-2021 Kristuff
 */

/* global namespace */
var Minitoring = Minitoring || {};


/* main application */
Minitoring.App = {
    init: function () {
        Minitoring.View.init();
        Minitoring.LoadAverage.init();
        Minitoring.Swap.init();
        Minitoring.Memory.init();
        Minitoring.Disks.init();
        Minitoring.SystemUsers.init();
        Minitoring.Logs.init();
        Minitoring.Iptables.init();
        Minitoring.Packages.init();
        Minitoring.App.getApiKey(function () {
            Minitoring.Settings.loadUserSettings();
            Minitoring.View.updateActiveView(Minitoring.View.getCurrentView());
            Minitoring.App.getFeedback();
        });
        Minitoring.UI.initTableSearch();
    },
    setNotif: function(type,message) {
        Minitoring.App.toast = Minitoring.App.toast || new Minikit.Toasts();
        Minitoring.App.toast.show(type,message)    
    },
    getApiKey: function (callback) {
        Minitoring.Api.apiRequest('GET', 'api/app/auth', null, function(response){
            Minitoring.Api.key = response.data.key;
            Minikit.isFn(callback, true);
        });
    },
    getFeedback: function () {
        Minitoring.Api.apiRequest('GET', 'api/app/feedback', null, function(apiResponse) {

            var type = apiResponse.data.feedbackNegatives.length > 0 ? 'error' : 'success';
            var msg = '';

            if (apiResponse.data.feedbackNegatives && apiResponse.data.feedbackNegatives.length > 0){
                msg += apiResponse.data.feedbackNegatives.map(function (msg){
                    return msg;
                }).join('<br>');
            }
            if (apiResponse.data.feedbackPositives && apiResponse.data.feedbackPositives.length > 0){
                msg += apiResponse.data.feedbackPositives.map(function (msg){
                    return msg;
                }).join('<br>');
            }
            if (Minikit.isObj(msg)) {
                Minitoring.App.setNotif(type, msg);
            } 
        });
    },
};

// init and start Application 
Minikit.ready(function () {
    // register in window TODO
    window.Minitoring = Minitoring;
    Minitoring.App.init();
});

/* --- Api --- */
Minitoring.Api = {
    _socketConnection:null,
    key:null,
    
    // toast notif with api response message or errors
    notifyApiResponse: function(apiResponse) {
        var msg = apiResponse.message;
        if (apiResponse.errors && apiResponse.errors.length > 0){
            msg += apiResponse.errors.map(function (error){
                return error.message;
            }).join('<br>');
        }
        if (Minikit.isObj(msg)) {
            Minitoring.App.setNotif(apiResponse.code >= 400 ? 'error' : 'success', msg);
        } 
    },
    apiRequest: function (method, url, args, successCallback, errorCallback) {
        var nocache = 'requestDate=' + new Date().getTime() + 
                      '&token=' + document.querySelector('body[data-api-token]').getAttribute('data-api-token'),
            args = Minikit.isObj(args) ? args + '&' + nocache : nocache;


        var handleError = function(errorCallback, response){
            if (response.code == 401){
                window.location.href =  window.location.origin;
            } else {
                if (Minikit.isFn(errorCallback)) {
                    errorCallback(response);
                } else {
                    Minitoring.Api.notifyApiResponse(response);    
                };
            }
        }

        // perform query
        Minikit.ajax({
            url: window.location.origin + '/' + url + ((method != 'POST') ? '?' + args : ''),
            method: method,
            data: (method === 'POST') ? args : null,
            callback: function (response) {
                var result = JSON.parse(response.responseText);
                if (Minikit.isFn(successCallback)) {
                    if (result.success){
                        successCallback(result);
                    } else {
                        handleError(errorCallback, result);
                    }
                }
            },
            errCallback: function (response) {
                var result = JSON.parse(response.responseText);
                handleError(errorCallback, result);
            }
        });
    },
    ajaxPostFile:function (args) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', window.location.origin + '/' + args.url, true);
        //xhr.setRequestHeader('Accept', 'application/json');
        //xhr.setRequestHeader('Content-type', 'multipart/form-data');

        xhr.addEventListener('error', function(evt){
            if (Minikit.isFn(args.errorCallback)){
                args.errorCallback(evt);
            }
        }, false);
        xhr.upload.onprogress = function(evt) {
            if (Minikit.isFn(args.onprogress)){
                if (evt.lengthComputable) {
                    args.onprogress(evt);
                }
            };
        };
        xhr.upload.addEventListener('load', function(evt) {
            if (Minikit.isFn(args.onload)){
                args.onload(evt);
            };
        }, false)
        xhr.upload.addEventListener('loadstart', function(evt) {
            if (Minikit.isFn(args.onloadstart)){
                args.onloadstart(evt);
            };
        }, false)
        xhr.addEventListener('readystatechange', function(evt){
            if ((evt.target.readyState === 4) && (evt.target.status > 101) && (Minikit.isFn(args.onsuccess) === true)) {
                args.onsuccess(evt);
            } 
        }, false);

        xhr.send(args.data);
    },
    get: function (url, args, callback, errorCallback) {
        Minitoring.Api.apiRequest('GET', url, args, callback, errorCallback);
    },
    post: function (url, args, callback, errorCallback) {
        Minitoring.Api.apiRequest('POST', url, args, callback, errorCallback);
    },
    put: function (url, args, callback, errorCallback) {
        Minitoring.Api.apiRequest('PUT', url, args, callback, errorCallback);
    },
    delete: function (url, args, callback, errorCallback) {
        Minitoring.Api.apiRequest('DELETE', url, args, callback, errorCallback);
    },

    socketApiRequest:function(request, successCallback, errorCallback) {

        var handleMessage = function(e, successCallback, errorCallback){
            var result = JSON.parse(e.data);
            if (result.success) {
                if (Minikit.isFn(successCallback)) successCallback(result);
            } else {
                if (Minikit.isFn(errorCallback)) {
                    errorCallback(result);
                } else {
                    Minitoring.Api.notifyApiResponse(result);
                }
            };
        }
        
        var conn = Minitoring.Api._socketConnection;

        // 2 closing / 3 closed 
        if (!Minikit.isObj(conn) || conn.readyState == 2 || conn.readyState == 3){
            
            // create a (secure) websocket connexion like       wss://example.com/wssapi
            // should work as well with localhost with no SSL   ws://localhost/wssapi
            var origin = (window.location.protocol == 'https:' ? 'wss://' : 'ws://') +  window.location.host; 
            conn = new WebSocket(origin + '/wssapi');
            Minitoring.Api._socketConnection = conn;
        }

        conn.onmessage = function(e) {
            // DEBUG console.log(e.data);
            handleMessage(e, successCallback, errorCallback);
        };

        // 1 open / 0 connecting...
        if (conn.readyState == 0){
            conn.onopen = function(e) {
                // console.log("Connection established!");
                // console.log(request);
                conn.send(JSON.stringify(request));
            };
        } else {
            conn.send(JSON.stringify(request));
        }
      
    }
}
/* --- Profile --- */
Minitoring.Profile = {

    editUserNameOrEmail:function() {
        var newName = document.querySelector('#profile_user_name').value,
            newEmail =  document.querySelector('#profile_user_email').value,
            args = 'user_email=' + newEmail + '&user_name=' + newName;

        Minitoring.Api.post('api/profile/' , args, function (apiResponse) {
            Minitoring.App.setNotif(apiResponse.code >= 400 ? 'error' : 'success', apiResponse.message);
            if (apiResponse.code < 400) {
                document.querySelector('#current-user .user-name').innerHTML = newName;
                document.querySelector('#current-user .user-email').innerHTML = newEmail;
                document.querySelector('#profile-card-name').innerHTML = newName;
                document.querySelector('#profile-card-email').innerHTML = newEmail;
            }
        });
    },

    editPassword:function() {
        var args = 'user_password_current=' + document.querySelector('#input_change_password_current').value +
                  '&user_password_new=' + document.querySelector('#input_change_password_new').value +
                  '&user_password_repeat=' + document.querySelector('#input_change_password_repeat').value;
 
        Minitoring.Api.post('api/profile/password' , args, function (apiResponse) {
            Minitoring.App.setNotif(apiResponse.code >= 400 ? 'error' : 'success', apiResponse.message);
            document.querySelector('#input_change_password_current').value = '';
            document.querySelector('#input_change_password_new').value = '';
            document.querySelector('#input_change_password_repeat').value = '';
        });
    },

    editAvatar:function() {
        var formdata = new FormData();      
        var divProgress = document.getElementById('avatar-upload-progress');
        var progressbar = document.getElementById('avatar-upload-progressbar');
        var selectText  = document.getElementById('avatar-file-upload').getAttribute('data-text');
        var labelFile   = document.querySelector('#avatar-file-upload .label-file');
        formdata.append('token', document.querySelector('body[data-api-token]').getAttribute('data-api-token'));
        formdata.append('USER_AVATAR_file', document.getElementById("USER_AVATAR_file").files[0]);

        Minitoring.Api.ajaxPostFile({
            url: 'api/profile/avatar' , 
            data: formdata, 
            onsuccess: function (evt) {
                var apiResponse = JSON.parse(evt.target.responseText)
                document.getElementById('avatar-preview').src = apiResponse.data.userAvatarUrl;
                document.querySelector('#current-user .avatar').src = apiResponse.data.userAvatarUrl;
                document.querySelector('#profile-card-avatar').src = apiResponse.data.userAvatarUrl;
                progressbar.classList.remove('active');
                Minitoring.Api.notifyApiResponse(apiResponse);
                Minitoring.Profile.updateDeleteAvatarButtonState(apiResponse.data.userHasAvatar);
                document.getElementById("USER_AVATAR_file").value = '';
                divProgress.innerHTML = '';
                labelFile.innerHTML = selectText;
            }, 
            onprogress: function (evt) {
                var percent = (evt.loaded /evt.total)*100;
                divProgress.innerHTML = 'Progress: ' + Math.round(percent) + '%'; //+ ' loaded:' + evt.loaded+ ' total:' + evt.total;
                progressbar.classList.add('active');
                progressbar.value = evt.loaded;
                progressbar.max = evt.total;

            },
            onload: function (evt) {
                //var apiResponse = JSON.parse(evt.target.responseText)
                divProgress.innerHTML = 'File uploaded, waiting for server response...';
            }, 
            onerror: function (evt) {
                var apiResponse = JSON.parse(evt.target.responseText)
                Minitoring.Api.notifyApiResponse(apiResponse);
                Minitoring.Profile.updateDeleteAvatarButtonState(apiResponse.data.userHasAvatar);
                progressbar.classList.remove('active');
                divProgress.innerHTML = '';
                document.getElementById("USER_AVATAR_file").value = '';
                labelFile.innerHTML = selectText;
            }
        });
    },
    
    deleteAvatar:function() {
        Minitoring.Api.post('api/profile/avatar/delete' , null, function (apiResponse) {
            document.getElementById('avatar-preview').src = apiResponse.data.userAvatarUrl;
            document.querySelector('#current-user .avatar').src = apiResponse.data.userAvatarUrl;
            document.querySelector('#profile-card-avatar').src = apiResponse.data.userAvatarUrl;
            Minitoring.Profile.updateDeleteAvatarButtonState(apiResponse.data.userHasAvatar);
            Minitoring.Api.notifyApiResponse(apiResponse);
        }, function (apiResponse) {
            Minitoring.Api.notifyApiResponse(apiResponse);
            Minitoring.Profile.updateDeleteAvatarButtonState(apiResponse.data.userHasAvatar);
        });
    },

    updateDeleteAvatarButtonState:function(hasAvatar){
        var bt = document.getElementById('delete-avatar-button');
        if (hasAvatar) {
            bt.classList.add('active');
        } else {
            bt.classList.remove('active');
        }
    },

    avatarPreviewChanged: function (){
        var fileInput = document.getElementById('USER_AVATAR_file');
        if (Minikit.isObj(fileInput) && Minikit.isObj(fileInput.files[0])){
            document.getElementById('avatar-preview').src = URL.createObjectURL(fileInput.files[0]);
            document.querySelector('#avatar-file-upload .label-file').innerHTML = fileInput.files[0].name;
        }
    }
}

/* --- Settings --- */
Minitoring.Settings = {

    loadUserSettings: function () {
        Minitoring.Api.get('api/users/self/settings' , null, function (apiResponse) {
            Minitoring.Settings.setTheme(apiResponse.data.UI_THEME ? apiResponse.data.UI_THEME : 'dark');
            Minitoring.Settings.setThemeColor(apiResponse.data.UI_THEME_COLOR ? apiResponse.data.UI_THEME_COLOR : 'green');
        });
    },

    setTheme:function(theme){
        document.body.setAttribute("data-theme", theme)
    },
    
    setThemeColor:function(color){
        document.body.setAttribute("data-color", color)
    },

    themeChanged: function () {
        var newtheme = document.getElementById('select-theme').value;
        Minitoring.Settings.updateSettingValue('UI_THEME', newtheme, function() {
            Minitoring.Settings.setTheme(newtheme);
        });
    },

    languageChanged: function () {
        var newValue = document.getElementById('select-language').value,
            currentValue = document.querySelector('body').getAttribute('data-language');

            if (newValue && newValue != currentValue){
                Minitoring.Settings.updateSettingValue('UI_LANG', newValue, function() {
                    window.location.reload();
                });
            }
    },

    themeColorChanged: function () {
        var newcolor = document.getElementById('select-theme-color').value;
        Minitoring.Settings.updateSettingValue('UI_THEME_COLOR', newcolor, function() {
            Minitoring.Settings.setThemeColor(newcolor);
        });
    },

    updateSettingValue: function (paramName, value, onSuccess) {
         Minitoring.Api.put('api/users/self/settings', 'parameter=' + paramName + '&value=' + value, onSuccess);
    },

    // reset current user settings  
    resetCurrent: function () {
        Minikit.dialog({
            message: document.querySelector("#reset-settings-button").getAttribute('data-dialog-text'),
            cancelable: true,
            type: 'warning',
            okButtonText: document.querySelector('.dialog-button-ok').innerHTML,
            cancelButtonText: document.querySelector('.dialog-button-cancel').innerHTML,
            callback: function(){
                Minitoring.Api.delete('api/users/self/settings', '', function (apiResponse) {
                    Minitoring.Api.notifyApiResponse(apiResponse);
                    Minitoring.Settings.loadUserSettings();
                });            
            }
        });
    }
}

/* --- UI utils --- */
Minitoring.UI = {

    // init a gauge element for given selector
    createGauge: function(selector) {
        return Gauge(document.querySelector(selector), { 
           max: 100, 
           dialStartAngle: 180, 
           dialEndAngle: 0, 
           value: 0, 
           label: function (value) { 
                var rounded = Math.round(value * 10) / 10;
                return rounded.toString() + "%";
                //return Math.round(value) + "%";
            } 
        });
    },

    getPaginatorHtml: function (limit, offset, total) {
        var html = '';
        var maxIndex = Math.ceil(total / limit);
        var currentIndex = offset > 0 ? Math.ceil(offset / limit) + 1 : 1;

        html += '<a href="#" class="previous" ' + (offset > 0 ? ' data-offset="' + (offset - limit) + '"' : ' data-disabled') + '><i class="fa fa-chevron-left"></i></a>';
        for (var i = 1; i <= maxIndex; i++) {
            html += '<a href="#" class="item ' + (i === currentIndex ? 'current' : '') + '" data-offset="' + ((i - 1) * limit) + '">' + i + '</a>';
        }
        html += '<a href="#" class="next" ' + (currentIndex < maxIndex ? ' data-offset="' + (offset + limit) + '"' : ' data-disabled') + '><i class="fa fa-chevron-right"></i></a>';
        return html;
    },
 
    getLoader:function() {
        return '<div class="loader"><i class="fa fa-2x fa-spinner fa-pulse color-theme"></i></div>';
    },
 
    getTableLoader:function(colspan) {
//      return '<tr class="table-loader no-style"><td class="align-center color-light" colspan="' + colspan + '"><i class="fa fa-2x fa-spinner fa-pulse"></i></td></tr>';
        return '<tr class="table-loader no-style"><td class="align-center color-light" colspan="' + colspan + '"><i class="fa fa-2x fa-circle-o-notch fa-spin fa-fw color-theme"></i></td></tr>';
    },
      
    getFormattedDate :function(value){
        return Minikit.isObj(value) ? Minikit.Format.date(value, '{DD}/{MM}/{YYYY} {hh}:{mm}', true) : '';  
    },

    initTableSearch: function(){
        Array.prototype.forEach.call(document.querySelectorAll('input.search[data-table-target]'), function(element){
            tableFilter.init(element)
        });
    }
}


 // table filtering
 var tableFilter = (function(Arr) {
    var _input;

    function _onInputEvent(e) {
        _input = e.target;
        var tableBody = document.querySelector('table#' + e.target.getAttribute('data-table-target') + ' tbody');
        Arr.forEach.call(tableBody.rows, _filter);
    }

    function _filter(row) {
        var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
        
        if (_input.value == ""){
            row.classList.remove('filter-show');
            row.classList.remove('filter-hide');
            return;
        }
        if (row.classList.contains('group-row')){
            row.classList.add('filter-hide');
            return;
        } 

        //row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
        if (text.indexOf(val) === -1){
            row.classList.remove('filter-show');
            row.classList.add('filter-hide');
        } else {
            row.classList.add('filter-show');
            row.classList.remove('filter-hide');
        }

    }

    return {
        init: function(input) {
            if (input) {
                input.oninput = _onInputEvent;
            }
        }
    };
})(Array.prototype);

/* --- Utils --- */
Minitoring.Utils={
    ipAction: {},

    getIpLink: function (IP, service) {
        switch(service){
            case 'abuseipdb':
            case 'abuseipdb.com':
                return '<a href="https://www.abuseipdb.com/check/' + IP + '" target="linkout" class="color-theme">' + IP + '</a>';

            case 'geoip':
            case 'geodatatool':
            case 'geodatatool.com':
                return '<a href="https://www.geodatatool.com/en/?IP=' + IP + '" target="linkout" class="color-theme">' + IP + '</a>';

            default:
                return '<span>' + IP + '</span>';
        }
    }
} 

/* handle navigation */
Minitoring.View = {
    htmlContainer: {}, 
    htmlOverlay: {},
    htmlHeaderTitle: {}, 
    htmlHeaderSubTitle: {},
    //htmlBackButton: {},
    sideMenu: {},
  
    // navigate to given url
    navigate: function (url) {
        var target = Minitoring.View.getUrlTarget(url);
        Minitoring.View.updateActiveView(target);

        // make sure we close menu in mobile view 
        sideMenu.classList.remove('open');
    },

    // get the url target 
    getUrlTarget: function(url){
        var parser = new URL(url),
            target = parser.pathname;

        if (target.endsWith('/'))   { target = target.substr(0, target.length - 1); }
        if (target.startsWith('/')) { target = target.substr(1, target.length - 1); }
        return target;
    },

    // handle links click for ajax navigation
    handleLinkClick: function(e){
        var element = e.target.closest('a[data-view]');
        if (Minikit.isObj(element) && Minikit.Event.isLeftButton(e)) {
            e.preventDefault();

            var url = element.getAttribute('href');
            Minitoring.View.navigate(url);
            Minikit.Browser.changeURL(url);
        }; 
    },

    getViewPanel:function(target, basetarget)
    {
        // Get the panel associated to this view
        var panel = document.querySelector('.view[data-view="' + target +'"]');
        if (Minikit.isObj(panel)) {
            return panel;
        }

        // no corresponding panel, so it's a sub view, so get the base panel
        panel = document.querySelector('.view[data-view="' + basetarget +'"]');
        if (Minikit.isObj(panel)) {
            return panel;
        }

        // not found...
        return null;
    },

    // update current view
    updateActiveView:function(target){
        
        // get the base target
        var baseTarget =  target.split('/')[0];

        // Get the panel associated to this view
        var viewPanel = Minitoring.View.getViewPanel(target, baseTarget);
        if (Minikit.isObj(viewPanel)) {
        
            // Hide all view
            Array.prototype.forEach.call(document.querySelectorAll('.view[data-view]'), function (elmt) {
                elmt.classList.remove('active');
            });

            // show current view and 
            // store the current view id
            viewPanel.classList.add('active');
            htmlContainer.setAttribute('data-current-view', target);

            // sync active menu item
            Array.prototype.forEach.call(document.querySelectorAll('.menu-item a[data-view]'), function (elmt) {
                if (elmt.getAttribute('data-view') === baseTarget) {
                    elmt.classList.add('active');
                } else {
                    elmt.classList.remove('active');
                }
            });
                
            // sync active sub menu item (if exists)
            Array.prototype.forEach.call(viewPanel.querySelectorAll('.tab-item a[data-view]'), function (elmt) {
                if (elmt.getAttribute('data-view') === target) {
                    elmt.closest('.tab-item').classList.add('current');
                } else {
                    elmt.closest('.tab-item').classList.remove('current');
                }
            });

            // set back button visibility
            //if (target != baseTarget) {
            //    htmlBackButton.classList.add('active');
            //} else {
            //    htmlBackButton.classList.remove('active');
            //}
            
            // auto action
            refreshAction = viewPanel.getAttribute('data-refresh');
            if (refreshAction) {
                Minikit.executeFunctionByName(refreshAction);
            }

            // sync current view param and title
            Minitoring.View.updateTitle(viewPanel);
        }
    },

    //TODO
    updateTitle: function (viewPanel) {
        htmlHeaderTitle.innerHTML = viewPanel.getAttribute('data-title');
    },

    // get the current view
    getCurrentView: function () {
        return htmlContainer.getAttribute('data-current-view');
    },   
    
    // back trigger
    goBack: function(){
        Minikit.Browser.goBack();
    },

    // init module
    init: function () {
        
        // init static elements
        htmlContainer   = document.querySelector('#main-container');
        htmlOverlay     = document.querySelector('main-container > .overlay');
        htmlHeaderTitle = document.querySelector('#header-title');
     // htmlHeaderSubTitle = document.querySelector('#header-subtitle');
     // htmlBackButton  = document.querySelector('.back-trigger');
        sideMenu        = document.querySelector('#side-menu');

        // detect links
        document.addEventListener('click', Minitoring.View.handleLinkClick);             

        window.onpopstate = function () {
            Minitoring.View.navigate(location.href);
        };
    }
}



/* --- Cron --- */
Minitoring.Cron = {
    getList:function(){
        // temp loader
        document.querySelector('table#users-cron-list tbody').innerHTML = Minitoring.UI.getTableLoader(4);
        document.querySelector('table#system-cron-list tbody').innerHTML = Minitoring.UI.getTableLoader(5);
        document.querySelector('table#system-timer-list tbody').innerHTML = Minitoring.UI.getTableLoader(6);

        Minitoring.Api.socketApiRequest({
            command:"crons",
            key: Minitoring.Api.key
        }, function (response) {
            var html = '', htmlSystem = '', htmlTimers = '';
            
            // user crons 
            for (var i = 0; i < response.data.users.length; i++) {
                html += '<tr>'; 
                html += '<td data-column="User">' + response.data.users[i].user + '</td>'; 
                html += '<td data-column="Time Expression">' + response.data.users[i].timeExpression + '</td>'; 
                html += '<td data-column="Command">' + response.data.users[i].command + '</td>'; 
                html += '<td data-column="Next Run Date"><span class="badge" data-badge="info">' + response.data.users[i].nextRunDate + '</span></td>'; 
                html += '</tr>'; 
            }
            document.querySelector('table#users-cron-list tbody').innerHTML = html;
            
            // system crons
            for (var i = 0; i < response.data.system.length; i++) {
                for (var ii = 0; ii < response.data.system[i].scripts.length; ii++) {
                    htmlSystem += '<tr>'; 
                    htmlSystem += '<td data-column="Time Expression">' + response.data.system[i].timeExpression + '</td>'; 
                    htmlSystem += '<td data-column="Script">' + response.data.system[i].scripts[ii].path + '</td>'; 
                    htmlSystem += '<td data-column="Type">' + response.data.system[i].scripts[ii].type + '</td>'; 
                    htmlSystem += '<td data-column="Command">' + response.data.system[i].command + '</td>'; 
                    htmlSystem += '<td data-column="Next Run Date"><span class="badge" data-badge="info">' + response.data.system[i].nextRunDate + '</span></td>'; 
                    htmlSystem += '</tr>'; 
                }
            }

             // system crons (crond)
            for (var i = 0; i < response.data.crond.length; i++) {
                htmlSystem += '<tr>'; 
                htmlSystem += '<td data-column="Time Expression">' + response.data.crond[i].timeExpression + '</td>'; 
                htmlSystem += '<td data-column="Script">' + response.data.crond[i].path + '</td>'; 
                htmlSystem += '<td data-column="Type">Command</td>'; 
                htmlSystem += '<td data-column="Command">' + response.data.crond[i].command + '</td>'; 
                htmlSystem += '<td data-column="Next Run Date"><span class="badge" data-badge="info">' + response.data.crond[i].nextRunDate + '</span></td>'; 
                htmlSystem += '</tr>'; 
            }
            document.querySelector('table#system-cron-list tbody').innerHTML = htmlSystem;

            // system timers 
            for (var i = 0; i < response.data.timers.length; i++) {
                htmlTimers += '<tr>'; 
                htmlTimers += '<td data-column="Unit">'         + response.data.timers[i].unit      + '</td>'; 
                htmlTimers += '<td data-column="Activates">'    + response.data.timers[i].activates + '</td>'; 
                htmlTimers += '<td data-column="Passed">'       + response.data.timers[i].passed    + '</td>'; 
                htmlTimers += '<td data-column="Last">'         + response.data.timers[i].last      + '</td>'; 
                htmlTimers += '<td data-column="Left">'         + response.data.timers[i].left + '</td>'; 
                htmlTimers += '<td data-column="Next"><span class="badge" data-badge="info">' + response.data.timers[i].next + '</span></td>'; 
                htmlTimers += '</tr>'; 
            }

            document.querySelector('table#system-timer-list tbody').innerHTML = htmlTimers;
        });
    }
}
/* --- Dashboard --- */
Minitoring.Dashboard = {
    refresh: function () {
        Minitoring.SystemInfos.get();
        Minitoring.LoadAverage.get();
        Minitoring.Cpu.get();
        Minitoring.Swap.get();
        Minitoring.Memory.get();
        Minitoring.Process.get();
        Minitoring.Services.refresh();
        Minitoring.Disks.refresh();
        Minitoring.Network.get();
        Minitoring.SystemUsers.getNumberActive();
        Minitoring.Packages.refreshAll();
        Minitoring.Ping.refresh();
    }
}

/* --- Disks --- */
Minitoring.Disks = {
    gauge: {},
    gaugeInodes: {},
    init: function () {
        Minitoring.Disks.gauge = Minitoring.UI.createGauge("#disks-gauge");
        Minitoring.Disks.gaugeInodes = Minitoring.UI.createGauge("#inodes-gauge");
    },

    refresh: function() {
        Minitoring.Disks.getInodesUsage();
        Minitoring.Disks.getDisksUsage();
    },
   
    getDisksUsage: function () {
        document.querySelector('#disks-table tbody').innerHTML = Minitoring.UI.getTableLoader(7);
        Minitoring.Api.get('api/system/disks', null, function (result) {

                switch (Minitoring.View.getCurrentView()) {
                    case 'overview':
                        var alertWarningCount = 0;
                        var alertErrorCount = 0;

                        for (var i = 0; i < result.data.disks.length; i++) {
                            switch (result.data.disks[i].alertCode) {
                                case 1: alertWarningCount++; break;
                                case 2: alertErrorCount++; break;
                            }
                        }
                        Minitoring.Disks.gauge.setValueAnimated(result.data.totalPercentUsed, 1);
                        document.querySelector("#disks-gauge").setAttribute('data-alert-code', result.data.alertCode);
                        document.querySelector("#disks-gauge").setAttribute('data-bottom', result.data.totalUsed + '/' + result.data.total + ' used');

                        var alertHtml = alertErrorCount > 0 ? '<span id="badge-disks-error" class="badge" data-badge="error" data-alert-code="2">' + alertErrorCount + '</span>' : '';
                        alertHtml +=  alertWarningCount > 0 ? '<span id="badge-disks-warning" class="badge" data-badge="warning" data-alert-code="1">' + alertWarningCount + '</span>' : ''
                        document.querySelector('#disks-alerts').innerHTML = alertHtml;
                        break;

                    case 'disks':

                        var html = '';
                            //txtTotal = document.querySelector('#')
                        for (var i = 0; i < result.data.disks.length; i++) {
                            html += Minitoring.Disks.getHtml(result.data.disks[i]);
                        }


                        // total row
                        html += '<tr class="row-total" data-alert-code="' + result.data.alertCode + '">';
                        html += '<td colspan="3">Total:</td>';
                        html += '<td data-column="% used" class="align-right"><div class="progress-bar" data-alert-code="' + result.data.alertCode + '" data-value="' + result.data.totalPercentUsed + '"><div class="progress-bar-placeholder">' + result.data.totalPercentUsed + '%</div><div class="progress-bar-inner"></div></div></td>';
                        html += '<td data-column="Used" class="align-right">'  + result.data.totalUsed + '</td>';
                        html += '<td data-column="Free" class="align-right">'  + result.data.totalFree + '</td>';
                        html += '<td data-column="Total" class="align-right">' + result.data.total     + '</td>';
                        html += '</tr>';

                        document.querySelector('#disks-table tbody').innerHTML = html;
                        Minikit.each(document.querySelectorAll('#disks-table tbody .progress-bar'), function (element) {
                            var value = element.getAttribute('data-value');
                            element.querySelector('.progress-bar-inner').style.width = value + '%';
                        });

                        break;
                }
            }
        );
    },

    getInodesUsage: function() {
        document.querySelector('#inodes-table tbody').innerHTML = Minitoring.UI.getTableLoader(7);

        Minitoring.Api.get('api/system/inodes', null, function (result) {
            
            switch (Minitoring.View.getCurrentView()) {
                case 'overview':
                    var alertWarningCount = 0;
                    var alertErrorCount = 0;

                    for (var i = 0; i < result.data.inodes.length; i++) {
                        switch (result.data.inodes[i].alertCode) {
                            case 1: alertWarningCount++; break;
                            case 2: alertErrorCount++; break;
                        }
                    }
                    Minitoring.Disks.gaugeInodes.setValueAnimated(result.data.totalPercentUsed, 1);
                    document.querySelector("#inodes-gauge").setAttribute('data-alert-code', result.data.alertCode);
                    document.querySelector("#inodes-gauge").setAttribute('data-bottom', result.data.totalUsed + '/' + result.data.total + ' used');

                    var alertHtml = alertErrorCount > 0 ? '<span id="badge-disks-error" class="badge" data-badge="error" data-alert-code="2">' + alertErrorCount + '</span>' : '';
                    alertHtml +=  alertWarningCount > 0 ? '<span id="badge-disks-warning" class="badge" data-badge="warning" data-alert-code="1">' + alertWarningCount + '</span>' : ''
                    document.querySelector('#inodes-alerts').innerHTML = alertHtml;
                    break;

                case 'disks':

                    var html = '';
                    for (var i = 0; i < result.data.inodes.length; i++) {
                        html += Minitoring.Disks.getHtml(result.data.inodes[i]);
                    }

                    // total row
                    html += '<tr class="row-total" data-alert-code="' + result.data.alertCode + '">';
                    html += '<td colspan="3">Total:</td>';
                    html += '<td data-column="% used" class="align-right"><div class="progress-bar" data-alert-code="' + result.data.alertCode + '" data-value="' + result.data.totalPercentUsed + '"><div class="progress-bar-placeholder">' + result.data.totalPercentUsed + '%</div><div class="progress-bar-inner"></div></div></td>';
                    html += '<td data-column="Used" class="align-right">'  + result.data.totalUsed + '</td>';
                    html += '<td data-column="Free" class="align-right">'  + result.data.totalFree + '</td>';
                    html += '<td data-column="Total" class="align-right">' + result.data.total     + '</td>';
                    html += '</tr>';

                    document.querySelector('#inodes-table tbody').innerHTML = html;
                    Minikit.each(document.querySelectorAll('#inodes-table tbody .progress-bar'), function (element) {
                        var value = element.getAttribute('data-value');
                        element.querySelector('.progress-bar-inner').style.width = value + '%';
                    });
                    break;
                }
        });
    },

    getHtml: function (item) {
        var html = '';
        html += '<tr data-alert-code="' + item.alertCode + '">';
        html += '<td data-column="Filesystem">' + item.filesystem + '</td>';
        html += '<td data-column="Type">'  + item.type + '</td>';
        html += '<td data-column="Mount">' + item.mount + '</td>';
        html += '<td data-column="% used" class="align-right"><div class="progress-bar" data-alert-code="' + item.alertCode + '" data-value="' + item.percentUsed + '"><div class="progress-bar-placeholder">' + item.percentUsed + '%</div><div class="progress-bar-inner"></div></div></td>';
        html += '<td data-column="Used"  class="align-right">' + item.used + '</td>';
        html += '<td data-column="Free"  class="align-right">' + item.free + '</td>';
        html += '<td data-column="Total" class="align-right">' + item.total + '</td>';
        html += '</tr>';
        return html;
    }
}
/* --- Fail2ban --- */
Minitoring.Fail2ban = {
    refresh: function (){

        // temp loader
        document.querySelector('table#fail2ban-jails tbody').innerHTML  = Minitoring.UI.getTableLoader(4);

        Minitoring.Api.socketApiRequest({
            command:"fail2ban_status",
            key: Minitoring.Api.key
        }, 
        function (result) {
            var html = '', badge = "error", status = 'STOPPED';
            for (var i = 0; i < result.data.jails.length; i++) {
                html += Minitoring.Fail2ban.getHtml(result.data.jails[i]);
            }
            if (result.data.status === 'active' ) {
                badge = "success";
                status = 'ACTIVE';
            }
            document.querySelector('table#fail2ban-jails tbody').innerHTML = html;
            document.querySelector('#fail2ban-server-version [data-column="Value"]').innerHTML = result.data.version;
            document.querySelector('#fail2ban-server-dbpath [data-column="Value"]').innerHTML = result.data.databasePath;
            document.querySelector('#fail2ban-server-dbsize [data-column="Value"]').innerHTML = result.data.databaseSize;
            document.querySelector('#fail2ban-server-status [data-column="Value"]').innerHTML = '<span class="badge" data-badge="' + badge + '">' + status + '</span>';
            document.querySelector('#fail2ban-jails-comment').innerHTML = "* Older ban was recorded " + result.data.olderBanAge;
        }, function (apiResponse) {
            Minitoring.Api.notifyApiResponse(apiResponse);
        });  
        
    },
    getHtml: function (item) {
        var html = '', badge = "error", status = 'DISABLED';
        if (item.enabled === 1 ) {
            badge = "success";
            status = 'ENABLED';
        }

        html += '<tr data-jail="' + item.name + '" ><td data-column="Name">' + item.name + '</td>';
  //      html += ' <td class="align-right tab-no-padding desk-no-padding" data-column="Actions">';
  //      html += '  <span class="row-actions visible-hover ">';
  //      html += '   <a class="row-button action-link" data-action="edit" data-id="' + item.name + '" data-color=""><i class="fa fa-pencil"></i></a>';
  //      html += '   <a class="row-button action-link" data-action="status" data-id="' + item.name + '" data-color=""><i class="fa fa-trash"></i></a>';
  //      html += '  </span>';
  //      html += ' </td>';
        html += '<td data-column="Status" class="align-center"><span class="badge" data-badge="' + badge + '">' + status + '</span></td>';
        html += '<td data-column="Logs files" class="align-right">' + item.logs + '</td>';
        html += '<td data-column="Total bans" class="align-right">' + item.bans +'</td>';
        html += '</tr>';
        return html;
    }
}
/* --- Iptables --- */
Minitoring.Iptables = {

    init: function(){
        Minikit.Event.add(document.querySelector('table#iptables-data '), 'click', function (e) {
            Minitoring.Iptables.tableClicked(e);
        });
        Minikit.Event.add(document.querySelector('table#ip6tables-data '), 'click', function (e) {
            Minitoring.Iptables.tableClicked(e);
        });
    },
  
    refreshIptables: function(){
        document.querySelector('table#iptables-data tbody').innerHTML   = Minitoring.UI.getTableLoader(7);
        Minitoring.Iptables.getIptablesData('iptables', 'table#iptables-data');

    },

    refreshIp6tables: function(){
        document.querySelector('table#ip6tables-data tbody').innerHTML  = Minitoring.UI.getTableLoader(7);
        Minitoring.Iptables.getIptablesData('ip6tables', 'table#ip6tables-data');
    },

   
    getIptablesData: function(iptablesCommand, tableSelector){
        Minitoring.Api.socketApiRequest({
            command:iptablesCommand,
            key: Minitoring.Api.key
        }, 
        function (result) {
            var html = '', rowId, numberItem, strNumber;
            var getIpLink = function(ip){
                return (ip == "0.0.0.0/0" || ip == "::/0") ? ip : Minitoring.Utils.getIpLink(ip, document.querySelector('body').getAttribute('data-ip-action'));
            };

//alert( result.data.chains.length + ' ' );// + result.data.chains[0] + ' ' + result.data.chains[0].rules.length );
            for (var i = 0; i < result.data.chains.length; i++) {
                numberItem = result.data.chains[i].rules.length;
                //if (numberItem = 0) {
                //    continue;
                //} else {
                    strNumber = '<span class="margin-left-6 color-light">(' + numberItem + ')</span>';
                //}
                rowId = Minikit.newId();
                html += '<tr class="group-row" data-rowid="' + rowId + '">';
                html += '<td class="align-left" colspan="6"><a class="toggle"><i class="fa fa-fw color-theme"></i>Chain: ' ;
                html += result.data.chains[i].chain;
                html += ' (';
                html += result.data.chains[i].policy;
                html += ')' + strNumber + '</a></td>';
                html += '</tr>';

                for (var ii = 0; ii < result.data.chains[i].rules.length; ii++) {
                    html += '<tr data-parentid="' + rowId + '" class="hidden">';
                    
                //    html += '<td data-column="Chain">'      + result.data.chains[i].chain + '</td>';
                //    html += '<td data-column="Policy">'     + result.data.chains[i].policy + '</td>';
                    html += '<td data-column="Group">'      +  '</td>';
                    html += '<td data-column="Target">'     + result.data.chains[i].rules[ii].target + '</td>';
                    html += '<td data-column="Protocol">'   + result.data.chains[i].rules[ii].protocol + '</td>';
                    html += '<td data-column="Source">'     + getIpLink(result.data.chains[i].rules[ii].source) + '</td>';
                    html += '<td data-column="Destination">' + getIpLink(result.data.chains[i].rules[ii].destination) + '</td>';
                    html += '<td data-column="Options">'    + result.data.chains[i].rules[ii].options + '</td>';
                    html += '</tr>';
                }
            }
            document.querySelector(tableSelector + ' tbody').innerHTML = html;
        }, function (apiResponse) {
            Minitoring.Api.notifyApiResponse(apiResponse);
        });
    },

    // "grouped row struff"
    tableClicked: function (e) {
        var row = e.target.closest('tr.group-row');
        if (Minikit.isObj(row)) {
            //e.preventDefault();

            var currentlyExpanded   = row.classList.contains('expanded'),
                expanded            = !currentlyExpanded;
                id                  = row.getAttribute('data-rowid');

            if (expanded) {
                row.classList.add('expanded');
                Array.prototype.forEach.call(document.querySelectorAll('tr[data-parentid="' + id + '"]'), function (el) {
                    el.classList.remove('hidden');
                });
            } else {
                row.classList.remove('expanded');
                Array.prototype.forEach.call(document.querySelectorAll('tr[data-parentid="' + id + '"]'), function (el) {
                    el.classList.add('hidden');
                });
            }

        }
    }
}
/* --- Logs --- */
Minitoring.Logs = {
    //autoRefresh:0,
    autoRefreshHandle:0,
    //defaultSettings:{},
    logList:{},
    $logFormats:{},

    init:function(){
        Minitoring.Logs.getLogFilesList();
    },

    refresh: function(){
        Minitoring.Logs.cleanAutoRefresh();
        if (Minikit.isObj(document.querySelector("select#select-log").value)){
            Minitoring.Logs.getLogs();
            Minitoring.Logs.setAutoRefresh();
        }
    },

    setAutoRefresh:function(){
        Minitoring.Logs.cleanAutoRefresh();

        var refreshValue = parseInt(document.querySelector('select#select-log-refresh').value);
        if (refreshValue > 0){
            //console.log('set autorefresh, value: ' +  refreshValue * 1000);
            Minitoring.Logs.autoRefreshHandle = setInterval(Minitoring.Logs.refresh, refreshValue * 1000);
        } else {
            Minitoring.Logs.cleanAutoRefresh();
        }
    },

    cleanAutoRefresh:function(){
        if (Minitoring.Logs.autoRefreshHandle > 0){
            //console.log('reset autorefresh');
            clearInterval(Minitoring.Logs.autoRefreshHandle);
            Minitoring.Logs.autoRefreshHandle = 0; // I just do this so I know I've cleared the interval
        }
    },
   
    getLogs: function(){

        var tableBody = document.querySelector('table#system-logs-table tbody'),
            tableHeader = document.querySelector('table#system-logs-table thead'),
            footer = document.querySelector('#system-logs-msg'),
            headerHtml = '',
            footerHtml = '', 
            html = '', 
            log, propertyName, columnDisplay, cellContent, statusCode, level, badge, bytes;


        // temp loader
        tableBody.innerHTML = Minitoring.UI.getTableLoader(10);
        footer.innerHTML = '';

        Minitoring.Api.socketApiRequest({
                command:"logs", 
                maxLines: document.querySelector("select#select-log-max").value,
                logId: document.querySelector("select#select-log").value,
                key: Minitoring.Api.key
            }, 
            function (response) {

                    // table header
                    headerHtml += '<tr>';
                    for (var i = 0; i < response.data.columns.length; i++) {
                        headerHtml += '<th data-column="' + response.data.columns[i].display + '">' + response.data.columns[i].display + '</th>';
                    }
                    headerHtml += '</tr>';
                    tableHeader.innerHTML = headerHtml;

                    // table content
                    for (var iLog = 0; iLog < response.data.logs.length; iLog++) {
                        html += '<tr>'; 
                        for (var iCol = 0; iCol < response.data.columns.length; iCol++) {
                            log = response.data.logs[iLog];
                            propertyName = response.data.columns[iCol].name;
                            columnDisplay = response.data.columns[iCol].display;

                            switch(propertyName){
                                case 'host':
                                case 'remoteIp':
                                    cellContent = Minitoring.Utils.getIpLink(log[propertyName], document.querySelector('body').getAttribute('data-ip-action'));
                                    //cellContent = '<a href="https://www.abuseipdb.com/check/' + log[propertyName]+ '" target="linkout" class="color-theme">' + log[propertyName]+ '</a>'
                                    //cellContent = '<a href="https://www.geodatatool.com/en/?IP=' + log[propertyName]+ '" target="linkout" class="color-theme">' + log[propertyName]+ '</a>'
                                    break;
                            
                                case 'sentBytes':
                                    bytes = parseInt(log[propertyName], 10);
                                    cellContent = Minikit.Format.bytes(bytes)
                                    break;

                                case 'status':
                                    statusCode = parseInt(log[propertyName], 10);
                                    badge = "success";
                                    if (statusCode >= 300) {badge = "warning";}
                                    if (statusCode >= 400) {badge = "error";}
                                    cellContent = '<span class="badge" data-badge="' + badge + '">' + log[propertyName] + '</span>';
                                    break;

                                case 'level':
                                    level = log[propertyName];
                                    badge = "success";
                                    switch (level){
                                        case "CRITICAL":
                                        case "ERROR":
                                        case "critical":
                                        case "error":
                                            badge = "error";
                                            break;
                                        case "DEBUG":
                                        case "debug":
                                        case "INFO":
                                        case "info":
                                                // case "NOTICE":
                                            badge = "info";
                                            break;
                                        default:
                                            badge = "warning";
    
                                    }
                                    cellContent = '<span class="badge" data-badge="' + badge + '">' + log[propertyName] + '</span>';
                                    break;

                                    
                                case 'time':
                                    cellContent = Minikit.Format.date(log['stamp'], '{YYYY}-{MM}-{DD} {hh}:{mm}:{ss}', true)
                                    break    

                                case 'referer':
                                        cellContent = Minikit.isObj(log[propertyName]) ? log[propertyName] : '';
                                        break    

                                default:
                                    cellContent = log[propertyName];
                                }

                            html += '<td data-column="' + columnDisplay + '">' + cellContent + '</td>';
                        }
                        html += '</tr>'; 
                    }
                    tableBody.innerHTML = html;

                    // footer msg
                    footerHtml = response.data.logs.length + '<span class="color-light"> lines found in </span>' + response.data.duration + 'ms<span class="color-light">' ;
                    footerHtml += ', </span>' + response.data.linesError + '<span class="color-light"> error line(s)</span>';
                    footerHtml += '<br>';
                    footerHtml += '<span class="color-light">File </span>' + response.data.logPath + '<span class="color-light"> was last modified on </span>' ;
                    footerHtml += Minikit.Format.date(response.data.fileTime, '{YYYY}-{MM}-{DD} {hh}:{mm}:{ss}', true)
                    footerHtml += '<span class="color-light"> size is </span>' + response.data.fileSize ;
                    footer.innerHTML = footerHtml;

            }, function (apiResponse) {
                Minitoring.Api.notifyApiResponse(apiResponse);
            }
        );

    },

    
  



    getLogFilesList: function () {
     
        Minitoring.Api.get('api/logs', null,
            function (result) {
                Minitoring.Logs.logList = result.data;

                var html = '';
                for (var i = 0; i < result.data.length; i++) {
                    html += '<option value="' + result.data[i].logId 
//                         + '" data-format="' + result.data[i].logFormat 
                         + '" data-type="' + result.data[i].logType 
                         + '">' + result.data[i].logName + '</option>';
                }
                document.querySelector('select#select-log').innerHTML = html;
            }
        );
    },
   
    getlogInfoFromCache: function(id) {
        var clone;
        for ( var i = 0; i < Minitoring.Logs.logList.length; i++) {
            if (Minitoring.Logs.logList[i].logId == id){
                clone = Object.assign({}, Minitoring.Logs.logList[i]);
                break;
            }
        }
        return clone;
    },

   
}
/* --- Network --- */
Minitoring.Network = {
    get: function () {
        var tableBody = document.querySelector('#network-table tbody');
       
        Minitoring.Api.get('api/system/network', null, function (result) {
            var html = '';
            for (var i = 0; i < result.data.network.length; i++) {
                html += Minitoring.Network.getHtml(result.data.network[i]);
            }
            tableBody.innerHTML = html;
        }, function (apiResponse) {
            Minitoring.Api.notifyApiResponse(apiResponse);
        });
    },
    getHtml: function (item) {
        var html = '<tr>';
        html += '<td data-column="Interface">' + item.interface + '</td>';
        html += '<td data-column="IP">'  + item.ip + '</td>';
        html += '<td data-column="Receive" class="align-right">' + item.receive + '</td>';
        html += '<td data-column="Transmit" class="align-right">' + item.transmit  + '</td>';
        html += '</tr>';
        return html;
    }
}
/* --- Packages --- */
Minitoring.Packages = {

    init:function() {
        Minikit.Event.add(document.querySelector('#packages-bottom-paginator'), 'click', Minitoring.Packages.onPaginatorClick);
        Minikit.Event.add(document.querySelector('table#packages-table '), 'click', function (e) {
            Minitoring.Packages.tableClicked(e);
        });
    },
    
    onPaginatorClick: function(e) {
        e.preventDefault();
        var el = e.target.closest('[data-offset]');
        if (Minikit.isObj(el)) {
            //Minitoring.Packages.get(parseInt(el.getAttribute('data-offset')));
        }
    },

    refreshAll:function(){
        Minitoring.Packages.getUpgrables();
        Minitoring.Packages.getAll();
    },
    refresh: function () {
        switch (Minitoring.View.getCurrentView()) {
            case 'packages':
            case 'packages/all':
                Minitoring.Packages.getAll();
                break;

            case 'packages/upgradable':
                Minitoring.Packages.getUpgrables();
                break;
        }
    },

    groupbyChanged: function () {
        
    },

    // "grouped row struff"
    tableClicked: function (e) {
        var row = e.target.closest('tr.group-row');
        if (Minikit.isObj(row)) {
            var currentlyExpanded   = row.classList.contains('expanded'),
                expanded            = !currentlyExpanded;
                id                  = row.getAttribute('data-group-id');

            if (expanded) {
                row.classList.add('expanded');
                Array.prototype.forEach.call(document.querySelectorAll('#packages-table tr[data-group-parentid="' + id + '"]'), function (el) {
                    el.classList.remove('hidden');
                });
            } else {
                row.classList.remove('expanded');
                Array.prototype.forEach.call(document.querySelectorAll('#packages-table tr[data-group-parentid="' + id + '"]'), function (el) {
                    el.classList.add('hidden');
                });
            }

        }
    },

    getAll: function () {
        document.querySelector('#packages-comment').innerHTML = '';
        document.querySelector('#packages-comment').classList.remove('active');
        document.querySelector('#packages-table thead').innerHTML = '';
        document.querySelector('#packages-bottom-paginator').setAttribute('data-label', '');
        document.querySelector('#packages-table tbody').innerHTML= Minitoring.UI.getTableLoader(10);
        Minitoring.Api.get('api/packages', null, function (result) {
            var bodyHtml = '', 
                dashboardErrorHtml = '<span class="badge" data-badge="success">0</span>'
                currentGroup = '',
                lastGroup = '',
                lastGroupCount = 0,
                groupRowsDetailHtml = '';

            var groupRow = function(group, count){
                return '<tr class="group-row" data-group-id="' + group + '">' +
                        '<td class="align-left" colspan="10"><a class="toggle"><i class="fa fa-fw color-theme"></i><span class="text-bold">' + group + '</span><span class="margin-left-6 color-light">(' + count + ')</span></td>' +
                        '</tr>'
            }

            for (var i = 0; i < result.data.packages.length; i++) {
                currentGroup = result.data.packages[i].name.charAt(0).toUpperCase();
                
                // new group and previous group is not empty, add it
                if (currentGroup !== lastGroup && lastGroup !== ''){
                    
                    bodyHtml += groupRow(lastGroup, lastGroupCount);
                    bodyHtml += groupRowsDetailHtml;
                
                    // register new group, reset details
                    lastGroup = currentGroup;
                    lastGroupCount = 0;
                    groupRowsDetailHtml = '';
                }

                lastGroup = currentGroup;
                lastGroupCount++;
                groupRowsDetailHtml += Minitoring.Packages.getpackageHtml(result.data.packages[i], lastGroup);

                // last item? add group row and details
                if (i === result.data.packages.length -1){
                    bodyHtml += groupRow(lastGroup, lastGroupCount); 
                    bodyHtml += groupRowsDetailHtml;
                }
            }

            if (result.data.number_error > 0) {
                dashboardErrorHtml = '<span class="badge" data-badge="error">' + result.data.number_error + '</span>';
            }

            document.querySelector('#dashboard_packages_total').innerHTML = result.data.number_total;
            document.querySelector('#dashboard_packages_error').innerHTML = dashboardErrorHtml;
            document.querySelector('#dashboard_packages_installed').innerHTML = '<span class="badge" data-badge="success">' + result.data.number_installed + '</span>';
            document.querySelector('#packages-table tbody').innerHTML = bodyHtml;
            document.querySelector('#packages-table thead').innerHTML = '<tr>' +
//                                    '<th data-column="State">State</th>' +
                                    '<th data-column="Group" class="group"></th>' +
                                    '<th data-column="Name">Name</th>' +
                                    '<th data-column="Version">Version</th>' +
                                    '<th data-column="Arch">Arch</th>' +
                                    '<th data-column="Description">Description</th>' +
                                    '<th data-column="Action">Action</th>' +
                                    '<th data-column="Status">Status</th>' +
                                    '<th data-column="Error">Error</th>' +
                                '</tr>'; 

            document.querySelector('#packages-bottom-paginator').setAttribute('data-label', result.data.packages.length + ' / ' + result.data.packages.length + ' item(s) displayed');    
        });
    },

    getUpgrables: function () {
        document.querySelector('#packages-comment').innerHTML = '';
        document.querySelector('#packages-comment').classList.remove('active');
        document.querySelector('#packages-table thead').innerHTML = '';
        document.querySelector('#packages-bottom-paginator').setAttribute('data-label', '');
        document.querySelector('#packages-table tbody').innerHTML = Minitoring.UI.getTableLoader(10);
        Minitoring.Api.get('api/packages/upgradable', null, function (result) {
            var bodyHtml = '',
                numberPackages = result.data.number,
                menuItemUpgradable = document.querySelector('#packages-upgradable-menuitem'),
                dashboardUpgradableHtml = numberPackages;
                          
            if (numberPackages > 0) {
                dashboardUpgradableHtml = '<span class="badge" data-badge="warning">' + numberPackages + '</span>';
                menuItemUpgradable.classList.add('badge');
                menuItemUpgradable.classList.add('margin-left-6');
                menuItemUpgradable.setAttribute('data-badge','warning');
                menuItemUpgradable.innerHTML = numberPackages;
            } else {
                dashboardUpgradableHtml = '<span class="badge" data-badge="success">' + numberPackages + '</span>';
                document.querySelector('#packages-comment').innerHTML = result.data.message;
                document.querySelector('#packages-comment').classList.add('active');
                menuItemUpgradable.classList.remove('badge');
                menuItemUpgradable.classList.remove('margin-left-6');
                //menuItemUpgradable.setAttribute('data-badge','success');
                menuItemUpgradable.innerHTML = '';
            }

            for (var i = 0; i < result.data.packages.length; i++) {
                bodyHtml += Minitoring.Packages.getUpgradableHtml(result.data.packages[i]);
            }

            document.querySelector('#dashboard_packages_upgradable').innerHTML = dashboardUpgradableHtml;
            document.querySelector('#packages-table tbody').innerHTML = bodyHtml;
            document.querySelector('#packages-table thead').innerHTML = '<tr>' +
                                    '<th data-column="Name">Name</th>' +
                                    '<th data-column="Suite">Suite</th>' +
                                    '<th data-column="Arch">Arch</th>' +
                                    '<th data-column="Current version">Current version</th>' +
                                    '<th data-column="New version">New version</th>' +
                                  '</tr>'; 
            document.querySelector('#packages-bottom-paginator').setAttribute('data-label', numberPackages + ' / ' + numberPackages + ' item(s) displayed');    
        });
    },

    getpackageHtml: function (item, group) {
        //data-parentid="' + rowId + '" class="hidden">';

        var html = '<tr data-group-parentid="' + group + '" class="hidden">', errorHtml = '';
        if (Minikit.isObj(item.error)){
            errorHtml = '<span class="badge" data-badge="error">' + item.error + '</span>';
        }
        html += '<td data-column="Group" class="group"></td>';
        html += '<td data-column="Name">'        + item.name        + '</td>';
        html += '<td data-column="Version">'     + item.version     + '</td>';
        html += '<td data-column="Arch">'        + item.arch        + '</td>';
        html += '<td data-column="Description">' + item.description + '</td>';
        html += '<td data-column="Action">'      + item.action      + '</td>';
        html += '<td data-column="Status"><span class="badge" data-badge="'+ item.status_code + '">' + item.status + '</span></td>';
        html += '<td data-column="Error">'+ errorHtml + '</td>';
        html += '</tr>';
        return html;
    },

    getUpgradableHtml: function (item) {
        var html = '<tr>';
        html += '<td data-column="Name">' + item.name + '</td>';
        html += '<td data-column="Suite">' + item.suite + '</td>';
        html += '<td data-column="Arch">' + item.arch + '</td>';
        html += '<td data-column="Current version">' + item.current_version + '</td>';
        html += '<td data-column="New version">' + item.version + '</td>';
        html += '</tr>';
        return html;
    }
}
/* --- Ping --- */
Minitoring.Ping = {

    refresh: function(){
        var tableBodyDashboard = document.querySelector('#section-dashboard #ping-table tbody');
        tableBodyDashboard.innerHTML= Minitoring.UI.getTableLoader(2);
        Minitoring.Api.get('api/pings/check', null,
            function (result) {
                var html = '';
                for (var i = 0; i < result.data.items.length; i++) {
                    html += Minitoring.Ping.getHtml(result.data.items[i]);
                }
                tableBodyDashboard.innerHTML = html;
            }
        );
    },
    getHtml: function (item) {
        var html = '<tr>';
        html += '<td data-column="Host" class="align-left">' + item.host + '</td>';
        html += '<td data-column="Ping" class="align-right">' + item.ping + ' ms</span></td>';
        html += '</tr>';
        return html;
    },
}

/* --- Packages --- */
Minitoring.Process = {
    get: function () {
        Minitoring.Api.get('api/system/process', null,
            function (result) {
                document.querySelector('#dashboard_process_total').innerHTML = result.data.total;
                document.querySelector('#dashboard_process_running').innerHTML = result.data.running;
            }
        );
    }
}
/* --- Services --- */
Minitoring.Services = {

    refresh: function(){
        var tableBodyDashboard  = document.querySelector('#section-dashboard #services-table tbody'),
            tableHeaderDashboard  = document.querySelector('#section-dashboard #services-table thead');
        tableHeaderDashboard.innerHTML='';
        tableBodyDashboard.innerHTML= Minitoring.UI.getTableLoader(2);
        Minitoring.Api.get('api/services/check', null,
            function (result) {
                var html = '', theadHtml = '';
                for (var i = 0; i < result.data.items.length; i++) {
                    html += Minitoring.Services.getHtml(result.data.items[i]);
                    if (theadHtml == '') theadHtml = Minitoring.Services.getHeader(result.data.items[i]);
                }
                tableHeaderDashboard.innerHTML = theadHtml;
                tableBodyDashboard.innerHTML = html;
            }
        );
    },

    getHeader: function (item) {
        var html = '<tr>';
        html += '<th data-column="Service" class="light no-style align-left">Service</th>';
        html += item.service_port ? '<th data-column="Port" class="light no-style align-right padding-right-12">Port</th>' : '';
        html += '<th data-column="Status" class="light no-style align-center">Status</th>';
        html += '</tr>';
        return html;
    },

    getHtml: function (item) {
        var html = '',
            status = item.service_port_open ? 'online' : 'offline',
            badge = status == 'online' ? 'success' : 'error',
            port = item.service_port ? '<td data-column="Port" class="align-right">' + item.service_port + '</td>' : '';

        html += '<tr data-id="' + item.service_id + '">';
        html += '<td data-column="Service" class="align-left">' + item.service_name + '</td>';
        html += port;
        html += '<td data-column="Status" class="align-center"><span class="badge uppercase" data-badge="' + badge + '">' + status + '</span></td>';
        html += '</tr>';
        return html;
    },
}

/* --- Cpu --- */
Minitoring.Cpu = {
    get: function () {
        Minitoring.Api.get('api/system/cpu', null,
            function (result) {
                document.querySelector('#cpu-model').innerHTML = result.data.model;
                document.querySelector('#cpu-cores').innerHTML = result.data.cores;
                document.querySelector('#cpu-speed').innerHTML = result.data.frequency;
                document.querySelector('#cpu-cache').innerHTML = result.data.cache;
                document.querySelector('#cpu-bogomips').innerHTML = result.data.bogomips;
                document.querySelector('#cpu-temperature').innerHTML = result.data.temperature;
            }
        );
    }
}

/* --- System infos --- */
Minitoring.SystemInfos = {
    get: function () {
        Minitoring.Api.get('api/system/infos', null,
            function (result) {
                var dashboardRebbotHtml = '';
                if (result.data.rebootRequired){
                    dashboardRebbotHtml = '<span class="badge uppercase" data-badge="warning">Reboot required</span>';
                }
                
                document.querySelector('#uptime-full').innerHTML = result.data.lastBoot;
                document.querySelector('#uptime-day').innerHTML = result.data.uptimeDays;
                document.querySelector('#dashboard-reboot-required').innerHTML = dashboardRebbotHtml;
               
                document.querySelector('#system-hostname').innerHTML = result.data.hostname;
             // document.querySelector('#system-current-users').innerHTML = result.data.currentUsersNumber;
                document.querySelector('#system-server-date').innerHTML = result.data.serverDate;
                document.querySelector('#system-last-boot').innerHTML = result.data.lastBoot;
                document.querySelector('#system-uptime').innerHTML = result.data.uptime;
                document.querySelector('#system-os').innerHTML = result.data.os;
                document.querySelector('#system-kernel').innerHTML = result.data.kernel;

            }
        );
    }
}
/* --- Load average --- */
Minitoring.LoadAverage = {
    gauge1_dashbord: {},
    gauge5_dashbord: {},
    gauge15_dashbord: {},

    init: function () {
        Minitoring.LoadAverage.gauge1_dashbord  = Minitoring.UI.createGauge("#section-dashboard  #load-average-1-gauge");
        Minitoring.LoadAverage.gauge5_dashbord  = Minitoring.UI.createGauge("#section-dashboard  #load-average-5-gauge");
        Minitoring.LoadAverage.gauge15_dashbord = Minitoring.UI.createGauge("#section-dashboard  #load-average-15-gauge");

    },
    get: function () {
        Minitoring.Api.get('api/system/load', null,
            function (result) {
                Minitoring.LoadAverage.gauge1_dashbord.setValueAnimated(result.data.load1purcent, 1);
                Minitoring.LoadAverage.gauge5_dashbord.setValueAnimated(result.data.load5purcent, 1);
                Minitoring.LoadAverage.gauge15_dashbord.setValueAnimated(result.data.load15purcent, 1);

                document.querySelector("#section-dashboard #load-average-1-gauge").setAttribute('data-alert-code', result.data.load1AlertCode);
                document.querySelector("#section-dashboard #load-average-5-gauge").setAttribute('data-alert-code', result.data.load5AlertCode);
                document.querySelector("#section-dashboard #load-average-15-gauge").setAttribute('data-alert-code', result.data.load15AlertCode);

                document.querySelector("#section-dashboard #load-average-1-gauge").setAttribute('data-bottom', '1 min - ' + result.data.load1);
                document.querySelector("#section-dashboard #load-average-5-gauge").setAttribute('data-bottom', '5 min - ' + result.data.load5);
                document.querySelector("#section-dashboard #load-average-15-gauge").setAttribute('data-bottom', '15 min - ' + result.data.load15);
            }
        );
    }
}
/* --- Memory --- */
Minitoring.Memory = {
    gauge_dashboard: {},
    
    init: function () {
        Minitoring.Memory.gauge_dashboard= Minitoring.UI.createGauge("#section-dashboard #memory-gauge");
    },
    get: function () {
        Minitoring.Api.get('api/system/memory', null,
            function(result) {
                Minitoring.Memory.gauge_dashboard.setValueAnimated(result.data.percentUsed, 1);
                document.querySelector("#section-dashboard #memory-gauge").setAttribute('data-alert-code', result.data.alertCode);
                document.querySelector("#section-dashboard #memory-gauge").setAttribute('data-bottom', result.data.used + ' used / ' + result.data.total);

            }, function (apiResponse) {
                Minitoring.Api.notifyApiResponse(apiResponse);
            }
        );
    }
}
/* --- Swap --- */
Minitoring.Swap = {
    gauge_dashboard: {},

    init: function () {
        Minitoring.Swap.gauge_dashboard = Minitoring.UI.createGauge("#section-dashboard #swap-gauge");
    },
    
    get: function () {
        Minitoring.Api.get('api/system/swap', null,
            function (result) {
                Minitoring.Swap.gauge_dashboard.setValueAnimated(result.data.percentUsed, 1);
                document.querySelector("#section-dashboard #swap-gauge").setAttribute('data-alert-code', result.data.alertCode);
                document.querySelector("#section-dashboard #swap-gauge").setAttribute('data-bottom', result.data.used + ' / ' + result.data.total + ' used');

            }, function (apiResponse) {
                Minitoring.Api.notifyApiResponse(apiResponse);
            }
        );
    }
}
/* --- System users --- */
Minitoring.SystemUsers = {
    init: function () {
        var paginatorClicked = function (e) {
            e.preventDefault();
            var el = e.target.closest('[data-offset]');
            if (Minikit.isObj(el)) {
                Minitoring.SystemUsers.refresh(parseInt(el.getAttribute('data-offset')));
            }
        };
        Minikit.Event.add(document.querySelector('#sysusers-bottom-paginator'), 'click', function (e) {
            paginatorClicked(e);
        });
        Minikit.Event.add(document.querySelector('#sysusers-top-paginator'), 'click', function (e) { 
            paginatorClicked(e);
        });
    },
    getNumberActive: function () {
        Minitoring.Api.get('api/sysusers/currentUsersNumber', null,
            function (result) {
                document.querySelector('#current-users-number').classList.remove('color-status-ok');
                document.querySelector('#current-users-number').classList.remove('color-status-warning');
                document.querySelector('#current-users-number').innerHTML = result.data.currentUsersNumber;
                if (result.data.currentUsersNumber > 0){
                    document.querySelector('#current-users-number').classList.add('color-status-warning');
                } else {
                    document.querySelector('#current-users-number').classList.add('color-status-ok');
                }
            }, function (apiResponse) {
                Minitoring.Api.notifyApiResponse(apiResponse);
            }
        );
    },

    // sync tabItems: set the selected tabItem
    syncNavBar:function(){
        Minikit.each(document.querySelectorAll('#section-sysusers '))

    },
    refresh: function (offset) {

        switch (Minitoring.View.getCurrentView()) {
            case 'sysusers':
            case 'sysusers/index':
            case 'sysusers/all':
                Minitoring.SystemUsers.get('all', offset);
                break;
            case 'sysusers/currents':
                Minitoring.SystemUsers.get('current', offset);
                break;
            case 'sysusers/lasts':
                Minitoring.SystemUsers.get('last', offset);
                break;
            case 'sysusers/groups':
                Minitoring.SystemUsers.get('groups', offset);
                break;
            }
    },
    get: function (what, offset) {
        var tableBody     = document.querySelector('#sysusers-table tbody'),
            tableHeader   = document.querySelector('#sysusers-table thead'),
            paginator     = document.querySelector('#sysusers-bottom-paginator'),
            paginatorText = '',
            limit         = tableBody.getAttribute('data-limit') ? parseInt(tableBody.getAttribute('data-limit')) : 20,
            offset        = Minikit.isObj(offset) ? parseInt(offset) : 0,
            html = '';
            
        Minitoring.Api.get('api/sysusers/' + what, 'limit=' + limit + '&offset=' + offset,
            function (result) {
                paginator.innerHTML = Minitoring.UI.getPaginatorHtml(limit, offset, result.data.total);
               
                if (what === 'groups'){
                    for (var i = 0; i < result.data.groups.length; i++) {
                        html += Minitoring.SystemUsers.getGroupHtml(result.data.groups[i]);
                    }
                    tableHeader.innerHTML =  Minitoring.SystemUsers.getGroupsHeaderHtml();
                    paginatorText = result.data.groups.length + ' / ' + result.data.total + ' item(s) displayed';
                
                } else {
                    for (var i = 0; i < result.data.users.length; i++) {
                        html += what === 'all' ?  Minitoring.SystemUsers.getUserItemHtml(result.data.users[i]) : 
                                                  Minitoring.SystemUsers.getHtml(result.data.users[i]) ;
                    }
                    tableHeader.innerHTML =  what === 'all' ?  Minitoring.SystemUsers.getUsersHeaderHtml() : 
                                                               Minitoring.SystemUsers.getUsersLastLoginHeaderHtml();                        
                    paginatorText = result.data.users.length + ' / ' + result.data.total + ' item(s) displayed';
                }
                
                tableBody.innerHTML = html;
                tableBody.setAttribute('data-offset', offset);
                paginator.setAttribute('data-label', paginatorText);
            }, function (apiResponse) {
                Minitoring.Api.notifyApiResponse(apiResponse);
            }
        );
    },
    getUsersLastLoginHeaderHtml: function(){
        return  '<tr class="table-header">' +
                '<th data-column="User">User</th>'+
                '<th data-column="Port">Port</th>'+
                '<th data-column="Pid">Pid</th>'+
                '<th data-column="From">Connected from</th>'+
                '<th data-column="LastLogin">Last login</th>'+
                '</tr>';
    },
    getGroupsHeaderHtml: function(){
        return  '<tr class="table-header">' +
                '<th data-column="Name">Name</th>'+
                '<th data-column="ID">ID</th>'+
                '<th data-column="Users">Users</th>'+
                '</tr>';
    },
    getUsersHeaderHtml: function(){
        return  '<tr class="table-header">' +
                '<th data-column="Name">Name</th>'+
                '<th data-column="User Id" class="align-center">User Id</th>'+
                '<th data-column="Group Id" class="align-center">Group Id</th>'+
                '<th data-column="Home Directory">Home Directory</th>'+
                '<th data-column="Login Shell">Login Shell</th>'+
                '</tr>';
    },
    getUserItemHtml: function(item){
        var html = '<tr>';
        html += '<td data-column="Name">' + item.name + '</td>';
        html += '<td data-column="User Id" class="align-center">' + item.uid + '</td>';
        html += '<td data-column="Group Id" class="align-center">' + item.gid + '</td>';
        html += '<td data-column="Home Directory">' + item.homeDirectory + '</td>';
        html += '<td data-column="Login Shell"><span class="badge" data-badge="' + (item.hasLoginShell ? 'warning' : 'info') + '">' + item.loginShell + '</span></td>';
        html += '</tr>';
        return html;

    },
    getGroupHtml: function (item) {
        var html = '<tr>', users = '';
        for (var i = 0; i < item.users.length; i++) {
            users += (i === 0) ? '' : ', ';     
            users += item.users[i];
        }
        html += '<td data-column="Name">' + item.name + '</td>';
        html += '<td data-column="ID" class="align-center">' + item.gid + '</td>';
        html += '<td data-column="Users" class="align-left">'  + users + '</td>';
        html += '</tr>';
        return html;
    },
    getHtml: function (item) {
        var html = '<tr>';
        html += '<td data-column="User">' + item.user + '</td>';
        html += '<td data-column="Port" class="align-center">' + item.port + '</td>';
        html += Minikit.isNotNull(item.pid) ? '<td data-column="Pid">' + item.pid + '</td>' : '';
        html += Minikit.isNotNull(item.comment) ? '<td data-column="Comment">' + item.comment + '</td>' : '';
        html += Minikit.isNotNull(item.from) ? '<td data-column="From">' + item.from + '</td>' : '';
        html += '<td data-column="LastLogin" class="align-left">' + item.date + '</td>';
        html += '</tr>';
        return html;
    }
}