import * as RequestApi from '../../../request-api.js';

var token = window.params.token

$(document).on('click', '#add_payday', function (e) {
    e.preventDefault();
    $('#modal-payday-date').modal('show');

});

$(document).on('click', '#save_payday', function (e) {
    e.preventDefault();
    var year = $('#year').val();
    var paydayId = $('#paydayId').val();
    var paymentType = $('#paymentType').val();
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    var duration = $('#duration').val();
    var storeUrl = window.params.storeRoute

    // Validate the retrieved values
    if (!year || !paydayId || !paymentType || !startDate || !endDate) {
        Swal.fire(
            'ผิดพลาด!',
            'กรุณากรอกข้อมูลให้ครบ',
            'error'
        );
        // Handle validation error, such as displaying an error message or preventing further action.
        return;
    }

    // Use Moment.js to compare startDate and endDate
    var momentStartDate = moment(startDate, 'DD/MM/YYYY');
    var momentEndDate = moment(endDate, 'DD/MM/YYYY');

    if (!momentEndDate.isSameOrAfter(momentStartDate)) {
        Swal.fire(
            'ผิดพลาด!',
            'กรุณากรอกวันที่ให้ถูกต้อง',
            'error'
        );
        return;
    }

    if (paymentType === 2 && !duration) {
        Swal.fire(
            'ผิดพลาด!',
            'กรุณากรอกจำนวนวัน',
            'error'
        );
        return;
    }
    console.log('4')
    var data = {
        'paymentType': paymentType,
        'startDate': startDate,
        'endDate': endDate,
        'duration': duration,
        'year': year,
        'paydayId': paydayId
    }
    // console.log(storeRoute)
    RequestApi.postRequest(data, storeUrl, token).then(response => {
        $('#table_container').html(response);
        $('#modal-payday-date').modal('hide');
    }).catch(error => {
    })
});



$(document).on('change', '#paymentType', function (e) {
    var selectedValue = $(this).val();

    if (selectedValue === '1') {
        $('#duration_wrapper').hide();
    } else if (selectedValue === '2') {
        $('#duration_wrapper').show();
    }
});

$(document).on('click', '.update-payday', function (e) {
    e.preventDefault();
    var paydayDetailId = $(this).data('id');
    var viewUrl = window.params.viewRoute
    var data = {
        'paydayDetailId': paydayDetailId
    }
    RequestApi.postRequest(data, viewUrl, token).then(response => {
        $('#modal-update-payday-date-wrapper').html(response);
        $('#modal-update-payday-date').modal('show');
    }).catch(error => {
    })
});

$(document).on('click', '#update_payday', function (e) {
    e.preventDefault();
    var paydayDetailId = $('#paydayDetailId').val();
    var startDate = $('#updateStartDate').val();
    var endDate = $('#updateEndDate').val();
    var paymentDate = $('#updatePaymentDate').val();
    var updateUrl = window.params.updateRoute

    var momentStartDate = moment(startDate, 'DD/MM/YYYY');
    var momentEndDate = moment(endDate, 'DD/MM/YYYY');
    var momentPaymentDate = moment(paymentDate, 'DD/MM/YYYY');

    if (momentEndDate.isSameOrAfter(momentStartDate)) {
        if (!momentPaymentDate.isSameOrAfter(momentEndDate)) {
            Swal.fire(
                'ผิดพลาด!',
                'กรุณากรอกวันที่ให้ถูกต้อง',
                'error'
            );
            return;
        }
    } else {
        Swal.fire(
            'ผิดพลาด!',
            'กรุณากรอกวันที่ให้ถูกต้อง2',
            'error'
        );
        return;
    }

    var data = {
        'paydayDetailId': paydayDetailId,
        'startDate': startDate,
        'endDate': endDate,
        'paymentDate': paymentDate,
    }
    RequestApi.postRequest(data, updateUrl, token).then(response => {
        $('#table_container').html(response);
        $('#modal-update-payday-date').modal('hide');
    }).catch(error => {
    })

});

