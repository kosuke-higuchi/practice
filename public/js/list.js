// $.ajaxSetup({
//     headers: { 'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content") },
// })

$(document).ready(function(){
    fetchProductList();

    $('#search-form').on('submit', function(e) {
        // console.log(e);
        e.preventDefault(); // デフォルトのフォーム送信をキャンセルする
        // 入力された検索条件を取得
        var keyword = $('#keyword').val();
        var companyId = $('#company_id').val();
    
        // 商品一覧を非同期で取得する関数を呼び出す
        fetchProductList(keyword, companyId);
      });

    function fetchProductList(keyword = '', companyId = '') {
        var searchData = {
            keyword: keyword,
            company_id: companyId
        };
        console.log(searchData);
        $.ajax({
            url: 'http://localhost:8888/practice/public/ajaxList',
            type: "GET",
            data: searchData,
            dataType: "json",
            success: function(index) {
                var imgUrl = 'http://localhost:8888/practice/public/storage';
                var products = index.products; //products情報を取得
                var list = '';
                for(var i = 0; i < products.length; i++) { //tbody内作成
                    var product = products[i];
                    list += '<tr>';
                    list += '<td>' + product.id + '</td>';
                    list += '<td>' + product.company_name + '</td>';
                    list += '<td>' + product.product_name + '</td>';
                    list += '<td>' + product.price + '</td>';
                    list += '<td>' + product.stock + '</td>';
                    if (product.img_path == null) {
                        list += '<td><img src="' + imgUrl + '/img/no_image.jpg" width="25%"></td>';
                    } else {
                        list += '<td><img src="' + imgUrl + product.img_path + '" width="25%"></td>';
                    }
                    list += '<td><a href="http://localhost:8888/practice/public/detail/' + product.id + '" class="btn">詳細表示</a></td>';
                    
                    list += '<td><form action=""http://localhost:8888/practice/public/remove/' + product.id + '" method="POST" onsubmit="return confirm("本当に削除しますか？");"><input type="submit" class="btn" value="削除"></form></td>';

                    list += '</tr>';

                }
                $('#product-table-body').html(list);
            },
            error:function(xhr, status, error){
            alert('通信の失敗をしました');
            console.log(error);
            }
        });
    }
    
});