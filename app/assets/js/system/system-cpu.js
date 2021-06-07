/* --- Cpu --- */
Minitoring.Cpu = {
    get: function () {
        Minitoring.Api.get('api/system/cpu', null,
            function (result) {
                document.querySelector('#cpu-model').innerHTML = result.data.model;
                document.querySelector('#cpu-cores').innerHTML = result.data.cores;
                document.querySelector('#cpu-speed').innerHTML = result.data.frequency;
                document.querySelector('#cpu-cache').innerHTML = result.data.cache;
                document.querySelector('#cpu-bogomips').innerHTML = result.data.bogomips;
                document.querySelector('#cpu-temperature').innerHTML = result.data.temperature;
            }, function (apiResponse) {
                Minitoring.Api.notifyApiResponse(apiResponse);
            }
        );
    }
}
