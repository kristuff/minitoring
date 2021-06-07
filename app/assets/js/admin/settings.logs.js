/* --- Logs --- */
Minitoring.Settings.Logs = {
    init:function(){

         //if (Minikit.isObj(Minitoring.Logs.defaultSettings) != true){
            //Minitoring.Api.get('api/logs/defaults', null,
            //    function (result) {
            //        Minitoring.Logs.defaultSettings = result.data;
            //    }
            //);
        //}

        Minitoring.Api.get('api/logs/types', null,
            function (result) {
                var html = '';
                for (var i = 0; i < result.data.length; i++) {
                    html += '<option value="' + result.data[i] + '">' + result.data[i] + '</option>';
                }
                document.querySelector('select#log-create-type').innerHTML = html;
                document.querySelector('select#log-edit-type').innerHTML = html;
            }
        );

        Minikit.Event.add(document.querySelector('#settings-logs-table'), 'click', Minitoring.Settings.Logs.onTableClick);
    },

    getLogFilesDetails: function () {
        Minitoring.Api.get('api/logs', null,
            function (result) {
                var html = '';
                 // boxId = Minikit.newId();
                    for (var i = 0; i < result.data.length; i++) {
                    html += '<tr data-id="' + result.data[i].logId + '">';
//                    html += '  <td data-column="Select">';
//                    html += '   <input type="checkbox" class="checkbox" id="' + boxId + '" />';
//                    html += '   <label for="' + boxId + '"></label>'; 
//                    html += '  </td>';
                    html += '<td data-column="Name" class="align-left">' + result.data[i].logName + '</td>';
                    html += ' <td data-column="Actions" class="action-bar align-right tab-no-padding desk-no-padding">';
                    html += ' <span class="row-actions visible-hover">';
                    html += '   <a class="row-button action-link" title="Edit" data-action="edit" data-log-id="' +  result.data[i].logId + '" ><i class="fa fa-pencil"></i></a>';
                    html += '   <a class="row-button action-link" title="Delete" data-action="delete" data-log-id="' +  result.data[i].logId + '" ><i class="fa fa-trash"></i></a>';
                    html += '  </span>';
                    html += ' </td>';
                    html += '<td data-column="Type" class="align-left"><span class="badge" data-badge="dark">' + result.data[i].logType + '</span></td>';
                    html += '<td data-column="Path" class="align-left">' + result.data[i].logPath + '</td>';
                    html += '<td data-column="Format" class="align-left">' + result.data[i].logFormat + '</td>';
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
                var args = 'log_name='     + document.querySelector('#system-logs-dialog  #log-create-name').value + 
                           '&log_path='    + document.querySelector('#system-logs-dialog  #log-create-path').value +
                           '&log_type='    + document.querySelector('#system-logs-dialog  #log-create-type').value +
                           '&log_format='  + document.querySelector('#system-logs-dialog  #log-create-format').value ;

                Minitoring.Api.post('api/logs', args, function (response) {
                    Minitoring.Logs.getLogFilesList();
                    Minitoring.Settings.Logs.getLogFilesDetails();
                    document.querySelector('#system-logs-dialog').classList.remove('active');
                });
                break;

            case 'edit':
                var id = document.querySelector('#system-logs-dialog').getAttribute('data-id'),
                    args = 'log_name='     + document.querySelector('#system-logs-dialog  #log-edit-name').value + 
                           '&log_path='    + document.querySelector('#system-logs-dialog  #log-edit-path').value +
                           '&log_type='    + document.querySelector('#system-logs-dialog  #log-edit-type').value +
                           '&log_format='  + document.querySelector('#system-logs-dialog  #log-edit-format').value ;

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

// standalone loader, module not available for all users
Minikit.ready(function () {
    Minitoring.Settings.Logs.init();
});