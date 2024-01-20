var modul_layout = $('section#limo-index');
var modul_proses = $('section#limo-proses');
var url_first    = modul_layout.find('#url_first').val();
var updated_id   = '';
var count_page   = 0;
let sum_muatan   = 0;
var modul_modal_pengiriman = $('div#modal-pengiriman');
var modul_modal_lokasi     = $('div#modal-lokasi');
var modul_modal_detail     = $('div#modal-detail');

/* ==========================================================================================================
------------------------------------------------- LAIN-LAIN -------------------------------------------------
===========================================================================================================*/
modul_layout.find('#search').attr('placeholder', 'Kode, Lokasi Tujuan');

modul_layout.find('#sort_field').append(
    $('<option>', {
        value: 'kode',
        text: 'Kode'
    }),
);

function formIndex(tipe) {
    // Note tipe : 0:index 1:create 2:update
    if (tipe == 0) {
        resetForm();

        // DEFAULT INDEX
        $('#limo-title').html('Data Transaksi');
        $('#limo-breadcrumb').html('Data Transaksi');
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
            $('#limo-title').html('Tambah Transaksi');
            $('#limo-breadcrumb').html('Tambah Transaksi');
            modul_proses.find('#limo-btn-simpan').attr('hidden', false);
            modul_proses.find('#limo-btn-ubah').attr('hidden', true);
            // END DEFAULT INDEX

            // EVENT FORM PROSES
                // jika ada event di form proses
            // END EVENT FORM PROSES
        } else {
            // DEFAULT INDEX
            $('#limo-title').html('Ubah Transaksi');
            $('#limo-breadcrumb').html('Ubah Transaksi');
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
    modul_proses.find('#armada').val('');
    modul_proses.find('#armada_id').val('');
    modul_proses.find('#armada_kapasitas').val('');
    modul_proses.find('#view-barang').html(
        '<div class="input-group">'+
            '<input readonly type="text" name="barang[]" class="form-control" placeholder="Nama Barang"/>'+
            '<input readonly type="text" name="muatan[]" class="form-control" placeholder="Perkiraan Muatan"/>'+
            '<button disabled id="btn-add-barang" onclick="addBarang()" class="btn input-group-text btn-dark waves-effect waves-light" type="button"><i class="fe-plus"></i></button>'+
        '</div>'
    );
    modul_proses.find('#lokasi_asal').val('');
    modul_proses.find('#lokasi_tujuan').val('');
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

modul_proses.find("#tgl_pemesanan").flatpickr({
    // dateFormat: "d-m-Y",
    enableTime: !0,
    minDate: new Date(),
    defaultDate: new Date(),
});

/* ======================================================================================================
------------------------------------------------- EVENT -------------------------------------------------
=========================================================================================================*/
modul_layout.find('#search').on('keyup', function (e) {
    if (e.key === 'Enter' || e.keyCode === 13) {
        loadData(url_first);
    }
});

modul_layout.find('#filter_status').on('change', function (e) {
    loadData(url_first);
});

$('body').on('click', '.pagination a', function(e) {
    var url = $(this).attr('data-link');
    loadData(url);
});

function addBarang() {
    var max_muatan = modul_proses.find('#armada_kapasitas').val();

    if (sum_muatan <= max_muatan) {
        modul_proses.find('#view-barang').append(
            '<div class="input-group">'+
               '<input type="text" name="barang[]" class="form-control" placeholder="Nama Barang"/>'+
               '<input type="text" name="muatan[]" class="form-control" placeholder="Perkiraan Muatan"/>'+
               '<button id="remove-barang" class="btn input-group-text btn-danger waves-effect waves-light" type="button"><i class="fe-trash-2"></i></button>'+
            '</div>'
        );
    } else {
        Swal.fire({
            icon: "error",
            title: "<i style='color:black'>Oops...</i>",
            html: "Barang melebihi muatan !",
        })
    }
}

$('body').on('keyup', '[name="muatan[]"]', function(e) {
    var max_muatan = modul_proses.find('#armada_kapasitas').val();
    var values = $("input[name^='muatan[]']").map(function (idx, ele) {
        return $(ele).val();
    }).get();

    // MERUBAH JADI INTEGER
    var result = values.map(function (x) { 
        return parseInt(x, 10); 
    });

    let hasil = 0;
    result.forEach(item => {
        hasil += item;
    });

    sum_muatan = hasil;

    if (sum_muatan > max_muatan) {
        Swal.fire({
            icon: "error",
            title: "<i style='color:black'>Oops...</i>",
            html: "Barang melebihi muatan !",
        })

        $(this).val(0);
        modul_proses.find('#btn-add-barang').attr('disabled', true);
    } else {
        if (sum_muatan == max_muatan) {
            modul_proses.find('#btn-add-barang').attr('disabled', true);
        } else {
            modul_proses.find('#btn-add-barang').attr('disabled', false);
        }
    }
});

$('body').on('click', '#remove-barang', function(e) {
    $(this).parents('.input-group').remove();
});

function showModalPengiriman(url_update, tgl_pemesanan, tgl_pengiriman, tgl_tiba, barang, status, deskripsi, armada)
{
    $('#modal-pengiriman').modal('show');

    const flatPengiriman = $("#tgl_pengiriman").flatpickr({
        // dateFormat: "d-m-Y",
        enableTime: !0,
        minDate: tgl_pemesanan,
        defaultDate: new Date(),
    });
    
    const flatTiba = $("#tgl_tiba").flatpickr({
        // dateFormat: "d-m-Y",
        enableTime: !0,
        minDate: tgl_pengiriman,
        defaultDate: new Date(),
    });
    
    flatPengiriman.setDate(tgl_pengiriman, true);
    flatTiba.setDate(tgl_tiba, true);

    modul_modal_pengiriman.find('#url_update').val(url_update);
    modul_modal_pengiriman.find('#view-barang').html(barang);
    modul_modal_pengiriman.find('[name="status"][value="'+status+'"]').prop('checked', true);
    modul_modal_pengiriman.find('#deskripsi').val(deskripsi);
    modul_modal_pengiriman.find('#armada').val(armada);
}

function showModalLokasi(url, url_update)
{
    $('#modal-lokasi').modal('show');
    modul_modal_lokasi.find('#url_update_lokasi').val(url_update);
    loadLokasi(url);
}

function showModalDetail(url)
{
    $('#modal-detail').modal('show');
    loadDetail(url);
}

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

function loadLokasi(url)
{
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'post',
        url: url,
        processData: false,
        contentType: false,
        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
            // modul_layout.find('#loading').attr('hidden', false);
        },
        success: function (resp) {
            // console.log(resp);
            modul_modal_lokasi.find('#view-map').html(resp);
            modul_modal_lokasi.find('#lokasi_update').val(resp);
        },
        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
            //
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

function loadDetail(url)
{
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'post',
        url: url,
        processData: false,
        contentType: false,
        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
            // modul_layout.find('#loading').attr('hidden', false);
        },
        success: function (resp) {
            console.log(resp);
            modul_modal_detail.find('#view-tgl-pengiriman').html(resp.view_tgl_kirim);
            modul_modal_detail.find('#view-tgl-tiba').html(resp.view_tgl_tiba);
            modul_modal_detail.find('#table-load-barang-modal-detail tbody').html(resp.view_barang);
            modul_modal_detail.find('#view-map-update').html(resp.view_lokasi_update);
        },
        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
            //
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
        modul_proses.find('#kode').val(resp.kode);
        modul_proses.find('#customer').html(resp.customer);

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
    var data_form = modul_proses.find('form').serializeArray();

    $.each(data_form,function(key,input){
        formData.append(input.name, input.value);
    });

    formData.append('ttl_muatan', sum_muatan);

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
function update() {
    var url       = modul_modal_pengiriman.find('#url_update').val();
    var formData  = new FormData();
    var data_form = modul_modal_pengiriman.find('form').serializeArray();

    $.each(data_form,function(key,input){
        formData.append(input.name, input.value);
    });
    formData.append('_method', 'PUT'); // default update

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'post',
        url: url,
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
            //
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
                $('#modal-pengiriman').modal('toggle');
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
            //
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

function updateLokasi() {
    var url = modul_modal_lokasi.find('#url_update_lokasi').val();
    var formData  = new FormData();
    var data_form = modul_modal_lokasi.find('form').serializeArray();

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
            //
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
                $('#modal-lokasi').modal('toggle');
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
            //
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