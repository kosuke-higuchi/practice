$(document).ready(function(){
    fetchProductList();

    // 検索
    $('#searchForm').on('submit', function(e) {
        e.preventDefault(); // デフォルトのフォーム送信をキャンセルする
        // 入力された検索条件を取得
        var keyword = $('#keyword').val();
        var companyId = $('#company_id').val();
        var minPrice = $('#min_price').val();
        var maxPrice = $('#max_price').val();
        var minStock = $('#min_stock').val();
        var maxStock = $('#max_stock').val();
    
        // 商品一覧を非同期で取得する関数の呼び出し
        fetchProductList(keyword, companyId, minPrice, maxPrice, minStock, maxStock);
    });

    function fetchProductList(keyword = '', companyId = '', minPrice = '', maxPrice = '', minStock = '', maxStock = '') {
        var searchData = {
            keyword: keyword,
            company_id: companyId,
            min_price: minPrice,
            max_price: maxPrice,
            min_stock: minStock,
            max_stock: maxStock
        };
        var url = 'http://localhost:8888/practice/public';

        // console.log(searchData);
        $.ajax({
            url: url + '/ajaxList',
            type: "GET",
            data: searchData,
            dataType: "json",
            success: function(index) {
                // 返ってきたデータの確認
                console.log(index);
                console.log(searchData);
                var imgUrl = url + '/storage';
                var products = index.products;
                var list = '';
                for(var i = 0; i < products.length; i++) {
                    //tbody内作成
                    var product = products[i];
                    list += '<tr>';
                    list += '<td>' + product.id + '</td>';
                    list += '<td>' + product.company_name + '</td>';
                    list += '<td>' + product.product_name + '</td>';
                    list += '<td>' + product.price + '</td>';
                    list += '<td>' + product.stock + '</td>';
                    if (product.img_path == null) {
                        list += '<td class="list-img"><img src="' + imgUrl + '/img/no_image.jpg"></td>';
                    } else {
                        list += '<td class="list-img"><img src="' + imgUrl + product.img_path + '"></td>';
                    }
                    list += '<td><a href=' + url + '"/detail/' + product.id + '" class="btn">詳細表示</a></td>';
                    
                    list += '<td id="deleteTarget"><form action="' + url + '/remove/' + product.id + '" method="POST"><input type="submit" class="btn" value="削除"></form></td>';
                    list += '</tr>';

                }
                $('#productTableBody').html(list);

            },
            error:function(xhr, status, error){
            alert('通信の失敗をしました');
            console.log(error);
            }
        });
    }

    // 商品の削除
    $(document).on('submit', '#deleteTarget form', function(e) {
        e.preventDefault(); // デフォルトのフォーム送信をキャンセルする
        var deleteForm = $(this);
        var delUrl = deleteForm.attr('action');
        console.log(deleteForm);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: delUrl,
            type: "POST",
            dataType: "json",
            success: function(response) {
                // 削除成功時の処理
                console.log(response);
                // 商品一覧を再読み込み
                fetchProductList();
            },
            error: function(xhr, status, error) {
                alert('削除の通信に失敗しました');
                console.log(error);
            }
        });
    });


    // ソート
    $('#sortTarget th').click(function(){
        // 情報取得
        var ele = $(this).attr('id');
        var sortFlg = $(this).data('sort');
    
        // リセット
        $('th').data('sort', "");
    
        // ソート順序
        if(sortFlg == "" || sortFlg == "desc"){
            sortFlg = "asc";
            $(this).data('sort', "asc");
        }else{
            sortFlg = "desc";
            $(this).data('sort', "desc");
        }
    
        // テーブルソート関数呼び出し
        sortTable(ele, sortFlg);
    });

    function sortTable(ele, sortFlg){
        let arr = $('#productTable tbody tr').sort(function(a, b){
          // ソート対象が数値の場合
            if($.isNumeric($(a).find('td').eq(ele).text())){
                let aNum = Number($(a).find('td').eq(ele).text());
                let bNum = Number($(b).find('td').eq(ele).text());

                if(sortFlg == "asc"){
                    return aNum - bNum;
                }else{
                    return bNum - aNum;
                }
            }else{ // ソート対象が数値でない場合
                let sortNum = 1;

                // 比較時は小文字に統一
                if($(a).find('td').eq(ele).text().toLowerCase() > $(b).find('td').eq(ele).text().toLowerCase()){
                    sortNum = 1;
                }else{
                    sortNum = -1;
                }
                if(sortFlg == "desc"){
                    sortNum *= (-1);
                }

                return sortNum;
            }
        });
        $('table tbody').html(arr);
    }

    // 削除

    function deleteProduct(productId) {
        $.ajax({
          url: url + '/remove/' + productId,
          type: 'POST',
          data: {
            _method: 'DELETE' // Laravelの場合、DELETEリクエストを送信する際には_methodパラメータにDELETEを指定する必要がある場合があります
          },
          dataType: 'json',
          success: function(response) {
            // 削除成功時に商品一覧を再取得
            fetchProductList();
          },
          error: function(xhr, status, error) {
            alert('削除に失敗しました');
            console.log(error);
          }
        });
      }



    // $('#deleteTarget').on('click', function() {
    //     var deleteConfirm =  confirm('削除してよろしいでしょうか？');

    //     if(deleteConfirm == true) {
    //         var clickEle = $(this)
    //         // 削除ボタンにユーザーIDをカスタムデータとして埋め込んでます。
    //         var userID = clickEle.attr('data-user-id');

    //         // $.ajax({
    //         //     url: 'http://localhost:8888/practice/public/remove{id}',
    //         //     type: 'POST',
    //         //     data: {'id': userID,
    //         //     '_method': 'DELETE'} // DELETE リクエストだよ！と教えてあげる。
    //         // })

    //         // .done(function() {
    //         //     // 通信が成功した場合、クリックした要素の親要素の <tr> を削除
    //         //     clickEle.parents('tr').remove();
    //         // })

    //         // .fail(function() {
    //         //     alert('エラー');
    //         // });
            
    //         // Ajax清書
    //         // $.ajax({
    //         //     url: 'http://localhost:8888/practice/public/remove{id}',
    //         //     type: "POST",
    //         //     data: 
    //         //         {'id': userID,
    //         //         '_method': 'DELETE'},
    //         //     dataType: ,
    //         //     success: function() {
    //         //         // 通信が成功した場合、クリックした要素の親要素の <tr> を削除
    //         //         clickEle.parents('tr').remove();
    //         //     },
    //         //     error:function(xhr, status, error){
    //         //         alert('通信の失敗をしました');
    //         //         console.log(error);
    //         //     }
    //         // });

    //     } else {
    //         (function(e) {
    //             e.preventDefault()
    //         });
    //     };
    // });
});
