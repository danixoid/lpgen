@extends('layouts.app')

@section('meta')
    @if(isset($metas) && $metas)
        @foreach($metas as $meta)
    <meta name="{!! $meta->name !!}" content="{!! $meta->content !!}" />
        @endforeach
    @endif

    @if(preg_match("/(content|skeleton)/",request()->path()))

        <style>
            .modal {
                position: static !important;
                opacity: 1 !important;
                display: block !important;
            }
        </style>
    @endif
@endsection

@section('content')

@if(isset($content)){!! $content !!}@endif

@endsection

@section('javascript')
{{--
    <script>
        $(function(){
            --}}{{--alert('{!! request()->path() !!}');--}}{{--
            @if(preg_match("/(content|skeleton)/",request()->path()))


            @endif
        });
    </script>--}}
@endsection