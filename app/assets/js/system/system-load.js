/* --- Load average --- */
Minitoring.LoadAverage = {
    gauge1: {},
    gauge5: {},
    gauge15: {},
    gauge1_dashbord: {},
    gauge5_dashbord: {},
    gauge15_dashbord: {},

    init: function () {
        Minitoring.LoadAverage.gauge1  = Minitoring.UI.createGauge("#system-section  #load-average-1-gauge");
        Minitoring.LoadAverage.gauge5  = Minitoring.UI.createGauge("#system-section  #load-average-5-gauge");
        Minitoring.LoadAverage.gauge15 = Minitoring.UI.createGauge("#system-section  #load-average-15-gauge");

        Minitoring.LoadAverage.gauge1_dashbord  = Minitoring.UI.createGauge("#section-dashboard  #load-average-1-gauge");
        Minitoring.LoadAverage.gauge5_dashbord  = Minitoring.UI.createGauge("#section-dashboard  #load-average-5-gauge");
        Minitoring.LoadAverage.gauge15_dashbord = Minitoring.UI.createGauge("#section-dashboard  #load-average-15-gauge");

    },
    get: function () {
        Minitoring.Api.get('api/system/load', null,
            function (result) {
                Minitoring.LoadAverage.gauge1.setValueAnimated(result.data.load1, 1);
                Minitoring.LoadAverage.gauge5.setValueAnimated(result.data.load5, 1);
                Minitoring.LoadAverage.gauge15.setValueAnimated(result.data.load15, 1);
                
                document.querySelector("#system-section #load-average-1-gauge").setAttribute('data-alert-code', result.data.load1AlertCode);
                document.querySelector("#system-section #load-average-5-gauge").setAttribute('data-alert-code', result.data.load5AlertCode);
                document.querySelector("#system-section #load-average-15-gauge").setAttribute('data-alert-code', result.data.load15AlertCode);

                Minitoring.LoadAverage.gauge1_dashbord.setValueAnimated(result.data.load1, 1);
                Minitoring.LoadAverage.gauge5_dashbord.setValueAnimated(result.data.load5, 1);
                Minitoring.LoadAverage.gauge15_dashbord.setValueAnimated(result.data.load15, 1);

                document.querySelector("#section-dashboard #load-average-1-gauge").setAttribute('data-alert-code', result.data.load1AlertCode);
                document.querySelector("#section-dashboard #load-average-5-gauge").setAttribute('data-alert-code', result.data.load5AlertCode);
                document.querySelector("#section-dashboard #load-average-15-gauge").setAttribute('data-alert-code', result.data.load15AlertCode);
            }, function (apiResponse) {
                Minitoring.Api.notifyApiResponse(apiResponse);
            }
        );
    }
}