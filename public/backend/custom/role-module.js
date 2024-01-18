var modul_layout = $('section#limo-index');
var modul_proses = $('section#limo-proses');
var url_first    = modul_layout.find('#url_first').val();

/* ==========================================================================================================
------------------------------------------------- LAIN-LAIN -------------------------------------------------
===========================================================================================================*/
function printErrorMsg (msg) {
    $(".msg-error").empty();

    $.each( msg, function( key, value ) {
       $("#error-"+key).html(value);
    });
}

/* ==========================================================================================================
------------------------------------------------- LOAD DATA -------------------------------------------------
===========================================================================================================*/
loadData(url_first);

function loadData(url) {
    var formData = new FormData();

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
            modul_layout.find('#limo-view-role').html(resp);
        },
        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
            modul_layout.find('#loading').attr('hidden', true);
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

                modul_proses.find('#modalRoleProses').modal('toggle');
                modul_proses.find(".msg-error").empty();
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
            modul_proses.find('#nama').val('');
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
function update(url, role) {
    var formData  = new FormData();

    modul_layout.find(".permission-"+role+":checked").each(function(){
        formData.append("permissions[]", $(this).val());
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
            Swal.fire({
                position: "center",
                icon: "success",
                title: "<span style='color:black;'>Data berhasil disimpan</span>",
                showConfirmButton: !1,
                timer: 1500
            })

            loadData(url_first);
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
------------------------------------------------- DELETE DATA -----------------------------------------------
===========================================================================================================*/
function hapus(url) {
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
                method: 'DELETE',
                url: url,
                processData: false,
                contentType: false,
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    modul_layout.find('#loading').attr('hidden', false);
                },
                success: function (resp) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "<span style='color:black;'>Data berhasil dihapus</span>",
                        showConfirmButton: !1,
                        timer: 1500
                    })
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