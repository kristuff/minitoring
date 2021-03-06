/* --- Settings --- */
Minitoring.Settings = {

    loadUserSettings: function () {
        Minitoring.Api.get('api/users/self/settings' , null, function (apiResponse) {
            Minitoring.Settings.setTheme(apiResponse.data.UI_THEME ? apiResponse.data.UI_THEME : 'dark');
            Minitoring.Settings.setThemeColor(apiResponse.data.UI_THEME_COLOR ? apiResponse.data.UI_THEME_COLOR : 'green');
        });
    },

    setTheme:function(theme){
        document.body.setAttribute("data-theme", theme)
    },
    
    setThemeColor:function(color){
        document.body.setAttribute("data-color", color)
    },

    themeChanged: function () {
        var newtheme = document.getElementById('select-theme').value;
        Minitoring.Settings.updateSettingValue('UI_THEME', newtheme, function() {
            Minitoring.Settings.setTheme(newtheme);
        });
    },

    languageChanged: function () {
        var newValue = document.getElementById('select-language').value,
            currentValue = document.querySelector('body').getAttribute('data-language');

            if (newValue && newValue != currentValue){
                Minitoring.Settings.updateSettingValue('UI_LANG', newValue, function() {
                    window.location.reload();
                });
            }
    },

    themeColorChanged: function () {
        var newcolor = document.getElementById('select-theme-color').value;
        Minitoring.Settings.updateSettingValue('UI_THEME_COLOR', newcolor, function() {
            Minitoring.Settings.setThemeColor(newcolor);
        });
    },

    updateSettingValue: function (paramName, value, onSuccess) {
         Minitoring.Api.put('api/users/self/settings', 'parameter=' + paramName + '&value=' + value, onSuccess);
    },

    // reset current user settings  
    resetCurrent: function () {
        Minikit.dialog({
            message: document.querySelector("#reset-settings-button").getAttribute('data-dialog-text'),
            cancelable: true,
            type: 'warning',
            okButtonText: document.querySelector('.dialog-button-ok').innerHTML,
            cancelButtonText: document.querySelector('.dialog-button-cancel').innerHTML,
            callback: function(){
                Minitoring.Api.delete('api/users/self/settings', '', function (apiResponse) {
                    Minitoring.Api.notifyApiResponse(apiResponse);
                    Minitoring.Settings.loadUserSettings();
                });            
            }
        });
    }
}
