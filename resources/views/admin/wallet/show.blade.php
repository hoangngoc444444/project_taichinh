@extends('admin.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <br>
                <div class="panel panel-default">
                    <div class="panel-heading">Chuyển khoản</div>
                    <div class="panel-body">
                        <form action="{{ route('transfer') }}" method="POST">
                            {{ csrf_field() }}
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Tên Ví</label>
                            <input disabled type="text" class="form-control" id="name" name="name" value="{{ $user->wallet->name }}">

                            </div>

                            <div class="form-group">
                                <label for="order">Tên tài khoản</label>
                            <input disabled type="text" class="form-control" value="{{ $user->name }}" >

                            </div>
                            <div class="form-group">
                                    <label for="order">Số tài khoản</label>
                                    <input disabled type="number" class="form-control" value="{{ $user->code }}" >
                            </div>
                            <div class="form-group">
                                    <label for="order">Số tiền có trong tài khoản</label>
                            <input disabled type="number" class="form-control" value="{{ $user->wallet->money }}" >
                            </div>
                            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                                <label for="code">Số tài khoản</label>
                                <input type="number" class="form-control" id="code" name="code" placeholder="Nhập số tài khoản"
                                       value="{{ old('code') }}">
                                <span class="help-block">{{ $errors->first('code') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('value') ? 'has-error' : '' }}">
                                <label for="value">Số tiền cần chuyển</label>
                                <input type="number" class="form-control" id="value" name="value" placeholder="Nhập số tiền"
                                       value="{{ old('value') }}">
                                <span class="help-block">{{ $errors->first('value') }}</span>
                            </div>
                            <button type="submit" class="btn btn-success">Chuyển</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
