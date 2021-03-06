/* --- Packages --- */
Minitoring.Packages = {

    init:function() {
        Minikit.Event.add(document.querySelector('#packages-bottom-paginator'), 'click', Minitoring.Packages.onPaginatorClick);
        Minikit.Event.add(document.querySelector('table#packages-table '), 'click', function (e) {
            Minitoring.Packages.tableClicked(e);
        });
    },
    
    onPaginatorClick: function(e) {
        e.preventDefault();
        var el = e.target.closest('[data-offset]');
        if (Minikit.isObj(el)) {
            //Minitoring.Packages.get(parseInt(el.getAttribute('data-offset')));
        }
    },

    refreshAll:function(){
        Minitoring.Packages.getUpgrables();
        Minitoring.Packages.getAll();
    },
    refresh: function () {
        switch (Minitoring.View.getCurrentView()) {
            case 'packages':
            case 'packages/all':
                Minitoring.Packages.getAll();
                break;

            case 'packages/upgradable':
                Minitoring.Packages.getUpgrables();
                break;
        }
    },

    groupbyChanged: function () {
        
    },

    // "grouped row struff"
    tableClicked: function (e) {
        var row = e.target.closest('tr.group-row');
        if (Minikit.isObj(row)) {
            var currentlyExpanded   = row.classList.contains('expanded'),
                expanded            = !currentlyExpanded;
                id                  = row.getAttribute('data-group-id');

            if (expanded) {
                row.classList.add('expanded');
                Array.prototype.forEach.call(document.querySelectorAll('#packages-table tr[data-group-parentid="' + id + '"]'), function (el) {
                    el.classList.remove('hidden');
                });
            } else {
                row.classList.remove('expanded');
                Array.prototype.forEach.call(document.querySelectorAll('#packages-table tr[data-group-parentid="' + id + '"]'), function (el) {
                    el.classList.add('hidden');
                });
            }

        }
    },

    getAll: function () {
        document.querySelector('#packages-comment').innerHTML = '';
        document.querySelector('#packages-comment').classList.remove('active');
        document.querySelector('#packages-table thead').innerHTML = '';
        document.querySelector('#packages-bottom-paginator').setAttribute('data-label', '');
        document.querySelector('#packages-table tbody').innerHTML= Minitoring.UI.getTableLoader(10);
        Minitoring.Api.get('api/packages', null, function (result) {
            var bodyHtml = '', 
                dashboardErrorHtml = '<span class="badge" data-badge="success">0</span>'
                currentGroup = '',
                lastGroup = '',
                lastGroupCount = 0,
                groupRowsDetailHtml = '';

            var groupRow = function(group, count){
                return '<tr class="group-row" data-group-id="' + group + '">' +
                        '<td class="align-left" colspan="10"><a class="toggle"><i class="fa fa-fw color-theme"></i><span class="text-bold">' + group + '</span><span class="margin-left-6 color-light">(' + count + ')</span></td>' +
                        '</tr>'
            }

            for (var i = 0; i < result.data.packages.length; i++) {
                currentGroup = result.data.packages[i].name.charAt(0).toUpperCase();
                
                // new group and previous group is not empty, add it
                if (currentGroup !== lastGroup && lastGroup !== ''){
                    
                    bodyHtml += groupRow(lastGroup, lastGroupCount);
                    bodyHtml += groupRowsDetailHtml;
                
                    // register new group, reset details
                    lastGroup = currentGroup;
                    lastGroupCount = 0;
                    groupRowsDetailHtml = '';
                }

                lastGroup = currentGroup;
                lastGroupCount++;
                groupRowsDetailHtml += Minitoring.Packages.getpackageHtml(result.data.packages[i], lastGroup);

                // last item? add group row and details
                if (i === result.data.packages.length -1){
                    bodyHtml += groupRow(lastGroup, lastGroupCount); 
                    bodyHtml += groupRowsDetailHtml;
                }
            }

            if (result.data.number_error > 0) {
                dashboardErrorHtml = '<span class="badge" data-badge="error">' + result.data.number_error + '</span>';
            }

            document.querySelector('#dashboard_packages_total').innerHTML = result.data.number_total;
            document.querySelector('#dashboard_packages_error').innerHTML = dashboardErrorHtml;
            document.querySelector('#dashboard_packages_installed').innerHTML = '<span class="badge" data-badge="success">' + result.data.number_installed + '</span>';
            document.querySelector('#packages-table tbody').innerHTML = bodyHtml;
            document.querySelector('#packages-table thead').innerHTML = '<tr>' +
//                                    '<th data-column="State">State</th>' +
                                    '<th data-column="Group" class="group"></th>' +
                                    '<th data-column="Name">Name</th>' +
                                    '<th data-column="Version">Version</th>' +
                                    '<th data-column="Arch">Arch</th>' +
                                    '<th data-column="Description">Description</th>' +
                                    '<th data-column="Action">Action</th>' +
                                    '<th data-column="Status">Status</th>' +
                                    '<th data-column="Error">Error</th>' +
                                '</tr>'; 

            document.querySelector('#packages-bottom-paginator').setAttribute('data-label', result.data.packages.length + ' / ' + result.data.packages.length + ' item(s) displayed');    
        });
    },

    getUpgrables: function () {
        document.querySelector('#packages-comment').innerHTML = '';
        document.querySelector('#packages-comment').classList.remove('active');
        document.querySelector('#packages-table thead').innerHTML = '';
        document.querySelector('#packages-bottom-paginator').setAttribute('data-label', '');
        document.querySelector('#packages-table tbody').innerHTML = Minitoring.UI.getTableLoader(10);
        Minitoring.Api.get('api/packages/upgradable', null, function (result) {
            var bodyHtml = '',
                numberPackages = result.data.number,
                menuItemUpgradable = document.querySelector('#packages-upgradable-menuitem'),
                dashboardUpgradableHtml = numberPackages;
                          
            if (numberPackages > 0) {
                dashboardUpgradableHtml = '<span class="badge" data-badge="warning">' + numberPackages + '</span>';
                menuItemUpgradable.classList.add('badge');
                menuItemUpgradable.classList.add('margin-left-6');
                menuItemUpgradable.setAttribute('data-badge','warning');
                menuItemUpgradable.innerHTML = numberPackages;
            } else {
                dashboardUpgradableHtml = '<span class="badge" data-badge="success">' + numberPackages + '</span>';
                document.querySelector('#packages-comment').innerHTML = result.data.message;
                document.querySelector('#packages-comment').classList.add('active');
                menuItemUpgradable.classList.remove('badge');
                menuItemUpgradable.classList.remove('margin-left-6');
                //menuItemUpgradable.setAttribute('data-badge','success');
                menuItemUpgradable.innerHTML = '';
            }

            for (var i = 0; i < result.data.packages.length; i++) {
                bodyHtml += Minitoring.Packages.getUpgradableHtml(result.data.packages[i]);
            }

            document.querySelector('#dashboard_packages_upgradable').innerHTML = dashboardUpgradableHtml;
            document.querySelector('#packages-table tbody').innerHTML = bodyHtml;
            document.querySelector('#packages-table thead').innerHTML = '<tr>' +
                                    '<th data-column="Name">Name</th>' +
                                    '<th data-column="Suite">Suite</th>' +
                                    '<th data-column="Arch">Arch</th>' +
                                    '<th data-column="Current version">Current version</th>' +
                                    '<th data-column="New version">New version</th>' +
                                  '</tr>'; 
            document.querySelector('#packages-bottom-paginator').setAttribute('data-label', numberPackages + ' / ' + numberPackages + ' item(s) displayed');    
        });
    },

    getpackageHtml: function (item, group) {
        //data-parentid="' + rowId + '" class="hidden">';

        var html = '<tr data-group-parentid="' + group + '" class="hidden">', errorHtml = '';
        if (Minikit.isObj(item.error)){
            errorHtml = '<span class="badge" data-badge="error">' + item.error + '</span>';
        }
        html += '<td data-column="Group" class="group"></td>';
        html += '<td data-column="Name">'        + item.name        + '</td>';
        html += '<td data-column="Version">'     + item.version     + '</td>';
        html += '<td data-column="Arch">'        + item.arch        + '</td>';
        html += '<td data-column="Description">' + item.description + '</td>';
        html += '<td data-column="Action">'      + item.action      + '</td>';
        html += '<td data-column="Status"><span class="badge" data-badge="'+ item.status_code + '">' + item.status + '</span></td>';
        html += '<td data-column="Error">'+ errorHtml + '</td>';
        html += '</tr>';
        return html;
    },

    getUpgradableHtml: function (item) {
        var html = '<tr>';
        html += '<td data-column="Name">' + item.name + '</td>';
        html += '<td data-column="Suite">' + item.suite + '</td>';
        html += '<td data-column="Arch">' + item.arch + '</td>';
        html += '<td data-column="Current version">' + item.current_version + '</td>';
        html += '<td data-column="New version">' + item.version + '</td>';
        html += '</tr>';
        return html;
    }
}