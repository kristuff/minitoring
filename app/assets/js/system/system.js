/* --- System --- */
Minitoring.System = {
    refresh:function(){
        Minitoring.SystemInfos.get();
        Minitoring.LoadAverage.get();
        Minitoring.Cpu.get();
        Minitoring.Swap.get();
        Minitoring.Memory.get();
    },
}