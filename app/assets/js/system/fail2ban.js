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