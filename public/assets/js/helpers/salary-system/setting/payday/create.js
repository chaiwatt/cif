import * as RequestApi from '../../../request-api.js';

var token = window.params.token


$(document).on('change', '#paydayType', function (e) {
    var selectedValue = $(this).val();
    if (selectedValue === '1') {
        $('#cantain_wrapper1').show();
        $('#cantain_wrapper2').hide();
    } else if (selectedValue === '2') {
        var year = $('#year').val();
        var getPaydayUrl = window.params.getPaydayRoute

        console.log(year)
        var data = {
            'year': year
        }

        RequestApi.postRequest(data, getPaydayUrl, token).then(response => {
            $('#select_option_wrapper').html(response);
        }).catch(error => {

        })

        $('#cantain_wrapper1').hide();
        $('#cantain_wrapper2').show();
    }
});