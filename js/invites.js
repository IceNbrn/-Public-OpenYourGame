$(document).ready(function(){
    function load_notificacoes_naovistas(view = '') {
        $.ajax({
            url: "invites/GetInvites.php",
            method: "POST",
            data: {view:view},
            dataType: "json",
            success:function(data) {
                $('#convites_dropdown').html(data.convites);
                /*if(data.unseen_convites > 0){
                    alert("Convite recebido!");
                    //swal("Convite", "Novo convite recebido!", "success");
                    //$('.count').html(data.unseen_convites);
                }*/
            }
        })
    }

    load_notificacoes_naovistas();

    /*$(document).on('click','.dropdown-toggle',function () {
        $('#count').html('');
        load_notificacoes_naovistas('yes');
    })*/
    setInterval(function () {
        load_notificacoes_naovistas();
    }, 2000)

});
