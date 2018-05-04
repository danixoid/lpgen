<?php
/**
 * Created by PhpStorm.
 * User: danixoid
 * Date: 04.05.18
 * Time: 11:19
 */
?>

@extends('layouts.app')

@section('content')
    <section class="p-y-lg">

        {{--<div class="overlay"></div>--}}
        <div class="container">
            <!-- Section Header -->
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="section-header text-center wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                        <h2>Блоки &laquo;{!! $section ? $section->name : 'Все секции' !!}&raquo;</h2>
                        <p class="lead"><a href="{!! route('block.create') !!}">Добавить шаблон блока</a></p>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach($blocks as $block)
                <div class="col-md-3" style="height: 250px;">
                    <h3>{!! $block->name !!}</h3>
                    <a href="{!! route('block.edit',$block->id) !!}"><img src="{!! url('/elements/thumbs/' . $block->name . '.png') !!}" class="img-thumbnail"/></a>
                    {{--<iframe src="{!! route('builder.content',$block->name) !!}"--}}
                            {{--height="{!! $block->height !!}px">{!! $block->name !!}</iframe>--}}
                </div>
                @endforeach
            </div><!-- /End Row -->
        </div><!-- /End Container -->

    </section>
@endsection