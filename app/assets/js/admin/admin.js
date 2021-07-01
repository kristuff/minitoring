/* --- Admin --- */
Minitoring.Admin = {
    
    resetApiKey:function(){
        Minitoring.Api.delete('api/app/auth', null, function (result) {
            document.querySelector('#settings-websocket-token').value = result.data.key;
            Minitoring.Api.key = result.data.key;
        });
    },

    ipActionChanged:function(){
        alert('TODO');
    }
}