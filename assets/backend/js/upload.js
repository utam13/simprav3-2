// logo aplikasi
function upload_logo() {
	$("#pilih_logo").click();
}

$("#pilih_logo").change(function () {
	let target_proses = serverloc + "/kantor/upload";

	if (this.files[0] != "") {
		if (this.files[0].size > 100000) {
			alert("Ukuran file melebihi 100 kb!");
		} else {
			$("#progress_div").show();
			$("#progress_bar").attr("aria-valuenow", 0);

			var formdata = new FormData();
			formdata.append("berkas", this.files[0]);
			var ajax = new XMLHttpRequest();
			ajax.upload.addEventListener("progress", progressHandler_kantor, false);
			ajax.addEventListener("load", completeHandler_kantor, false);
			ajax.addEventListener("error", errorHandler_kantor, false);
			ajax.addEventListener("abort", abortHandler_kantor, false);
			ajax.open("POST", target_proses);
			ajax.send(formdata);
		}
	}
});

function progressHandler_kantor(event) {
	var percent = (event.loaded / event.total) * 100;
	$(".progress-bar").css("width", Math.round(percent) + "%");
}

function errorHandler_kantor(event) {
	alert("Upload Gagal");
}

function abortHandler_kantor(event) {
	alert("Upload Dibatalkan");
}

function completeHandler_kantor(event) {
	const nama_file = event.target.responseText;
	let berkas;

	$("#progress_div").hide();
	console.log(nama_file);
	if (nama_file == "gagal") {
		alert("Gagal upload file, coba upload ulang !!!");
	} else {
		berkas = serverloc + "/upload/logo/" + nama_file + "?" + Math.random();

		$("#logo_app").attr("src", berkas);
	}
}

// slide
function upload_slide(nomor) {
	$("#pilih-"+nomor).click();
	console.log(nomor);
}

$("#pilih-1").change(function () {
	let target_proses = serverloc + "/slide/upload/" + 1;
	
	if (this.files[0] != "") {
		if (this.files[0].size > 6000000) {
			alert("Ukuran file melebihi 6 Mb!");
		} else {
			$("#progress_div").show();
			$("#progress_bar").attr("aria-valuenow", 0);

			var formdata = new FormData();
			formdata.append("berkas", this.files[0]);
			var ajax = new XMLHttpRequest();
			ajax.upload.addEventListener("progress", progressHandler_slide, false);
			ajax.addEventListener("load", completeHandler_slide, false);
			ajax.addEventListener("error", errorHandler_slide, false);
			ajax.addEventListener("abort", abortHandler_slide, false);
			ajax.open("POST", target_proses);
			ajax.send(formdata);
		}
	}
});

$("#pilih-2").change(function () {
	let target_proses = serverloc + "/slide/upload/" + 2;

	if (this.files[0] != "") {
		if (this.files[0].size > 6000000) {
			alert("Ukuran file melebihi 6 Mb!");
		} else {
			$("#progress_div").show();
			$("#progress_bar").attr("aria-valuenow", 0);

			var formdata = new FormData();
			formdata.append("berkas", this.files[0]);
			var ajax = new XMLHttpRequest();
			ajax.upload.addEventListener("progress", progressHandler_slide, false);
			ajax.addEventListener("load", completeHandler_slide, false);
			ajax.addEventListener("error", errorHandler_slide, false);
			ajax.addEventListener("abort", abortHandler_slide, false);
			ajax.open("POST", target_proses);
			ajax.send(formdata);
		}
	}
});

$("#pilih-3").change(function () {
	let target_proses = serverloc + "/slide/upload/" + 3;

	if (this.files[0] != "") {
		if (this.files[0].size > 6000000) {
			alert("Ukuran file melebihi 6 Mb!");
		} else {
			$("#progress_div").show();
			$("#progress_bar").attr("aria-valuenow", 0);

			var formdata = new FormData();
			formdata.append("berkas", this.files[0]);
			var ajax = new XMLHttpRequest();
			ajax.upload.addEventListener("progress", progressHandler_slide, false);
			ajax.addEventListener("load", completeHandler_slide, false);
			ajax.addEventListener("error", errorHandler_slide, false);
			ajax.addEventListener("abort", abortHandler_slide, false);
			ajax.open("POST", target_proses);
			ajax.send(formdata);
		}
	}
});

