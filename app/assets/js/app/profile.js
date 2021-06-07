/* --- Profile --- */
Minitoring.Profile = {

    editUserNameOrEmail:function() {
        var newName = document.querySelector('#profile_user_name').value,
            newEmail =  document.querySelector('#profile_user_email').value,
            args = 'user_email=' + newEmail + '&user_name=' + newName;

        Minitoring.Api.post('api/profile/' , args, function (apiResponse) {
            Minitoring.App.setNotif(apiResponse.code >= 400 ? 'error' : 'success', apiResponse.message);
            if (apiResponse.code < 400) {
                document.querySelector('#current-user .user-name').innerHTML = newName;
                document.querySelector('#current-user .user-email').innerHTML = newEmail;
                document.querySelector('#profile-card-name').innerHTML = newName;
                document.querySelector('#profile-card-email').innerHTML = newEmail;
            }
        });
    },

    editPassword:function() {
        var args = 'user_password_current=' + document.querySelector('#input_change_password_current').value +
                  '&user_password_new=' + document.querySelector('#input_change_password_new').value +
                  '&user_password_repeat=' + document.querySelector('#input_change_password_repeat').value;
 
        Minitoring.Api.post('api/profile/password' , args, function (apiResponse) {
            Minitoring.App.setNotif(apiResponse.code >= 400 ? 'error' : 'success', apiResponse.message);
            document.querySelector('#input_change_password_current').value = '';
            document.querySelector('#input_change_password_new').value = '';
            document.querySelector('#input_change_password_repeat').value = '';
        });
    },

    editAvatar:function() {
        var formdata = new FormData();      
        var divProgress = document.getElementById('avatar-upload-progress');
        var progressbar = document.getElementById('avatar-upload-progressbar');
        var selectText  = document.getElementById('avatar-file-upload').getAttribute('data-text');
        var labelFile   = document.querySelector('#avatar-file-upload .label-file');
        formdata.append('token', document.querySelector('body[data-api-token]').getAttribute('data-api-token'));
        formdata.append('USER_AVATAR_file', document.getElementById("USER_AVATAR_file").files[0]);

        Minitoring.Api.ajaxPostFile({
            url: 'api/profile/avatar' , 
            data: formdata, 
            onsuccess: function (evt) {
                var apiResponse = JSON.parse(evt.target.responseText)
                document.getElementById('avatar-preview').src = apiResponse.data.userAvatarUrl;
                document.querySelector('#current-user .avatar').src = apiResponse.data.userAvatarUrl;
                document.querySelector('#profile-card-avatar').src = apiResponse.data.userAvatarUrl;
                progressbar.classList.remove('active');
                Minitoring.Api.notifyApiResponse(apiResponse);
                Minitoring.Profile.updateDeleteAvatarButtonState(apiResponse.data.userHasAvatar);
                document.getElementById("USER_AVATAR_file").value = '';
                divProgress.innerHTML = '';
                labelFile.innerHTML = selectText;
            }, 
            onprogress: function (evt) {
                var percent = (evt.loaded /evt.total)*100;
                divProgress.innerHTML = 'Progress: ' + Math.round(percent) + '%'; //+ ' loaded:' + evt.loaded+ ' total:' + evt.total;
                progressbar.classList.add('active');
                progressbar.value = evt.loaded;
                progressbar.max = evt.total;

            },
            onload: function (evt) {
                //var apiResponse = JSON.parse(evt.target.responseText)
                divProgress.innerHTML = 'File uploaded, waiting for server response...';
            }, 
            onerror: function (evt) {
                var apiResponse = JSON.parse(evt.target.responseText)
                Minitoring.Api.notifyApiResponse(apiResponse);
                Minitoring.Profile.updateDeleteAvatarButtonState(apiResponse.data.userHasAvatar);
                progressbar.classList.remove('active');
                divProgress.innerHTML = '';
                document.getElementById("USER_AVATAR_file").value = '';
                labelFile.innerHTML = selectText;
            }
        });
    },
    
    deleteAvatar:function() {
        Minitoring.Api.post('api/profile/avatar/delete' , null, function (apiResponse) {
            document.getElementById('avatar-preview').src = apiResponse.data.userAvatarUrl;
            document.querySelector('#current-user .avatar').src = apiResponse.data.userAvatarUrl;
            document.querySelector('#profile-card-avatar').src = apiResponse.data.userAvatarUrl;
            Minitoring.Profile.updateDeleteAvatarButtonState(apiResponse.data.userHasAvatar);
            Minitoring.Api.notifyApiResponse(apiResponse);
        }, function (apiResponse) {
            Minitoring.Api.notifyApiResponse(apiResponse);
            Minitoring.Profile.updateDeleteAvatarButtonState(apiResponse.data.userHasAvatar);
        });
    },

    updateDeleteAvatarButtonState:function(hasAvatar){
        var bt = document.getElementById('delete-avatar-button');
        if (hasAvatar) {
            bt.classList.add('active');
        } else {
            bt.classList.remove('active');
        }
    },

    avatarPreviewChanged: function (){
        var fileInput = document.getElementById('USER_AVATAR_file');
        if (Minikit.isObj(fileInput) && Minikit.isObj(fileInput.files[0])){
            document.getElementById('avatar-preview').src = URL.createObjectURL(fileInput.files[0]);
            document.querySelector('#avatar-file-upload .label-file').innerHTML = fileInput.files[0].name;
        }
    }
}
