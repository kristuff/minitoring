/* --- Admin --- */
Minitoring.Admin = {
    
    resetApiKey:function(){
        Minitoring.Api.delete('api/app/auth', null, function (result) {
            document.querySelector('#settings-websocket-token').value = result.data.key;
            Minitoring.Api.key = result.data.key;
        });
    },

    updateAppSettingValue: function (paramName, value, onSuccess) {
        Minitoring.Api.post('api/app/settings', 'parameter=' + paramName + '&value=' + value, onSuccess);
    },
    
    defaultlangChanged:function(){
        Minitoring.Admin.updateAppSettingValue('UI_LANG', document.querySelector("#select-default-language").value);
    },

    ipActionChanged:function(){
        Minitoring.Admin.updateAppSettingValue('IP_ACTION', document.querySelector("#select-ip-action").value, function(response){
            document.querySelector('body').setAttribute('data-ip-action', response.data.newValue)
        });
    },

    serviceShowPortChanged: function(){
        Minitoring.Admin.updateAppSettingValue('SERVICES_SHOW_PORT_NUMBER', document.querySelector("#services_show_port").checked ? 1 : 0);
    },

    diskShowTmpfsChanged: function(){
        Minitoring.Admin.updateAppSettingValue('DISKS_SHOW_TMPFS', document.querySelector("#disks_show_tmpfs").checked ? 1 : 0);
    },

    diskShowLoopChanged: function(){
        Minitoring.Admin.updateAppSettingValue('DISKS_SHOW_LOOP', document.querySelector("#disks_show_loop").checked ? 1 : 0);
    },

    diskShowFileSystemChanged: function(){
        Minitoring.Admin.updateAppSettingValue('DISKS_SHOW_FILE_SYSTEM', document.querySelector("#disks_show_fs").checked ? 1 : 0);
    }

}