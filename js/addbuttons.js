$(document).ready(function(){

$('#addhref').click(function(){
var addhref = prompt('Введите ссылку', '');
if (addhref) {
  addhref = '<a href="'+addhref+'">Название ссылки</a>';
  document.getElementById('textarea').value += addhref;}
});


$('#addimage').click(function(){
alert("Кнопка в разработке");
});


$('#addaudio').click(function(){
alert("Кнопка в разработке");
});


$('#addvideo').click(function(){
alert("Кнопка в разработке");
});


$(function(){
    $(".AnsweringButton").on("click", function(){
    var id = $(this).attr('id');
    var name = $(this).attr('value');
    document.getElementById('textarea').value += name+",";
    document.getElementById('mainid').value = id;
    });
});




});
