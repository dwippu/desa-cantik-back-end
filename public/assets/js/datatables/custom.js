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

    // Modal Close
    $('.closeModal').click(function(e) {
        $('#modalCancel').modal('hide');
        $('#modalView').modal('hide');
        $('#modalInValid').modal('hide');
    });

    // Modal Profile
    $(document).on('click', '#btnCancelProfile', function(){
        var id = $(this).attr('data-id');
        $('form').attr('action', '/profiledesa/'+id);
        $('#modalCancel').modal('show');
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

    // Modal Struktur Desa
    if($('#inValidName').text() == 'in-valid name'){
        $('#modalInValid').modal('show');
    };

    $(document).on('click', '#btnCancelStruktur', function(){
        var id = $(this).attr('data-id');
        var keterangan = $(this).attr('data-keterangan');
        $('#keteranganCancel').val(keterangan);
        $('form').attr('action', '/daftarpengajuanstruktur/'+id);
        $('#modalCancel').modal('show');
    });

    $(document).on('click', '#btnViewStruktur', function(){
        var id = $(this).attr('data-id');
        var keterangan = $(this).attr('data-keterangan');
        $('#keteranganView').val(keterangan);
        $('#modalView').modal('show');

        $.ajax({
            method: "GET",
            url: "/daftarpengajuanstruktur/"+id,
            success: function(response){
                $('#prov').val(response.info_desa['nama_prov']);
                $('#kabkot').val(response.info_desa['nama_kab']);
                $('#kec').val(response.info_desa['nama_kec']);
                $('#desa').val(response.info_desa['nama_desa']);
                $('#nama').val(response.pengajuan['nama']);
                document.getElementById("jabatan").value = response.pengajuan['jabatan'];
                $('#email').val(response.pengajuan['email']);
                $('#ig').val(response.pengajuan['instagram']);
                document.getElementById("foto").src = "../Foto Perangkat/"+response.pengajuan['gambar'];
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
            $('form').attr('action', '/setujuistruktur/'+id);
        });

        $('#tolak').click(function(e){
            $('form').attr('action', '/tolakstruktur/'+id);
        });
    });

});