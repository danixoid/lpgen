@extends('layouts.app')

@section('meta')
    @if(isset($metas) && $metas)
        @foreach($metas as $meta)
    <meta name="{!! $meta->name !!}" content="{!! $meta->content !!}" />
        @endforeach
    @endif
@endsection

@section('content')

@if(isset($content)){!! $content !!}@endif

@endsection