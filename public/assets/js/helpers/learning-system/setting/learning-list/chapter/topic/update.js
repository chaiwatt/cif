import * as RequestApi from '../../../../../request-api.js';

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

$(document).on('click', '#btn-update-topic', function (e) {
    e.preventDefault();
    var formData = new FormData(); 
    var name = $('#name').val();
    var chapterId = $('#chapterId').val();
    var topicId = $('#topicId').val();
    var summernoteContent = $('#summernote').summernote('code');
    for (var i = 0; i < attachments.length; i++) {
        formData.append('attachments[]', attachments[i]);
    }
    formData.append('name', name);
    formData.append('chapterId', chapterId);
    formData.append('topicId', topicId);
    formData.append('summernoteContent', summernoteContent);

    // console.log(selectedFile)

    var updateUrl = window.params.updateRoute
    RequestApi.postRequestFormData(formData, updateUrl, token).then(response => {
        var url = window.params.url + '/groups/learning-system/setting/learning-list/chapter/topic/' + chapterId
        window.location.href = url; // Redirect to the generated URL
        
    }).catch(error => {

    })
});

$(document).on('click', '.delete-file', function (e) {
    e.preventDefault();
    var deleteAttachmentUrl = window.params.deleteAttachmentRoute
    var topicAttachmentId = $(this).data('id');
    var data = {
        'topicAttachmentId': topicAttachmentId
    }

    RequestApi.postRequest(data, deleteAttachmentUrl, token).then(response => {
        $(this).closest('tr').remove();
    }).catch(error => { })

    // Remove the corresponding table row on "Delete" button click
    
});