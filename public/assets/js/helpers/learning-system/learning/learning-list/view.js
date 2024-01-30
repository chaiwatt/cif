import * as RequestApi from '../../../request-api.js';

var token = window.params.token

$(document).on('click', '.topic-link', function (e) {
    e.preventDefault();
    var topicId = $(this).data('id');
    // console.log(topicId);
    var contentUrl = window.params.contentRoute
    
    var data = {
        'topicId': topicId
    }
    $('.topic-link').removeClass("active");
    RequestApi.postRequest(data, contentUrl, token).then(response => {
        $('#content_wrapper').html(response);
        $(this).addClass("active");

    }).catch(error => { })

});

