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
        Minitoring.Users.showDialog('invite','');
    },

    create:function(){
        Minitoring.Users.showDialog('create','');
    },

    onDialogOkClick:function (e){

        switch (document.querySelector('#users-dialog .dialog-part.active').getAttribute('data-part')) {
            case 'invite':
                var args = 'action=invite' + '&userEmail=' + document.querySelector('#user-invite-email').value + '&output=json';
                Minitoring.Api.post('api/users', args, function (result) {
                    Minitoring.Api.notifyApiResponse(result);
                    Minitoring.Users.refresh();
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
                });
                break;

            case 'delete':
                var full = document.querySelector('#users-dialog #user-delete-full').checked,
                    id = document.querySelector('#users-dialog').getAttribute('data-user-id');

                if (full){
                    Minitoring.Api.delete('api/users/' + id, null, function (result) {
                        Minitoring.Api.notifyApiResponse(result);
                        Minitoring.Users.refresh();
                    });
                } else {
                    Minitoring.Api.put('api/users/' + id + '/delete', null, function (result) {
                        Minitoring.Api.notifyApiResponse(result);
                        Minitoring.Users.refresh();
                    });
                }
                break;

            case 'suspend':
                var id = document.querySelector('#users-dialog').getAttribute('data-user-id'),
                    args = 'suspensionDays=' + document.querySelector('#user-suspend-days').value + '&output=json';

                Minitoring.Api.put('api/users/' + id + '/suspend', args, function (result) {
                    Minitoring.Api.notifyApiResponse(result);
                    Minitoring.Users.refresh();
                });
                break;
        }

        // close dialog
        document.querySelector('#users-dialog').classList.remove('active');
        document.querySelector('#users-dialog').setAttribute('data-user-id', '');
        e.preventDefault();

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
                    case 'suspend':
                        Minitoring.Users.showDialog(action, id);
                        break;
                }
            }
        }
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
        var html = '';
        var loginDate   = Minitoring.UI.getFormattedDate(item.userLastLoginTimestamp);
        var suspendDate = Minitoring.UI.getFormattedDate(item.userSuspensionTimestamp);
        var deletedDate = Minitoring.UI.getFormattedDate(item.userDeletionTimestamp);
        var createdDate = Minitoring.UI.getFormattedDate(item.userCreationTimestamp);
        var status = ''
        var badgeType = 'dark';
        if (item.userActivated > 0 && item.userDeleted < 1) {
            badgeType = 'success';
            status = 'Active';

            if (Minikit.isObj(item.userSuspensionTimestamp)){
                var date = new Date(item.userSuspensionTimestamp * 1000);
                var now = Date.now();
                if (date > now){
                    badgeType = 'warning';
                    status = 'Suspended';
                }
            }

        } else if (item.userDeleted == 1) {
            status = 'Deleted';
            badgeType = 'warning';
        } else if (item.userActivated == 0) {
            badgeType = 'warning';
            status = 'Inactive';
        } 

        html += '<tr class="data-row user" data-user-id="' + item.userId + '">';
        html += ' <td data-column="Avatar"><img src="' + item.userAvatarUrl + '"/></td>';
        html += ' <td data-column="Name">' + item.userName + '</td>';
        html += ' <td data-column="Actions" class="action-bar align-right no-padding">';
        html += ' <span class="row-actions visible-hover">';
        html += '   <a class="row-button action-link" title="Suspend" data-action="suspend" data-user-id="' + item.userId + '"><i class="fa fa-ban"></i></a>';
        html += '   <a class="row-button action-link" title="Delete" data-action="delete" data-user-id="' + item.userId + '" ><i class="fa fa-trash"></i></a>';
        html += '  </span>';
        html += ' </td>';
        html += ' <td data-column="Type">' + item.userAccountTypeRendered + '</td>';
        html += ' <td data-column="Email">' + item.userEmail + '</td>';
        html += ' <td data-column="Created on">' + createdDate + '</td>';
        html += ' <td data-column="LastLogin">' + loginDate + '</td>';
        html += ' <td data-column="Status"><span class="badge" data-badge="' + badgeType + '">' + status + '</span></td>';
        html += ' <td data-column="Suspended to">' + suspendDate + '</td>';
        html += ' <td data-column="Deleted on">' + deletedDate + '</td>';
        html += '</tr>';
        return html;
    }
}

// standalone loader, module not available for all users
Minikit.ready(function () {
    Minitoring.Users.init();
});