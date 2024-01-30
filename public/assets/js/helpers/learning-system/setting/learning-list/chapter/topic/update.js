import * as RequestApi from '../../../../../request-api.js';

var token = window.params.token
var attachments = new Map();
$(document).on('change', '#attachment', function (event) {
    const files = event.target.files;
    var filesWrapper = document.getElementById('files_wrapper');

    // Clear any existing list items
    for (const file of files) {
        let idx = [...attachments.keys()].pop() ? [...attachments.keys()].pop() + 1 : 1;
        attachments.set(idx, file)
        var listItem = document.createElement('li');
        listItem.className = 'file_content';
        listItem.id = 'file-content-' + idx;
        listItem.innerHTML = `<p>${file.name}</p><button class="destroy-btn" data-idx="${idx}"><span class="material-symbols-outlined" style="font-size: 1rem">cancel</span></button>`
        filesWrapper.append(listItem);
    }
});
$(document).on('click', '.destroy-btn', function () {
    var idx = $(this).data('idx');
    attachments.delete(idx);
    document.getElementById('file-content-'+idx).remove();
});

$(document).on('click', '#btn-update-topic', function (e) {
    e.preventDefault();
    var formData = new FormData(); 
    var name = $('#name').val();
    var chapterId = $('#chapterId').val();
    var topicId = $('#topicId').val();
    var summernoteContent = $('#summernote').summernote('code');
    for (const file of attachments) {
        formData.append('attachments[]', attachments.get(file[0]));
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
        $(`#attachment-${topicAttachmentId}`).remove();
    }).catch(error => { })

    // Remove the corresponding table row on "Delete" button click
    
});