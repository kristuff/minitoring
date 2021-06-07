/* --- Memory --- */
Minitoring.Memory = {
    gauge: {},
    gauge_dashboard: {},
    
    init: function () {
        Minitoring.Memory.gauge = Minitoring.UI.createGauge("#system-section #memory-gauge");
        Minitoring.Memory.gauge_dashboard= Minitoring.UI.createGauge("#section-dashboard #memory-gauge");
    },
    get: function () {
        Minitoring.Api.get('api/system/memory', null,
            function(result) {
                Minitoring.Memory.gauge.setValueAnimated(result.data.percentUsed, 1);
                document.querySelector("#system-section #memory-gauge").setAttribute('data-alert-code', result.data.alertCode);
                document.querySelector("#system-section #memory-gauge").setAttribute('data-bottom', result.data.used + ' used / ' + result.data.total);

                Minitoring.Memory.gauge_dashboard.setValueAnimated(result.data.percentUsed, 1);
                document.querySelector("#section-dashboard #memory-gauge").setAttribute('data-alert-code', result.data.alertCode);
                document.querySelector("#section-dashboard #memory-gauge").setAttribute('data-bottom', result.data.used + ' used / ' + result.data.total);

            }, function (apiResponse) {
                Minitoring.Api.notifyApiResponse(apiResponse);
            }
        );
    }
}