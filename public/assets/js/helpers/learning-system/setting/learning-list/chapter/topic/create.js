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

$(document).on('click', '#btn-add-topic', function (e) {
    e.preventDefault();
    var formData = new FormData(); 
    var name = $('#name').val();
    var chapterId = $('#chapterId').val();
    var summernoteContent = $('#summernote').summernote('code');
    for (var i = 0; i < attachments.length; i++) {
        formData.append('attachments[]', attachments[i]);
    }
    formData.append('name', name);
    formData.append('chapterId', chapterId);
    formData.append('summernoteContent', summernoteContent);

    // console.log(selectedFile)

    var storeUrl = window.params.storeRoute
    RequestApi.postRequestFormData(formData, storeUrl, token).then(response => {
        var url = window.params.url + '/groups/learning-system/setting/learning-list/chapter/topic/' + chapterId
        window.location.href = url; // Redirect to the generated URL
        
    }).catch(error => {

    })
});

