var _tr = "<tr>";
var _str = "</tr>";
var _td = "<td>";
var _std = "</td>";
var numericOption = {aSep: '.', aDec: ',', aSign: 'Rp ', vMin: '-999999999', aPad: false};

$("#kasFilter").submit(function (e) { 
  e.preventDefault();
  
  showLoading();

  var url = "http://localhost/annur/index.php/kas/getTotalKasByMonth";
  var inputTahun = $("#filterTahun").val();
  var inputBulan = $("#filterBulan").val();

  $("tbody").empty();

  $.post(
    url,
    {
      month:inputBulan,
      year:inputTahun
    },
    function(data,status){
      
      var penerimaanIndex = 1;
      var pengeluaranIndex = 1;
      for(var i = 0; i < data.kas.length; i++){

        if(data.kas[i].status == "1"){

          var row = _tr +
                    _td + penerimaanIndex + _std +
                    _td + data.kas[i].kode + _std +
                    _td + data.kas[i].nama + _std +
                    _td + "<span class='numeric'>" + data.kas[i].nilai + "</span>" + _std +
                    _tr;  

          $(".penerimaan tbody").append(row);
          
          penerimaanIndex += 1;

        }else{

          var row = _tr +
                    _td + pengeluaranIndex + _std +
                    _td + data.kas[i].kode + _std +
                    _td + data.kas[i].nama + _std +
                    _td + "<span class='numeric'>" + data.kas[i].nilai + "</span>" + _std +
                    _tr;  

          $(".pengeluaran tbody").append(row);

          pengeluaranIndex += 1;
        }
      }

      var selisih = parseInt(data.selisih);
      var _cardStatus = $(".cardStatus span");
      if(_cardStatus.hasClass("red")){
        if(selisih >= 0){
          _cardStatus.removeClass("red");  
        }
      }else if(_cardStatus.hasClass("green")){
        if(selisih <= 0){
          _cardStatus.removeClass("green");
        }
      }else if(_cardStatus.hasClass("grey")){
        if(selisih != 0){
          _cardStatus.removeClass("grey");
        }
      }

      if(selisih < 0){
        _cardStatus.addClass("red");
      }else if(selisih > 0){
        _cardStatus.addClass("green");
      }else{
        _cardStatus.addClass("grey");
      }

      $('.numeric').autoNumeric('init',numericOption);
      $(".penerimaan .cardFooter p").autoNumeric("set",data.penerimaan);
      $(".pengeluaran .cardFooter p").autoNumeric("set",data.pengeluaran);
      $(".cardStatus p").autoNumeric("set",selisih);

      hideLoading();
    }
  );

});

$("#actionPrintPage").click(function (e) { 
  e.preventDefault();
  var penerimaan = $(".penerimaan tbody").html();
  var penerimaanTotal = $(".penerimaan .cardTotal p").html();
  var pengeluaran = $(".pengeluaran tbody").html();
  var pengeluaranTotal = $(".pengeluaran .cardTotal p").html();
  var selisih = $(".nilaiSelisih").html();


  localStorage.setItem("penerimaan",penerimaan);
  localStorage.setItem("penerimaanTotal",penerimaanTotal);
  localStorage.setItem("pengeluaran",pengeluaran);
  localStorage.setItem("pengeluaranTotal",pengeluaranTotal);
  localStorage.setItem("selisih",selisih);
  var w = window.open("http://localhost/annur/print/totalkas_print.html").print();
});

$(document).ready(function(){
      /// Initialization Of Auto Numeric
      console.log("Masuk Di Print");
      $('.numeric').autoNumeric('init',numericOption);

      $('select').material_select();

      hideLoading();

      

});