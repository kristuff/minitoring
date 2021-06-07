/* --- System infos --- */
Minitoring.SystemInfos = {
    get: function () {
        Minitoring.Api.get('api/system/infos', null,
            function (result) {
                // dashboard view
                document.querySelector('#uptime-full').innerHTML = result.data.lastBoot;
                document.querySelector('#uptime-day').innerHTML = result.data.uptimeDays;

                // detail view        
                document.querySelector('#system-hostname').innerHTML = result.data.hostname;
             // document.querySelector('#system-current-users').innerHTML = result.data.currentUsersNumber;
                document.querySelector('#system-server-date').innerHTML = result.data.serverDate;
                document.querySelector('#system-last-boot').innerHTML = result.data.lastBoot;
                document.querySelector('#system-uptime').innerHTML = result.data.uptime;
                document.querySelector('#system-os').innerHTML = result.data.os;
                document.querySelector('#system-kernel').innerHTML = result.data.kernel;
            }, function (apiResponse) {
                Minitoring.Api.notifyApiResponse(apiResponse);
            }
        );
    }
}