var modul_layout = $('section#limo-index');
var modul_proses = $('section#limo-proses');
var url_first    = modul_layout.find('#url_first').val();
var updated_id   = '';
var count_page   = 0;
var url_branch   = modul_proses.find('#url_branch').val();

/* ==========================================================================================================
------------------------------------------------- LAIN-LAIN -------------------------------------------------
===========================================================================================================*/
modul_layout.find('#search').attr('placeholder', 'Nama');

modul_layout.find('#sort_field').append(
    $('<option>', {
        value: 'name',
        text: 'Nama'
    }),
);

function formIndex(tipe) {
    // Note tipe : 0:index 1:create 2:update
    if (tipe == 0) {
        resetForm();

        // DEFAULT INDEX
        $('#limo-title').html('Data Travel');
        $('#limo-breadcrumb').html('Data Travel');
        $('section#limo-index').attr('hidden', false);
        $('section#limo-proses').attr('hidden', true);
        // END DEFAULT INDEX

        // EVENT FORM PROSES
            // jika ada event di form proses
        // END EVENT FORM PROSES
    } else {
        if (tipe == 1) {
            // DEFAULT INDEX
            $('#limo-title').html('Tambah Travel');
            $('#limo-breadcrumb').html('Tambah Travel');
            modul_proses.find('#limo-btn-simpan').attr('hidden', false);
            modul_proses.find('#limo-btn-ubah').attr('hidden', true);
            // END DEFAULT INDEX

            // EVENT FORM PROSES
                // jika ada event di form proses
            // END EVENT FORM PROSES
        } else {
            // DEFAULT INDEX
            $('#limo-title').html('Ubah Travel');
            $('#limo-breadcrumb').html('Ubah Travel');
            modul_proses.find('#limo-btn-simpan').attr('hidden', true);
            modul_proses.find('#limo-btn-ubah').attr('hidden', false);
            // END DEFAULT INDEX

            // EVENT FORM PROSES
                // jika ada event di form proses
            // END EVENT FORM PROSES
        }

        // DEFAULT INDEX
        $('section#limo-index').attr('hidden', true);
        $('section#limo-proses').attr('hidden', false);
        // END DEFAULT INDEX
    }
}

function resetForm() {
    // FORM PROSES
    modul_proses.find('#name').val('');
    modul_proses.find('#img').val('');
    modul_proses.find('#table-detail tbody').empty();
    modul_proses.find('[name="show"][value="1"]').prop('checked', true);
    modul_proses.find('#name_detail').val('');
    // END FORM PROSES

    // DEFAULT
    modul_layout.find('#limo-btn-hapus').attr('disabled', true);
    modul_layout.find('#count-hapus').html(0);
    updated_id = '';

    $(".msg-error").empty();

    // RESET CB
    modul_layout.find('#checkAll').prop('checked', false);
    modul_layout.find('.cb_id').prop('checked', false);
    modul_layout.find('#btn_delete').attr('disabled', true);
    // END DEFAULT
}

function printErrorMsg (msg) {
    $(".msg-error").empty();

    $.each( msg, function( key, value ) {
       $("#error-"+key).html(value);
    });
}

modul_proses.find("#letter_date").flatpickr({
    // enableTime: !0,
    // dateFormat: "d-m-Y",
    defaultDate: new Date(),
});

modul_proses.find("#range_date").flatpickr({
    // dateFormat: "d-m-Y",
    mode: "range",
    onChange: function(dates) {
        if (dates.length == 2) {
            // var start = dates[0];
            // var end = dates[1];

            // days  = (end - start) / 1000 / 60 / 60 / 24;
            // if (days > 0) {
            // //   $('#howManyNights').val(days);
            //   console.log(days);
            // }
            
            var date_now   = new Date();
            var firts_date = dates[0];

            days_cek  = (date_now - firts_date) / 1000 / 60 / 60 / 24;

            if (days_cek < -3) {
                modul_proses.find('#case').attr('disabled', false);
            } else {
                modul_proses.find('#case').attr('disabled', true);
            }
        }

    }
});

modul_proses.find("#range_date_detail").flatpickr({
    // dateFormat: "d-m-Y",
    mode: "range",
    onChange: function(dates) {
        if (dates.length == 2) {
            var start = dates[0];
            var end   = dates[1];

            days  = (end - start) / 1000 / 60 / 60 / 24;
            if (days > 0) {
                if (modul_proses.find('#category').val() == 1) {
                    modul_proses.find('#qty').val(days - 1);
                } else {
                    modul_proses.find('#qty').val(days);
                }
            //   console.log(days);
            }
        }
    }
});

