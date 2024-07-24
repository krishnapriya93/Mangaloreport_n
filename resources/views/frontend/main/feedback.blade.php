@extends('frontend.layouts.main_header')
@section('content')
    <style>
        .redalert {
            color: red;
        }

        .alert>.start-icon {
            margin-right: 0;
            min-width: 20px;
            text-align: center;
        }

        .alert>.start-icon {
            margin-right: 5px;
        }

        .greencross {
            font-size: 18px;
            color: #25ff0b;
            text-shadow: none;
        }

        .alert-simple.alert-success {
            border: 1px solid rgba(36, 241, 6, 0.46);
            background-color: rgba(7, 149, 66, 0.12156862745098039);
            box-shadow: 0px 0px 2px #259c08;
            color: #0ad406;
            /* text-shadow: 2px 1px #00040a; */
            transition: 0.5s;
            cursor: pointer;
        }

        .alert-success:hover {
            background-color: rgba(7, 149, 66, 0.35);
            transition: 0.5s;
        }
    </style>
    <div class="container" style="margin-top:10px; mb-4">

        <div class="card mb-4">
            <div class="one text-col px-5 mt-3 mb-4">
                <h1>Feed back</h1>
            </div>
            @if (Session::get('success') != '')
                <section>
                    <div class="square_box box_three"></div>
                    <div class="square_box box_four"></div>
                    <div class="container mt-5">
                        <div class="row">

                            <div class="col-sm-12">
                                <div
                                    class="alert fade alert-simple alert-success alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show">
                                    <button type="button" class="close font__size-18" data-dismiss="alert">
                                        <span aria-hidden="true"><a>
                                                <i class="fa fa-times greencross"></i>
                                            </a></span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                    <i class="start-icon far fa-check-circle faa-tada animated"></i>
                                    <strong class="font__weight-semibold">Well done!</strong> You successfully submit feedback.
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
            @endif
            <div class="card-body">
                <img class="port3" src="{{ asset('assets/frontend/images/section-bg-09.png') }}" alt="">
                <img class="portx" src="{{ asset('assets/frontend/images/section-bg-08.png') }}" alt="">



                <form id="formiid" method="POST" action="{{ route('feedbacksubmit') }}" enctype="multipart/form-data">

                    @csrf
                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <label for="inputName">Name <span class="redalert"> *</span></label>
                            <input type="text" class="form-control" name="inputName" id="inputName"
                                placeholder="Enter name here" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail">Email <span class="redalert"> *</span></label>
                            <input type="email" class="form-control" name="inputEmail" id="inputEmail"
                                placeholder="Enter email here" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputsubject">Subject <span class="redalert"> *</span></label>
                        <input type="text" class="form-control" name="inputsubject" id="inputsubject"
                            placeholder="Enter subject here " required>
                    </div>

                    <div class="form-group">
                        <label for="inputMessage">Message <span class="redalert"> *</span></label>
                        <textarea class="form-control" name="inputMessage" id="inputMessage" placeholder="Enter message here" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">Add </button>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
@endsection
