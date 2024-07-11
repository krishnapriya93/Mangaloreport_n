@extends('frontend.layouts.main_header')

@section('content')



    <!-- Start: Header -->
    <div class="header">
        <div class="headbg">
            <div class="container-">
                <div class="row">
                    <div class="navbar-header col-md-3">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navigation">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="region region-header">
                            <div id="block-construction-zymphonies-theme-branding" class="site-branding block block-system block-system-branding-block">
                                <div class="brand logo">
                                    <a href="/index.php/" title="Home" rel="home" class="site-branding__logo">
                                        <img src="{{ asset('assets/frontend/images/nmptlogonew-14n2-en.png') }}" alt="Home" />
                                    </a>
                                </div>
                                <div class="brand site-name">
                                    <div class="site-branding__name">
                                        <a href="/index.php/" title="Home" rel="home">New Mangalore Port Authority</a><span class="site-branding__slogan"></span>
                                    </div>
                                            <!--  -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 menu-wrap">

                                <!-- <div class="region region-search">
                                    <div id="block-sagarmala"
                                        class="block block-block-content block-block-content9ce5803b-2a98-4e9d-b968-bf001750da08">


                                        <div class="content">

                                            <div
                                                class="clearfix text-formatted field field--name-body field--type-text-with-summary field--label-hidden field__item">
                                                <div style="padding-top:0%; z-index: 99999999; position: relative;"><img
                                                        alt="Golden Jubilee Year" data-entity-type="file"
                                                        data-entity-uuid="d44a9310-b7ae-42c9-aecb-a052c83cc2b6"
                                                        height="92"
                                                        src="{{ asset('assets/frontend/images/gj_copy.png') }}"
                                                        width="300" class="align-center" loading="lazy" /><a
                                                        href="http://sagarmala.gov.in/" target="_blank"
                                                        title="sagarmala.gov.in"><img alt="Sagarmala"
                                                            data-entity-type="file"
                                                            data-entity-uuid="4dd3f345-03d8-41d0-8afa-f9ae68761b04"
                                                            height="193"
                                                            src="{{ asset('assets/frontend/images/sagarmala-new.png') }}"
                                                            width="314" class="align-center" loading="lazy" /></a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div> -->

                                <!-- Start: UpperTop2 widget -->
                                <div class="uppertop2" id="uppertop2">
                                    <div class="container">
                                        <div class="row uptopwidget-list clearfix">
                                            <div class="">
                                                <div class="region region-uptoptwo">
                                                    <div id="block-solartext"
                                                        class="block block-block-content block-block-content547d3074-89cc-454c-a58b-2d1d01c91936">


                                                        <div class="content">

                                                            <div
                                                                class="clearfix text-formatted field field--name-body field--type-text-with-summary field--label-hidden field__item">
                                                                <!-- <div class="text-align-left"
                                                                    style="color:#ffdf30!important; font-weight:500; font-size:22px; padding-top:30px; word-spacing:3px;">
                                                                    A GREEN WELCOME TO 100% SOLAR POWERED PORT</div> -->
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End: UpperTop2 widget -->
                    @include('frontend.layouts.mainmenu')

                       
                    </div>
                </div>
            </div>
        </div>
    </div>
            <!-- End: Header -->

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
            <h5 class="mb-2">  {!! $details->content ?? '' !!}</h5>
        </div>
    </div>
    @if($details->file!='')
    <div class="row">
        <div class="col-lg-12 pt-4 pt-lg-0 order-2 order-lg-1 content">
            <div class="d-flex justify-content-between align-items-center">
                <img src="{{ asset('/assets/backend/uploads/articles/'.$articledetails->articleval_sub[0]->file) }} "></img>
            </div>  
        </div>
    </div>
    @endif
 </div>
 @endforeach 
</section>  

<!-- End: Articles -->


