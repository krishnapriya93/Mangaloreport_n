@extends('frontend.layouts.main_header')
@section('content')
    <style>
        section {
            padding: 60px 0;
            overflow: hidden;
        }

        .section-bg {
            background-color: #f3f5fa;
        }

        .section-title {
            text-align: center;
            padding-bottom: 30px;
        }

        .section-title h2 {
            font-size: 32px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
            padding-bottom: 20px;
            position: relative;
            color: #37517e;
        }

        .section-title h2::before {
            content: "";
            position: absolute;
            display: block;
            width: 120px;
            height: 1px;
            background: #ddd;
            bottom: 1px;
            left: calc(50% - 60px);
        }

        .section-title h2::after {
            content: "";
            position: absolute;
            display: block;
            width: 40px;
            height: 3px;
            background: #47b2e4;
            bottom: 0;
            left: calc(50% - 20px);
        }

        .section-title p {
            margin-bottom: 0;
        }

        /*
                    .team .member {
                        position: relative;
                        box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
                        padding: 30px;
                        border-radius: 5px;
                        background: #fff;
                        transition: 0.5s;
                        height: 100%;
                    } */

        .team .member .pic {
            overflow: hidden;
            width: 180px;
            border-radius: 50%;
        }

        .team .member .pic img {
            transition: ease-in-out 0.3s;
        }

        .team .member:hover {
            transform: translateY(-10px);
        }

        .team .member .member-info {
            padding-left: 30px;
        }

        .team .member h4 {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 20px;
            color: #37517e;
        }

        .team .member span {
            display: block;
            font-size: 15px;
            padding-bottom: 10px;
            position: relative;
            font-weight: 500;
        }

        .team .member span::after {
            content: "";
            position: absolute;
            display: block;
            width: 50px;
            height: 1px;
            background: #cbd6e9;
            bottom: 0;
            left: 0;
        }

        .team .member p {
            margin: 10px 0 0 0;
            font-size: 14px;
        }

        .team .member .social {
            margin-top: 12px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .team .member .social a {
            transition: ease-in-out 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50px;
            width: 32px;
            height: 32px;
            background: #eff2f8;
        }

        .team .member .social a i {
            color: #37517e;
            font-size: 16px;
            margin: 0 2px;
        }

        .team .member .social a:hover {
            background: #47b2e4;
        }

        .team .member .social a:hover i {
            color: #fff;
        }

        .team .member .social a+a {
            margin-left: 8px;
        }

        .wedo {
            background: url(http://127.0.0.1:8000/assets/frontend/images/6758688_7811.jpg);
            background-size: cover;
            background-position: center;
            padding: 16px 5px;
            border-radius: 0px 17px 0 17px;
            min-height: 147px;
            transition: all .3s ease-in-out;
            box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
            border: none;
            margin-right: 0.5rem;
        }

        .col-md-4 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 33.666%;
            flex: 0 0 32.666%;
            max-width: 33.666%;
        }
    </style>
    <section id="team" class="team section-bg">
        <div class="container" data-aos="fade-up">
            <div class="one text-col px-5 mt-1 mb-4">
                <h1>Board Members</h1>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        @foreach ($bod as $bods)
                            @foreach ($bods->bodsub as $bodsub)
                                <div class="col-md-4 wedo mt-3 mr-2" data-aos="zoom-in" data-aos-delay="100">
                                    <div class="member d-flex align-items-start">
                                        <div class="pic">
                                            <img alt="shipping-minister" data-entity-type="file"
                                                data-entity-uuid="52346b63-9af0-4d1b-9054-ba79e5495957" height="185"
                                                src="{{ asset('/assets/backend/uploads/bod/' . $bods->photo) }}"
                                                style="margin:30px auto 15px auto;" width="154" class="align-center"
                                                loading="lazy" />
                                        </div>
                                        <div class="member-info">
                                            <h4>{{ $bodsub->name }}</h4>
                                            <span>{{ $bodsub->desig_id }}</span>
                                            <p>{{ strip_tags($bodsub->alt) }}</p>
                                            <div class="social">
                                                <p>
                                                    <span>Mobile (O): {{ $bods->mobilenumber }}</spanr>
                                                        <span class="mr-2">Mobile (R): {{ $bods->officenumber }}</span>
                                                        <span class="mr-2">Email: {{ $bods->email }}</span>
                                                </p>
                                                {{-- <a href=""><i class="bi bi-telephone"></i></a>
                                                <a href=""><i class="ri-instagram-fill"></i></a>
                                                <a href=""><i class="ri-linkedin-box-fill"></i></a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        </div><!--END - dialog-off-canvas-main-canvas-->
    </section>
    <!-- End Team Section -->
@endsection
