<?php
/**
 * Created by PhpStorm.
 * User: danixoid
 * Date: 07.03.18
 * Time: 10:57
 */?>

@extends('layouts.app')

@section('meta')
@endsection

@section('content')
    <section class="p-y-lg bg-white bg-edit">

        <div class="container">
            <!-- Section Header -->
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="section-header text-center wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                        <h2>Список сайтов</h2>
                        <p class="lead"></p>
                    </div>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Поддомен</th>
                        <th>Алиасы</th>
                        <th colspan="3">Управление</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach($domains as $domain)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $domain->name }}</td>
                        <td>@foreach($domain->l_aliases as $alias){{ $alias->name }}<br/>@endforeach</td>
                        <td><a href="{!! route('builder.show',$domain->id) !!}">Управление блоками</a></td>
                        <td><a href="{!! route('domain.edit',$domain->id) !!}">Правка домена</a></td>
                        <td><a href="#" onclick="if(confirm('Вы действительно хотите удалить домен?')) {
                                $('#form_domain_delete_{!! $domain->id !!}').submit();
                            }">Удалить</a>
                            <form id="form_domain_delete_{!! $domain->id !!}" action="{!! route('domain.destroy',$domain->id) !!}" method="POST">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="4"></th>
                        <th><a href="{!! route('domain.create') !!}">Добавить домен</a></th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>

        </div><!-- /End Container -->
    </section>
@endsection


@section('javascript')
@endsection