$(document).ready(function () {
    // Apply input masking for numeric inputs with format 99.99
    $('.numericInput').inputmask('99.99');

    // Apply input masking for numeric inputs with format 9.99
    $('.numericInputSingle').inputmask('9.99');

    // Apply input masking for a 13-digit number
    $('.numericInputPhone').inputmask('999-999-9999');

    // Apply input masking for a 13-digit number
    $('.numericInputHid').inputmask('9 9999 99999 99 9');

    // Apply input masking for numeric input
    $('.numericInputInt').inputmask('9{1,}', { "placeholder": "" });

});

$(document).on('click', 'a[data-confirm]', function (event) {
    event.preventDefault();

    var confirmationMessage = $(this).data('confirm');
    var deleteId = $(this).data('id');
    var deleteRoute = $(this).data('delete-route').replace('__id__', deleteId);
    var message = $(this).data('message');

    Swal.fire({
        title: 'ลบ' + message,
        text: confirmationMessage,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'ยืนยันลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: deleteRoute,
                type: 'DELETE',
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    var message = response.message;
                    Swal.fire({
                        title: 'ลบแล้ว',
                        text: message,
                        icon: 'success'
                    }).then((result) => {
                        
                        window.location.reload();
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        title: 'ข้อผิดพลาด',
                        text: 'เกิดข้อผิดพลาดขณะลบ' + message,
                        icon: 'error'
                    });
                }
            });
        }
    });
});

