@extends('admin.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="color:brown;font-size: large;margin:10px">Thông tin tài khoản</div>
                <div class="panel-body">
                    @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    <h3>Ảnh đại diện</h3>
                    <div class="images">
                        @if($user->images)
                        <img width="100px" src="{{ asset('uploads/'.$user->images) }}" alt="" srcset="">
                        @else
                        <img width="100px"
                            src="{{ asset('uploads/download.png') }}"
                            alt="" srcset="">
                        @endif
                    </div>
                    @if(!empty($user->wallet))
                    <a href="{{ route('showvalue') }}" class="btn btn-primary">Chuyển khoản</a>
                    <a href="{{ route('admin.wallet.index') }}" class="btn btn-primary">Nhập thu chi</a>
                    <a href="" class="btn btn-danger" onclick="event.preventDefault();
                    window.confirm('Bạn đã chắc chắn xóa chưa?') ?
                   document.getElementById('wallet-delete-{{ $user->wallet->id }}').submit() :
                   0;">Xóa Ví</a>
                    <form action="{{ route('admin.wallet.destroy', ['id' => $user->wallet->id]) }}" method="post"
                        id="wallet-delete-{{ $user->wallet->id }}">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                    </form>
                    @else
                    <a href="{{ route('admin.wallet.create') }}" class="btn btn-primary">Tạo ví</a>
                    @endif
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tên Tài Khoản</th>
                                    <th>Số Tk</th>
                                    <th>Số tiền trong ví</th>
                                    <th>Email</th>
                                    <th>Ngày sinh chủ tài khoản</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày cập nhật</th>
                                    <th style="min-width:200px">Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->code }}</td>
                                    <th>{{ $user->wallet ? number_format($user->wallet->money).'VND' : "Không có đồng nào" }}
                                    </th>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @php
                                        $date = date_create("$user->date");
                                        $date = date_format($date,"d/m/Y");
                                        @endphp
                                        {{ $date }}
                                    </td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('admin.user.show', ['id' => $user->id]) }}"
                                            class="btn btn-primary">Sửa</a>
                                        <a href="{{ route('admin.changepass', ['id' => $user->id]) }}"
                                            class="btn btn-primary">Đổi mật khẩu</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <div class="panel-heading" style="color:brown;font-size: large;margin:10px">Thông tin giao dịch</div>
        @if(!empty($user->wallet) && $month > 0)
        <div class="export">
            @for($i = 0; $i < $month; $i++)

            <a href="{{ route('export',['month' => $start]) }}" class="btn btn-info export" id="export-button">Báo cáo
            giao dich tháng {{$start}}</a>
                    <?php
                    $start++;
                    ?>
            @endfor
        </div>
        @endif


        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Các Khoản Thu Chi</th>
                    <th scope="col">Ngày giao dịch</th>
                    <th scope="col">Số tiền thời điểm trước giao dịch</th>
                    <th scope="col">Số tiền thời điểm sau giao dịch</th>
                    <th scope="col">Danh mục thu chi</th>
                    <th scope="col">Giá trị</th>
                </tr>
            </thead>
            <tbody>
                @php
                $stt = 1;
                @endphp
                @forelse($user->expends ?: [] as $expend)
                <tr>
                    <th scope="row">{{ $stt }}</th>
                    <td>{{ $expend->name }}</td>
                    <td>{{ $expend->created_at }}</td>
                    <td>{{ $expend->money_before }}</td>
                    <td>{{ $expend->money_after }}</td>
                    <td>{{ $expend->type == 1 ? "chi" : "thu"}}</td>
                    <td>{{ $expend->value }}</td>
                </tr>
                @php
                $stt ++;
                @endphp
                @empty
                <tr>
                    <td colspan="5">Không có khoản thu chi nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
