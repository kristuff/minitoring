/* --- Load average --- */
Minitoring.LoadAverage = {
    gauge1_dashbord: {},
    gauge5_dashbord: {},
    gauge15_dashbord: {},

    init: function () {
        Minitoring.LoadAverage.gauge1_dashbord  = Minitoring.UI.createGauge("#section-dashboard  #load-average-1-gauge");
        Minitoring.LoadAverage.gauge5_dashbord  = Minitoring.UI.createGauge("#section-dashboard  #load-average-5-gauge");
        Minitoring.LoadAverage.gauge15_dashbord = Minitoring.UI.createGauge("#section-dashboard  #load-average-15-gauge");

    },
    get: function () {
        Minitoring.Api.get('api/system/load', null,
            function (result) {
                Minitoring.LoadAverage.gauge1_dashbord.setValueAnimated(result.data.load1purcent, 1);
                Minitoring.LoadAverage.gauge5_dashbord.setValueAnimated(result.data.load5purcent, 1);
                Minitoring.LoadAverage.gauge15_dashbord.setValueAnimated(result.data.load15purcent, 1);

                document.querySelector("#section-dashboard #load-average-1-gauge").setAttribute('data-alert-code', result.data.load1AlertCode);
                document.querySelector("#section-dashboard #load-average-5-gauge").setAttribute('data-alert-code', result.data.load5AlertCode);
                document.querySelector("#section-dashboard #load-average-15-gauge").setAttribute('data-alert-code', result.data.load15AlertCode);

                document.querySelector("#section-dashboard #load-average-1-gauge").setAttribute('data-bottom', '1 min - ' + result.data.load1);
                document.querySelector("#section-dashboard #load-average-5-gauge").setAttribute('data-bottom', '5 min - ' + result.data.load5);
                document.querySelector("#section-dashboard #load-average-15-gauge").setAttribute('data-bottom', '15 min - ' + result.data.load15);
            }
        );
    }
}