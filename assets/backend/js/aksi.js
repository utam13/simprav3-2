const serverloc =  "http://"+window.location.hostname;

function formatNumber(num) {
	return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
}

//lihat password
function lihatpassword() {
	var x = document.getElementById("password");
	if (x.type === "password") {
		x.type = "text";
		$("#iconlihat").removeClass('fa fa-eye').addClass('fa fa-eye-slash');
	} else {
		x.type = "password";
		$("#iconlihat").removeClass('fa fa-eye-slash').addClass('fa fa-eye');
	}
}

//tampilkan loading indikator
function showloading() {
	$("#dvloading").show();
}

//pesan proses input edit masih aktif
function pesanprosesdata() {
	alert("Anda masih dalam proses penginputan/perubahan data\nSelesaikan proses tersebut dengan mengklik tombol Simpan/Selesai/Batal (untuk membatalkan penginputan)");
}

function recaptcha() {
    let url = serverloc + '/login/recaptcha';
		$.getJSON(url, function (result) {
			console.log(result);
			$.each(result, function (i, field) {
                $(".captcha").html(field.captchaview);
			});
		});

    $("#btn-login").attr("disabled",true);
    $("#btn-login").attr("type","button");
}

$("#cekcaptcha").on('input', function () {
	let cekcaptcha = $(this).val();
	
	if (cekcaptcha != "") {
		let url = serverloc + '/login/cek/' + cekcaptcha;
		$.getJSON(url, function (result) {
			console.log(result);
			$.each(result, function (i, field) {
				if (field.jml == 0) {
                    if(cekcaptcha.length >= 4){					
					    alert("Captcha yg Anda masukkan tidak sama");
                        $("#cekcaptcha").val("");
                    }

                    $("#btn-login").attr("disabled",true);
                    $("#btn-login").attr("type","button");
				} else {
                    $("#btn-login").removeAttr("disabled");
                    $("#btn-login").attr("type","submit");
                }
			});
		});
	}  else {
		$("#btn-login").attr("disabled",true);
		$("#btn-login").attr("type","button");
	}
});

$('#nama').change(function(){
	let awal = $('#nama_awal').val();
	let nama = $(this).val();

	if(awal != nama){
		let url = serverloc + "/linkapp/cek/nama/" + nama;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('Nama Aplikasi sudah terdaftar !!!');
				$('#nama').val('');
				$('#nama').focus();
			}
		})
	}
})

$('#urlapp').change(function(){
	let awal = $('#url_awal').val();
	let urlapp = $(this).val();

	if(awal != urlapp){
		let url = serverloc + "/linkapp/cek/url/" + urlapp;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('URL Aplikasi sudah terdaftar !!!');
				$('#urlapp').val('');
				$('#urlapp').focus();
			}
		})
	}
})

$('#nip').change(function(){
	let awal = $('#nip_awal').val();
	let nip = $(this).val();
	console.log();
	if(awal != nip){
		let url = serverloc + "/pegawai/cek/nip/" + nip;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('NIP sudah terdaftar !!!');
				$('#nip').val('');
				$('#nip').focus();
			}
		})
	}
})

$('#userakses').change(function(){
	let awal = $('#username_awal').val();
	let username = $(this).val();

	if(awal != username){
		let url = serverloc + "/pegawai/cek/username/" + username;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('User Name sudah terdaftar !!!');
				$('#userakses').val('');
				$('#userakses').focus();
			}
		})
	}
})

$("#levelakses").change(function(){
	let pilih = $(this).val();

	if(pilih == "1" || pilih == "2"){
		$("#userakses").attr("required", true);
        $("#userpass").attr("required", true);
	} else {
		$("#userakses").removeAttr("required");
        $("#userpass").removeAttr("required");
	}
});

$('#kd_penyedia').change(function(){
	let awal = $('#kode_awal').val();
	let kode = $(this).val();

	if(awal != kode){
		let url = serverloc + "/penyedia/cek/kode/" + kode;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('Kode penyedia sudah terdaftar !!!');
				$('#kd_penyedia').val('');
				$('#kd_penyedia').focus();
			}
		})
	}
})

$('#nama_penyedia').change(function(){
	let awal = $('#nama_awal').val();
	let nama = $(this).val();
	console.log(nama);
	if(awal != nama){
		let url = serverloc + "/penyedia/cek/nama/" + nama;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('Nama penyedia sudah terdaftar !!!');
				$('#nama_penyedia').val('');
				$('#nama_penyedia').focus();
			}
		})
	}
})

$('#npwp_penyedia').change(function(){
	let awal = $('#npwp_awal').val();
	let npwp = $(this).val();

	if(awal != npwp){
		let url = serverloc + "/penyedia/cek/npwp/" + npwp;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('NPWP penyedia sudah terdaftar !!!');
				$('#npwp_penyedia').val('');
				$('#npwp_penyedia').focus();
			}
		})
	}
})

$('#email').change(function(){
	let awal = $('#email_awal').val();
	let email = $(this).val();

	if(awal != email){
		let url = serverloc + "/penyedia/cek/email/" + email;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('Email sudah terdaftar !!!');
				$('#email').val('');
				$('#email').focus();
			}
		})
	}
})

