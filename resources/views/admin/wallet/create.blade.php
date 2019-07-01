@extends('admin.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <br>
                <div class="panel panel-default">
                    <div class="panel-heading">Tạo mới ví</div>
                    <div class="panel-body">
                        <form action="{{ route('admin.wallet.store') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Tên Ví</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Tên Ví"
                                       value="{{ old('name') }}">
                                <span class="help-block">{{ $errors->first('name') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="order">Tên tài khoản</label>
                            <input disabled type="text" class="form-control" id="order" value="{{ $user->name }}" >

                            </div>
                            <div class="form-group">
                                    <label for="order">Số tài khoản</label>
                                    <input disabled type="number" class="form-control" id="order" value="{{ $user->code }}" >
                            </div>
                            <div class="form-group">
                                    <label for="order">Số tiền có sẵn trong tài khoản</label>
                                    <input disabled type="number" class="form-control" id="order" value="5000" >
                            </div>

                            <button type="submit" class="btn btn-success">Tạo Ví</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
