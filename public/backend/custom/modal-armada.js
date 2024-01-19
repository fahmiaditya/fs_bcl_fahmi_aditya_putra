var modul_modal_armada     = $('div#modal-armada');
var url_jenis_armada       = modul_modal_armada.find('#url_jenis_modal').val();
var url_first_modal_armada = modul_modal_armada.find('#url_first_modal').val();

$("#modal_jenis").select2({ 
    dropdownParent: $("#modal-armada") 
}); 

function showModalArmada()
{
    $('#modal-armada').modal('show');
    loadComboboxJenis(url_jenis_armada);
}

modul_modal_armada.find('#modal_jenis').on('change', function (e) {
    laodDataModalArmada(url_first_modal_armada);
});

modul_modal_armada.find('#modal_search').on('keyup', function (e) {
    if (e.key === 'Enter' || e.keyCode === 13) {
        laodDataModalArmada(url_first_modal_armada);
    }
});

function loadComboboxJenis(url) {
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'post',
        url: url,
        processData: false,
        contentType: false,
        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
            //
        },
        success: function (resp) {
            // console.log(resp);
            modul_modal_armada.find('#modal_jenis').html(resp);
        },
        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
            laodDataModalArmada(url_first_modal_armada);
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

function laodDataModalArmada(url)
{
    var formData   = new FormData();
    var other_data = modul_modal_armada.find('#group_search_modal :input').serializeArray();

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
            modul_modal_armada.find('#loading').attr('hidden', false);
        },
        success: function (resp) {
            // console.log(resp);
            modul_modal_armada.find('#table-modal-load tbody').html(resp.item_table);
            modul_modal_armada.find('#pagination-modal').html(resp.pagination);
        },
        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
            modul_modal_armada.find('#loading').attr('hidden', true);
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

$('body').on('click', '.pagination-modal-armada a', function(e) {
    var url = $(this).attr('data-link');
    laodDataModalArmada(url);
});

modul_modal_armada.find("#btn-pilih").click(function () {
    var armada    = modul_modal_armada.find('[name="rb_modal"]:checked').attr('data-armada');
    var armada_id = modul_modal_armada.find('[name="rb_modal"]:checked').val();
    var kapasitas = modul_modal_armada.find('[name="rb_modal"]:checked').attr('data-kapasitas');

    modul_proses.find('#armada').val(armada);
    modul_proses.find('#armada_id').val(armada_id);
    modul_proses.find('#armada_kapasitas').val(kapasitas);
    modul_proses.find('#view-max-muatan').html('(Max Muatan : '+kapasitas+')');
    modul_proses.find('#btn-add-barang').attr('disabled', false);
    modul_proses.find('[name="barang[]"]').attr('readonly', false);
    modul_proses.find('[name="muatan[]"]').attr('readonly', false);

    $('#modal-armada').modal('toggle');
});