@extends('layouts.app')

@section('meta')

    @if(preg_match("/(content|skeleton)/",request()->path()))

        <style>
            .mfp-hide {
                display: block !important;
            }
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
    {{--<script>
        $(function(){
            @if(preg_match("/(content|skeleton)/",request()->path()))

            @endif
        });
    </script>--}}
@endsection