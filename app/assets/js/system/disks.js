/* --- Disks --- */
Minitoring.Disks = {
    gauge: {},
    init: function () {
        Minitoring.Disks.gauge = Minitoring.UI.createGauge("#disks-gauge");
    },
    get: function () {
        var tableBody = document.querySelector('#disks-table tbody');
        var args = Minitoring.View.getCurrentView() === 'disks' ?
                    'tmpfs=' + (document.querySelector("#disks_show_tmpfs").checked) : '';

        Minitoring.Api.get('api/system/disks', args, function (result) {

                switch (Minitoring.View.getCurrentView()) {
                    case 'dashboard':
                        var alertWarningCount = 0;
                        var alertErrorCount = 0;

                        for (var i = 0; i < result.data.disks.length; i++) {
                            switch (result.data.disks[i].alertCode) {
                                case 1: alertWarningCount++; break;
                                case 2: alertErrorCount++; break;
                            }
                        }
                        Minitoring.Disks.gauge.setValueAnimated(result.data.totalPercentUsed, 1);
                        document.querySelector("#disks-gauge").setAttribute('data-alert-code', result.data.alertCode);
                        document.querySelector("#disks-gauge").setAttribute('data-bottom', result.data.totalUsed + '/' + result.data.total + ' used');

                        var alertHtml = alertErrorCount > 0 ? '<span id="badge-disks-error" class="badge" data-badge="error" data-alert-code="2">' + alertErrorCount + '</span>' : '';
                        alertHtml +=  alertWarningCount > 0 ? '<span id="badge-disks-warning" class="badge" data-badge="warning" data-alert-code="1">' + alertWarningCount + '</span>' : ''
                        document.querySelector('#disks-alerts').innerHTML = alertHtml;
                        break;

                    case 'disks':

                        var html = '';
                        for (var i = 0; i < result.data.disks.length; i++) {
                            html += Minitoring.Disks.getHtml(result.data.disks[i]);
                        }

                        // total row
                        html += '<tr class="row-total" data-alert-code="' + result.data.alertCode + '">';
                        html += '<td colspan="3">Total:</td>';
                        html += '<td data-column="% used" class="align-right"><div class="progress-bar" data-alert-code="' + result.data.alertCode + '" data-value="' + result.data.totalPercentUsed + '"><div class="progress-bar-placeholder">' + result.data.totalPercentUsed + '%</div><div class="progress-bar-inner"></div></div></td>';
                        html += '<td data-column="Free" class="align-right">'  + result.data.totalFree + '</td>';
                        html += '<td data-column="Used" class="align-right">'  + result.data.totalUsed + '</td>';
                        html += '<td data-column="Total" class="align-right">' + result.data.total     + '</td>';
                        html += '</tr>';

                        tableBody.innerHTML = html;
                        Minikit.each(document.querySelectorAll('#disks-table tbody .progress-bar'), function (element) {
                            var value = element.getAttribute('data-value');
                            element.querySelector('.progress-bar-inner').style.width = value + '%';
                        });

                        // todo
                        Minitoring.Disks.getInodes();

                        break;
                }
            }, function (apiResponse) {
                Minitoring.Api.notifyApiResponse(apiResponse);
            }
        );
    },
    getInodes: function() {
        var tableBody = document.querySelector('#inodes-table tbody');
        var args = Minitoring.View.getCurrentView() === 'disks' ?
                    'tmpfs=' + (document.querySelector("#disks_show_tmpfs").checked) : '';

        Minitoring.Api.get('api/system/inodes', args, function (result) {
            var html = '';
            for (var i = 0; i < result.data.inodes.length; i++) {
                html += Minitoring.Disks.getHtml(result.data.inodes[i]);
            }

            // total row
            html += '<tr class="row-total" data-alert-code="' + result.data.alertCode + '">';
            html += '<td colspan="3">Total:</td>';
            html += '<td data-column="% used" class="align-right"><div class="progress-bar" data-alert-code="' + result.data.alertCode + '" data-value="' + result.data.totalPercentUsed + '"><div class="progress-bar-placeholder">' + result.data.totalPercentUsed + '%</div><div class="progress-bar-inner"></div></div></td>';
            html += '<td data-column="Free" class="align-right">'  + result.data.totalFree + '</td>';
            html += '<td data-column="Used" class="align-right">'  + result.data.totalUsed + '</td>';
            html += '<td data-column="Total" class="align-right">' + result.data.total     + '</td>';
            html += '</tr>';

            tableBody.innerHTML = html;
            Minikit.each(document.querySelectorAll('#inodes-table tbody .progress-bar'), function (element) {
                var value = element.getAttribute('data-value');
                element.querySelector('.progress-bar-inner').style.width = value + '%';
            });

        }, function (apiResponse) {
            Minitoring.Api.notifyApiResponse(apiResponse);
        });
    },
    getHtml: function (item) {
        var html = '';
        html += '<tr data-alert-code="' + item.alertCode + '">';
        html += '<td data-column="Filesystem">' + item.filesystem + '</td>';
        html += '<td data-column="Type">'  + item.type + '</td>';
        html += '<td data-column="Mount">' + item.mount + '</td>';
        html += '<td data-column="% used" class="align-right"><div class="progress-bar" data-alert-code="' + item.alertCode + '" data-value="' + item.percentUsed + '"><div class="progress-bar-placeholder">' + item.percentUsed + '%</div><div class="progress-bar-inner"></div></div></td>';
        html += '<td data-column="Free"  class="align-right">' + item.free + '</td>';
        html += '<td data-column="Used"  class="align-right">' + item.used + '</td>';
        html += '<td data-column="Total" class="align-right">' + item.total + '</td>';
        html += '</tr>';
        return html;
    }
}