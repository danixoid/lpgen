<?php
/**
 * Created by PhpStorm.
 * User: danixoid
 * Date: 04.05.18
 * Time: 11:19
 */
?>

@extends('layouts.app')

@section('meta')
@endsection
@section('javascript')
    <script src="{!! url('/js/src-min-noconflict/ace.js') !!}"></script>
    <script>
        $(function(){
            var scale = 1;
{{--            document.domain = '{!! preg_replace('/^https?:\/\//','',request()->root()) !!}';--}}
            $('iframe').css({
                '-webkit-transform-origin'  : '0 0',
                '-moz-transform-origin'     : '0 0',
                '-ms-transform-origin'      : '0 0',
                '-o-transform-origin'       : '0 0',
                'transform-origin'  : '0 0',
                '-webkit-transform' : 'scale(' + scale + ')',
                '-moz-transform'    : 'scale(' + scale + ')',
                '-ms-transform'     : 'scale(' + scale + ')',
                '-o-transform'      : 'scale(' + scale + ')',
                'transform'         : 'scale(' + scale + ')'
            });
            $('iframe').css('width',$('.container').width()/scale);

            var editor = ace.edit('editor');

            editor.setTheme("ace/theme/twilight");
            editor.getSession().setMode("ace/mode/html");
            editor.getSession().on("change", function () {
                $('#content').val(editor.getSession().getValue());
                $('#iblock').contents().find('#page').html(editor.getSession().getValue());
            });

            $('#content').val(editor.getSession().getValue());
        });
    </script>
@endsection

@section('content')
    <section class="p-y-lg">

        {{--<div class="overlay"></div>--}}
        <div class="container">
            <!-- Section Header -->
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="section-header text-center wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                        <h2>Блок &laquo;{!! $block->name !!}&raquo;</h2>
                        <p class="lead"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">

            <form action="{!! route('block.update',$block->id) !!}" method="post">
                {!! csrf_field() !!}
                {!! method_field('PUT') !!}
                {{--@method('PUT')--}}
                {{--@csrf--}}
                <input type="hidden" id="content" name="content" />
                <div class="row">
                    <div class="col-md-3">
                        <a href="{!! route('block.index',['section_id' => $block->t_section_id]) !!}" class="btn btn-warning">Назад</a>
                    </div>
                    <div class="col-md-4 pull-right text-right">
                        {{--<button type="button" class="btn btn-red">Сбросить</button>--}}
                        <button type="submit" class="btn btn-blue">Сохранить</button>
                    </div>
                </div><!-- /End Row -->
                <div class="form-group">
                    <div class="col-md-4">
                        <label class="control-label">Наименование шаблона</label>
                        <input type="text" pattern="[\w\-]+" class="form-control" placeholder="Имя лат." name="name" value="{!! $block->name !!}" required/>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label">Секция</label>
                        <select class="form-control" name="t_section_id" required>
                            @foreach(\App\TSection::all() as $section)
                                <option {!! $block->t_section_id == $section->id ? 'selected' : '' !!} value="{!! $section->id !!}">{!! $section->name !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label">Высота в px</label>
                        <input type="number" id="frameHeight" class="form-control" placeholder="Высота" name="height" value="{!! $block->height !!}" required/>
                    </div>
                </div><!-- /End Row -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item active" role="presentation">
                        <a class="nav-link" id="view-tab" data-toggle="tab" href="#view" role="tab" aria-controls="view" aria-selected="false">Просмотр</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="edit-tab" data-toggle="tab" href="#edit" role="tab" aria-controls="edit" aria-selected="true">Редактирование</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane active" id="view" role="tabpanel" aria-labelledby="view-tab">

                        <iframe id="iblock" src="{!! route('builder.content',$block->name) !!}"
                                height="{!! $block->height !!}px"></iframe>

                    </div>
                    <div class="tab-pane" id="edit" role="tabpanel" aria-labelledby="edit-tab">

                        <div class="row">
                            <div id="editor" style="height:400px">@if($block->sandbox != null){{ $block->loader }}@else{{ $block->content }}@endif
                            </div>
                        </div><!-- /End Row -->
                    </div>
                </div><!-- /End Row -->
            </form>
        </div><!-- /End Container -->

    </section>
@endsection