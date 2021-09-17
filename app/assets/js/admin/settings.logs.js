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

