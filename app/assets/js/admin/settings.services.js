/* --- Services --- */
Minitoring.Settings.Services = {

    init:function(){
        Minikit.Event.add(document.querySelector('#settings-services-table'), 'click', function (e) {
            Minitoring.Settings.Services.tableClicked(e);
        });
    },

    showDialog: function (section, id) {
        Minikit.each(document.querySelectorAll('#services-dialog .dialog-part'), function (el) {
            if (el.getAttribute('data-part') == section) {
                el.classList.add('active');
            } else {
                el.classList.remove('active');

            }
        });
        document.querySelector('#services-dialog .dialog-inner').classList.add('active');
        document.querySelector('#services-dialog').setAttribute('data-id', Minikit.isNotNull(id) ? id : '');
        document.querySelector('#services-dialog').classList.add('active');
    },

    //TODO
    handleDialog: function(){
        switch (document.querySelector('#services-dialog .dialog-part.active').getAttribute('data-part')) {
          
            case 'add':
                //TODO
                    //var token = document.querySelector('#users').getAttribute('data-token'),
                    //    email = document.querySelector('#user-invite-email').value,
                    //    args = 'userEmail=' + email + '&token=' + token + '&output=json';
                    
                    alert('TODO');
                        //Minitoring.Api.apiRequest('POST', '/settings/users/invite', args, function (result) {
                    //    Minitoring.Users.setRequestFeedback(result);
                    //});
                    break;


                case 'xxcreate':
                    alert('todo');
                    break;
                
                case 'delete':
                    alert('TODO');
                    break;

        }
        
        // close dialog
        document.querySelector('#services-dialog ').classList.remove('active');
        document.querySelector('#services-dialog ').setAttribute('data-id', '');
        e.preventDefault();
    },
    
    tableClicked: function (e) {
        var el = e.target.closest('a');
        if (Minikit.isObj(el) && el.classList.contains('action-link')) {
            e.preventDefault();
            var action = el.getAttribute('data-action');
            var id = el.getAttribute('data-id');
            if (Minikit.isObj(action) && Minikit.isObj(id)) {
                switch (action) {
                    case 'delete': 
                        new Minikit.Dialog({type:'question', message:'This will remove the service from the list and all history. Do  ?'}, true, function () {
                           alert("todo");
                           // Minitoring.Settings.Services.remove(id);
                        });
                        break;
                    case 'edit': break;
                }
            }
        } else {
            var input = e.target.closest('input[type="checkbox"]');
            if (Minikit.isObj(input)) {
                var id = input.getAttribute('data-id');
                var checked = input.getAttribute('checked');
                if (checked) {
                    Minitoring.Settings.Services.activate(id);
                } else {
                    Minitoring.Settings.Services.desactivate(id);
                }

            }
        }
    },

    getHtml: function (item) {
        var html = '',
            port = Minikit.isObj(item.service_port) ? item.service_port : 'N.C.',
            //status = item.service_check_status == '1' ? 'online' : 'offline';
            status = item.service_port_open ? 'online' : 'offline',
            badge = status == 'online' ? 'success' : 'error',
            checked = item.service_check_enabled == '1' ? 'checked' : '',
            checkboxId = Minikit.newId();

        html += '<tr data-id="' + item.service_id + '">';
        html += ' <td data-column="Service" class="align-left">' + item.service_name + '</td>';
        html += ' <td class="align-right no-padding" data-column="Actions">';
        html += '  <span class="row-actions visible-hover ">';
        html += '   <a class="row-button action-link" data-action="edit" data-id="' + item.service_id + '" data-color=""><i class="fa fa-pencil"></i><span class="mob-only padding-left-6">Edit</span></a>';
        html += '   <a class="row-button action-link" data-action="delete" data-id="' + item.service_id + '" data-color=""><i class="fa fa-trash"></i><span class="mob-only padding-left-6">Delete</span></a>';
        html += '  </span>';
        html += ' </td>';
        html += ' <td data-column="Port" class="align-right">' + port + '</td>';
        html += ' <td data-column="Check enabled" class="align-center">';
        html += '  <input type="checkbox" id="'+ checkboxId +'" class="switch" ' + checked + ' data-id="' + item.service_id + '" />';
        html += '  <label for="'+ checkboxId +'"></label>'; 
        html += ' </td>';
        html += '</tr>';
        return html;
    },
     
    // refresh current view
    refresh: function(){
        var tableBody = document.querySelector('#settings-services #settings-services-table tbody');
        Minitoring.Api.get('api/services/list', null, 
            function (result) {
                var html = '';
                for (var i = 0; i < result.data.items.length; i++) {
                    html += Minitoring.Settings.Services.getHtml(result.data.items[i]);
                }
                tableBody.innerHTML = html;
            }
        );
    },
    
    activate: function (id) {
        Minitoring.Api.apiRequest('PUT', 'api/services/activate/' + id , null, function (result) {
            document.querySelector('tr[data-id="' + id + '"] input[type="checkbox"].toggle').setAttribute('checked', 'true');
        });
    },
    desactivate: function (id) {
        Minitoring.Api.apiRequest('PUT', 'api/services/desactivate/' + id , null, function (result) {
            document.querySelector('tr[data-id="' + id + '"] input[type="checkbox"].toggle').setAttribute('checked', 'false');
        });
    },
    remove: function (id) {
        Minitoring.Api.apiRequest('DELETE', 'api/services/' + id , null, function (result) {
            var oldRow = document.querySelector('tr[data-id="' + id + '"]');
            oldRow.parentNode.removeChild(oldRow);
        });
    },

    
    add:function(){
        Minitoring.Settings.Services.showDialog('add');
    },
}