$("#pilih-4").change(function () {
	let target_proses = serverloc + "/slide/upload/" + 4;

	if (this.files[0] != "") {
		if (this.files[0].size > 6000000) {
			alert("Ukuran file melebihi 6 Mb!");
		} else {
			$("#progress_div").show();
			$("#progress_bar").attr("aria-valuenow", 0);

			var formdata = new FormData();
			formdata.append("berkas", this.files[0]);
			var ajax = new XMLHttpRequest();
			ajax.upload.addEventListener("progress", progressHandler_slide, false);
			ajax.addEventListener("load", completeHandler_slide, false);
			ajax.addEventListener("error", errorHandler_slide, false);
			ajax.addEventListener("abort", abortHandler_slide, false);
			ajax.open("POST", target_proses);
			ajax.send(formdata);
		}
	}
});

function progressHandler_slide(event) {
	var percent = (event.loaded / event.total) * 100;
	$(".progress-bar").css("width", Math.round(percent) + "%");
}

function errorHandler_slide(event) {
	alert("Upload Gagal");
}

function abortHandler_slide(event) {
	alert("Upload Dibatalkan");
}

function completeHandler_slide(event) {
	const nama_file = event.target.responseText;
	let berkas;

	$("#progress_div").hide();
	console.log(nama_file);
	if (nama_file == "gagal") {
		alert("Gagal upload file, coba upload ulang !!!");
	} else {
		berkas = serverloc + "/upload/slide/" + nama_file + "?" + Math.random();
		console.log(berkas);

		if(nama_file.includes("slide_1") == true){
			$("#slide-1").attr("src", berkas);
		}

		if(nama_file.includes("slide_2") == true){
			$("#slide-2").attr("src", berkas);
		}
		
		if(nama_file.includes("slide_3") == true){
			$("#slide-3").attr("src", berkas);
		}

		if(nama_file.includes("slide_4") == true){
			$("#slide-4").attr("src", berkas);
		}
	}
}

// link app
function upload_link(jenis) {
	$("#pilih-"+jenis).click();
	console.log(jenis);
}

$("#pilih-slide").change(function () {
	let target_proses = serverloc + "/linkapp/upload/slide";
	
	if (this.files[0] != "") {
		if (this.files[0].size > 6000000) {
			alert("Ukuran file melebihi 6 Mb!");
		} else {
			$("#progress_div").show();
			$("#progress_bar").attr("aria-valuenow", 0);

			var formdata = new FormData();
			formdata.append("berkas", this.files[0]);
			var ajax = new XMLHttpRequest();
			ajax.upload.addEventListener("progress", progressHandler_linkapp, false);
			ajax.addEventListener("load", completeHandler_linkapp, false);
			ajax.addEventListener("error", errorHandler_linkapp, false);
			ajax.addEventListener("abort", abortHandler_linkapp, false);
			ajax.open("POST", target_proses);
			ajax.send(formdata);
		}
	}
});

$("#pilih-icon").change(function () {
	let target_proses = serverloc + "/linkapp/upload/icon";

	if (this.files[0] != "") {
		if (this.files[0].size > 6000000) {
			alert("Ukuran file melebihi 6 Mb!");
		} else {
			$("#progress_div").show();
			$("#progress_bar").attr("aria-valuenow", 0);

			var formdata = new FormData();
			formdata.append("berkas", this.files[0]);
			var ajax = new XMLHttpRequest();
			ajax.upload.addEventListener("progress", progressHandler_linkapp, false);
			ajax.addEventListener("load", completeHandler_linkapp, false);
			ajax.addEventListener("error", errorHandler_linkapp, false);
			ajax.addEventListener("abort", abortHandler_linkapp, false);
			ajax.open("POST", target_proses);
			ajax.send(formdata);
		}
	}
});

function progressHandler_linkapp(event) {
	var percent = (event.loaded / event.total) * 100;
	$(".progress-bar").css("width", Math.round(percent) + "%");
}

function errorHandler_linkapp(event) {
	alert("Upload Gagal");
}

function abortHandler_linkapp(event) {
	alert("Upload Dibatalkan");
}

function completeHandler_linkapp(event) {
	const nama_file = event.target.responseText;
	let berkas;

	$("#progress_div").hide();
	console.log(nama_file);
	if (nama_file == "gagal") {
		alert("Gagal upload file, coba upload ulang !!!");
	} else {
		berkas = serverloc + "/upload/linkapp/" + nama_file + "?" + Math.random();
		console.log(berkas);

		if(nama_file.includes("slide") == true){
			$("#slide").val(nama_file);
			$("#slide-app").attr("src", berkas);
		}

		if(nama_file.includes("icon") == true){
			$("#icon").val(nama_file);
			$("#icon-app").attr("src", berkas);
		}
	}
}