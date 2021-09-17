/* --- Dashboard --- */
Minitoring.Dashboard = {
    refresh: function () {
        Minitoring.SystemInfos.get();
        Minitoring.LoadAverage.get();
        Minitoring.Cpu.get();
        Minitoring.Swap.get();
        Minitoring.Memory.get();
        Minitoring.Process.get();
        Minitoring.Services.refresh();
        Minitoring.Disks.refresh();
        Minitoring.Network.get();
        Minitoring.SystemUsers.getNumberActive();
        Minitoring.Packages.refreshAll();
        Minitoring.Ping.refresh();
    }
}
