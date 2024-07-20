@extends('backend.layouts.htmlheader')

@section('content')
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title mb-30">
                            <h2> Dashboard</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper mb-30">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <!-- <a href="#0">Dashboard<i class="fas fa-clock"></i></a> -->
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- Invoice Wrapper Start -->
            <div class="invoice-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="invoice-card card-style mb-30">
                            <div class="invoice-header">
                                <div class="invoice-for">
                                    <h2 class="mb-10">{{ auth()->user()->name }}</h2>
                                    <p class="text-sm">
                                        Media Admin Dashboard - Media Admin content management
                                    </p>
                                </div>
                                <div class="invoice-logo">
                                    <img src="{{ asset('assets/frontend/images/working.png') }}" alt="" />
                                </div>
                                <div class="invoice-date">
                                    <p><span>USER IP:</span>{{ $userIp }}</p>
                                    {{-- <p><span>Date Due:</span> 20/02/2028</p>
                                    <p><span>Order ID:</span> #5467</p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="alert alert-primary" role="alert">
                <div class="row">

                    @foreach ($carddata as $carddatas)
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="icon-card mb-30">
                                <div class="icon purple">
                                    <i class="lni lni-database"></i>
                                </div>
                                <div class="content">
                                    <h6 class="mb-10">{{ $carddatas['component']->name }}</h6>
                                    {{-- <h3 class="text-bold mb-10">34567</h3> --}}
                                    <p class="text-sm text-success">
                                        <i class="lni lni-arrow-up"></i> Last updation:
                                        <br>{{ $carddatas['component']->updated_at->format('Y-m-d H:i:s') }}
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Cart -->
                        </div>
                    @endforeach


                    <!-- End Col -->

                </div>
                <!-- End Row -->
            </div>

        </div>
    </section>
@endsection

</body>

</html>
