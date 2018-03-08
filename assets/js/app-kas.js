const createKasUrl = "http://localhost/annur/index.php/kas/createKas";
const editKasUrl = "http://localhost/annur/index.php/kas/editKas";
var data_state = "create";
var editedID;
var kodeObj;
var globalPenerimaan = 0;
var globalPengeluaran = 0;
var globalTotal = 0;
var saldokas = 0;
var saldoBank = 0;
var saldoTotal = 0;
var numericOption = {aSep: '.', aDec: ',', aSign: 'Rp ', vMin: '-999999999', aPad: false};

function search(nameKey, myArray){
    for (var i=0; i < myArray.length; i++) {
        if (myArray[i].id === nameKey) {
            return myArray[i].nama;
        }
    }
}


$("#kas-form").submit(function(event){

    event.preventDefault();
    var input_no = $("#kas-no").val();
    var input_kode = $("#kas-kode").val();
    var input_ket = $("#kas-ket").val();
    var input_status = $('input[name=status]:checked', '#kas-form').val();
    var input_type = $('input[name=type]:checked', '#kas-form').val();
    var input_nilai = $("#kas-nilai").autoNumeric('get');
    var input_tanggal = $("#kas-tanggal").val();
    console.log("Nilai : " + input_nilai);

    if(data_state == "create"){
        console.log("masuk create");
        $.post(
            createKasUrl,
            {
                no:input_no,
                kode:input_kode,
                ket:input_ket,
                status:input_status,
                type:input_type,
                nilai:input_nilai,
                tanggal:input_tanggal
            },

            function(data,status){
                if(data.status == 1){
                    console.log(kodeObj);
                    var kodeNama = search(input_kode,kodeObj);

                    var row_pemasukan = "<td width='15%' class='row-pemasukan'>0</td>";
                    var row_pengeluaran = "<td width='15%' class='row-pemasukan'>0</td>";
                    var typeClass = "pink";

                    if(input_status == 1){
                        row_pemasukan = "<td width='15%' class='row-pemasukan'>" +
                                            "<span class='numeric'  data-a-sign='Rp ' data-a-dec=',' data-a-sep='.' data-a-pad='false' data-l-zero='deny' data-v-min='0'>" + input_nilai + "</span>" +
                                        "</td>";       
                    }else{
                        row_pengeluaran =  "<td width='15%' class='row-pengeluaran'>" +
                                                "<span class='numeric'  data-a-sign='Rp ' data-a-dec=',' data-a-sep='.' data-a-pad='false' data-l-zero='deny' data-v-min='0'>" + input_nilai + "</span>" +
                                            "</td>";   
                    }

                    if(input_type == "1"){
                        typeClass = "blue";
                    }

                    $("#kas-list > tbody").prepend(
                        "<tr style='position:relative;' data-id='" + data.id + "'>" +
                        "<td width='7%' class='row-no'>" + input_no + "</td>" +
                        "<td width='4%'>" +
                        "<span class='" + typeClass + " lighten-1 row-type' style='width:12px;height:12px;display:block;border-radius:10px;'></span>" +
                        "</td>" +
                        "<td width='12%' class='row-tanggal'>" + input_tanggal + "</td>" +
                        "<td width='8%' class='row-kode tooltipped' data-position='bottom' data-delay='50' data-tooltip='" + kodeNama +"'>" + input_kode + "</td>" +
                        "<td class='row-key'>" + input_ket + "</td>" +
                        row_pemasukan +
                        row_pengeluaran +
                        "<td style='position:absolute;right:0;'>" +
                        "<span class='action-column'>" +
                        "<a class='action-edit'><i class='material-icons'>create</i></a>" +
                        "<a class='action-delete'><i class='material-icons'>delete</i></a>" +
                        "</span>" +
                        "</td>" +
                        "</tr>"
                    );
                    var intNilai = parseInt(input_nilai);
                    if(input_status == 1){
                        globalPenerimaan = globalPenerimaan + intNilai;
                        if(input_type == 1){
                            saldokas = saldokas + intNilai;
                        }else{
                            saldoBank = saldoBank + intNilai;
                        }
                    }else{
                        globalPengeluaran = globalPengeluaran + intNilai;
                        if(input_type == 1){
                            saldokas = saldokas - intNilai;
                        }else{
                            saldoBank = saldoBank - intNilai;
                        }
                    }

                    saldoTotal = saldokas + saldoBank;
                    globalTotal = globalPenerimaan - globalPengeluaran;

                    $("#penerimaan").autoNumeric('set',globalPenerimaan);
                    $("#pengeluaran").autoNumeric('set',globalPengeluaran);
                    $("#total").autoNumeric('set',globalTotal);

                    $("#saldoKas").autoNumeric('set',saldokas);
                    $("#saldoBank").autoNumeric('set',saldoBank);
                    $("#totalSaldo").autoNumeric('set',saldoTotal);

                    $('.numeric').autoNumeric('init',numericOption);
                    $('.tooltipped').tooltip();

                    Materialize.toast('Berhasil menambah data', 2000);
                    
                    $("#kas-no").val("");
                    $("#kas-kode").val("");
                    $("#kas-tanggal").val("");
                    $("#kas-ket").val("");
                    $("#kas-nilai").val("");
                    $("#kode-no").focus();
                }else{
                    console.log("Gagal menambah data");
                    if(data.status == 2){
                        Materialize.toast('Gagal menambah data, cek apa ada data yang kosong', 2000);
                    }else{
                        Materialize.toast('Gagal menambah data, kode tidak ditemukan', 2000);
                    }
                }
                /*
                console.log("Data : " + data.info + "\nStatus : " + status);
                */
            }
        );
    }else{
        /// Form Var
        $.post(
            editKasUrl,
            {
                id:editedID,
                no:input_no,
                kode:input_kode,
                ket:input_ket,
                status:input_status,
                type:input_type,
                nilai:input_nilai,
                tanggal:input_tanggal
            },
            function(data,status){
                if(data.status == 1){
                    
                    var pemasukan = 0;
                    var pengeluaran = 0;
                    if(input_status == 1){
                        pemasukan = input_nilai;
                    }else{
                        pengeluaran = input_nilai;
                    }

                    var tipeClass = "pink";
                    if(input_type == 1){
                        tipeClass = "blue";
                    }
                    $(".table-row-edit").each(function(){
                        $(this).find(".row-no").html(input_no);
                        $(this).find(".row-tanggal").html(input_tanggal);
                        $(this).find(".row-kode").html(input_kode);
                        $(this).find(".row-ket").html(input_ket);
                        $(this).find(".row-pemasukan > span").autoNumeric('set',pemasukan);
                        $(this).find(".row-pengeluaran > span").autoNumeric('set',pengeluaran);
                        $(this).find(".row-type").removeClass("pink").removeClass("blue");
                        $(this).find(".row-type").addClass(tipeClass);
                        $(this).removeClass("table-row-edit");
                        $(this).find("a").show();
                    });

                    $('.tooltipped').tooltip();

                    Materialize.toast('Berhasil merubah data', 2000);
                    
                    $("#kode-form .card-title").html("Tambah Kode");
                    
                    $("#kas-no").val("");
                    $("#kas-kode").val("");
                    $("#kas-tanggal").val("");
                    $("#kas-ket").val("");
                    $("#kas-nilai").val("");
                    $("#kode-no").focus();
                    $("#kode-submit").val("Tambah");
                    $("#kode-batal").fadeOut(200);
                    data_state = "create";
                    
                }else{
                    console.log("Gagal menambah data");
                    if(data.status == 2){
                        Materialize.toast('Gagal menambah data, cek apa ada data yang kosong', 2000);
                    }else{
                        Materialize.toast('Gagal menambah data, kode tidak ditemukan', 2000);
                    }
                }
                /*
                console.log("Data : " + data.info + "\nStatus : " + status);
                */
            }
        );

    }
});


