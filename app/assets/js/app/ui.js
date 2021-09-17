/* --- UI utils --- */
Minitoring.UI = {

    // init a gauge element for given selector
    createGauge: function(selector) {
        return Gauge(document.querySelector(selector), { 
           max: 100, 
           dialStartAngle: 180, 
           dialEndAngle: 0, 
           value: 0, 
           label: function (value) { 
                var rounded = Math.round(value * 10) / 10;
                return rounded.toString() + "%";
                //return Math.round(value) + "%";
            } 
        });
    },

    getPaginatorHtml: function (limit, offset, total) {
        var html = '';
        var maxIndex = Math.ceil(total / limit);
        var currentIndex = offset > 0 ? Math.ceil(offset / limit) + 1 : 1;

        html += '<a href="#" class="previous" ' + (offset > 0 ? ' data-offset="' + (offset - limit) + '"' : ' data-disabled') + '><i class="fa fa-chevron-left"></i></a>';
        for (var i = 1; i <= maxIndex; i++) {
            html += '<a href="#" class="item ' + (i === currentIndex ? 'current' : '') + '" data-offset="' + ((i - 1) * limit) + '">' + i + '</a>';
        }
        html += '<a href="#" class="next" ' + (currentIndex < maxIndex ? ' data-offset="' + (offset + limit) + '"' : ' data-disabled') + '><i class="fa fa-chevron-right"></i></a>';
        return html;
    },
 
    getLoader:function() {
        return '<div class="loader"><i class="fa fa-2x fa-spinner fa-pulse color-theme"></i></div>';
    },
 
    getTableLoader:function(colspan) {
//      return '<tr class="table-loader no-style"><td class="align-center color-light" colspan="' + colspan + '"><i class="fa fa-2x fa-spinner fa-pulse"></i></td></tr>';
        return '<tr class="table-loader no-style"><td class="align-center color-light" colspan="' + colspan + '"><i class="fa fa-2x fa-circle-o-notch fa-spin fa-fw color-theme"></i></td></tr>';
    },
      
    getFormattedDate :function(value){
        return Minikit.isObj(value) ? Minikit.Format.date(value, '{DD}/{MM}/{YYYY} {hh}:{mm}', true) : '';  
    },

    initTableSearch: function(){
        Array.prototype.forEach.call(document.querySelectorAll('input.search[data-table-target]'), function(element){
            tableFilter.init(element)
        });
    }
}


 // table filtering
 var tableFilter = (function(Arr) {
    var _input;

    function _onInputEvent(e) {
        _input = e.target;
        var tableBody = document.querySelector('table#' + e.target.getAttribute('data-table-target') + ' tbody');
        Arr.forEach.call(tableBody.rows, _filter);
    }

    function _filter(row) {
        var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
        
        if (_input.value == ""){
            row.classList.remove('filter-show');
            row.classList.remove('filter-hide');
            return;
        }
        if (row.classList.contains('group-row')){
            row.classList.add('filter-hide');
            return;
        } 

        //row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
        if (text.indexOf(val) === -1){
            row.classList.remove('filter-show');
            row.classList.add('filter-hide');
        } else {
            row.classList.add('filter-show');
            row.classList.remove('filter-hide');
        }

    }

    return {
        init: function(input) {
            if (input) {
                input.oninput = _onInputEvent;
            }
        }
    };
})(Array.prototype);
