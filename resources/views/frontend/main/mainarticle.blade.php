@extends('frontend.layouts.main_header')
@section('content')
<style>
    /* === BASE HEADING === */

    h1 {
        position: relative;
        padding: 0;
        margin: 0;
        font-family: "Raleway", sans-serif;
        font-weight: 300;
        font-size: 40px;
        color: #080808;
        -webkit-transition: all 0.4s ease 0s;
        -o-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
    }

    h1 span {
        display: block;
        font-size: 0.5em;
        line-height: 1.3;
    }

    h1 em {
        font-style: normal;
        font-weight: 600;
    }

    /* === HEADING STYLE #1 === */
    .one h1 {
        text-align: center;
        text-transform: uppercase;
        padding-bottom: 5px;
    }

    .one h1:before {
        width: 28px;
        height: 5px;
        display: block;
        content: "";
        position: absolute;
        bottom: 3px;
        left: 50%;
        margin-left: -14px;
        background-color: #b80000;
    }

    .one h1:after {
        width: 100px;
        height: 1px;
        display: block;
        content: "";
        position: relative;
        margin-top: 25px;
        left: 50%;
        margin-left: -50px;
        background-color: #b80000;
    }
    .bs-example{
      margin: 20px;
      }

</style>

    <!-- Start: Articles -->

    <section class="breadcrumbs">


        <div class="container">
            <div class="row">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>
                        @foreach ($articledetails['articleval_sub'] as $details)
                    </h2>
                    <!-- <ul>
                    <a href="{{ url('/') }}">Home</a>
                </ul>     -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 pt-4 pt-lg-0 order-2 order-lg-1 content">
                    {{-- <div class="d-flex justify-content-between align-items-center">
                        <h1 class="mb-2 one">{{ $details->title ?? '' }}</h1>
                    </div> --}}
                    <div class="one">
                        <h1>{{ $details->title ?? '' }}</h1>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 pt-4 pt-lg-0 order-2 order-lg-1 content">
                    <h5 class="mb-2"> {!! $details->content ?? '' !!}</h5>
                </div>
            </div>
            @if ($details->file != '')
                <div class="row">
                    <div class="col-lg-12 pt-4 pt-lg-0 order-2 order-lg-1 content">
                        <div class="d-flex justify-content-between align-items-center">
                            <img
                                src="{{ asset('/assets/backend/uploads/articles/' . $articledetails->articleval_sub[0]->file) }} "></img>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @endforeach
    </section>
    <br>
    <!-- End: Articles -->


    </div><!--END - dialog-off-canvas-main-canvas-->
@endsection

