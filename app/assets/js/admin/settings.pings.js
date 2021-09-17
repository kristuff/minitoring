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