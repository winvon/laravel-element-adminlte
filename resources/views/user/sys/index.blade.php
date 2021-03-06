@extends('layouts.user.app')

@section('content')
    <router-view></router-view>
@endsection

@push('scripts')
    <script>
        var routeList={
            index:"{{route('user.role.index')}}",
            show:"{{route('user.role.show',['id'=>':id'])}}",
            store:"{{route('user.role.store')}}",
            update:"{{route('user.role.update',['id'=>':id'])}}",
            destroy:"{{route('user.role.destroy',['id'=>':id'])}}",
            menu:"{{route('user.menu.index')}}",
        }
    </script>
    <script src="{{mix('js/user/sys/index.js')}}"></script>
@endpush
