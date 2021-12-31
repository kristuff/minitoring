/*
 *        _      _ _           _
 *  _ __ (_)_ _ (_) |_ ___ _ _(_)_ _  __ _
 * | '  \| | ' \| |  _/ _ \ '_| | ' \/ _` |
 * |_|_|_|_|_||_|_|\__\___/_| |_|_||_\__, |
 *                                   |___/
 * 
 * This file is part of Kristuff\Minitoring.
 * (c) Kristuff <kristuff@kristuff.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @version    0.1.21
 * @copyright  2017-2021 Kristuff
 */

/* global namespace */
var Minitoring = Minitoring || {};

// standalone loader, modules not available for all users
Minikit.ready(function () {
    Minitoring.Settings.Logs.init();
    Minitoring.Settings.Services.init();
    Minitoring.Settings.Pings.init();
    Minitoring.Users.init();
});

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
    },
    cpuShowTempChanged: function(){
        Minitoring.Admin.updateAppSettingValue('CPU_SHOW_TEMPERATURE', document.querySelector("#cpu_show_temp").checked ? 1 : 0);
    }

}
/* --- Logs --- */
Minitoring.Settings.Logs = {
    logFormats:{},

    init:function(){
        Minitoring.Settings.Logs.getLogFormats();
        Minikit.Event.add(document.querySelector('#settings-logs-table'), 'click', Minitoring.Settings.Logs.onTableClick);
    },

    dialogCreateFormatChanged: function(){
        var selectElement = document.querySelector('select#log-create-format-name');
            logFormat     = selectElement.options[selectElement.selectedIndex].getAttribute('data-log-format');

        document.querySelector('input#log-create-format').value = logFormat;
        
        if (logFormat == ''){
            document.querySelector('input#log-create-format').removeAttribute('readonly');            
        } else {
            document.querySelector('input#log-create-format').setAttribute('readonly', 'readonly');
        }
        document.querySelector('input#log-create-type').value = selectElement.options[selectElement.selectedIndex].getAttribute('data-log-type');
    }, 
    dialogEditFormatChanged: function(){
        var selectElement = document.querySelector('select#log-edit-format-name'),
            logFormat     = selectElement.options[selectElement.selectedIndex].getAttribute('data-log-format');

        document.querySelector('input#log-edit-format').value = logFormat;

        if (logFormat == ''){
            document.querySelector('input#log-edit-format').removeAttribute('readonly');            
        } else {
            document.querySelector('input#log-edit-format').setAttribute('readonly', 'readonly');
        }

        document.querySelector('input#log-edit-type').value = selectElement.options[selectElement.selectedIndex].getAttribute('data-log-type');
    }, 

    getLogFormats: function () {
     
        Minitoring.Api.get('api/logs/formats', null,
            function (result) {
                Minitoring.Settings.Logs.logFormats = result.data;
                var html = ''; //'<option value="">...</option>';
                for (var i = 0; i < result.data.length; i++) {
                    html += '<option value=\'' + result.data[i].type + '_' + result.data[i].name 
                        + '\' data-log-format=\'' + result.data[i].format 
                        + '\' data-log-format-name="' + result.data[i].name 
                        + '" data-log-type="' + result.data[i].type 
                         + '">' + result.data[i].longName + '</option>';
                }

                document.querySelector('select#log-create-format-name').innerHTML = html;
                document.querySelector('select#log-edit-format-name').innerHTML = html;
            }
        );
    },

    setAutocomplete:function(type) {

        for ( var i = 0; i < Minitoring.Settings.Logs.logFormats.length; i++) {
            if (Minitoring.Settings.Logs.logFormats[i].logType == type){

                clone = Object.assign({}, Minitoring.Logs.logList[i]);
                break;
            }
        }
    },

    getLogFilesDetails: function () {
        Minitoring.Api.get('api/logs', null,
            function (result) {
                var html = '';
                    for (var i = 0; i < result.data.length; i++) {
                    html += '<tr data-id="' + result.data[i].logId + '" data-log-format-name="' + result.data[i].logFormatName + '" data-log-format=\'' +  result.data[i].logFormat + '\'>';
                    html += '<td data-column="Name" class="align-left">' + result.data[i].logName + '</td>';
                    html += ' <td data-column="Actions" class="action-bar align-right tab-no-padding desk-no-padding">';
                    html += ' <span class="row-actions visible-hover">';
//TODO              html += '<a class="row-button action-link" title="Copy" data-action="copy" data-log-id="' +  result.data[i].logId + '"><i class="fa fa-copy"></i></a>';
                    html += '<a class="row-button action-link" title="Edit" data-action="edit" data-log-id="' +  result.data[i].logId + '"><i class="fa fa-pencil"></i><span class="mob-only padding-left-6">Edit</span></a>';
                    html += '<a class="row-button action-link" title="Delete" data-action="delete" data-log-id="' +  result.data[i].logId + '"><i class="fa fa-trash"></i><span class="mob-only padding-left-6">Delete</span></a>';
                    html += '</span>';
                    html += ' </td>';
                    html += '<td data-column="Path" class="align-left">' + result.data[i].logPath + '</td>';
                    html += '<td data-column="Type" class="align-left"><span class="badge" data-badge="dark">' + result.data[i].logType + '</span></td>';
                    html += '<td data-column="Format" class="align-left">' + result.data[i].logFormatName + '</td>';
                    html += '</tr>';
                }
                document.querySelector('table#settings-logs-table tbody').innerHTML = html;
            }
        );
    },

    onTableClick: function (e) {
        var el = e.target.closest('a');
        if (Minikit.isObj(el) && el.hasAttribute('data-action')) {
            e.preventDefault();

            var action      = el.getAttribute('data-action'),
                id          = el.getAttribute('data-log-id'),
                currentItem;

            if (Minikit.isObj(action) && Minikit.isObj(id)) {
                switch (action) {

                    case 'copy':
                        alert('TODO');
                        break;

                    case 'delete':
                        Minitoring.Api.delete('api/logs/' + id, null, function(response){
                            document.querySelector('table#settings-logs-table tr[data-id="' + id + '"]').remove();
                            Minitoring.Logs.getLogFilesList(); //reload select
                        });
                        break;
                    
                    case 'edit':
                        currentItem = Minitoring.Logs.getlogInfoFromCache(id);
                        document.querySelector('#system-logs-dialog').setAttribute('data-id', id)  
                        document.querySelector('#system-logs-dialog  #log-edit-name').value   = currentItem.logName;
                        document.querySelector('#system-logs-dialog  #log-edit-path').value   = currentItem.logPath;
                        document.querySelector('#system-logs-dialog  #log-edit-type').value   = currentItem.logType;
                        document.querySelector('#system-logs-dialog  #log-edit-format').value = currentItem.logFormat;
                        document.querySelector('#system-logs-dialog  #log-edit-format-name').value = currentItem.logType + '_' + currentItem.logFormatName;
                        Minitoring.Settings.Logs.showDialog('edit');
                        break;
                }
            }
        }
    },

    showDialog: function (section, id) {
        Minikit.each(document.querySelectorAll('#system-logs-dialog .dialog-part'), function (el) {
            if (el.getAttribute('data-part') == section) {
                el.classList.add('active');
            } else {
                el.classList.remove('active');

            }
        });
        document.querySelector('#system-logs-dialog').setAttribute('data-log-id', Minikit.isNotNull(id) ? id : '');
        document.querySelector('#system-logs-dialog').classList.add('active');
    },

    handleDialog: function(){
        // Minitoring.Users.clearFeedback();
        switch (document.querySelector('#system-logs-dialog .dialog-part.active').getAttribute('data-part')) {
            
            case 'create':
                var selectElement = document.querySelector('select#log-create-format-name'),
                    args = 'log_name='          + document.querySelector('#system-logs-dialog  #log-create-name').value + 
                           '&log_path='         + document.querySelector('#system-logs-dialog  #log-create-path').value +
                           '&log_type='         + document.querySelector('#system-logs-dialog  #log-create-type').value +
                           '&log_format='       + document.querySelector('#system-logs-dialog  #log-create-format').value +
                           '&log_format_name='  + selectElement.options[selectElement.selectedIndex].getAttribute('data-log-format-name');
                        // '&log_format_name='  + document.querySelector('#system-logs-dialog  #log-create-format-name').value ;

                Minitoring.Api.post('api/logs', args, function (response) {
                    Minitoring.Logs.getLogFilesList();
                    Minitoring.Settings.Logs.getLogFilesDetails();
                    document.querySelector('#system-logs-dialog').classList.remove('active');
                });
                break;

            case 'edit':
                var selectElement = document.querySelector('select#log-edit-format-name'),
                    id            = document.querySelector('#system-logs-dialog').getAttribute('data-id'),
                    args = 'log_name='          + document.querySelector('#system-logs-dialog  #log-edit-name').value + 
                           '&log_path='         + document.querySelector('#system-logs-dialog  #log-edit-path').value +
                           '&log_type='         + document.querySelector('#system-logs-dialog  #log-edit-type').value +
                           '&log_format='       + document.querySelector('#system-logs-dialog  #log-edit-format').value +
                           '&log_format_name='  + selectElement.options[selectElement.selectedIndex].getAttribute('data-log-format-name');
                        //'&log_format_name='  + document.querySelector('#system-logs-dialog  #log-edit-format-name').value ;

                Minitoring.Api.post('api/logs/' + id, args, function (response) {
                    Minitoring.Logs.getLogFilesList();
                    Minitoring.Settings.Logs.getLogFilesDetails();
                    document.querySelector('#system-logs-dialog').classList.remove('active');
                });
                break;
        }
    },


    add:function(){
        Minitoring.Settings.Logs.showDialog('create');
    },
}


