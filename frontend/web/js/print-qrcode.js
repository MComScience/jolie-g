"use strict";

// variable
var $keys = [], $elmprint = $('button.on-print'), $selection = $('#tbproduct-selection'), $form = $('#form-print');

var qrPrint = {
    isEmpty: function (v) {
        return v === undefined || v === null || v.length === 0;
    }
};

// Handle click on "Select all" control
$('#select-all').on('click', function () {
    var $table = $('#tb-qrcode').DataTable();
    // Get all rows with search applied
    var rows = $table.rows({'search': 'applied'}).nodes();
    // Check/uncheck checkboxes for all rows in the table
    $('input[name="selection[]"]', rows).prop('checked', this.checked);
    var data = $table.$('input[type="checkbox"]').serialize();
    if (qrPrint.isEmpty(data)) {
        $selection.val(null);
    } else {
        data = data.replace(new RegExp('selection%5B%5D=', 'g'), '');
        var dataArr = data.split('&');
        var arrRemove = dataArr.slice(1000);
        var arrData = dataArr.slice(0, 1000);
        if (dataArr.length > 1000) {
            swal({
                type: "warning",
                title: "Oops!",
                text: 'จำกัดการพิมพ์ 1000 รายการ/ครั้ง เนื่องจากมีข้อจำกัดด้านทรัพยากรของ Server และเพื่อไม่ให้ Server ทำงานหนักเกินไป'
            });
            /*setTimeout(function(){
                $.each(arrRemove, function (index, value) {
                    $('input#' + value, rows).prop('checked', false);
                    if (index++ === (arrRemove.length - 1)){
                        $('#progBar').hide();
                        swal({
                            type: "warning",
                            title: "Oops!",
                            text: 'จำกัดการพิมพ์ 1000 รายการ/ครั้ง เนื่องจากมีข้อจำกัดด้านทรัพยากรของ Server และเพื่อไม่ให้ Server ทำงานหนักเกินไป'
                        });
                    }
                });
            },1000);*/
            $selection.val(arrData.join('&'));
        } else {
            $selection.val(data);
        }
    }
});

$('#tb-qrcode tbody').on('change', 'input[type="checkbox"]', function () {
    // If checkbox is not checked
    var $table = $('#tb-qrcode').DataTable();
    var data = $table.$('input[type="checkbox"]').serialize();
    if (qrPrint.isEmpty(data)) {
        $selection.val(null);
    } else {
        data = data.replace(new RegExp('selection%5B%5D=', 'g'), '');
        var dataArr = data.split('&');
        if (dataArr.length > 1000) {
            swal({
                type: "warning",
                title: "Oops!",
                text: 'จำกัดการพิมพ์ 1000 รายการ/ครั้ง เนื่องจากมีข้อจำกัดด้านทรัพยากรของ Server และเพื่อไม่ให้ Server ทำงานหนักเเกินไป'
            });
            var rows = $table.rows({'search': 'applied'}).nodes();
            $('input[name="selection[]"]', rows).prop('checked', false);
        } else {
            $selection.val(data);
        }
    }
});
// form event
$form.on('beforeSubmit', function () {
    swal({
        type: "warning",
        title: 'กรุณารอสักครู่...',
        showConfirmButton: false
    });
});

//Print
$elmprint.on('click', function () {
    // Iterate over all checkboxes in the table
    var $table = $('#tb-qrcode').DataTable();
    var $elm = this;
    var keyArr = [];
    $table.$('input[type="checkbox"]').each(function () {
        // If checkbox doesn't exist in DOM
        // If checkbox is checked
        if (this.checked) {
            keyArr.push(this.value);
        }
    });
    if (keyArr.length > 0) {
        swal({
            title: 'ยืนยันการพิมพ์',
            text: keyArr.length + ' รายการ',
            type: "question",
            showCancelButton: true,
            confirmButtonText: "พิมพ์",
            cancelButtonText: "ยกเลิก",
            allowEscapeKey: false,
            allowOutsideClick: false,
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve, reject) {
                    var w = window.open(window.location.origin + $($elm).data('url'), "myPrint", "width=800, height=600");
                    w.print();
                    resolve();
                });
            },
        }).then(function (result) {
            if (result.value) {
                swal.close();
            }
        });
    }
});
if (!qrPrint.isEmpty($selection.val())) {
    var data = $selection.val().split('&');
    $.each(data, function (index, value) {
        $('#tb-qrcode input#' + value).prop('checked', true);
    });
}