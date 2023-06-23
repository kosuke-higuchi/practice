@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="flex-center position-ref full-height">
                <div class="title m-b-md">
                    商品情報一覧画面
                </div>

                <div>
                    <form action="{{ route('list') }}" method="GET">
                        <div>
                            <label>キーワード</label>
                            <input type="text" name="keyword" value="">                            
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
                        <input type="submit" value="検索">
                    </form>
                </div>

                <div class="links">
                    <table>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>メーカー名</th>
                                <th>商品名</th>
                                <th>価格</th>
                                <th>在庫数</th>
                                <th>商品画像</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->company_name }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td><img src="{{ asset('storage/'. $product->img_path) }}" width="25%"></td>
                                    <td><a href="{{ route('detail', ['id'=>$product->id]) }}" class="btn">詳細表示</a></td>
                                    <td>
                                        <form action="{{ route('list.remove', ['id'=>$product->id], $product) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                        @csrf
                                            <input type="submit" class="btn" value="削除">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
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
@endsection