/* --- Pings --- */
Minitoring.Settings.Pings = {
    init:function(){
        Minikit.Event.add(document.querySelector('#settings-pings-table'), 'click', Minitoring.Settings.Pings.tableClicked);
    },

    add:function(){
        document.querySelector('#ping-dialog [data-part="add"]').setAttribute('data-action','add');
        document.querySelector('#ping-dialog-title').innerHTML = document.querySelector('#ping-dialog [data-part="add"]').getAttribute('data-add-title');
        document.querySelector('#ping-dialog #ping-dialog-host').value       = "";
        Minitoring.Settings.Pings.showDialog('add', '');
    },

    edit:function(id){
        document.querySelector('#ping-dialog [data-part="add"]').setAttribute('data-action','edit');
        document.querySelector('#ping-dialog-title').innerHTML = document.querySelector('#ping-dialog [data-part="add"]').getAttribute('data-edit-title');
        var currentItem =  document.querySelector('#settings-pings-table tr[data-id="' + id + '"');
        document.querySelector('#ping-dialog #ping-dialog-host').value       = currentItem.getAttribute('data-ping-host');
        Minitoring.Settings.Pings.showDialog('add', id);
    },
    
    activate: function (id) {
        Minitoring.Api.apiRequest('PUT', 'api/ping/' + id + '/enable' , null, function (response) { }, function (response) {
            Minitoring.Api.notifyApiResponse(response);
            var enable = document.querySelector('#settings-pings-table tr[data-id="' + id + '"]').getAttribute('data-ping-check-enabled'); 
            document.querySelector('#settings-pings-table tr[data-id="' + id + '"] input[type="checkbox"]').setAttribute('checked', enable ? 'true' : 'false');
        });
    },
    
    desactivate: function (id) {
        Minitoring.Api.apiRequest('PUT', 'api/ping/' + id + '/disable', null, function (result) { }, function (response) {
            Minitoring.Api.notifyApiResponse(response);
            var enable = document.querySelector('#settings-pings-table tr[data-id="' + id + '"]').getAttribute('data-ping-check-enabled'); 
            document.querySelector('#settings-pings-table tr[data-id="' + id + '"] input[type="checkbox"]').setAttribute('checked', enable ? 'true' : 'false');
        });
    },

    remove: function (id) {
        Minitoring.Api.apiRequest('DELETE', 'api/ping/' + id , null, function (result) {
            var oldRow = document.querySelector('#settings-pings-table tr[data-id="' + id + '"]');
            oldRow.parentNode.removeChild(oldRow);
        });
    },

    showDialog: function (section, id) {
        Minikit.each(document.querySelectorAll('#ping-dialog .dialog-part'), function (el) {
            el.classList.remove('active');
        });
        document.querySelector('#ping-dialog [data-part="add"]').classList.add('active');
        document.querySelector('#ping-dialog').setAttribute('data-id', id);
        document.querySelector('#ping-dialog').classList.add('active');
    },

    handleDialog: function(){
        switch (document.querySelector('#ping-dialog .dialog-part.active').getAttribute('data-action')) {
            
            case 'add':
                var args = 'ping_host=' + document.querySelector('#ping-dialog  #ping-dialog-host').value + 
                           '&ping_check_port=1' ; //todo

                Minitoring.Api.post('api/pings', args, function (response) {
                    Minitoring.Settings.Pings.refresh();
                    document.querySelector('#ping-dialog').classList.remove('active');
                    document.querySelector('#ping-dialog').setAttribute('data-id', '');
                });
                break;    
        
            case 'edit':
                var id   = document.querySelector('#ping-dialog').getAttribute('data-id'),
                    args = 'ping_host=' + document.querySelector('#ping-dialog  #ping-dialog-host').value;
                    
                Minitoring.Api.post('api/ping/' + id, args, function (response) {
                    Minitoring.Settings.Pings.refresh();
                    document.querySelector('#ping-dialog').classList.remove('active');
                    document.querySelector('#ping-dialog').setAttribute('data-id', '');
                });
                break;    
        }
    },
          
    refresh: function(){
        Minitoring.Api.get('api/pings/', null, function (result) {
            var html = '';
            for (var i = 0; i < result.data.items.length; i++) {
                html += Minitoring.Settings.Pings.getHtml(result.data.items[i]);
            }
            document.querySelector('#settings-pings-table tbody').innerHTML = html;
        });
    },
    
    getHtml: function (item) {
        var html = '',
            checked = item.ping_check_enabled == '1' ? 'checked' : '',
            checkboxId = Minikit.newId();

        html += '<tr data-id="' + item.ping_id + 
            '" data-ping-host="' + item.ping_host +   
            '" data-ping-check-enabled="' + item.ping_check_enabled +   
            '">';
        html += ' <td data-column="Host" class="align-left">' + item.ping_host + '</td>';
        html += ' <td class="align-right tab-no-padding desk-no-padding" data-column="Actions">';
        html += '<span class="row-actions visible-hover ">';
        html += '<a class="row-button action-link" data-action="edit" data-id="' + item.ping_id + '" data-color=""><i class="fa fa-pencil"></i><span class="mob-only padding-left-6">Edit</span></a>';
        html += '<a class="row-button action-link" data-action="delete" data-id="' + item.ping_id + '" data-color=""><i class="fa fa-trash"></i><span class="mob-only padding-left-6">Delete</span></a>';
        html += '</span>';
        html += '</td>';
        html += ' <td data-column="Check enabled" class="align-center">';
        html += '  <input type="checkbox" id="'+ checkboxId +'" class="switch" ' + checked + ' data-id="' + item.ping_id + '" />';
        html += '  <label for="'+ checkboxId +'"></label>'; 
        html += ' </td>';
        html += '</tr>';
        return html;
    },
   
    tableClicked: function (e) {
        var el = e.target.closest('a');
        if (Minikit.isObj(el) && el.classList.contains('action-link')) {
            e.preventDefault();
            var action  = el.getAttribute('data-action');
            var id      = el.getAttribute('data-id');
            if (Minikit.isObj(action) && Minikit.isObj(id)) {
                switch (action) {
                    case 'delete': 
                        Minitoring.Settings.Pings.remove(id);
                        break;
                    case 'edit': 
                        Minitoring.Settings.Pings.edit(id);
                        break;
                }
            }
        } else {
            var input = e.target.closest('input[type="checkbox"]');
            if (Minikit.isObj(input)) {
                var id = input.getAttribute('data-id');
                var checked = document.querySelector('#settings-pings-table  tr[data-id="' + id + '"] input[type="checkbox"].switch:checked');
                if (checked) {
                    Minitoring.Settings.Pings.activate(id);
                } else {
                    Minitoring.Settings.Pings.desactivate(id);
                }

            }
        }
    },
}
/* --- Services --- */
Minitoring.Settings.Services = {
      init:function(){
        Minikit.Event.add(document.querySelector('#settings-services-table'), 'click', Minitoring.Settings.Services.tableClicked);
    },

    add:function(){
        document.querySelector('#services-dialog [data-part="add"]').setAttribute('data-action','add');
        document.querySelector('#service-dialog-title').innerHTML = document.querySelector('#services-dialog [data-part="add"]').getAttribute('data-add-title');
        document.querySelector('#services-dialog #service-dialog-name').value       = "";
        document.querySelector('#services-dialog #service-dialog-host').value       = "";
        //document.querySelector('#services-dialog #service-dialog-protocol').value   = "";
        document.querySelector('#services-dialog #service-dialog-port').value       = "";
        Minitoring.Settings.Services.showDialog('add', '');
    },

    edit:function(id){
        document.querySelector('#services-dialog [data-part="add"]').setAttribute('data-action','edit');
        document.querySelector('#service-dialog-title').innerHTML = document.querySelector('#services-dialog [data-part="add"]').getAttribute('data-edit-title');
        var currentItem =  document.querySelector('#settings-services-table tr[data-id="' + id + '"');
        document.querySelector('#services-dialog #service-dialog-name').value       = currentItem.getAttribute('data-service-name');
        document.querySelector('#services-dialog #service-dialog-host').value       = currentItem.getAttribute('data-service-host');
        document.querySelector('#services-dialog #service-dialog-protocol').value   = currentItem.getAttribute('data-service-protocol');
        document.querySelector('#services-dialog #service-dialog-port').value       = currentItem.getAttribute('data-service-port');
        Minitoring.Settings.Services.showDialog('edit', id);
    },
    
    activate: function (id) {
        Minitoring.Api.apiRequest('PUT', 'api/service/' + id + '/enable' , null, function (result) { }, function (result) {
            Minitoring.Api.notifyApiResponse(response);
            var enable = document.querySelector('#settings-services-table tr[data-id="' + id + '"]').getAttribute('data-service-check-enabled'); 
            document.querySelector('#settings-services-table tr[data-id="' + id + '"] input[type="checkbox"]').setAttribute('checked', enable ? 'true' : 'false');
        });
    },
    
    desactivate: function (id) {
        Minitoring.Api.apiRequest('PUT', 'api/service/' + id + '/disable', null, function (result) { }, function (result) {
            Minitoring.Api.notifyApiResponse(response);
            var enable = document.querySelector('#settings-services-table tr[data-id="' + id + '"]').getAttribute('data-service-check-enabled'); 
            document.querySelector('#settings-services-table tr[data-id="' + id + '"] input[type="checkbox"]').setAttribute('checked', enable ? 'true' : 'false');
        });
    },

    remove: function (id) {
        Minitoring.Api.apiRequest('DELETE', 'api/service/' + id , null, function (result) {
            var oldRow = document.querySelector('#settings-services-table tr[data-id="' + id + '"]');
            oldRow.parentNode.removeChild(oldRow);
        });
    },

    showDialog: function (section, id) {
        Minikit.each(document.querySelectorAll('#services-dialog .dialog-part'), function (el) {
            el.classList.remove('active');
        });
        document.querySelector('#services-dialog [data-part="add"]').classList.add('active');
        document.querySelector('#services-dialog').setAttribute('data-id', id);
        document.querySelector('#services-dialog').classList.add('active');
    },

    handleDialog: function(){
        switch (document.querySelector('#services-dialog .dialog-part.active').getAttribute('data-action')) {
            
            case 'add':
                var args = 'service_name='      + document.querySelector('#services-dialog  #service-dialog-name').value + 
                          '&service_port='      + document.querySelector('#services-dialog  #service-dialog-port').value +
                          '&service_host='      + document.querySelector('#services-dialog  #service-dialog-host').value +
                          '&service_protocol='  + document.querySelector('#services-dialog  #service-dialog-protocol').value +
                          '&service_check_port=1' ; //todo

                Minitoring.Api.post('api/services', args, function (response) {
                    Minitoring.Settings.Services.refresh();
                    document.querySelector('#services-dialog').classList.remove('active');
                    document.querySelector('#services-dialog').setAttribute('data-id', '');
                });
                break;    
        
            case 'edit':
                var id   = document.querySelector('#services-dialog').getAttribute('data-id'),
                    args = 'service_name=' + document.querySelector('#services-dialog  #service-dialog-name').value + 
                     '&service_port='      + document.querySelector('#services-dialog  #service-dialog-port').value +
                     '&service_host='      + document.querySelector('#services-dialog  #service-dialog-host').value +
                     '&service_protocol='  + document.querySelector('#services-dialog  #service-dialog-protocol').value +
                     '&service_check_port=1' ; //todo

                Minitoring.Api.post('api/service/' + id, args, function (response) {
                    Minitoring.Settings.Services.refresh();
                    document.querySelector('#services-dialog').classList.remove('active');
                    document.querySelector('#services-dialog').setAttribute('data-id', '');
                });
                break;    
        }
    },
          
    refresh: function(){
        Minitoring.Api.get('api/services/list', null, function (result) {
            var html = '';
            for (var i = 0; i < result.data.items.length; i++) {
                html += Minitoring.Settings.Services.getHtml(result.data.items[i]);
            }
            document.querySelector('#settings-services #settings-services-table tbody').innerHTML = html;
        });
    },
    
    getHtml: function (item) {
        var html = '',
            port = Minikit.isObj(item.service_port) ? item.service_port : 'N.C.',
            //status = item.service_check_status == '1' ? 'online' : 'offline';
            status = item.service_port_open ? 'online' : 'offline',
            badge = status == 'online' ? 'success' : 'error',
            checked = item.service_check_enabled == '1' ? 'checked' : '',
            checkboxId = Minikit.newId();

        html += '<tr data-id="' + item.service_id + 
            '" data-service-name="' + item.service_name +   
            '" data-service-port="' + item.service_port +   
            '" data-service-check-enabled="' + item.service_check_enabled +   
            '" data-service-protocol="' + item.service_protocol +   
            '" data-service-host="' + item.service_host + 
            '">';
        html += '<td data-column="Service" class="align-left">' + item.service_name + '</td>';
        html += '<td class="align-right tab-no-padding desk-no-padding" data-column="Actions">';
        html += '<span class="row-actions visible-hover ">';
        html += '<a class="row-button action-link" data-action="edit" data-id="' + item.service_id + '" data-color=""><i class="fa fa-pencil"></i><span class="mob-only padding-left-6">Edit</span></a>';
        html += '<a class="row-button action-link" data-action="delete" data-id="' + item.service_id + '" data-color=""><i class="fa fa-trash"></i><span class="mob-only padding-left-6">Delete</span></a>';
        html += '</span>';
        html += '</td>';
        html += '<td data-column="Protocol" class="align-center">' + item.service_protocol + '</td>';
        html += '<td data-column="Host" class="align-left">' + item.service_host + '</td>';
        html += '<td data-column="Port" class="align-right">' + port + '</td>';
        html += '<td data-column="Check enabled" class="align-center">';
        html += '<input type="checkbox" id="'+ checkboxId +'" class="switch" ' + checked + ' data-id="' + item.service_id + '" />';
        html += '<label for="'+ checkboxId +'"></label>'; 
        html += '</td>';
        html += '</tr>';
        return html;
    },
   
    tableClicked: function (e) {
        var el = e.target.closest('a');
        if (Minikit.isObj(el) && el.classList.contains('action-link')) {
            e.preventDefault();
            var action  = el.getAttribute('data-action');
            var id      = el.getAttribute('data-id');
            if (Minikit.isObj(action) && Minikit.isObj(id)) {
                switch (action) {
                    case 'delete': 
                        Minikit.dialog({
                            message: document.querySelector("#settings-services-table").getAttribute('data-dialog-delete-text'),
                            cancelable: true,
                            type: 'warning',
                            okButtonText: document.querySelector('.dialog-button-ok').innerHTML,
                            cancelButtonText: document.querySelector('.dialog-button-cancel').innerHTML,
                            callback: function(){
                                Minitoring.Settings.Services.remove(id);
                            }
                        });
                        break;
                    case 'edit': 
                        Minitoring.Settings.Services.edit(id);
                        break;
                }
            }
        } else {
            var input = e.target.closest('input[type="checkbox"]');
            if (Minikit.isObj(input)) {
                var id = input.getAttribute('data-id');
                var checked = document.querySelector('#settings-services-table  tr[data-id="' + id + '"] input[type="checkbox"].switch:checked');
                if (checked) {
                    Minitoring.Settings.Services.activate(id);
                } else {
                    Minitoring.Settings.Services.desactivate(id);
                }

            }
        }
    },

}
Minitoring.Users = {

    init:function() {
        Minikit.Event.add(document.querySelector('#users-bottom-paginator'), 'click', Minitoring.Users.onPaginatorClick);
        Minikit.Event.add(document.querySelector('#users-top-paginator'), 'click', Minitoring.Users.onPaginatorClick);
        Minikit.Event.add(document.querySelector('#users-dialog .dialog-button-ok'), 'click', Minitoring.Users.onDialogOkClick);
        Minikit.Event.add(document.querySelector('#users-table'), 'click', Minitoring.Users.onTableClick);
    },

    refresh: function(){
        var offset = Minikit.getAttr(document.querySelector('#users-data'), 'data-offset', 0);
        Minitoring.Users.getList(offset);
    },
   
    invite:function(){
        Minitoring.Users.cleanDialog();
        Minitoring.Users.showDialog('invite','');
    },

    create:function(){
        Minitoring.Users.cleanDialog();
        Minitoring.Users.showDialog('create','');
    },

    onDialogOkClick:function (e){
        e.preventDefault();

        switch (document.querySelector('#users-dialog .dialog-part.active').getAttribute('data-part')) {
            case 'invite':
                var args = 'action=invite' + '&userEmail=' + document.querySelector('#user-invite-email').value + '&output=json';
                Minitoring.Api.post('api/users', args, function (result) {
                    Minitoring.Api.notifyApiResponse(result);
                    Minitoring.Users.refresh();
                    Minitoring.Users.closeDialog();
                });
                break;

            case 'create':
                var args = 'action=create' + '&output=json' +
                           '&userEmail=' + document.querySelector('#user-create-email').value +
                           '&userName=' + document.querySelector('#user-create-name').value +
                           '&userPassword=' + document.querySelector('#user-create-password').value +
                           '&userPasswordRepeat=' + document.querySelector('#user-create-password-repeat').value;

                Minitoring.Api.post('api/users', args, function (result) {
                    Minitoring.Api.notifyApiResponse(result);
                    Minitoring.Users.refresh();
                    Minitoring.Users.closeDialog();
                    Minitoring.Users.cleanDialog();
                });
                break;
        }
    },
    
    onPaginatorClick: function(e) {
        e.preventDefault();
        var el = e.target.closest('[data-offset]');
        if (Minikit.isObj(el)) {
            Minitoring.Users.get(parseInt(el.getAttribute('data-offset')));
        }
    },

    onTableClick: function (e) {
        var el = e.target.closest('a');
        if (Minikit.isObj(el) && el.hasAttribute('data-action')) {
            e.preventDefault();

            var action = el.getAttribute('data-action'),
                id =     el.getAttribute('data-user-id');

            if (Minikit.isObj(action) && Minikit.isObj(id)) {
                switch (action) {
                    case 'delete':
                      //case 'suspend':
                        Minitoring.Users.deleteUser(id);
                        break;
                }
            }
        }
    },

    cleanDialog: function() {
        document.querySelector('#user-create-email').value = "";
        document.querySelector('#user-create-name').value = "";
        document.querySelector('#user-create-password').value = "";
        document.querySelector('#user-create-password-repeat').value = "";
        document.querySelector('#user-invite-email').value = "";
    },

    closeDialog: function() {
         document.querySelector('#users-dialog').classList.remove('active');
         document.querySelector('#users-dialog').setAttribute('data-user-id', '');
    },

    // full delete a user 
    deleteUser: function (id) {
        Minikit.dialog({
            message: document.querySelector("#users-delete-message").value,
            cancelable: true,
            type: 'warning',
            okButtonText: document.querySelector('.dialog-button-ok').innerHTML,
            cancelButtonText: document.querySelector('.dialog-button-cancel').innerHTML,
            callback: function(){
                Minitoring.Api.delete('api/users/' + id, null, function (result) {
                    Minitoring.Api.notifyApiResponse(result);
                    Minitoring.Users.refresh();
                });
            }
        });
    },

    showDialog: function (section, id) {
        Minikit.each(document.querySelectorAll('#users-dialog .dialog-part'), function (el) {
            if (el.getAttribute('data-part') == section) {
                el.classList.add('active');
            } else {
                el.classList.remove('active');

            }
        });
        document.querySelector('#users-dialog').setAttribute('data-user-id', Minikit.isNotNull(id) ? id : '');
        document.querySelector('#users-dialog').classList.add('active');
    },

    getList: function (offset) {
        var tableBody = document.querySelector('#users-data tbody'),
            bottomPaginator = document.querySelector('#users-bottom-paginator'),
            paginatorText = '',
            html = '',
            order = Minikit.getAttr(tableBody, 'list-order', 'name'),
            limit = tableBody.getAttribute('data-limit') ? parseInt(tableBody.getAttribute('data-limit')) : 20,
            offset = Minikit.isObj(offset) ? parseInt(offset) : 0,
            args = "offset=" + offset + '&limit=' + limit + '&order=' + order + '&output=json';

        Minitoring.Api.get('api/users', args, function (response) {
            for (var i = 0; i < response.data.items.length; i++) {
                html += Minitoring.Users.getHtml(response.data.items[i]);
            }
            tableBody.innerHTML = html;
            tableBody.setAttribute('data-offset', offset);
            paginatorText = response.data.items.length + ' / ' + response.data.total + ' item(s) displayed';
            bottomPaginator.innerHTML = Minitoring.UI.getPaginatorHtml(limit, offset, response.data.total);
            bottomPaginator.setAttribute('data-label', paginatorText);
        });
    },

    getHtml: function (item) {
        var html = '',
            loginDate   = Minitoring.UI.getFormattedDate(item.userLastLoginTimestamp),
            createdDate = Minitoring.UI.getFormattedDate(item.userCreationTimestamp),
            status = '',
            badgeType = 'dark';
        
        if (item.userActivated > 0 && item.userDeleted < 1) {
            badgeType = 'success';
            status = 'Active';

        } else if (item.userDeleted == 1) {
            status = 'Deleted';
            badgeType = 'warning';
        } else if (item.userActivated == 0) {
            badgeType = 'warning';
            status = 'Inactive';
        } 

        html += '<tr class="data-row user" data-user-id="' + item.userId + '">';
        html += ' <td data-column="Avatar"><img class="avatar" src="' + item.userAvatarUrl + '"/></td>';
        html += ' <td data-column="Name">' + item.userName + '</td>';
        html += ' <td data-column="Actions" class="action-bar tab-align-right desk-align-right">';
        html += '<span class="row-actions visible-hover">';
        html += '<a class="row-button action-link" title="Delete" data-action="delete" data-user-id="' + item.userId + '" ><i class="fa fa-trash"></i><span class="title">Delete</span></a>';
        html += '</span>';
        html += ' </td>';
        html += ' <td data-column="Type">' + item.userAccountTypeRendered + '</td>';
        html += ' <td data-column="Email">' + item.userEmail + '</td>';
        html += ' <td data-column="Created on">' + createdDate + '</td>';
        html += ' <td data-column="LastLogin">' + loginDate + '</td>';
        html += ' <td data-column="Status"><span class="badge" data-badge="' + badgeType + '">' + status + '</span></td>';
        html += '</tr>';
        return html;
    }
}
