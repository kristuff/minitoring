/* --- Services --- */
Minitoring.Services = {

    refresh: function(){
        var tableBodyDashboard  = document.querySelector('#section-dashboard #services-table tbody');
        tableBodyDashboard.innerHTML= Minitoring.UI.getTableLoader(2);
        Minitoring.Api.get('api/services/check', null,
            function (result) {
                var html = '';
                for (var i = 0; i < result.data.items.length; i++) {
                    html += Minitoring.Services.getHtml(result.data.items[i]);
                }
                tableBodyDashboard.innerHTML = html;
            }
        );
    },

    getHtml: function (item) {
        var html = '',
            status = item.service_port_open ? 'online' : 'offline',
            badge = status == 'online' ? 'success' : 'error';

        html += '<tr data-id="' + item.service_id + '">';
        html += '<td data-column="Service" class="align-left">' + item.service_name + '</td>';
        html += '<td data-column="Status" class="align-center"><span class="badge uppercase" data-badge="' + badge + '">' + status + '</span></td>';
        html += '</tr>';
        return html;
    },
}
