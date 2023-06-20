function initializeDataTable(tableSelector) {
    var searchInputId = tableSelector.substring(1) + "_filter";

    $(tableSelector).DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "pageLength": 15,
        "language": {
            "search": "ค้นหา:", // Replace with your desired text
            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            "infoEmpty": "ไม่พบรายการที่ต้องการ",
            "infoFiltered": "(กรองจากทั้งหมด _MAX_ รายการ)",
            "emptyTable": "ไม่มีข้อมูลในตาราง",
            "paginate": {
                "first": "หน้าแรก",
                "last": "หน้าสุดท้าย",
                "next": "ถัดไป",
                "previous": "ก่อนหน้า"
            }
        }
    });

    // Move the search input to the card header
    $('#' + searchInputId).detach().appendTo('#searchWrapper');
}