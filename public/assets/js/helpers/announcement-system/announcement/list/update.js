import * as RequestApi from '../../../request-api.js';

var token = window.params.token
var attachments = [];
$(document).on('change', '#attachment', function (event) {
    attachments = event.target.files;
    var filesWrapper = $('#files_wrapper');

    // Clear any existing list items
    filesWrapper.empty();

    for (var i = 0; i < attachments.length; i++) {
        var listItem = $('<li></li>').text(attachments[i].name);
        filesWrapper.append(listItem);
    }
});

$(document).on('click', '#btn-update-announcement', function (e) {
    e.preventDefault();
    // console.log('ok');
    var formData = new FormData(); 
    var title = $('#title').val();
    var description = $('#description').val();
    var announcementId = $('#announcementId').val();
    var summernoteContent = $('#summernote').summernote('code');
    for (var i = 0; i < attachments.length; i++) {
        formData.append('attachments[]', attachments[i]);
    }
    formData.append('title', title);
    formData.append('description', description);
    formData.append('announcementId', announcementId);
    formData.append('summernoteContent', summernoteContent);

    var updateUrl = window.params.updateRoute
    RequestApi.postRequestFormData(formData, updateUrl, token).then(response => {
        var url = window.params.url + '/groups/announcement-system/announcement/list/'
        window.location.href = url; // Redirect to the generated URL
        
    }).catch(error => {

    })
});

$(document).on('click', '.delete-file', function (e) {
    e.preventDefault();
    console.log('ok');
    var deleteAttachmentUrl = window.params.deleteAttachmentRoute
    var announceAttachmentId = $(this).data('id');
    var data = {
        'announceAttachmentId': announceAttachmentId
    }

    RequestApi.postRequest(data, deleteAttachmentUrl, token).then(response => {
        $(this).closest('tr').remove();
    }).catch(error => { })
    
});