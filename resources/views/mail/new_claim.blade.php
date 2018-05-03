<?php
/**
 * Created by PhpStorm.
 * User: danixoid
 * Date: 03.05.18
 * Time: 17:47
 */
?>


@extends('layouts.mail')

@section('content')
    <section class="p-y-lg bg-green bg-edit">

        <div class="overlay"></div>
        <div class="container">
            <!-- Section Header -->
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="section-header text-center text-white wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                        <h2>Новая заявка</h2>
                        <p class="lead"></p>
                    </div>
                </div>
            </div><!-- /End Row -->

            <table class="table table-condensed text-white">
                <tr>
                    <th>Сайт</th>
                    <td>{!! $root !!}</td>
                </tr>
                <tr>
                    <th>Имя</th>
                    <td>{!! isset($request['name']) ? $request['name'] : '' !!}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{!! isset($request['email']) ? $request['email'] : '' !!}</td>
                </tr>
                <tr>
                    <th>Телефон</th>
                    <td>{!! isset($request['phone']) ? $request['phone'] : '' !!}</td>
                </tr>
                <tr>
                    <th>Сообщение</th>
                    <td>{!! isset($request['message']) ? $request['message'] : '' !!}</td>
                </tr>
                <tr>
                    <th>Тип сообщения</th>
                    <td>{!! $type !!}</td>
                </tr>
            </table>
        </div><!-- /End Container -->

    </section>
@endsection
