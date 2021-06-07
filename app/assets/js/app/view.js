
/* handle navigation */
Minitoring.View = {
    htmlContainer: {}, 
    htmlOverlay: {},
    htmlHeaderTitle: {}, 
    htmlHeaderSubTitle: {},
    htmlBackButton: {},
  
    // navigate to given url
    navigate: function (url) {
        var target = Minitoring.View.getUrlTarget(url);
        Minitoring.View.updateActiveView(target);
    },

    // get the url target 
    getUrlTarget: function(url){
        var parser = new URL(url),
            target = parser.pathname;

        if (target.endsWith('/'))   { target = target.substr(0, target.length - 1); }
        if (target.startsWith('/')) { target = target.substr(1, target.length - 1); }
        return target;
    },

    // handle links click for ajax navigation
    handleLinkClick: function(e){
        var element = e.target.closest('a[data-view]');
        if (Minikit.isObj(element) && Minikit.Event.isLeftButton(e)) {
            e.preventDefault();

            var url = element.getAttribute('href');
            Minitoring.View.navigate(url);
            Minikit.Browser.changeURL(url);
        }; 
    },

    getViewPanel:function(target, basetarget)
    {
        // Get the panel associated to this view
        var panel = document.querySelector('.view[data-view="' + target +'"]');
        if (Minikit.isObj(panel)) {
            return panel;
        }

        // no corresponding panel, so it's a sub view, so get the base panel
        panel = document.querySelector('.view[data-view="' + basetarget +'"]');
        if (Minikit.isObj(panel)) {
            return panel;
        }

        // not found...
        return null;
    },

    // update current view
    updateActiveView:function(target){
        
        // get the base target
        var baseTarget =  target.split('/')[0];

        // Get the panel associated to this view
        var viewPanel = Minitoring.View.getViewPanel(target, baseTarget);
        if (Minikit.isObj(viewPanel)) {
        
            // Hide all view
            Array.prototype.forEach.call(document.querySelectorAll('.view[data-view]'), function (elmt) {
                elmt.classList.remove('active');
            });

            // show current view and 
            // store the current view id
            viewPanel.classList.add('active');
            htmlContainer.setAttribute('data-current-view', target);

            // sync active menu item
            Array.prototype.forEach.call(document.querySelectorAll('.menu-item a[data-view]'), function (elmt) {
                if (elmt.getAttribute('data-view') === baseTarget) {
                    elmt.classList.add('active');
                } else {
                    elmt.classList.remove('active');
                }
            });
                
            // sync active sub menu item (if exists)
            Array.prototype.forEach.call(viewPanel.querySelectorAll('.tab-item a[data-view]'), function (elmt) {
                if (elmt.getAttribute('data-view') === target) {
                    elmt.closest('.tab-item').classList.add('current');
                } else {
                    elmt.closest('.tab-item').classList.remove('current');
                }
            });

            // set back button visibility
            if (target != baseTarget) {
                htmlBackButton.classList.add('active');
            } else {
                htmlBackButton.classList.remove('active');
            }
            
            // auto action
            refreshAction = viewPanel.getAttribute('data-refresh');
            if (refreshAction) {
                Minikit.executeFunctionByName(refreshAction);
            }

            // sync current view param and title
            Minitoring.View.updateTitle(viewPanel);
        }
    },

    //TODO
    updateTitle: function (viewPanel) {
        htmlHeaderTitle.innerHTML = viewPanel.getAttribute('data-title');
    },

    // get the current view
    getCurrentView: function () {
        return htmlContainer.getAttribute('data-current-view');
    },   
    
    // back trigger
    goBack: function(){
        Minikit.Browser.goBack();
    },

    // init module
    init: function () {
        
        // init static elements
        htmlContainer   = document.querySelector('#main-container');
        htmlOverlay     = document.querySelector('main-container > .overlay');
        htmlHeaderTitle = document.querySelector('#header-title');
     // htmlHeaderSubTitle = document.querySelector('#header-subtitle');
        htmlBackButton = document.querySelector('.back-trigger');

        // detect links
        document.addEventListener('click', Minitoring.View.handleLinkClick);             

        window.onpopstate = function () {
            Minitoring.View.navigate(location.href);
        };
    }
}