$(".action-edit").click(function (e) { 
    actionEdit(e,$(this));
    data_state = "edit";
    editedID = $(this).parents("tr").attr("data-id");
    var getKasByIdUrl = "http://localhost/annur/index.php/kas/getKas";

    $.post(
        getKasByIdUrl,
        {
            id:editedID
        },
        function(data,status){

            var kasType = 1;
            var nilai = data.kas;
            if(data.kas == 0 || data.kas == "0"){
                nilai = data.bank;
                kasType = 2;
            }

            $("#kas-form .card-title").html("Edit Kas No " + data.no);
            $("#kas-no").val(data.no);
            $("#kas-kode").val(data.kode);
            $("#kas-ket").val(data.ket);
            $("#kas-tanggal").val(data.tanggal);
            $("#kas-nilai").autoNumeric('set',nilai);
            $("input[name=type][value=" + kasType + "]").prop('checked', true);
            $("input[name=status][value=" + data.status + "]").prop('checked', true);
            $("#kas-submit").val("Simpan");
            $("#kas-batal").fadeIn(300);
            Materialize.updateTextFields();
        }
    );
});

$(".action-delete").click(function(e){
    actionEdit(e,$(this));
    editedID = $(this).parents("tr").attr("data-id");
    $('#modal-delete').modal('open');
});

