$(document).on('click', 'a[data-confirm]', function (event) {
    event.preventDefault();

    var confirmationMessage = $(this).data('confirm');
    var userId = $(this).data('id');
    var deleteRoute = $(this).data('delete-route').replace('__id__', userId);
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

