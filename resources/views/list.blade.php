@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="flex-center position-ref full-height">
                <div class="title m-b-md">
                    商品情報一覧画面
                </div>

                <!-- ここから検索フォーム -->
                <div>
                    <form id="searchForm" action="{{ route('list') }}" method="GET">
                        <div>
                            <label>キーワード</label>
                            <input type="text" id="keyword" name="keyword" value="">                            
                        </div>
                        <div>
                            <label>メーカー</label>
                            <select class="form-control" id="company_id" name="company_id">
                            <option value="">-- 選択してください --</option>
                            @foreach ($companies as $company)
                                <option value="{{$company->id}}" @if(old('company_id') == $company->id) selected @endif>{{ $company->company_name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div>
                            <label>値段</label>
                            <input type="text" id="min_price" name="min_price" placeholder="下限" value="">
                            <input type="text" id="max_price" name="max_price" placeholder="上限" value="">
                        </div>
                        <div>
                            <label>在庫数</label>
                            <input type="text" id="min_stock" name="min_stock" placeholder="下限" value="">
                            <input type="text" id="max_stock" name="max_stock" placeholder="上限" value="">
                        </div>
                        <input id="searchButton" type="submit" value="検索">
                    </form>
                </div>

                <!-- ここから一覧表示 -->
                <div class="links">
                    <table id="productTable">
                        <thead>
                            <tr id="sortTarget">
                                <th id="0" class="cursor-change" data-sort="">id</th>
                                <th id="1" class="cursor-change" data-sort="">メーカー名</th>
                                <th id="2" class="cursor-change" data-sort="">商品名</th>
                                <th id="3" class="cursor-change" data-sort="">価格</th>
                                <th id="4" class="cursor-change" data-sort="">在庫数</th>
                                <th>商品画像</th>
                            </tr>
                        </thead>
                        <tbody id="productTableBody">
                            <!-- JQueryで一覧表示 -->
                        </tbody>
                    </table>
                </div>
                <div>
                    <!-- 空div -->
                </div>
                <div>
                    <a class="links" href="{{ route('regist') }}">新規登録</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>
<script src="{{ asset('js/list.js') }}"></script>

@endsection
