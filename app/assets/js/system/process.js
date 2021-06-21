/* --- Packages --- */
Minitoring.Process = {
    get: function () {
        Minitoring.Api.get('api/system/process', null,
            function (result) {
                document.querySelector('#dashboard_process_total').innerHTML = result.data.total;
                document.querySelector('#dashboard_process_running').innerHTML = result.data.running;
            }
        );
    }
}