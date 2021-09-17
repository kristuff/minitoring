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