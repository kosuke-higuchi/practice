@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="title m-b-md">
                商品情報編集画面
            </div>

            <div>
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <label for="product_name">商品情報ID</label>
                        <input type="text" class="form-control" id="product.id" placeholder="商品情報ID" value="{{ $details->id }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="product_name">商品名</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" placeholder="商品名" value="{{ $details->product_name }}">
                        @if($errors->has('product_name'))
                            <p>{{ $errors->first('product_name') }}</p>
                        @endif
                    </div>

                    <div class="form-group">
                    <label for="company_id">メーカー</label>
                        <select class="form-control" id="company_id" name="company_id">
                            @foreach ($companies as $company)
                                <option value="{{$company->id}}">{{ $company->company_name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('company'))
                            <p>{{ $errors->first('company') }}</p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="price">価格</label>
                        <input type="text" class="form-control" id="price" name="price" placeholder="価格" value="{{ $details->price }}">
                        @if($errors->has('price'))
                            <p>{{ $errors->first('price') }}</p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="stock">在庫数</label>
                        <input type="text" class="form-control" id="stock" name="stock" placeholder="在庫数" value="{{ $details->stock }}">
                        @if($errors->has('stock'))
                            <p>{{ $errors->first('stock') }}</p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="comment">コメント</label>
                        <textarea class="form-control" id="comment" name="comment"  rows="5" cols="20" placeholder="コメント">{{ $details->comment }}</textarea>
                        @if($errors->has('comment'))
                            <p>{{ $errors->first('comment') }}</p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="img_path">商品画像</label>
                        <input type="file" accept=".jpg" class="form-control" id="img_path" name="img_path" placeholder="商品画像" value=" ">
                        @if($errors->has('image'))
                            <p>{{ $errors->first('image') }}</p>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-default">更新</button>
                </form>
            </div>

            <div>
                <a class="links" href="{{ route('detail', ['id'=>$details->id]) }}">戻る</a>
            </div>
        </div>
    </div>
</div>
@endsection
