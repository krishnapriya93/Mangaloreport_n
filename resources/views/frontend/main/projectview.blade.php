@extends('frontend.layouts.main_header')
@section('content')
    <style>
        .row {
            display: flex;
            /* flex-wrap: wrap; */
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-sm-4 {
            flex: 0 0 33.3333%;
            max-width: 33.3333%;
            padding: 15px;
        }

        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card-text {
            flex-grow: 1;
        }

        .card-title {
            font-weight: bold;
            font-size: 16px;
        }

        .row1 {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            /* flex-wrap: wrap; */
            margin-right: -15px;
            margin-left: -15px;
        }

        .form-inline-modern {
            max-width: 500px;
            padding: 20px;
        }
        .input-group-text-modern {
            background-color: #007bff;
            color: white;
            border: none;
        }
        .form-control-modern {
            border-radius: 0;
            box-shadow: none;
        }
        .text-cls{
            text-align: center;
        }

    </style>

    <!-- Start: Articles -->

    <section class="breadcrumbs team section-bg" id="team">
        <div class="container" data-aos="fade-up">
            <div class="one text-col px-2 mt-3">
                <h1>Projects</h1>
            </div>
            <div class="d-flex justify-content-end">

                @php  $id = \Crypt::encryptString(1) @endphp
                <form class="form-inline-modern" id="formid" method="GET" action="{{ route('search',[$id]) }}" enctype="multipart/form-data">
                   @csrf
                    <div class="input-group">
                        <input type="text" class="form-control form-control-modern" name="searchkeyword" placeholder="Username" aria-label="Username" value="{{ $keyword ?? ''}}">
                        <button type="submit" class="btn btn-primary">Search </button>
                    </div>
                </form>
            </div>

            @if (count($projects) != 0 && strlen($keyword)==0)

            <div class="row1 mt-3">
                @foreach ($projects as $project)
                    @foreach ($project->publicrelsub as $publicrelsub)
                        <div class="col-sm-4 mr-1">
                            <div class="card">
                                <img class="card-img-top" src="{{ asset('assets/frontend/images/port_project.jpeg') }}"
                                    alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $publicrelsub->title }}</h5>
                                    @php  $projectid = \Crypt::encryptString($project->id) @endphp
                                    <p class="card-text">{!! $publicrelsub->content ?? '' !!}</p>
                                    <a href="{{ route('projectdetailview', [$projectid]) }}" class="btn btn-primary">Detail
                                        view</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
            @elseif (strlen($keyword)!=0 && count($projects) != 0)

            <div class="row1 mt-3">
                @foreach ($projects as $project)
                    @foreach ($project->publicrelsub as $publicrelsub)
                        <div class="col-sm-4 mr-1">
                            <div class="card">
                                <img class="card-img-top" src="{{ asset('assets/frontend/images/port_project.jpeg') }}"
                                    alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $publicrelsub->title }}</h5>
                                    @php  $projectid = \Crypt::encryptString($project->id) @endphp
                                    <p class="card-text">{!! $publicrelsub->content ?? '' !!}</p>
                                    <a href="{{ route('projectdetailview', [$projectid]) }}" class="btn btn-primary">Detail
                                        view</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            @else
            <div class="alert alert-danger text-cls" role="alert">

                <img alt="nodata" src="{{ asset('assets/frontend/images/message.png') }}" width="5%" height="5%">
                <h3>No result found</h3>
                <h6><a href="{{ route('projects') }}">Back to project </a>
                </h6>
              </div>
            @endif

        </div>
    </section>
    <br>
    <!-- End: Articles -->
    </div><!--END - dialog-off-canvas-main-canvas-->
@endsection
