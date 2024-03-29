/* global $*/
        
$(function () {
    //検索ボタンをクリックされたときに実行
    $("#search_btn").click(function () {
        //入力値をセット
        var param = {zipcode: $('#zipcode').val()};
        //zipcloudのAPIのURL
        var send_url = "https://zipcloud.ibsnet.co.jp/api/search";
        $.ajax({
            type: "GET",
            cache: false,
            data: param,
            url: send_url,
            dataType: "jsonp",
            success: function (res) {
                //結果によって処理を振り分ける
                if (res.status == 200) {
                    //処理が成功したとき
                    //該当する住所を表示
                    var html = '';
                    for (var i = 0; i < res.results.length; i++) {
                        var result = res.results[i];
                        console.log(res.results);
                        html +=  result.address1 + result.address2 + result.address3;
                    }
                    
                    $('#zipname').val(result.address1 + result.address2 + result.address3)
                } else {
                    //エラーだった時
                    //エラー内容を表示
                    $('#zip_result').html(res.message);

                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
            }
        });
    });
    

});

function mediaQueriesWin(){
    var width = $(window).width();
    if(width <= 768){
        $(".has-child>a").off('click');
        $(".has-child>a").on('click',function(){
            var parentElem = $(this).parent();
            $(parentElem).toggleClass('active');
            $(parentElem).children('ul').stop().slideToggle(500);
            return false;
        });
    }else{
        $(".has-child>a").off('click');
        $(".has-child>a").removeClass('active');
        $(".has-child").children('ul').css("display","");
    }
}

$(window).resize(function(){
    mediaQueriesWin();
});

$(window).on('load',function(){
    mediaQueriesWin();
});

$(function(){
    $('.message').fadeOut(3000);
});
$(function(){
    $('.flash_message').fadeOut(3000);
});