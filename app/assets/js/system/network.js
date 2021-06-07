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