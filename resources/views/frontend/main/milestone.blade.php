@extends('frontend.layouts.main_header')
@section('content')
    <style>

    </style>

    <!-- Start: Articles -->

    <section class="breadcrumbs">
        <div class="one text-col px-5 mt-5">
            <h1>Milestone</h1>
        </div>


        <div class="container mt-3">
            <ul class="timeline">

                @foreach ($milestone as $milestones)
                    @foreach ($milestones->milestonesub as $milestonesub)
                        <li class="event">
                            <div class="left-arrow"></div>
                            @php $milstonedate = $milestones->date; @endphp

                            <div class="time">{{ date('d-M-Y', strtotime($milstonedate)) }} <span
                                    class="glyphicon glyphicon-time"></span></div>
                            <h3><img src="{{ asset('assets/frontend/images/ship.png') }}" class="milestoneicon"
                                    alt=""></img> {{ $milestonesub->title }}</h3>
                            <div class="description">
                                <p>Thank you {{ $milestonesub->title }}</p>
                            </div>
                        </li>
                    @endforeach
                @endforeach

            </ul>
        </div>

    </section>
    <br>
    <!-- End: Articles -->


    </div><!--END - dialog-off-canvas-main-canvas-->
@endsection
