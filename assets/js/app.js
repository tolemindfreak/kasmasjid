/* Document Ready */

$(document).ready(function(){
    var window_width = $(window).width();
    var window_height = $(window).height();
    $(".button-collapse").sideNav();
    $("body").css("min-height",window_height);

});

$(document).on('mouseover', 'table tr', function(e) {
    $(this).find(".action-column").show();
});

$(document).on('mouseout', 'table tr', function(e) {
     // code from mouseout hover function goes here
     $(this).find(".action-column").hide();
});

$(window).scroll(function(){
    if($(document).scrollTop() < 20){
        $("#form-card").css("top",100);
    }else{
        $("#form-card").css("top",20);
    }
});

function actionEdit(e,obj){
    e.preventDefault();
    $(".table-row-edit").each(function(){
        $(this).removeClass("table-row-edit");
        $(this).find("a").show();
    });

    obj.parents("tr").addClass("table-row-edit");
    obj.hide();
    obj.next().hide();
}

function hideLoading(){
    $("body").removeClass("hiddenOverflow");
    $(".preload").fadeOut(100);
}

function showLoading(){
    $("body").addClass("hiddenOverflow");
    $(".preload").show();
}