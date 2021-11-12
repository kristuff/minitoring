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
