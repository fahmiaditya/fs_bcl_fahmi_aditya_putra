var modul_layout = $('section#limo-index');
var modul_proses = $('section#limo-proses');
var url_first    = modul_layout.find('#url_first').val();
var updated_id   = '';
var count_page   = 0;

/* ==========================================================================================================
------------------------------------------------- LAIN-LAIN -------------------------------------------------
===========================================================================================================*/
modul_layout.find('#search').attr('placeholder', 'Nomor');

modul_layout.find('#sort_field').append(
    $('<option>', {
        value: 'nomor',
        text: 'Nomor'
    }),
);

function formIndex(tipe) {
    // Note tipe : 0:index 1:create 2:update
    if (tipe == 0) {
        resetForm();

        // DEFAULT INDEX
        $('#limo-title').html('Data Armada');
        $('#limo-breadcrumb').html('Data Armada');
        $('section#limo-index').attr('hidden', false);
        $('section#limo-proses').attr('hidden', true);
        // END DEFAULT INDEX

        // EVENT FORM PROSES
            // jika ada event di form proses
            modul_proses.find('#view-permission').empty();
        // END EVENT FORM PROSES
    } else {
        if (tipe == 1) {
            // DEFAULT INDEX
            $('#limo-title').html('Tambah Armada');
            $('#limo-breadcrumb').html('Tambah Armada');
            modul_proses.find('#limo-btn-simpan').attr('hidden', false);
            modul_proses.find('#limo-btn-ubah').attr('hidden', true);
            // END DEFAULT INDEX

            // EVENT FORM PROSES
                // jika ada event di form proses
                modul_proses.find('#group-password').attr('hidden', false);
            // END EVENT FORM PROSES
        } else {
            // DEFAULT INDEX
            $('#limo-title').html('Ubah Armada');
            $('#limo-breadcrumb').html('Ubah Armada');
            modul_proses.find('#limo-btn-simpan').attr('hidden', true);
            modul_proses.find('#limo-btn-ubah').attr('hidden', false);
            // END DEFAULT INDEX

            // EVENT FORM PROSES
                // jika ada event di form proses
                modul_proses.find('#group-password').attr('hidden', true);
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
    modul_proses.find('#nama').val('');
    modul_proses.find('#nomor').val('');
    modul_proses.find('#kapasitas').val(0);
    modul_proses.find('[name="ketersediaan"][value="1"]').prop('checked', true);
    modul_proses.find('#username').val('');
    modul_proses.find('#email').val('');
    modul_proses.find('#password').val('');
    modul_proses.find('#password_confirmation').val('');
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

/* ======================================================================================================
------------------------------------------------- EVENT -------------------------------------------------
=========================================================================================================*/
modul_layout.find('#search').on('keyup', function (e) {
    if (e.key === 'Enter' || e.keyCode === 13) {
        loadData(url_first);
    }
});

$('body').on('click', '.pagination a', function(e) {
    var url = $(this).attr('data-link');
    loadData(url);
});

modul_layout.find('#filter_ketersediaan').on('change', function (e) {
    loadData(url_first);
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

/* ==========================================================================================================
------------------------------------------------- CREATE DATA -----------------------------------------------
===========================================================================================================*/
function create(url) {
    $.ajax({
        url : url
    }).done(function (resp) {
        // console.log(resp);
        modul_proses.find('#jenis').html(resp);

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

/* ==========================================================================================================
------------------------------------------------- UPDATE DATA -----------------------------------------------
===========================================================================================================*/
function edit(url) {
    $.ajax({
        url : url
    }).done(function (resp) {
        // console.log(resp);
        modul_proses.find('#jenis').html(resp.jenis);

        updated_id = resp.data.key; // default update
        modul_proses.find('#nomor').val(resp.data.nomor);
        modul_proses.find('#jenis').val(resp.data.jenis_armada_id);
        modul_proses.find('#kapasitas').val(resp.data.kapasitas);
        modul_proses.find('[name="ketersediaan"][value="'+resp.data.ketersediaan+'"]').prop('checked', true);
        modul_proses.find('#nama').val(resp.data.nama);
        modul_proses.find('#username').val(resp.data.username);
        modul_proses.find('#email').val(resp.data.email);

        formIndex(2);
    }).fail(function (e) {
        Swal.fire({
            icon: "error",
            title: "<i style='color:black'>Oops...</i>",
            html: "<i>Something went wrong!</i> <br> "+e.responseJSON.message
        })
    });
}

function update(url) {
    var formData  = new FormData();
    var data_form = $('form').serializeArray();

    $.each(data_form,function(key,input){
        formData.append(input.name, input.value);
    });
    formData.append('_method', 'PUT'); // default update

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'post',
        url: url+'/'+updated_id,
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
            modul_proses.find('#loading').attr('hidden', false);
            modul_proses.find('#limo-btn-ubah').attr('hidden', true);
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
            modul_proses.find('#limo-btn-ubah').attr('hidden', false);
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

/* ==========================================================================================================
------------------------------------------------- DELETE DATA -----------------------------------------------
===========================================================================================================*/
modul_layout.find("#checkAll").click(function () {
    modul_layout.find('.cb_id').not(this).prop('checked', this.checked);
    var cb_checked = $('.cb_id:checked').length;

    if (cb_checked > 0) {
        modul_layout.find('#limo-btn-hapus').attr('disabled', false);
        modul_layout.find('#count-hapus').html(cb_checked);
    } else {
        modul_layout.find('#limo-btn-hapus').attr('disabled', true);
        modul_layout.find('#count-hapus').html(0);
    }
});

function cb_click() {
    var cb_checked = $('.cb_id:checked').length;
    var per_page   = count_page;

    if (cb_checked > 0) {
        if (cb_checked == per_page) {
            modul_layout.find('#checkAll').prop('checked', true);
        } else {
            modul_layout.find('#checkAll').prop('checked', false);
        }

        $('#limo-btn-hapus').attr('disabled', false);
        modul_layout.find('#count-hapus').html(cb_checked);
    } else {
        $('#limo-btn-hapus').attr('disabled', true);
        modul_layout.find('#count-hapus').html(0);
    }
}

function hapus(url) {
    var formData = new FormData();

    modul_layout.find(".cb_id:checked").each(function(){
        formData.append("id[]", $(this).val());
    });

    Swal.fire({
        title: "<span style='color:black;'>Anda yakin menghapus data ini ?</span>",
        text: "Data tidak dapat dikembalikan lagi !",
        icon: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#28bb4b",
        cancelButtonColor: "#f34e4e",
        confirmButtonText: "Ya, Hapus !"
    }).then((result) => {
        if (result.value) {
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
                    if (resp.result == 200) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "<span style='color:black;'>Data berhasil dihapus</span>",
                            showConfirmButton: !1,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "<i style='color:black'>Oops...</i>",
                            html: "Data gagal dihapus, karena user sedang aktif",
                        })
                    }
                },
                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    modul_layout.find('#loading').attr('hidden', true);
                    loadData(url_first);
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
    });
}