$(".btn-delete-yes").click(function(e){
    var deleteKasUrl = "http://localhost/annur/index.php/kas/deleteKas";
    $.post(
        deleteKasUrl,
        {
            id:editedID
        },
        function(data,status){
            $(".table-row-edit").remove();
        }
    );
});

$(".btn-delete-cancel").click(function(e){
    $(".table-row-edit").each(function(){
        $(this).removeClass("table-row-edit");
        $(this).find("a").show();
    });
});

$("#kode-batal").click(function(e){
    e.preventDefault();
    $(".table-row-edit").each(function(){
        $(this).removeClass("table-row-edit");
        $(this).find("a").show();
        
    });
    
    $("#kode-form .card-title").html("Tambah Kode");
    $("#kode-id").val("");
    $("#kode-nama").val("");
    $("#kode-submit").val("Tambah");
    $("#kode-batal").fadeOut(200);
    data_state = "create";
});

$(document).ready(function(){

    /// initialization of Table Pager
    $('#kas-list-items').pageMe({
      pagerSelector:'#myPager',
      activeColor: 'blue',
      prevText:'Prev',
      nextText:'Next',
      showPrevNext:true,
      hidePageNumbers:false,
      perPage:45
    });

      /// Initialization Of Auto Numeric
      $('.numeric').autoNumeric('init',numericOption);
      /// Initialization Modal
      $('.modal').modal();

      /// Initialization of Kode autocomplete
      var kodeAutocompleteDataUrl = "http://localhost/annur/index.php/kas/getKode";
      var kodeAutocompleteObj = {};

      $.get(kodeAutocompleteDataUrl, function( data ) {
            kodeObj = data;
            for(var i = 0; i < data.length;i++){
                kodeAutocompleteObj[data[i].id + " - " + data[i].nama] = null;
            }
            $('input.autocomplete').autocomplete({
                data: kodeAutocompleteObj,
                limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
                onAutocomplete: function(val) {
                  // Callback function when value is autcompleted.
                  var kodeVal = val.split(" ")[0];
                  $('input.autocomplete').val(kodeVal);
                },
                minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
              });
      });

      /// Initialization of Summary Kas

      var summaryKasUrl = "http://localhost/annur/index.php/kas/getKasLastMonth";
      $.get(summaryKasUrl,function(data){
        globalPenerimaan = data.penerimaan;
        globalPengeluaran = data.pengeluaran;
        globalTotal = globalPenerimaan - globalPengeluaran;
        saldokas = data.kas;
        saldoBank = data.bank;
        saldoTotal = saldokas + saldoBank;

        $("#penerimaan").autoNumeric('set',globalPenerimaan);
        $("#pengeluaran").autoNumeric('set',globalPengeluaran);
        $("#total").autoNumeric('set',globalTotal);

        $("#saldoKas").autoNumeric('set',saldokas);
        $("#saldoBank").autoNumeric('set',saldoBank);
        $("#totalSaldo").autoNumeric('set',saldoTotal);

        var ctxSaldo = $("#chartSaldo");
        var saldoChart = new Chart(ctxSaldo,{
            type:'doughnut',
            data:{
                datasets:[{
                    data:[saldokas,saldoBank],
                    backgroundColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ]
                }],
                labels:[
                    'Kas','Bank'
                ]
            },
            options:{
                cutoutPercentage:50
            }
        });

        hideLoading();
      });
});