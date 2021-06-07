/* --- Logs --- */
Minitoring.Logs = {
    //autoRefresh:0,
    autoRefreshHandle:0,
    //defaultSettings:{},
    logList:{},

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
                                    cellContent = '<a href="https://www.abuseipdb.com/check/' + log[propertyName]+ '" target="linkout" class="color-theme">' + log[propertyName]+ '</a>'
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