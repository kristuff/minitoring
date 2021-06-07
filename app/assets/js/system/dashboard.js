/* --- Dashboard --- */
Minitoring.Dashboard = {
    refresh: function () {
        Minitoring.System.refresh();
        Minitoring.Services.refreshDashBoard();
        Minitoring.Disks.get();
        Minitoring.Network.get();
        Minitoring.SystemUsers.getNumberActives();    
    }
}
