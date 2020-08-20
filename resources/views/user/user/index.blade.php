@extends("layouts.AdminLTE.app")


@section('content')
    <router-view></router-view>
@endsection

@push('scripts')
    <script>
        var routeList = {
            userList: "{{route('user.user.index')}}",
            userInfo: "{{route('user.user.show',['id'=>':id'])}}",
            userUpdate: "{{route('user.user.update',['id'=>':id'])}}",
        }
    </script>
    <script src="{{mix('js/user/user/index.js')}}"></script>
@endpush
