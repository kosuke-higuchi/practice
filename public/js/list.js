$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content") },
})
// $('.iza').on('click', function(){
//     id = $('input[name="id"]').val();
//     $.ajax({
//         url: 'http://localhost:8888/practice/public/iza',
//         method: "GET",
//         data: { id : id },
//         dataType: "json",
//         success: function(res) {
//             console.log(res);
//             $('ul').append('<li>'+ res.product_name + '</li>');
//         },
//         error:function(){
//         alert('通信の失敗をしました');
//         }
//     });
// });

$(document).ready(function(){
    fetchProductList();

    function fetchProductList() {
        $.ajax({
            url: 'http://localhost:8888/practice/public/test',
            method: "GET",
            dataType: "json",
            success: function(index, json, data) {
                console.log(data); 
                var imgUrl = 'http://localhost:8888/practice/public/storage';
                var products = index.products; //products情報を取得
                var list = '';
                for(var i = 0; i < products.length; i++) {
                    var product = products[i];
                    list += '<tr>';
                    list += '<td>' + product.id + '</td>';
                    list += '<td>' + product.company_name + '</td>';
                    list += '<td>' + product.product_name + '</td>';
                    list += '<td>' + product.price + '</td>';
                    list += '<td>' + product.stock + '</td>';
                    if(product.img_path == '') {
                        list += '<td><img url="' + imgUrl + '/img/no_image.jpg" width="25%"></td>';
                    } else {
                        list += '<td><img url="' + imgUrl + product.img_path + '" width="25%"></td>';
                    }
                    list += '<td><img src="' + imgUrl + product.img_path + '" width="25%"></td>';

                    list += '<td><a href="http://localhost:8888/practice/public/detail/' + product.id + '" class="btn">詳細表示</a></td>';
                    
                    list += '<td><form action=""http://localhost:8888/practice/public/remove/' + product.id + '" method="POST" onsubmit="return confirm("本当に削除しますか？");">@csrf<input type="submit" class="btn" value="削除"></form></td>';

                    list += '</tr>';

                }
                $('#test').html(list);
            },
            error:function(){
            alert('通信の失敗をしました');
            }
        });
    }
    
});