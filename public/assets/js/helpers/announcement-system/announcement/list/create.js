import * as RequestApi from '../../../request-api.js';

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
$(document).on('click', '#btn-add-announcement', function (e) {
    e.preventDefault();
    var formData = new FormData(); 
    var title = $('#title').val();
    var description = $('#description').val();
    var status = $('#status').val();
    var start_date = $('#start_date_input').val();
    var end_date = $('#end_date_input').val();
    var image = document.getElementById('announce-img-input').files;
    var summernoteContent = document.getElementById('summernote').value;
    for (const file of attachments) {
        formData.append('attachments[]', attachments.get(file[0]));
    }
    formData.append('announce_thumbnail', image[0]);
    formData.append('title', title);
    formData.append('description', description);
    formData.append('status', status);
    formData.append('summernoteContent', summernoteContent);
    formData.append('start_date', start_date);
    formData.append('end_date', end_date);

    var storeUrl = window.params.storeRoute
    RequestApi.postRequestFormData(formData, storeUrl, token).then(response => {
        var url = window.params.url + '/groups/announcement-system/announcement/list/'
        window.location.href = url; // Redirect to the generated URL
        
    }).catch(error => {

    })
});

