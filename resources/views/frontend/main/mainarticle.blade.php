@extends('frontend.layouts.main_header')

@section('content')
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
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-2">{{ $details->title ?? '' }}</h3>
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

    <!-- End: Articles -->


    </div><!--END - dialog-off-canvas-main-canvas-->
@endsection
