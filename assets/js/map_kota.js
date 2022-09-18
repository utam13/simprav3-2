$(document).ready(function () {
    // menampilkan koordinat di peta indonesia
    let lat = $("#latitude_std").val();
    let lng = $("#longitude_std").val();
    
    viewmap("kota",lat,lng);
});
