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

$(document).on('click', '#btn-update-application-news', function (e) {
    e.preventDefault();

    var formData = new FormData(); 
    var title = $('#title').val();
    var description = $('#description').val();
    var status = $('#status').val();
    var applicationNewId = $('#applicationNewId').val();
    var summernoteContent = $('#summernote').summernote('code');
    for (var i = 0; i < attachments.length; i++) {
        formData.append('attachments[]', attachments[i]);
    }
    formData.append('title', title);
    formData.append('description', description);
    formData.append('status', status);
    formData.append('applicationNewId', applicationNewId);
    formData.append('summernoteContent', summernoteContent);

    var updateUrl = window.params.updateRoute
    RequestApi.postRequestFormData(formData, updateUrl, token).then(response => {
        var url = window.params.url + '/groups/job-application-system/job-application/list/'
        window.location.href = url; // Redirect to the generated URL
        
    }).catch(error => {

    })
});

$(document).on('click', '.delete-file', function (e) {
    e.preventDefault();
    var deleteAttachmentUrl = window.params.deleteAttachmentRoute
    var applicationNewAttachmentId = $(this).data('id');
    var data = {
        'applicationNewAttachmentId': applicationNewAttachmentId
    }

    RequestApi.postRequest(data, deleteAttachmentUrl, token).then(response => {
        $(this).closest('tr').remove();
    }).catch(error => { })
    
});