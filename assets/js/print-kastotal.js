$(function() {
    if(localStorage.getItem("penerimaan")) {

     var penerimaan = localStorage.getItem("penerimaan");
     var penerimaanTotal = localStorage.getItem("penerimaanTotal");
     var pengeluaran = localStorage.getItem("pengeluaran");
     var pengeluaranTotal = localStorage.getItem("pengeluaranTotal");
     var selisih = localStorage.getItem("selisih");

     $(".penerimaan tbody").html(penerimaan);
     $(".pengeluaran tbody").html(pengeluaran);
     $(".total-nilai-penerimaan").html(penerimaanTotal);
     $(".total-nilai-pengeluaran").html(pengeluaranTotal);
     $(".selisih h6").html(selisih);

     localStorage.removeItem("penerimaan");
     localStorage.removeItem("penerimaanTotal");
     localStorage.removeItem("pengeluaran");
     localStorage.removeItem("pengeluaranTotal");
     localStorage.removeItem("selisih");
    }

});