@extends("layouts.AdminLTE.app")

@section("content")
    <router-view></router-view>
@endsection

@push('scripts')
    <script>
        var routeList = {
            menuList:"{{route('user.menu.index')}}",
            routeList:"{{route('api.route.index')}}",
            menuStore:"{{route('user.menu.store')}}",
            menuEdit:"{{route('user.menu.update',['id'=>':id'])}}",
        }
    </script>

    <script src="{{mix("js/user/menu/index.js")}}"></script>
@endpush
