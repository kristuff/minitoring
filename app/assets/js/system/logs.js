/* --- Logs --- */
Minitoring.Logs = {
    autoRefreshHandle:0,
    autoRefreshLastLineHash:null,
    logList:{},
    $logFormats:{},

    init:function(){
        Minitoring.Logs.getLogFilesList();
    },

    refresh: function(){
        Minitoring.Logs.cleanAutoRefresh(true);
        if (Minikit.isObj(document.querySelector("select#select-log").value)){
            Minitoring.Logs.getLogs(null, null);
        }
    },

    refreshAuto: function(){
        if (Minikit.isObj(document.querySelector("select#select-log").value)){
            Minitoring.Logs.getLogs(null, Minikit.getAttr(document.querySelector('table#system-logs-table tbody'), 'data-toplinehash', ''));

            var d = new Date();
            console.log('DEBUG ' + d.getHours() +':' + d.getMinutes() +':' + d.getSeconds() + ' refreshing, hash: ' +  Minikit.getAttr(document.querySelector('table#system-logs-table tbody'), 'data-toplinehash', ''));
        }
    },

    loadMore: function(){
        Minitoring.Logs.cleanAutoRefresh(true);
        if (Minikit.isObj(document.querySelector("select#select-log").value)){
            Minitoring.Logs.getLogs(Minikit.getAttr(document.querySelector('section#system-logs-loadmore'), 'data-lastlinehash', ''), null);
            Minitoring.Logs.setAutoRefresh();
        }
    },

    setAutoRefresh:function(){
        Minitoring.Logs.cleanAutoRefresh(false);

        var refreshValue = parseInt(document.querySelector('select#select-log-refresh').value);
        if (refreshValue > 0){

            var d = new Date();
            console.log('DEBUG ' + d.getHours() +':' + d.getMinutes() +':' + d.getSeconds() + '  set autorefresh, value: ' +  refreshValue * 1000);
            Minitoring.Logs.autoRefreshHandle = setInterval(Minitoring.Logs.refreshAuto, refreshValue * 1000);
        }
    },

    cleanAutoRefresh:function(resetSelector){
        if (Minitoring.Logs.autoRefreshHandle > 0){
            if (resetSelector) document.querySelector("select#select-log-refresh").value="0";
            Array.prototype.forEach.call(document.querySelectorAll('table#system-logs-table tbody tr.new-row'), function(row){
                row.classList.remove('new-row');
            });
            
            var d = new Date();
            console.log('DEBUG ' + d.getHours() +':' + d.getMinutes() +':' + d.getSeconds() + ' cleaning autorefresh');
            
            clearInterval(Minitoring.Logs.autoRefreshHandle);
            Minitoring.Logs.autoRefreshHandle = 0; // I just do this so I know I've cleared the interval
        }
    },

    getLogs: function(lastLineHash, topLineHash){

        var tableBody = document.querySelector('table#system-logs-table tbody'),
            tableHeader = document.querySelector('table#system-logs-table thead'),
            sectionLoadMore = document.querySelector('section#system-logs-loadmore'),
            footer = document.querySelector('#system-logs-msg'),
            headerHtml = '',
            footerHtml = '', 
            html = '',
            previoushtml = '', 
            log, propertyName, columnDisplay, cellContent, statusCode, level, badge, bytes;

        // clean
        Array.prototype.forEach.call(document.querySelectorAll('table#system-logs-table tbody tr.new-row'), function(row){
            row.classList.remove('new-row');
        });

        // temp loader
        if (Minikit.isObj(lastLineHash)){
            footer.innerHTML = '';
            sectionLoadMore.classList.remove('active');
            html = tableBody.innerHTML; 
            tableBody.innerHTML = html + Minitoring.UI.getTableLoader(10);
        } else if (Minikit.isObj(topLineHash)){
            previoushtml = tableBody.innerHTML; 
        } else {
            footer.innerHTML = '';
            sectionLoadMore.classList.remove('active');
            tableBody.innerHTML = Minitoring.UI.getTableLoader(10);
        }

        Minitoring.Api.socketApiRequest({
                command:"logs", 
                maxLines: document.querySelector("select#select-log-max").value,
                logId: document.querySelector("select#select-log").value,
                key: Minitoring.Api.key,
                lastlinehash: lastLineHash,
                toplineHash: topLineHash
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
                        
                        if (Minikit.isObj(topLineHash)){
                            html += '<tr class="new-row">'; 
                        } else {
                            html += '<tr>'; 
                        }
                        
                        for (var iCol = 0; iCol < response.data.columns.length; iCol++) {
                            log = response.data.logs[iLog];
                            propertyName = response.data.columns[iCol].name;
                            columnDisplay = response.data.columns[iCol].display;

                            switch(propertyName){
                                case 'host':
                                case 'remoteIp':
                                    cellContent = Minitoring.Utils.getIpLink(log[propertyName], document.querySelector('body').getAttribute('data-ip-action'));
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

                    if (Minikit.isObj(topLineHash)){
                         html+= previoushtml;        
                    }
                    tableBody.innerHTML = html;
                    tableBody.setAttribute('data-toplinehash', response.data.topLineHash);

                    if (response.data.hasMoreLines){
                        sectionLoadMore.classList.add('active');
                        sectionLoadMore.setAttribute('data-lastlinehash', response.data.lastLineHash);
                    } else {
                        sectionLoadMore.classList.remove('active');
                        sectionLoadMore.setAttribute('data-lastlinehash', '');
                    }

                    // footer msg
                    footerHtml = response.data.logs.length + '<span class="color-light"> new line(s) found in </span>' + response.data.duration + 'ms<span class="color-light">' ;
                    footerHtml += ', </span>' + response.data.linesError + '<span class="color-light"> error line(s)</span>';
                    footerHtml += '<br>';
                    footerHtml += '<span class="color-light">File </span>' + response.data.logPath + '<span class="color-light"> was last modified on </span>' ;
                    footerHtml += Minikit.Format.date(response.data.fileTime, '{YYYY}-{MM}-{DD} {hh}:{mm}:{ss}', true)
                    footerHtml += '<span class="color-light"> size is </span>' + response.data.fileSize ;
                    footer.innerHTML = footerHtml;

            }, function (apiResponse) {
                footer.innerHTML = '';
                sectionLoadMore.classList.remove('active');
                Minitoring.Api.notifyApiResponse(apiResponse);
            }   
        );

    },

    getLogFilesList: function () {
        Minitoring.Api.get('api/logs', null, function (result) {
            Minitoring.Logs.logList = result.data;
            var html = '';
            for (var i = 0; i < result.data.length; i++) {
                html += '<option value="' + result.data[i].logId 
                        + '" data-type="' + result.data[i].logType 
                        + '">' + result.data[i].logName + '</option>';
            }
            document.querySelector('select#select-log').innerHTML = html;
        });
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