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