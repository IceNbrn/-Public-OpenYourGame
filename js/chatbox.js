/**
 * Created by Henrique on 16-02-2017.
 */
function submitChat(){
    var msg_ = $('#msg').val();
    if(msg_ == ''){
        swal("Oops!", "Por tem de escrever a mensagem!", "error");
        return;
    }
    var tamanhoText = msg_.length;
    if(tamanhoText <= 150){
        var xmlhttp = new XMLHttpRequest();


        xmlhttp.open('POST','chatbox/insDataBox.php?m=' + msg_, true);
        xmlhttp.send();
        document.getElementById('msg').value = "";
    }
    else {
        swal("Oops!", "Tens de escrever uma mensagem com menos de 150 caracteres!", "error");
    }

}

$(document).ready(function () {
    $.ajaxSetup({cache:false});
    setInterval(function () {
        $('#show').load('chatbox/getDataBox.php')
    }, 0.1)
});