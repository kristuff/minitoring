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
