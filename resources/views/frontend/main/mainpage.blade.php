@extends('frontend.layouts.main_header')

@section('content')
    @include('frontend.main.mainbanner')

    @include('frontend.main.mainmarquee')

    @include('frontend.main.mainmidwidget')

    @include('frontend.main.mainbod')

    <!-- Start: Updates widgets -->
    <div class="topupbg">
        <div class="updates" id="updates">
            <div class="container">
                <div class="row updates-list">
                    @include('frontend.main.maintender')
                    @include('frontend.main.mainwhatsnew')
                </div>
            </div>
        </div>

    </div>
    <!--End: Updates widgets -->

    <!-- Start: middle widget -->
    <div class="middletop" id="middletop">
        <div class="container">
            <div class="row topwidget-list clearfix">
                <div class="col-sm-12"></div>
            </div>
        </div>
    </div>
    <!--End: middle widget -->


    <!--Start: Highlighted -->
    <div class="highlighted" style="position: relative;">
        <img class="port2" src="{{ asset('/assets/frontend/images/port1.png') }}" alt="">

        @include('frontend.main.mainwhatwedo')

    </div>
    <!--End: Highlighted -->


    <!--Start: Title -->
    <!--End: Title -->


    <div class="main-content-home">
        <div class="container">
            <div class="">

                <div class="row layout">
                    <!--- Start: Left SideBar -->
                    <!-- End Left SideBar -->

                    <!--- Start Content -->
                    <div class=col-md-12>
                        <div class="content_layout">
                            <!--Start: Breadcrumb -->
                            <!--End: Breadcrumb -->
                            <div class="region region-content">
                                <div id="block-construction-zymphonies-theme-content"
                                    class="block block-system block-system-main-block">
                                    <div class="content">
                                        <div class="views-element-container">
                                            <div
                                                class="js-view-dom-id-9003d9fb0b36114b909b2b362017509fa036b96b8586679816207b91029a2423">
                                                <a href="https://newmangaloreport.gov.in/rss.xml" class="feed-icon">
                                                    Subscribe to
                                                </a>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End: Content -->

                    <!-- Start: Right SideBar -->
                    <!-- End: Right SideBar -->

                </div>
            </div>
        </div>
    </div>
    <!-- End: Main content -->


    <!-- Start: Features -->
    <!--End: Features -->


    <!-- Start: Clients -->
    <div class="clients" id="clients">
        <div class="gmap">
            <div class="region region-clients">
                <div id="block-nmptmap"
                    class="block block-block-content block-block-content0e2503b9-11fb-4ed6-9a89-d1c503238c52">
                    <div class="content">
                        <div
                            class="clearfix text-formatted field field--name-body field--type-text-with-summary field--label-hidden field__item">
                            <div style="display:flex; justify-content:center; flex-wrap:wrap;">
                                <div><a href="/portmap" rel=" noopener" target="_blank" title="Portmap"><img alt="Portmap"
                                            data-entity-type="file" data-entity-uuid="b3682051-7a11-47c2-9ebe-d4e3e818715e"
                                            src="{{ asset('/assets/frontend/images/portmapnew.png') }}"
                                            style="width:100%; height:auto; padding:10px; background:#f9f8f8;"
                                            class="align-center" width="1200" height="150" loading="lazy" /></a></div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
    <!--End: Clients -->



    @include('frontend.main.maingallery')



    <!-- Start: Related widget -->
    @include('frontend.main.mainrelated')
    <!--End: Related widget -->



    </div>
@endsection

