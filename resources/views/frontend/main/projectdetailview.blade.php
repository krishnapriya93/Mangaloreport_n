@extends('frontend.layouts.main_header')
@section('content')
    <style>
        .row {
            display: flex;
            /* flex-wrap: wrap; */
            margin-right: -15px;
            margin-left: -15px;
        }

        article {
            position: relative;
            margin: 20px auto;
            /* width: 80%; */
            /* max-width: 1000px; */
            height: 100%;
            border: 1px solid #ccc;
            display: flex;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            padding-bottom: 10px;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            font: inherit;
            font-size: 100%;

            /* Add transition for smooth effect */
        }

        article:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            /* More prominent shadow */
            transform: scale(1.02);
            /* Slightly scale up */
        }

        .article-image-container {
            width: 30%;
            height: 100%;
            margin: 16px;
            overflow: hidden;
        }

        .article-image-container img {
            width: 100%;
            height: auto;
            border-radius: 4px;
        }

        .content-container {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 70%;
            padding: 0 15px;
        }

        .content-container .article-title {
            text-align: center;
            padding: 15px 0;
            margin: 0;
            font-size: 24px;
            color: #333;
            border-bottom: 2px solid #eee;
        }

        .content-container .article-content {
            /* overflow: hidden; */
            text-align: justify;
            /* color: #666; */
        }

        .read-more-btn {
            position: absolute;
            bottom: 7px;
            right: 7px;
            padding: 8px 20px;
            background-color: rgba(0, 0, 0, 0.4);
            color: white;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
            border-radius: 5px;
        }

        .read-more-btn:hover {
            background-color: #4CAF50;
            color: black;
            border-radius: 30px;
        }

        h1 {
            position: relative;
            padding: 0;
            margin: 0;
            font-family: "Raleway", sans-serif;
            /* font-weight: 300; */
            font-size: 25px;
            /* color: #080808; */
            -webkit-transition: all 0.4s ease 0s;
            -o-transition: all 0.4s ease 0s;
            transition: all 0.4s ease 0s;
        }

        .depalign {
            text-align: right;
            margin-right: 20px;
        }
    </style>

    <!-- Start: Articles -->

    <section class="breadcrumbs team section-bg mt-3 mb-3" id="team">
        <div class="container" data-aos="fade-up">
            <div class="one text-col px-2 mt-3">

                @if (count($projects) != 0)
                    <div>
                        <article>
                            <div class="article-image-container">
                                @if ($projects['publicrelsub'][0]->image)
                                    <img
                                        src="{{ asset('/assets/backend/uploads/publicrelation/' . $projects['publicrelsub'][0]->image) }}">
                                @else
                                    <img src="{{ asset('assets/frontend/images/port_project.jpeg') }}">
                                @endif

                            </div>

                            <div class="content-container mt-3">
                                @foreach ($projects['publicrelsub'] as $projectsub)
                                    <h1>{{ $projectsub->title }}</h1>
                                    <h4 class="depalign"><i class="fa fa-circle" aria-hidden="true"></i>
                                        {{ $projects['publicreldep'][0]->name }}</h4>
                                    <h3 class="article-content"> {!! $projectsub->content !!}</h3>

                                    @foreach ($projects['publicrelationitem'] as $publicrelationitem)
                                        <ol><i class="fa fa-file" aria-hidden="true"></i> <a class="lightbox"
                                                href="{{ asset('/assets/backend/uploads/publicrelationitems/' . $publicrelationitem['image']) }}">
                                                {{ $publicrelationitem['image'] }}</a></ol>
                                    @endforeach
                                @endforeach
                            </div>
                        </article>
                    </div>
                @else
                    <div class="alert">
                        No data
                    </div>
                @endif


            </div>


        </div>
    </section>
    <br>
    </div><!--END - dialog-off-canvas-main-canvas-->
    <!-- End: Articles -->
@endsection
