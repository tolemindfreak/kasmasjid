var data_state = "create";
var editedID;
$(document).ready(function(){
    $('#kode-list-items').pageMe({
      pagerSelector:'#myPager',
      activeColor: 'blue',
      prevText:'Prev',
      nextText:'Next',
      showPrevNext:true,
      hidePageNumbers:false,
      perPage:15
    });

    hideLoading();
});

$("#kode-form").submit(function(event){

    event.preventDefault();

    if(data_state == "create"){
        var url = "http://localhost/annur/index.php/kas/createKode";
    
        /// Form Var
        var input_id = $("#kode-id").val();
        var input_nama = $("#kode-nama").val();
        $.post(
            url,
            {
                id:input_id,
                nama:input_nama
            },
            function(data,status){
                if(data.status == 1){
                    console.log("Berhasil menambah data");
                    $("#kode-list > tbody").append(
                        "<tr>" +
                        "<td>" + input_id + "</td>" +
                        "<td>" + input_nama + "</td>" +
                        "<td style='position:absolute;right:0;'>" +
                        "<span class='action-column'>" +
                        "<a class='action-edit'>" +
                        "<i class='material-icons>create</i>" +
                        "</a>" +
                        "<a class='action-delete'>" +
                        "<i class='material-icons'>delete</i>" +
                        "</a></span></td>" +
                        "</tr>"
                    );
                    Materialize.toast('Berhasil menambah data', 2000);
    
                    $("#kode-id").val("");
                    $("#kode-nama").val("");
                    $("#kode-id").focus();
                }else{
                    console.log("Gagal menambah data");
                    if(data.status == 0){
                        Materialize.toast('Gagal menambah data, cek apa ada data yang kosong', 2000);
                    }else{
                        Materialize.toast('Gagal menambah data, id kode sudah ada', 2000);
                    }
                }
                /*
                console.log("Data : " + data.info + "\nStatus : " + status);
                */
            }
        );
    }else{
        console.log("Lagi di Edit Bosque");
        var url = "http://localhost/annur/index.php/kas/editKode";

        /// Form Var
        var input_id = $("#kode-id").val();
        var input_nama = $("#kode-nama").val();
        $.post(
            url,
            {
                id:editedID,
                newId:input_id,
                nama:input_nama
            },
            function(data,status){
                if(data.status == 1){
                    console.log("Berhasil menambah data");
                    $(".table-row-edit").each(function(){
                        $(this).find(".row-id").html(input_id);
                        $(this).find(".row-nama").html(input_nama);
                        $(this).find("span").attr("data-id", input_id);
                        $(this).find("span").attr("data-nama", input_nama);
                        $(this).removeClass("table-row-edit");
                        $(this).find("a").show();
                    });
                    Materialize.toast('Berhasil merubah data', 2000);
                    
                    $("#kode-form .card-title").html("Tambah Kode");
                    $("#kode-id").val("");
                    $("#kode-nama").val("");
                    $("#kode-id").focus();
                    $("#kode-submit").val("Tambah");
                    $("#kode-batal").fadeOut(200);
                    data_state = "create";
                    
                }else{
                    console.log("Gagal menambah data");
                    if(data.status == 0){
                        Materialize.toast('Gagal merubah data, cek apa ada data yang kosong', 2000);
                    }else{
                        Materialize.toast('Gagal merubah data, id kode sudah ada', 2000);
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
    editedID = $(this).parent().attr("data-id");
    var editedNama = $(this).parent().attr("data-nama");
        
    $("#kode-form .card-title").html("Edit Kode " + editedID);
    $("#kode-id").val(editedID);
    $("#kode-nama").val(editedNama);
    $("#kode-submit").val("Simpan");
    $("#kode-batal").fadeIn(300);
    Materialize.updateTextFields();
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