<!-- Start: Footer widgets -->
<div class="footer" id="footer">
                <div class="gmap">


                </div>
                <div class="container">

                    <div class="row">
                        <div class=col-md-4>
                            <div class="region region-footer-first">
                                <div id="block-contacthome"
                                    class="block block-block-content block-block-contentae5dfe71-fdbc-406d-a336-7c074cbff116">

                                    <h2 class="title">Contact</h2>

                                    <div class="content">

                                        <div
                                            class="clearfix text-formatted field field--name-body field--type-text-with-summary field--label-hidden field__item">
                                            <p><strong>NEW MANGALORE PORT AUTHORITY, </strong><br />
                                                Ministry of Ports,Shipping and Waterways<br />
                                                Government of India<br />
                                                Panambur, Mangalore-575010,<br />
                                                D.K. District, Karnataka<br />
                                                Tel:0824-2407341 (24 lines)Fax:2408390<br />
                                                Email: chairman[at]nmpt[dot]gov[dot]in</p>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class=col-md-4>
                            <div class="region region-footer-second">
                                <div id="block-footerlinks"
                                    class="block block-block-content block-block-contente2614915-cb19-42b5-a37b-972add7fbaa9">


                                    <div class="content">

                                        <div
                                            class="clearfix text-formatted field field--name-body field--type-text-with-summary field--label-hidden field__item">
                                            <p>&nbsp;</p>

                                            <ul>
                                                <li><a href="/important-links" title="important links">Important
                                                        Links</a></li>
                                                <li><a href="/terms-and-condition" title="Terms and Condition">Terms and
                                                        Condition</a></li>
                                                <li><a href="/hyperlinking-policy"
                                                        title="Hyperlinking Policy">Hyperlinking Policy</a></li>
                                                <li><a href="/privacy-policy" title="Privacy Policy">Privacy Policy</a>
                                                </li>
                                                <li><a href="/disclaimer" title="disclaimer">Disclaimer</a></li>
                                                <li><a href="/copyright-policy" title="copyright-policy">Copyright
                                                        Policy</a></li>
                                                <li><a href="/gst-corner" title="GST Corner">GST Corner</a></li>
                                                <li><a href="/web-information-manager"
                                                        title="Web Information Manager">Web Information Manager</a></li>
                                                <li><a href="/help" rel=" noopener" target="_blank"
                                                        title="help">Help</a></li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class=col-md-4>
                            <div class="region region-footer-third">
                                <div id="block-followuson"
                                    class="social block block-block-content block-block-contentef189ab2-3165-4e1a-bcfc-5ccdf7187ccb">


                                    <div class="content">

                                        <div
                                            class="clearfix text-formatted field field--name-body field--type-text-with-summary field--label-hidden field__item">
                                            <p> </p>

                                            <p><strong>Dial Us : </strong><br />
                                                <span class="dial">1800-599-1222</span>
                                            </p>

                                            <p><strong>Follow us on</strong></p>

                                            <p><a href="http://www.facebook.com/pages/New-Mangalore-Port-Trust/1601939813389904"
                                                    rel="" target="_blank" title=""><img
                                                        alt="Facebook" data-entity-type="file"
                                                        data-entity-uuid="400ba506-f5b4-4ced-bd3e-bb6887ac8542"
                                                        src="{{ asset('assets/frontend/socialmedia/facebook.png') }}"
                                                        class="align-left" width="64" height="64"
                                                        loading="lazy" /></a><a href="https://twitter.com/NewMngPort"
                                                    rel="" target="_blank" title=""><img
                                                        alt="Twitter" data-entity-type="file"
                                                        data-entity-uuid="063b4bdf-7bce-4b53-a144-62a1d661d570"
                                                        src="{{ asset('assets/frontend/socialmedia/twitter.png') }}"
                                                        class="align-left" width="64" height="64"
                                                        loading="lazy" /></a><a
                                                    href="https://www.youtube.com/channel/UCz9fdx_BlvJLTrwVMA5oXuA"
                                                    rel="" target="_blank" title=""><img
                                                        alt="Youtube" data-entity-type="file"
                                                        data-entity-uuid="0a1b8c69-e1c9-49d2-b003-ff727a338f84"
                                                        src="{{ asset('assets/frontend/socialmedia/youtube.png') }}"
                                                        class="align-left" width="64" height="64"
                                                        loading="lazy" /></a></p>
                                        </div>

                                    </div>
                                </div>
                                <div id="block-hitcounter"
                                    class="block block-block-content block-block-contentd5c3a996-9668-48f9-86ae-57312c908665">


                                    <div class="content">

                                        <div
                                            class="clearfix text-formatted field field--name-body field--type-text-with-summary field--label-hidden field__item">
                                            <div
                                                style="font-size:10px; pointer-events:none; text-align:right; width:30%; color:#333;">
                                                Hit counter:
                                                <script type="text/javascript" src="//counter.websiteout.net/js/17/7/5812/1"></script>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--End: Footer widgets -->


            <!-- Start: Copyright -->
            <div class="copyright">
                <div class="container">

                    <div class="">
                        <div class="region region-copyright">
                            <div class="views-element-container block block-views block-views-blocklast-updated-time-block-1"
                                id="block-views-block-last-updated-time-block-1">


                                <div class="content">
                                    <div>
                                        <div
                                            class="lastupdate js-view-dom-id-a7d550ae47b7c22cf3712390c4112ab3c0c6897cefd3fa6bcf7f1c523cd326d1">




                                            <header>
                                                Last Updated :
                                            </header>




                                            <div class="views-row">
                                                <div class="views-field views-field-changed"><span
                                                        class="field-content">15/05/2024 - 11:53</span></div>
                                            </div>








                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div id="block-copyright"
                                class="block block-block-content block-block-content39706c61-abdc-4758-9c26-716e9cc8ca3b">


                                <div class="content">

                                    <div
                                        class="clearfix text-formatted field field--name-body field--type-text-with-summary field--label-hidden field__item">
                                        <div class="text-align-center" style="padding-bottom:0px;">Copyright © NEW
                                            MANGALORE PORT AUTHORITY | All Rights Reserved.<br />
                                            Designed &amp; Developed By <a href="https://www.cdit.org/" rel=" noopener"
                                                style="color:#fff;" target="_blank" title="CDIT">C-DIT</a></div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>


                </div>
            </div>
            <!-- End: Copyright -->






</div><!--END - dialog-off-canvas-main-canvas-->
    @endsection