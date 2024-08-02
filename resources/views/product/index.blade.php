@extends('layoutadmin')
@section('title')
    Danh sách sản phẩm
@endsection
@section('content')
    <a href="{{route('product.create')}}" class="btn btn-success">Thêm mới</a>
    <form action="{{route('logout')}}" method="POST">
        @csrf
        <button type="submit">Dang Xuat</button>
    </form>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">name</th>
            <th scope="col">price</th>
            <th scope="col">quantity</th>
            <th scope="col">image</th>
            <th scope="col">category name</th>
            <th scope="col">status</th>
            <th>Thao Tác</th>
        </tr>
        </thead>
        <tbody>
        @foreach($listPro as $item)
        <tr>
            <th scope="row">{{$item->id}}</th>
            <td>{{$item->name}}</td>
            <td>{{$item->price}}</td>
            <td>{{$item->quantity}}</td>
            <td>
                @if(!isset($item->image))
                    Không có hình ảnh
                @else
                    <img src="{{Storage::url($item->image)}}">
                @endif
            </td>
            <td>{{$item->loadAllCategory->name}}</td>
{{--                <td>{{$item->catename}}</td>--}}
{{--            <td>{{$listCate[$item->category_id]}}</td>--}}
            <td>{{$item->status}}</td>
            <td>
                <a href="{{route('product.edit', ['id'=>$item->id])}}">EDIT</a>
                <form action="{{route('product.destroy', ['id'=>$item->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                     <button type="submit">DELETE</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    {{$listPro->links()}}
@endsection
