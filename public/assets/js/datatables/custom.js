$(document).ready(function(){
    // DataTable
    var user = $('#user').DataTable({
        "scrollX": true,
        "scrollY": "27em",
        "scrollCollapse": true
    });

    user.buttons().container()
    .appendTo('#user'); 

    var rpdesa = $('#rpdesa').DataTable({
        "scrollX": true,
        "scrollY": "27em",
        "scrollCollapse": true
    });

    rpdesa.buttons().container()
    .appendTo('#rpdesa'); 


    // Modal
    $(document).on('click', '#btnCancelProfile', function(){
        var id = $(this).attr('data-id');
        $('form').attr('action', '/profiledesa/'+id);
        $('#modalCancel').modal('show');
    });

    $('.closeModal').click(function(e) {
        $('#modalCancel').modal('hide');
        $('#modalView').modal('hide');
    });


    $(document).on('click', '#btnViewProfile', function(){
        var id = $(this).attr('data-id');
        $('#modalView').modal('show');
        $.ajax({
            method: "GET",
            url: "/profiledesa/"+id,
            success: function(response){
                $('#prov').val(response.info_desa['nama_prov']);
                $('#kabkot').val(response.info_desa['nama_kab']);
                $('#kec').val(response.info_desa['nama_kec']);
                $('#desa').val(response.info_desa['nama_desa']);
                $('#alamat').text(response.pengajuan['alamat']);
                $('#email').val(response.pengajuan['email']);
                $('#telp').val(response.pengajuan['telp']);
                $('#info').text(response.pengajuan['info_umum']);
                $('#maps').text(response.pengajuan['html_tag']);
                if (response.pengajuan['tanggal_konfirmasi']!=null){
                    $('#setujui').prop('disabled', true);
                    $('#tolak').prop('disabled', true);
                }else{
                    $('#setujui').prop('disabled', false);
                    $('#tolak').prop('disabled', false);
                };
            }
        });

        $('#setujui').click(function(e){
            $('form').attr('action', '/setujuiprofile/'+id);
        });

        $('#tolak').click(function(e){
            $('form').attr('action', '/tolakprofile/'+id);
        });
    });
});