/* ======================================================================================================
------------------------------------------------- EVENT -------------------------------------------------
=========================================================================================================*/
modul_layout.find('#search').on('keyup', function (e) {
    if (e.key === 'Enter' || e.keyCode === 13) {
        loadData(url_first);
    }
});

modul_layout.find('#filter_role').on('change', function (e) {
    loadData(url_first);
});

$('body').on('click', '.pagination a', function(e) {
    var url = $(this).attr('data-link');
    loadData(url);
});

modul_proses.find('#destination').on('keyup', function (e) {
    $(this).val($(this).val().toUpperCase());
});

modul_proses.find('#reason_to_travel').on('keyup', function (e) {
    $(this).val($(this).val().toUpperCase());
});

modul_proses.find('#region').on('change', function (e) {
    loadBranch(url_branch);
});


/* ==========================================================================================================
------------------------------------------------- LOAD DATA -------------------------------------------------
===========================================================================================================*/
loadData(url_first);

function loadData(url) {
    var formData   = new FormData();
    var other_data = $('#group_search :input').serializeArray();

    $.each(other_data,function(key,input){
        formData.append(input.name, input.value);
    });

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'post',
        url: url,
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
            modul_layout.find('#loading').attr('hidden', false);
        },
        success: function (resp) {
            // console.log(resp);
            modul_layout.find('#table-load tbody').html(resp.item_table);
            modul_layout.find('#pagination').html(resp.pagination);
            count_page = resp.count_page;
        },
        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
            modul_layout.find('#loading').attr('hidden', true);
            formIndex(0);
        },
        error: function(e) {
            Swal.fire({
                icon: "error",
                title: "<i style='color:black'>Oops...</i>",
                html: "<i>Something went wrong!</i> <br> "+e.responseJSON.message
            })
        }
    });
}

function loadBranch(url)
{
    var category_id = modul_proses.find('#category').val();
    var region_id = modul_proses.find('#region').val();
   
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'post',
        url: '../data-branch/'+category_id+'/'+region_id,
        processData: false,
        contentType: false,
        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
            // modul_layout.find('#loading').attr('hidden', false);
        },
        success: function (resp) {
            console.log(resp);
            modul_proses.find('#branch').html(resp);
        },
        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
            // modul_layout.find('#loading').attr('hidden', true);
            // formIndex(0);
        },
        error: function(e) {
            Swal.fire({
                icon: "error",
                title: "<i style='color:black'>Oops...</i>",
                html: "<i>Something went wrong!</i> <br> "+e.responseJSON.message
            })
        }
    });
}

/* ==========================================================================================================
------------------------------------------------- CREATE DATA -----------------------------------------------
===========================================================================================================*/
function create(url) {
    $.ajax({
        url : url
    }).done(function (resp) {
        // console.log(resp);
        modul_proses.find('#category').html(resp.category);
        modul_proses.find('#region').html(resp.region);

        formIndex(1);
    }).fail(function (e) {
        Swal.fire({
            icon: "error",
            title: "<i style='color:black'>Oops...</i>",
            html: "<i>Something went wrong!</i> <br> "+e.responseJSON.message
        })
    });
}

function store(url) {
    var formData  = new FormData();
    var data_form = $('form').serializeArray();

    $.each(data_form,function(key,input){
        formData.append(input.name, input.value);
    });

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'post',
        url: url,
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
            modul_proses.find('#loading').attr('hidden', false);
            modul_proses.find('#limo-btn-simpan').attr('hidden', true);
            modul_proses.find('#limo-btn-kembali').attr('hidden', true);
        },
        success: function (resp) {
            // console.log(resp);
            if($.isEmptyObject(resp.error)){
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "<span style='color:black;'>Data berhasil disimpan</span>",
                    showConfirmButton: !1,
                    timer: 1500
                })

                loadData(url_first);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "<i style='color:black'>Oops...</i>",
                    html: "Data gagal disimpan, silahkan cek kembali inputan Anda !",
                })

                printErrorMsg(resp.error);
            }
        },
        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
            modul_proses.find('#loading').attr('hidden', true);
            modul_proses.find('#limo-btn-simpan').attr('hidden', false);
            modul_proses.find('#limo-btn-kembali').attr('hidden', false);
        },
        error: function(e) {
            Swal.fire({
                icon: "error",
                title: "<i style='color:black'>Oops...</i>",
                html: "<i>Something went wrong!</i> <br> "+e.responseJSON.message
            })
        }
    });
}
