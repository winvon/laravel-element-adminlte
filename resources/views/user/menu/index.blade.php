@extends("layouts.AdminLTE.app")

@section("content")
     <router-view></router-view>
@endsection

@push('scripts')
    <script src="{{mix("js/user/menu/index.js")}}"></script>
@endpush
