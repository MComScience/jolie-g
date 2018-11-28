"use strict";
// variable
var $elmqrcode = $('#tbproduct-qrcode'),
    $elmqrcode_qty = $('#tbproduct-qrcode_qty'),
    $elmcount = $('#count-qrcode'),
    $form = $('#form-product'),
    $keys = [];

var product = {
    isEmpty: function (v) {
        return v === undefined || v === null || v.length === 0;
    },
    setCount: function () {
        var count = $elmqrcode.tagsinput('items').length;
        $elmcount.html(count);
        $elmqrcode_qty.val(count);
    }
};
// create qrcode number
$('button.on-gen-qrcode').on('click', function (e) {
    e.preventDefault();
    var x = $elmqrcode_qty.val();
    if (product.isEmpty(x)) { // if qty is empty
        swal({
            type: 'warning',
            title: 'Oops...',
            text: 'กรุณากรอกจำนวน'
        });
        return false;
    }
    $elmqrcode.tagsinput('removeAll');
    for (var i = 0; i < x; i++) {
        $elmqrcode.tagsinput('add', {
            value: Math.floor(Math.random() * (999999999999 - 100000000001)) + 100000000001,
            text: Math.floor(Math.random() * (999999999999 - 100000000001)) + 100000000001,
            continent: 'success'
        });
    }
});
// clear qrcode
$('button.on-clear').on('click', function (e) {
    $elmqrcode.tagsinput('removeAll');
    product.setCount();
});
// tag input events
$elmqrcode.on('itemAdded', function () {
    product.setCount();
});
$elmqrcode.on('itemRemoved', function () {
    product.setCount();
});
// form event
$form.on('beforeSubmit', function () {
    var data = $form.serialize();
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: data,
        success: function (response) {
            // Implement successful
            if (response.success) {
                swal({
                    type: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 2000
                });
                setTimeout(function () {
                    window.location.href = response.url;
                }, 2000);
            } else {
                $.each(response.validate, function (key, val) {
                    $($form).yiiActiveForm('updateAttribute', key, [val]);
                });
                $("html, body").animate({scrollTop: 0}, "slow");
            }
        },
        error: function (jqXHR, errMsg) {
            swal({
                type: 'error',
                title: 'Oops...',
                text: errMsg
            });
        }
    });
    return false; // prevent default submit
});
// handle click
$('table#tb-qrcode tbody').on('click', 'tr td a.on-delete', function (e) {
    e.preventDefault();
    var $elm = this;
    var $table = $('#tb-qrcode').DataTable();
    swal({
        title: 'ยืนยันการลบ',
        text: $($elm).data('id'),
        type: "question",
        showCancelButton: true,
        confirmButtonText: "ลบ",
        cancelButtonText: "ยกเลิก",
        allowEscapeKey: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                $.ajax({
                    type: 'POST',
                    url: $($elm).attr('href'),
                    success: function (data, textStatus, jqXHR) {
                        $table.ajax.reload();
                        resolve();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        swal({
                            type: "error",
                            title: errorThrown,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    dataType: "json"
                });
            });
        }
    }).then(function(result) {
        if (result.value) {
            swal({
                type: "success",
                title: "ลบรายการเรียบร้อย!",
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
});
// Handle click on "Select all" control
$('#select-all').on('click', function () {
    var $table = $('#tb-qrcode').DataTable();
    var $elm = $('button.on-delete-select-all');
    // Get all rows with search applied
    var rows = $table.rows({'search': 'applied'}).nodes();
    // Check/uncheck checkboxes for all rows in the table
    $('input[name="selection[]"]', rows).prop('checked', this.checked);
    var data = $table.$('input[name="selection[]"]').serialize();

    if (product.isEmpty(data)) {
        $elm.prop('disabled', true);
    } else {
        $elm.prop('disabled', false);
    }
});

// Handle click on checkbox to set state of "Select all" control
$('#tb-qrcode tbody').on('change', 'input[type="checkbox"]', function () {
    // If checkbox is not checked
    var $table = $('#tb-qrcode').DataTable(),
        value = this.value,
        data = $table.$('input[type="checkbox"]').serialize(),
        $elm = $('button.on-delete-select-all');
    if (!product.isEmpty(data)) {
        data = data.replace(new RegExp('selection%5B%5D=', 'g'), '');
        $keys = data.split('&');
    }
    if (!this.checked) {
        if (jQuery.inArray(value, $keys) !== -1) {
            $.each($keys, function (index, data) {
                if (value === data) {
                    $keys.splice(index, 1);
                }
            });
        }
        var el = $('#select-all').get(0);
        // If "Select all" control is checked and has 'indeterminate' property
        if (el && el.checked && ('indeterminate' in el)) {
            // Set visual state of "Select all" control
            // as 'indeterminate'
            el.indeterminate = true;
        }
        if ($keys.length === 0) {
            $elm.prop('disabled', true);
        }
    } else {
        if ($keys.length > 0) {
            $elm.prop('disabled', false);
        }
    }
});

$('#form-product .on-delete-select-all').on('click', function () {
    // Iterate over all checkboxes in the table
    var elm = this;
    var keyArr = [];
    var $table = $('#tb-qrcode').DataTable();
    $table.$('input[type="checkbox"]').each(function () {
        // If checkbox doesn't exist in DOM
        // If checkbox is checked
        if (this.checked) {
            keyArr.push(this.value);
        }
    });
    if (keyArr.length > 0) {
        swal({
            title: 'ยืนยันการลบ',
            text: keyArr.length + ' รายการ',
            type: "question",
            showCancelButton: true,
            confirmButtonText: "ลบ",
            cancelButtonText: "ยกเลิก",
            allowEscapeKey: false,
            allowOutsideClick: false,
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve, reject) {
                    $.ajax({
                        type: 'POST',
                        url: $(elm).data('url'),
                        data: {keys: keyArr},
                        success: function (data, textStatus, jqXHR) {
                            $table.ajax.reload();
                            $('#select-all').prop('checked', false);
                            resolve();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            swal({
                                type: "error",
                                title: errorThrown,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        dataType: "json"
                    });
                });
            },
        }).then(function(result) {
            if (result.value) {
                swal({
                    type: "success",
                    title: "ลบรายการเรียบร้อย!",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }
});

$elmqrcode_qty.keyup(function () {
    if ($(this).val() > 1000) {
        swal({
            type: "warning",
            title: "Oops!",
            text: 'สร้างได้ 1000 รหัส ต่อครั้งเท่านั้น!'
        });
        $(this).val(1000);
    }
});