$('#jeniscount').change(function () {  
	let pilih = $(this).val();

	$('.div-kelompok').removeClass('sr-only');
	$('#kelompok').empty();
	$('#kelompok').append('<option value="">Pilih</option>');
	$('#kelompok').attr('required',true);

	$('#thn').val('');

	switch (pilih) {
		case 'struktur_apbd': 
			$('#kelompok').append('<option value="murni">Murni</option>');
			$('#kelompok').append('<option value="perubahan">Perubahan</option>');

			$('#kelompok').focus();
			break;
		case 'rincian_struktur_apbd': 
			$('#kelompok').append('<option value="murni">Murni</option>');
			$('#kelompok').append('<option value="perubahan">Perubahan</option>');

			$('#kelompok').focus();
			break;
		case 'rup_rekapitulasi':
			$('.div-kelompok').addClass('sr-only');
			$('#kelompok').removeAttr('required');

			$('#thn').focus();
			break;
		case 'tender_rekapitulasi':
			$('#kelompok').append('<option value="metode">Metode</option>');
			$('#kelompok').append('<option value="jenis">Jenis</option>');
			$('#kelompok').append('<option value="satker">Satuan Kerja (Satker)</option>');

			$('#kelompok').focus();
			break;
		case 'nontender_rekapitulasi':
			$('#kelompok').append('<option value="metode">Metode</option>');
			$('#kelompok').append('<option value="jenis">Jenis</option>');
			$('#kelompok').append('<option value="satker">Satuan Kerja (Satker)</option>');

			$('#kelompok').focus();
			break;
		case 'realisasi_rekapitulasi':
			$('.div-kelompok').addClass('sr-only');
			$('#kelompok').removeAttr('required');

			$('#thn').focus();
			break;
		case 'realisasi_triwulan':
			$('.div-kelompok').addClass('sr-only');
			$('#kelompok').removeAttr('required');

			$('#thn').focus();
			break;
		case 'monitoring_ppk':
			$('#kelompok').append('<option value="tender">Tender</option>');
			$('#kelompok').append('<option value="nontender">Non Tender</option>');
			$('#kelompok').append('<option value="pctnontender">Pencatatan Non Tender</option>');
			$('#kelompok').append('<option value="pctswakelola">Pencatatan Swakelola</option>');
			$('#kelompok').append('<option value="epurchasing">e-Purchasing</option>');

			$('#kelompok').focus();
			break;
		case 'monitoring_personil':
			$('#kelompok').append('<option value="pokja">Pokja</option>');
			$('#kelompok').append('<option value="pp">PP</option>');

			$('#kelompok').focus();
			break;
		case 'monitoring_penyedia':
			$('#kelompok').append('<option value="tender">Tender</option>');
			$('#kelompok').append('<option value="nontender">Non Tender</option>');
			$('#kelompok').append('<option value="pctnontender">Pencatatan Non Tender</option>');
			$('#kelompok').append('<option value="pctswakelola">Pencatatan Swakelola</option>');
			$('#kelompok').append('<option value="epurchasing">e-Purchasing</option>');

			$('#kelompok').focus();
			break;
		case 'rencana_paket_pengadaan':
			$('.div-kelompok').addClass('sr-only');
			$('#kelompok').removeAttr('required');

			$('#thn').focus();
			break;
		case 'grafik_belanja_pengadaan':
			$('.div-kelompok').addClass('sr-only');
			$('#kelompok').removeAttr('required');

			$('#thn').focus();
			break;
		case 'grafik_rup_penyedia':
			$('.div-kelompok').addClass('sr-only');
			$('#kelompok').removeAttr('required');

			$('#thn').focus();
			break;
		case 'grafik_rup_swakelola':
			$('.div-kelompok').addClass('sr-only');
			$('#kelompok').removeAttr('required');

			$('#thn').focus();
			break;
		case 'grafik_tender':
			$('.div-kelompok').addClass('sr-only');
			$('#kelompok').removeAttr('required');

			$('#thn').focus();
			break;
		case 'grafik_nontender':
			$('.div-kelompok').addClass('sr-only');
			$('#kelompok').removeAttr('required');

			$('#thn').focus();
			break;
		case 'mekanisme_lainnya':
			$('.div-kelompok').addClass('sr-only');
			$('#kelompok').removeAttr('required');

			$('#thn').focus();
			break;
	}
})

$('#nama_satker').change(function(){
	let awal = $('#nama_awal').val();
	let nama = $(this).val();

	if(awal != nama){
		let url = serverloc + "/satker/cek/nama/" + nama;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('Nama sudah terdaftar !!!');
				$('#nama_satker').val('');
				$('#nama_satker').focus();
			}
		})
	}
})

$('#singkatan').change(function(){
	let awal = $('#singkatan_awal').val();
	let singkatan = $(this).val();

	if(awal != singkatan){
		let url = serverloc + "/satker/cek/singkatan/" + singkatan;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('Email sudah terdaftar !!!');
				$('#singkatan').val('');
				$('#singkatan').focus();
			}
		})
	}
})