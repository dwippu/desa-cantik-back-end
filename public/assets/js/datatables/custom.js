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
        $('#modalHapusSk').modal('hide');
    });

    // Modal Profile
    $(document).on('click', '#btnCancelProfile', function(){
        var id = $(this).attr('data-id');
        $('form').attr('action', '/profiledesa/'+id);
        $('#modalCancel').modal('show');
    });

    $('.closeModal').click(function(e) {
        $('#modalCancel').modal('hide');
        $('#modalView').modal('hide');
        $('#modalDelete').modal('hide');
        $('#modalReset').modal('hide');
        $('#modalAktif').modal('hide');
        tutupModal();
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

    $('#role').change(function(){
        let role = $('#role :selected').val();
        let idkab = $('#pilih_kabupaten :selected').val();
        if (role == 'adminkab'){
            $('#pilih_kabupaten').prop("hidden", false);
            $('#pilih_desa').prop("hidden", true);
            $('#input_hidden').val('32'+idkab+'000000');
            $('#input_hidden').prop("disabled", false);
        }
        else{
            $('#pilih_kabupaten').prop("hidden", false);
            $('#pilih_desa').prop("hidden", false);
            $('#input_hidden').prop("disabled", true);
        }
    });

    $('#pilih_kabupaten').change(function(){
        let idkab = $('#pilih_kabupaten :selected').val();
        let role = $('#role :selected').val();
        if (role == 'adminkab'){
            $('#input_hidden').val('32'+idkab+'000000');
        }
        else{
            $.ajax({url: "/desa/"+idkab, success: function(result){
                $('#pilih_desa option').not(':disabled').remove();
                for (var key in result){
                    $('#pilih_desa').append($('<option>', {value:result[key]['kode_desa'], text:result[key]['nama_desa']}));
                }
                $('#pilih_desa').prop("disabled", false);
        }})}
    });

    // List user
    $(document).on('click', '#btnViewUser', function(){
        var id = $(this).attr('data-id');
        $('#modalView').modal('show');
        $('#deletebtn').attr('data-id', id);
        $('#resetbtn').attr('data-id', id);
        $('#ubah_info').attr('data-id', id);
        $.ajax({
            method: "GET",
            url: "/users//"+id,
            success: function(response){ 
                $('#kabkot').val(response['nama_kab']);
                $('#desa').val((response['nama_desa'] == null) ? '-' : response['nama_desa']);
                $('#kode_desa').val(response['kode_desa']);
                $('#email').val(response['secret']);
                $('#nama').val(response['username']);
                $('#role').val(response['group']);
                $('#last_active').val(response['last_active']);
            }
        });
    });

    function tutupModal(){
        $('.pass-collapse').removeClass('show')
        $('#delaction').text('Ya')
        $('#resetaction').text('Ya')
    };

    //Delete user
    $(document).on('click', '#deletebtn', function(){
        $('#modalDelete').modal('show');
        var id = $(this).attr('data-id');
    });

    $('#delaction').click(function(){
        var isi = $(this).text();
        var id = $('#deletebtn').attr('data-id');
        $('.pass-collapse').addClass('show')
        if (isi == 'Ya'){
            $(this).text('Hapus Akun')
        }
        if (isi == 'Hapus Akun'){
            $('#user_id_delete').val(id);
            $('#form-delete-user').submit();
        }
    })

    // Reset Password
    $(document).on('click', '#resetbtn', function(){
        $('#modalReset').modal('show');
        var id = $(this).attr('data-id');
    });


    $('#resetaction').click(function(){
        var isi = $(this).text();
        var id = $('#resetbtn').attr('data-id');
        $('.pass-collapse').addClass('show')
        if (isi == 'Ya'){
            $(this).text('Reset Password')
        }
        if (isi == 'Reset Password'){
            $('#user_id_reset').val(id);
            $('#form-reset-user').submit();
        }
    })
    
    //list descan sk
    $('#jumlahdescan').keyup(function(){
        if($('#label-input-kode-desa').prop("hidden")){
            $('#label-input-kode-desa').prop("hidden", false)
        }
        $('.input-kode-desa').empty();
        var jml = $(this).val();
        for (let i = 0; i < jml; i++){
            $('.input-kode-desa').prepend('<div class="col-3 pt-2"><input name="kode_desa" type="text" class="form-control kode-desa"></div>');
        }
    })
    $('#jumlahdescan').change(function(){
        if($('#label-input-kode-desa').prop("hidden")){
            $('#label-input-kode-desa').prop("hidden", false)
        }
        $('.input-kode-desa').empty();
        var jml = $(this).val();
        for (let i = 0; i < jml; i++){
            $('.input-kode-desa').prepend('<div class="col-3 pt-2"><input name="kode_desa[]" type="text" class="form-control kode-desa" required></div>');
        }
    })

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

    // Modal Aktifkan struktur
    $(document).on('click', '#btnAktif', function(){
        var id = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        $('#pesanAktif').text("Apakah yakin "+status+"?");
        $('#keteranganAktif').val(status);
        $('form').attr('action', '/aktifstrukturdesa/'+id);
        $('#modalAktif').modal('show');
    });

    // View SK
    $(document).on('click', '#btnViewSk', function(){
        var file = $(this).attr('data-file');
        var no_sk = $(this).attr('data-sk');
        document.getElementById("fileSkAgen").src = "../SK Agen/"+file;
        $('#namaSK').text(no_sk);
        $('#modalView').modal('show');

    });

    // View SK Agen
    $(document).on('click', '#btnViewSkAgen', function(){
        var id = $(this).attr('data-id');
        var keterangan = $(this).attr('data-keterangan');
        $('#keteranganView').val(keterangan);
        $('#modalView').modal('show');

        $.ajax({
            method: "GET",
            url: "/daftarskagenstatistik/"+id,
            success: function(response){
                document.getElementById("fileSkAgen").src = "../SK Agen/"+response.sk_agen['file'];
                $("#namaSK").text("SK Agen Statistik - "+response.sk_agen['nomor_sk']);
                $("#no_sk").val(response.sk_agen['nomor_sk']);
                $("#tanggal_sk").val(response.sk_agen['tanggal_sk']);
                if (response.sk_agen['tanggal_konfirmasi']!=null){
                    $('#setujui').prop('disabled', true);
                    $('#tolak').prop('disabled', true);
                }else{
                    $('#setujui').prop('disabled', false);
                    $('#tolak').prop('disabled', false);
                };
            }
        });

        $('#setujui').click(function(e){
            $('form').attr('action', '/setujuiskagen/'+id);
        });

        $('#tolak').click(function(e){
            $('form').attr('action', '/tolakskagen/'+id);
        });

    });

    // Hapus SK
    $(document).on('click', '#btnHapusSk', function(){
        var id = $(this).attr('data-id');
        $('form').attr('action', '/hapusskagen/'+id);
        $('#modalHapusSk').modal('show');
    });

    // Modal Cancel SK Agen
    $(document).on('click', '#btnCancelSkAgen', function(){
        var id = $(this).attr('data-id');
        var keterangan = $(this).attr('data-keterangan');
        $('#keteranganCancel').val(keterangan);
        $('form').attr('action', '/daftarskagenstatistik/'+id);
        $('#modalCancel').modal('show');
    });


});

// Photo Preview On Change
function previewImg(){
    const foto = document.querySelector('#foto');
    const imgPrev = document.querySelector('#fotoPrev');
    const fileFoto = new FileReader();
    fileFoto.readAsDataURL(foto.files[0]);
    fileFoto.onload = function(e){
        imgPrev.src = e.target.result;
    };
};

function previewpdf(){
    const pdf = document.querySelector('#file_sk');
    const pdfPrev = document.querySelector('#fileSkAgen');
    const fileFoto = new FileReader();
    fileFoto.readAsDataURL(pdf.files[0]);
    fileFoto.onload = function(e){
        pdfPrev.src = e.target.result;
    };
};