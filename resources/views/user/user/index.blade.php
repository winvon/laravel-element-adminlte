@extends('layouts.user.app')



@section('content')
    <router-view></router-view>
@endsection

@push('scripts')
    <script>
        var routeList = {
            userList: "{{route('user.user.index')}}",
            roleList: "{{route('user.role.list')}}",
            userInfo: "{{route('user.user.show',['id'=>':id'])}}",
            userUpdate: "{{route('user.user.update',['id'=>':id'])}}",
            store: "{{route('user.user.store')}}",
        }
    </script>
    <script src="{{mix('js/user/user/index.js')}}"></script>
@endpush
