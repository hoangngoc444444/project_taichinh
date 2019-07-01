@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Xác nhận tài khoản của bạn qua email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Một mail xác nhận vừa mới gửi đến email tài khoản của bạn.') }}
                        </div>
                    @endif

                    {{ __('Trước khi vào ứng dụng, hãy click vào liên kết xác nhận trong mail của bạn.') }}
                    {{ __('Nếu bạn không nhận được email') }}, <a href="{{ route('verification.resend') }}">{{ __('click vào đây để gửi lại') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
