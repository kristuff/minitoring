/* --- Cron --- */
Minitoring.Cron = {
    getList:function(){
        // temp loader
        document.querySelector('table#users-cron-list tbody').innerHTML = Minitoring.UI.getTableLoader(4);
        document.querySelector('table#system-cron-list tbody').innerHTML = Minitoring.UI.getTableLoader(5);

        Minitoring.Api.socketApiRequest({
            command:"crons",
            key: Minitoring.Api.key
        }, function (response) {
            var html = '', htmlSystem = '';
            
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
        }, function (apiResponse) {
            Minitoring.Api.notifyApiResponse(apiResponse);
        });
    }
}