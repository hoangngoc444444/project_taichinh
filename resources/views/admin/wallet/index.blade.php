@extends('admin.master')
@section('content')
@if (session('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="{{ route('admin.expend.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="panel-heading" style="color:brown;font-size: large;margin:10px">Nhập thông tin thu chi</div>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Tên thu chi"
                        value="{{ old('name') }}">
                    <span class="help-block">{{ $errors->first('name') }}</span>
                </div>

                <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                    <label for="type">Danh mục thu chi</label><br>
                    <input type="radio" name="type" value="1">Chi
                    <input type="radio" name="type" value="2"> Thu<br>
                    <span class="help-block">{{ $errors->first('type') }}</span>
                </div>
                <div class="form-group {{ $errors->has('value') ? 'has-error' : '' }}">
                    <label for="value">Giá trị</label>
                    <input name="value" type="number" class="form-control" id="value" value="{{ old('value') }}">
                    <span class="help-block">{{ $errors->first('value') }}</span>
                </div>
                <button type="submit" class="btn btn-success">Tạo thu chi</button>
            </form>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
@endsection
