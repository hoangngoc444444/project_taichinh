@extends('admin.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div>
                <a href="{{ route('admin.user.index') }}" class="btn btn-primary">Thông tin tài khoản</a>
            </div>
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">Cập nhật tài khoản</div>
                <div class="panel-body">
                    <form action="{{ route('admin.user.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <div class="form-group {{ $errors->has('images') ? 'has-error' : '' }}">
                            <label for="name">Tên tài khoản</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Tên tài khoản"
                                   value="{{ $user->name }}">
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="code">Số tài khoản</label>
                            <input disabled type="number" class="form-control" id="code" name="code"
                                   value="{{ $user->code }}">
                        </div>
                        <div class="form-group">
                            <label for="wallet">Số dư tài khoản</label>
                        <input type="text" disabled class="form-control" id="wallet" name="wallet" value="{{ $user->wallet ? $user->wallet->money : 0 }}">
                        </div>
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email">Địa chỉ Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="Địa chỉ Email"
                                   value="{{ $user->email }}">
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('birthday') ? 'has-error' : '' }}">
                            <label for="birthday">Ngày sinh</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" placeholder="Ngày sinh"
                                   value="{{ $user->birthday }}">
                            <span class="help-block">{{ $errors->first('birthday') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('images') ? 'has-error' : '' }}">
                            <label for="images">Ảnh đại diện</label>
                            <input type="file" class="form-control" id="images" name="images"
                                   value="{{ old('images') }}">
                            <span class="help-block">{{ $errors->first('images') }}</span>
                        </div>

                        <button type="submit" class="btn btn-success">Cập nhật tài khoản</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
