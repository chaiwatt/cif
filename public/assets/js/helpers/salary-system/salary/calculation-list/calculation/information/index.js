import * as RequestApi from '../../../../../request-api.js';

var token = window.params.token

$(document).on('click', '.delete-income-deduct', function (e) {
    e.preventDefault();
    var incomeDeductUserId = $(this).data('id');
    var deleteUrl = window.params.deleteRoute
    var data = {
        'incomeDeductUserId': incomeDeductUserId
    }

    RequestApi.postRequest(data, deleteUrl, token).then(response => {
        $('#income-deducy-tab').html(response);
    }).catch(error => { })
});


