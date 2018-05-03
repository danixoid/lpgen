@extends('layouts.app')


@section('content')

    <section class="p-y-lg bg-green bg-edit">
        <div class="overlay"></div>

        <div class="container">
            <!-- Section Header -->
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="section-header text-white text-center wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                        <h2>404 &mdash; эта страница еще не создана</h2>
                        <p class="lead"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <a href="{!! route('domain.create') !!}" class="btn btn-shadow btn-blue btn-block">СОЗДАТЬ СТРАНИЦУ {!! mb_strtoupper(request()->getHttpHost()) !!}</a>
                    <a href="#test" id="test" class="btn btn-shadow btn-green btn-block hidden">ТЕСТ</a>
                    <p class="small text-center"><a href="{{ route('home') }}" class="inverse">На главную</a></p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script>
        $(function(){

            if(typeof MobileMap !== 'undefined') {
                $("#test").removeClass('hidden');
                $("#test").click(function () {
                    MobileMap.alertTest();
                });
            }
        });
    </script>
@endsection