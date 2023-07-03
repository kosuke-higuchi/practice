@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="content">
                <div class="title m-b-md">
                    商品詳細
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>商品情報ID</th>
                            <th>メーカー</th>
                            <th>商品名</th>
                            <th>価格</th>
                            <th>在庫数</th>
                            <th>商品画像</th>
                            <th>コメント</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $details->id }}</td>
                            <td>{{ $details->company_name }}</td>
                            <td>{{ $details->product_name }}</td>
                            <td>{{ $details->price }}</td>
                            <td>{{ $details->stock }}</td>
                            <td>
                                @if ($details->img_path =='')
                                    <img src="{{ asset('storage/img/no_image.jpg') }}" width="25%">
                                @else
                                    <img src="{{ asset('storage/'. $details->img_path) }}" width="25%">
                                @endif
                            </td>
                            <td>{{ $details->comment }}</td>
                        </tr>
                    </tbody>
                </table>
                <div>
                <a class="links" href="{{ route('edit', ['id'=>$details->id]) }}">編集</a>
                <a class="links" href="{{ route('list') }}">戻る</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
