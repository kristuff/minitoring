/* --- System users --- */
Minitoring.SystemUsers = {
    init: function () {
        var paginatorClicked = function (e) {
            e.preventDefault();
            var el = e.target.closest('[data-offset]');
            if (Minikit.isObj(el)) {
                Minitoring.SystemUsers.refresh(parseInt(el.getAttribute('data-offset')));
            }
        };
        Minikit.Event.add(document.querySelector('#sysusers-bottom-paginator'), 'click', function (e) {
            paginatorClicked(e);
        });
        Minikit.Event.add(document.querySelector('#sysusers-top-paginator'), 'click', function (e) { 
            paginatorClicked(e);
        });
    },
    getNumberActive: function () {
        Minitoring.Api.get('api/sysusers/currentUsersNumber', null,
            function (result) {
                document.querySelector('#current-users-number').classList.remove('color-status-ok');
                document.querySelector('#current-users-number').classList.remove('color-status-warning');
                document.querySelector('#current-users-number').innerHTML = result.data.currentUsersNumber;
                if (result.data.currentUsersNumber > 0){
                    document.querySelector('#current-users-number').classList.add('color-status-warning');
                } else {
                    document.querySelector('#current-users-number').classList.add('color-status-ok');
                }
            }, function (apiResponse) {
                Minitoring.Api.notifyApiResponse(apiResponse);
            }
        );
    },

    // sync tabItems: set the selected tabItem
    syncNavBar:function(){
        Minikit.each(document.querySelectorAll('#section-sysusers '))

    },
    refresh: function (offset) {

        switch (Minitoring.View.getCurrentView()) {
            case 'sysusers':
            case 'sysusers/index':
            case 'sysusers/all':
                Minitoring.SystemUsers.get('all', offset);
                break;
            case 'sysusers/currents':
                Minitoring.SystemUsers.get('current', offset);
                break;
            case 'sysusers/lasts':
                Minitoring.SystemUsers.get('last', offset);
                break;
            case 'sysusers/groups':
                Minitoring.SystemUsers.get('groups', offset);
                break;
            }
    },
    get: function (what, offset) {
        var tableBody     = document.querySelector('#sysusers-table tbody'),
            tableHeader   = document.querySelector('#sysusers-table thead'),
            paginator     = document.querySelector('#sysusers-bottom-paginator'),
            paginatorText = '',
            limit         = tableBody.getAttribute('data-limit') ? parseInt(tableBody.getAttribute('data-limit')) : 20,
            offset        = Minikit.isObj(offset) ? parseInt(offset) : 0,
            html = '';
            
        Minitoring.Api.get('api/sysusers/' + what, 'limit=' + limit + '&offset=' + offset,
            function (result) {
                paginator.innerHTML = Minitoring.UI.getPaginatorHtml(limit, offset, result.data.total);
               
                if (what === 'groups'){
                    for (var i = 0; i < result.data.groups.length; i++) {
                        html += Minitoring.SystemUsers.getGroupHtml(result.data.groups[i]);
                    }
                    tableHeader.innerHTML =  Minitoring.SystemUsers.getGroupsHeaderHtml();
                    paginatorText = result.data.groups.length + ' / ' + result.data.total + ' item(s) displayed';
                
                } else {
                    for (var i = 0; i < result.data.users.length; i++) {
                        html += what === 'all' ?  Minitoring.SystemUsers.getUserItemHtml(result.data.users[i]) : 
                                                  Minitoring.SystemUsers.getHtml(result.data.users[i]) ;
                    }
                    tableHeader.innerHTML =  what === 'all' ?  Minitoring.SystemUsers.getUsersHeaderHtml() : 
                                                               Minitoring.SystemUsers.getUsersLastLoginHeaderHtml();                        
                    paginatorText = result.data.users.length + ' / ' + result.data.total + ' item(s) displayed';
                }
                
                tableBody.innerHTML = html;
                tableBody.setAttribute('data-offset', offset);
                paginator.setAttribute('data-label', paginatorText);
            }, function (apiResponse) {
                Minitoring.Api.notifyApiResponse(apiResponse);
            }
        );
    },
    getUsersLastLoginHeaderHtml: function(){
        return  '<tr class="table-header">' +
                '<th data-column="User">User</th>'+
                '<th data-column="Port">Port</th>'+
                '<th data-column="Pid">Pid</th>'+
                '<th data-column="From">Connected from</th>'+
                '<th data-column="LastLogin">Last login</th>'+
                '</tr>';
    },
    getGroupsHeaderHtml: function(){
        return  '<tr class="table-header">' +
                '<th data-column="Name">Name</th>'+
                '<th data-column="ID">ID</th>'+
                '<th data-column="Users">Users</th>'+
                '</tr>';
    },
    getUsersHeaderHtml: function(){
        return  '<tr class="table-header">' +
                '<th data-column="Name">Name</th>'+
                '<th data-column="User Id" class="align-center">User Id</th>'+
                '<th data-column="Group Id" class="align-center">Group Id</th>'+
                '<th data-column="Home Directory">Home Directory</th>'+
                '<th data-column="Login Shell">Login Shell</th>'+
                '</tr>';
    },
    getUserItemHtml: function(item){
        var html = '<tr>';
        html += '<td data-column="Name">' + item.name + '</td>';
        html += '<td data-column="User Id" class="align-center">' + item.uid + '</td>';
        html += '<td data-column="Group Id" class="align-center">' + item.gid + '</td>';
        html += '<td data-column="Home Directory">' + item.homeDirectory + '</td>';
        html += '<td data-column="Login Shell"><span class="badge" data-badge="' + (item.hasLoginShell ? 'warning' : 'info') + '">' + item.loginShell + '</span></td>';
        html += '</tr>';
        return html;

    },
    getGroupHtml: function (item) {
        var html = '<tr>', users = '';
        for (var i = 0; i < item.users.length; i++) {
            users += (i === 0) ? '' : ', ';     
            users += item.users[i];
        }
        html += '<td data-column="Name">' + item.name + '</td>';
        html += '<td data-column="ID" class="align-center">' + item.gid + '</td>';
        html += '<td data-column="Users" class="align-left">'  + users + '</td>';
        html += '</tr>';
        return html;
    },
    getHtml: function (item) {
        var html = '<tr>';
        html += '<td data-column="User">' + item.user + '</td>';
        html += '<td data-column="Port" class="align-center">' + item.port + '</td>';
        html += Minikit.isNotNull(item.pid) ? '<td data-column="Pid">' + item.pid + '</td>' : '';
        html += Minikit.isNotNull(item.comment) ? '<td data-column="Comment">' + item.comment + '</td>' : '';
        html += Minikit.isNotNull(item.from) ? '<td data-column="From">' + item.from + '</td>' : '';
        html += '<td data-column="LastLogin" class="align-left">' + item.date + '</td>';
        html += '</tr>';
        return html;
    }
}