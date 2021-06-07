/* --- Services --- */
Minitoring.Services = {

   


    init: function () {
        // init paginator
        var paginatorClicked = function (e) {
            e.preventDefault();
            var el = e.target.closest('[data-offset]');
            if (Minikit.isObj(el)) {
                Minitoring.Services.refreshHistory(parseInt(el.getAttribute('data-offset')));
            }
        };
        Minikit.Event.add(document.querySelector('section-services #services-bottom-paginator'), 'click', paginatorClicked);
        Minikit.Event.add(document.querySelector('section-services #services-top-paginator'), 'click', paginatorClicked);
       
       // todo
       // Minikit.Event.add(document.querySelector('section-services #services-table'), 'click', Minitoring.Services.tableClicked);

    },

    // refresh current view
    refresh: function(){
        switch (Minitoring.View.getCurrentView()) {
            case 'services/history':
                Minitoring.Services.getHistory();
                break;

            case 'services/index':
            case 'services':
                var tableBodyMain = document.querySelector('#section-services #services-table tbody');
                Minitoring.Services.get(tableBodyMain, true);
                break;
        }
    },

    check: function () {
        var tableBody = document.querySelector('#services-table tbody');
        Minitoring.Api.get('api/services/checks/', null,
            function (result) {
                var html = '';
                for (var i = 0; i < result.data.checks.length; i++) {
                    html += Minitoring.Services.getHtml(result.data.checks[i], full);
                }
                tableBody.innerHTML = html;
            },
            function () {
                tableBody.innerHTML = '...';
            },
            function () {
                alert('todo');
            }
        );
    },


  

    refreshDashBoard: function () {
        var tableBodyDashboard  = document.querySelector('#section-dashboard #services-table tbody');
     
        Minitoring.Api.get('api/services/list', null,
            function (result) {
                var html = '';
                for (var i = 0; i < result.data.items.length; i++) {
                    html += Minitoring.Services.getHtml(result.data.items[i], false);
                }
                tableBodyDashboard.innerHTML = html;
            }
        );
    },
    get: function (tableBody, withDate) {
     
        Minitoring.Api.get('api/services/list', null,
            function (result) {
                var html = '';
                for (var i = 0; i < result.data.items.length; i++) {
                    html += Minitoring.Services.getHtml(result.data.items[i], withDate);
                }
                tableBody.innerHTML = html;
            }
        );
    },  
    getHtml: function (item, withDate) {
        var html = '',
            port = Minikit.isObj(item.service_port) ? item.service_port : 'N.C.',
            //status = item.service_check_status == '1' ? 'online' : 'offline';
            status = item.service_port_open ? 'online' : 'offline',
            badge = status == 'online' ? 'success' : 'error',
            checked = item.service_check_enabled == '1' ? 'checked' : '',
            checkboxId = Minikit.newId();

        html += '<tr data-id="' + item.service_id + '">';
        html += '<td data-column="Service" class="align-left">' + item.service_name + '</td>';
        if (withDate) {
            var sDate = new Date(item.service_check_time * 1000);
            html += '<td data-column="">' + sDate.toDateString() + ' ' + sDate.toTimeString() + '</td>';
        }
        html += '<td data-column="" class="align-center"><span class="badge uppercase" data-badge="' + badge + '">' + status + '</span></td>';
        html += '</tr>';
        return html;
    },



     
    //TODO
    refreshHistory: function (offset) {
        Minitoring.Services.getHistory(offset);
    },

    //TODO
    getHistory: function (offset) {
        var tableBody = document.querySelector('#services-table tbody'),
            topPaginator = document.querySelector('#services-top-paginator'),
            bottomPaginator = document.querySelector('#services-bottom-paginator'),
            paginatorText = '',
            limit = tableBody.getAttribute('data-limit') ? parseInt(tableBody.getAttribute('data-limit')) : 20,
            offset = Minikit.isObj(offset) ? parseInt(offset) : 0;

        Minitoring.Api.get('api/services/check/history', 'limit=' + limit + '&offset=' + offset,
            function (result) {
                var html = '';
                for (var i = 0; i < result.data.items.length; i++) {
                    html += Minitoring.Services.getHtml(result.data.items[i], false, true);
                }
                tableBody.innerHTML = html;
                tableBody.setAttribute('data-offset', offset);
                paginatorText = result.data.items.length + ' / ' + result.data.total + ' item(s) displayed';
                topPaginator.innerHTML = Minitoring.App.getPaginatorHtml(limit, offset, result.data.total);
                bottomPaginator.innerHTML = Minitoring.App.getPaginatorHtml(limit, offset, result.data.total);
                topPaginator.setAttribute('data-label-before', paginatorText);
                bottomPaginator.setAttribute('data-label-before', paginatorText);
            }
        );
    },
   
}
