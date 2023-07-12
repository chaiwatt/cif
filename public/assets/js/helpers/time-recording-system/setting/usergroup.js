import * as RequestApi from '../../request-api.js';

var token = window.params.token
const url = window.location.href;

$(document).on('change', '#select_all', function (e) {
    $('.user-checkbox').prop('checked', this.checked);
});

$(document).on('change', '.user-checkbox', function (e) {
    if ($('.user-checkbox:checked').length == $('.user-checkbox').length) {
        $('#select_all').prop('checked', true);
    } else {
        $('#select_all').prop('checked', false);
    }
});