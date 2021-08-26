
/* main application */
Minitoring.App = {
    init: function () {
        Minitoring.View.init();
        Minitoring.LoadAverage.init();
        Minitoring.Swap.init();
        Minitoring.Memory.init();
        Minitoring.Disks.init();
        Minitoring.SystemUsers.init();
        Minitoring.Logs.init();
        Minitoring.Iptables.init();
        Minitoring.Packages.init();
        Minitoring.App.getApiKey(function () {
            Minitoring.Settings.loadUserSettings();
            Minitoring.View.updateActiveView(Minitoring.View.getCurrentView());
            Minitoring.App.getFeedback();
        });
    },
    setNotif: function(type,message) {
        Minitoring.App.toast = Minitoring.App.toast || new Minikit.Toasts();
        Minitoring.App.toast.show(type,message)    
    },
    getApiKey: function (callback) {
        Minitoring.Api.apiRequest('GET', 'api/app/auth', null, function(response){
            Minitoring.Api.key = response.data.key;
            Minikit.isFn(callback, true);
        });
    },
    getFeedback: function () {
        Minitoring.Api.apiRequest('GET', 'api/app/feedback', null, function(apiResponse) {

            var type = apiResponse.data.feedbackNegatives.length > 0 ? 'error' : 'success';
            var msg = '';

            if (apiResponse.data.feedbackNegatives && apiResponse.data.feedbackNegatives.length > 0){
                msg += apiResponse.data.feedbackNegatives.map(function (msg){
                    return msg;
                }).join('<br>');
            }
            if (apiResponse.data.feedbackPositives && apiResponse.data.feedbackPositives.length > 0){
                msg += apiResponse.data.feedbackPositives.map(function (msg){
                    return msg;
                }).join('<br>');
            }
            if (Minikit.isObj(msg)) {
                Minitoring.App.setNotif(type, msg);
            } 
        });
    },
};

// init and start Application 
Minikit.ready(function () {
    // register in window TODO
    window.Minitoring = Minitoring;
    Minitoring.App.init();
});
