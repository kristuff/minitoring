/* --- Swap --- */
Minitoring.Swap = {
    gauge: {},
    gauge_dashboard: {},

    init: function () {
        Minitoring.Swap.gauge           = Minitoring.UI.createGauge("#system-section #swap-gauge");
        Minitoring.Swap.gauge_dashboard = Minitoring.UI.createGauge("#section-dashboard #swap-gauge");
    },
    
    get: function () {
        Minitoring.Api.get('api/system/swap', null,
            function (result) {
                Minitoring.Swap.gauge.setValueAnimated(result.data.percentUsed, 1);
                Minitoring.Swap.gauge_dashboard.setValueAnimated(result.data.percentUsed, 1);
                document.querySelector("#system-section #swap-gauge").setAttribute('data-alert-code', result.data.alertCode);
                document.querySelector("#system-section #swap-gauge").setAttribute('data-bottom', result.data.used + ' / ' + result.data.total + ' used');

                document.querySelector("#section-dashboard #swap-gauge").setAttribute('data-alert-code', result.data.alertCode);
                document.querySelector("#section-dashboard #swap-gauge").setAttribute('data-bottom', result.data.used + ' / ' + result.data.total + ' used');

            }, function (apiResponse) {
                Minitoring.Api.notifyApiResponse(apiResponse);
            }
        );
    }
}