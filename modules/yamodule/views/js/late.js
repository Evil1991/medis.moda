$(document).ready(function(){
    $('#order-list tbody tr').each(function(){
        var m = $(this).find('.history_detail a:last').attr('href').match(/id_order=(\d*)/);
        var id_order = m[1];
        var id_state = $(this).find('.history_state').data('value');
        if(id_state == ya_pay){
            var btn = '<a href="/module/yamodule/redirectk?id_order='+id_order+'" class="label ya-pay"><span>'+ya_btn+'&nbsp;&gt;</span></a>';
        }else if(id_state == ya_wait || id_state == ya_aborted || id_state == ya_refund || id_state == ya_error){
            var btn = '<a class="label ya-wait"></a>';
        }else{
            var btn = '<a class="label ya-payed"><span>'+ya_btn_good+'</span></a>';
        }
        $(this).find('.history_invoice').html(btn);
    });
});
