// standalone loader, modules not available for all users
Minikit.ready(function () {
    Minitoring.Settings.Logs.init();
    Minitoring.Settings.Services.init();
    Minitoring.Users.init();
});