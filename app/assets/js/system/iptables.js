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
                return (ip == "0.0.0.0/0" || ip == "::/0") ? ip : Minitoring.Utils.getIpLink(ip, "abuseipdb");
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
                html += '<td class="align-left" colspan="6"><a class="toggle"><i class="fa fa-fw icon-left color-theme"></i>Chain: ' ;
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
                    html += '<td data-column="Desination">' + getIpLink(result.data.chains[i].rules[ii].destination) + '</td>';
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