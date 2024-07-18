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
                                                    <a href="https://newmangaloreport.gov.in/rss.xml"
                                                        class="feed-icon">
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
                                    <div><a href="/portmap" rel=" noopener" target="_blank" title="Portmap"><img
                                                alt="Portmap" data-entity-type="file"
                                                data-entity-uuid="b3682051-7a11-47c2-9ebe-d4e3e818715e"
                                                src="{{ asset('/assets/frontend/images/portmapnew.png') }}"
                                                style="width:100%; height:auto; padding:10px; background:#f9f8f8;"
                                                class="align-center" width="1200" height="150"
                                                loading="lazy" /></a></div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!--End: Clients -->



        <!-- Start: Bottom widgets -->
        <div class="bottombg">
            <div class="bottom-widget" id="bottom-widget">
                <div class="container">
                    <div class="row bottom-widget-list">
                        <div class=col-md-6>
                            <div class="region region-bottom-first">
                                <div class="views-element-container block block-views block-views-blockgallery-block-1"
                                    id="block-views-block-gallery-block-1">

                                    <h2 class="title">Gallery</h2>

                                    <div class="content">
                                        <div>
                                            <div
                                                class="js-view-dom-id-91119e5d3b77b88a39697e28f79aa5cc2f3083b0e1da6fc88e338cbbf720bdbf">


                                                <div class="skin-default">

                                                    <div id="views_slideshow_cycle_main_gallery-block_1"
                                                        class="views_slideshow_cycle_main views_slideshow_main">
                                                        <div id="views_slideshow_cycle_teaser_section_gallery-block_1"
                                                            class="views_slideshow_cycle_teaser_section">
                                                            <div id="views_slideshow_cycle_div_gallery-block_1_0"
                                                                class="views_slideshow_cycle_slide views_slideshow_slide views-row-1 views-row-odd">
                                                                <div
                                                                    class="views-row views-row-0 views-row-odd views-row-first">
                                                                    <div class="views-field views-field-field-image">
                                                                        <div class="field-content"> <a
                                                                                href="/celebration-133rd-birthday-bharath-ratna-drbr-ambedkar-14042024-nmpa"><img
                                                                                    src="./sites/default/files/styles/gallery/public/2024-04/Slide1_3.JPG?itok=ZGL9mGng"
                                                                                    alt="" loading="lazy"
                                                                                    typeof="foaf:Image"
                                                                                    class="image-style-gallery" />

                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="views-field views-field-title"><span
                                                                            class="field-content">&quot; Celebration of
                                                                            133rd
                                                                            Birthday of Bharath Ratna Dr.B.R. Ambedkar
                                                                            on
                                                                            14.04.2024 at NMPA&quot;.</span></div>
                                                                </div>

                                                            </div>

                                                            <div id="views_slideshow_cycle_div_gallery-block_1_1"
                                                                class="views_slideshow_cycle_slide views_slideshow_slide views-row-2 views_slideshow_cycle_hidden views-row-even">
                                                                <div class="views-row views-row-1 views-row-even">
                                                                    <div class="views-field views-field-field-image">
                                                                        <div class="field-content"> <a
                                                                                href="/seven-seas-mariner-6th-cruise-ship-arrived-new-mangalore-port-31032024"><img
                                                                                    src="./sites/default/files/styles/gallery/public/2024-04/Slide1_1.JPG?itok=d-SmmaXA"
                                                                                    alt="" loading="lazy"
                                                                                    typeof="foaf:Image"
                                                                                    class="image-style-gallery" />

                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="views-field views-field-title"><span
                                                                            class="field-content">&quot;Seven Seas
                                                                            Mariner - 6th
                                                                            Cruise Ship arrived at New Mangalore Port on
                                                                            31.03.2024&quot;.</span></div>
                                                                </div>

                                                            </div>

                                                            <div id="views_slideshow_cycle_div_gallery-block_1_2"
                                                                class="views_slideshow_cycle_slide views_slideshow_slide views-row-3 views_slideshow_cycle_hidden views-row-odd">
                                                                <div class="views-row views-row-2 views-row-odd">
                                                                    <div class="views-field views-field-field-image">
                                                                        <div class="field-content"> <a
                                                                                href="/61st-national-maritime-day-celebration-05042024-nmpa"><img
                                                                                    src="./sites/default/files/styles/gallery/public/2024-04/Slide1.JPG?itok=J8vfscLj"
                                                                                    alt="" loading="lazy"
                                                                                    typeof="foaf:Image"
                                                                                    class="image-style-gallery" />

                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="views-field views-field-title"><span
                                                                            class="field-content">61st National
                                                                            Maritime Day
                                                                            celebration on 05.04.2024 at NMPA.</span>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div id="views_slideshow_cycle_div_gallery-block_1_3"
                                                                class="views_slideshow_cycle_slide views_slideshow_slide views-row-4 views_slideshow_cycle_hidden views-row-even">
                                                                <div class="views-row views-row-3 views-row-even">
                                                                    <div class="views-field views-field-field-image">
                                                                        <div class="field-content"> <a
                                                                                href="/valedictory-function-53rd-national-safety-week-celebration-11032024-nmpa"><img
                                                                                    src="./sites/default/files/styles/gallery/public/2024-03/Slide1_3.JPG?itok=zfvzrj7N"
                                                                                    alt="" loading="lazy"
                                                                                    typeof="foaf:Image"
                                                                                    class="image-style-gallery" />

                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="views-field views-field-title"><span
                                                                            class="field-content">&quot;Valedictory
                                                                            function of
                                                                            the 53rd National Safety Week Celebration on
                                                                            11.03.2024 at NMPA&quot;.</span></div>
                                                                </div>

                                                            </div>

                                                            <div id="views_slideshow_cycle_div_gallery-block_1_4"
                                                                class="views_slideshow_cycle_slide views_slideshow_slide views-row-5 views_slideshow_cycle_hidden views-row-odd">
                                                                <div
                                                                    class="views-row views-row-4 views-row-odd views-row-last">
                                                                    <div class="views-field views-field-field-image">
                                                                        <div class="field-content"> <a
                                                                                href="/celebration-international-womens-day-new-mangalore-port-authority-08032024"><img
                                                                                    src="./sites/default/files/styles/gallery/public/2024-03/Slide1_1.JPG?itok=nXWgz8zg"
                                                                                    alt="" loading="lazy"
                                                                                    typeof="foaf:Image"
                                                                                    class="image-style-gallery" />

                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="views-field views-field-title"><span
                                                                            class="field-content">&quot;Celebration of
                                                                            International Women&#039;s Day at New
                                                                            Mangalore Port
                                                                            Authority on 08.03.2024&quot;.</span></div>
                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>


                                                </div>






                                                <footer>
                                                    <a href="gallery">View all</a>
                                                </footer>


                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class=col-md-6>
                            <div class="region region-bottom-second">
                                <div class="views-element-container block block-views block-views-blockvideos-block-1"
                                    id="block-views-block-videos-block-1">

                                    <h2 class="title">Videos</h2>

                                    <div class="content">
                                        <div>
                                            <div
                                                class="js-view-dom-id-c15d269bb41d2f7649ff0a6e48360bb1118e5cf977b323f607375c3fd4f72556">
                                                <div data-settings="{&quot;grouping&quot;:[],&quot;row_class&quot;:&quot;&quot;,&quot;default_row_class&quot;:true,&quot;uses_fields&quot;:false,&quot;items&quot;:1,&quot;itemsDesktop&quot;:[1199,1],&quot;itemsDesktopSmall&quot;:[979,1],&quot;itemsTablet&quot;:[768,1],&quot;itemsMobile&quot;:[479,1],&quot;singleItem&quot;:false,&quot;itemsScaleUp&quot;:false,&quot;slideSpeed&quot;:200,&quot;paginationSpeed&quot;:800,&quot;rewindSpeed&quot;:1000,&quot;autoPlay&quot;:false,&quot;stopOnHover&quot;:true,&quot;navigation&quot;:false,&quot;navigationText&quot;:[&quot;prev&quot;,&quot;next&quot;],&quot;prevText&quot;:&quot;prev&quot;,&quot;nextText&quot;:&quot;next&quot;,&quot;rewindNav&quot;:true,&quot;scrollPerPage&quot;:false,&quot;pagination&quot;:false,&quot;paginationNumbers&quot;:false,&quot;responsive&quot;:true,&quot;responsiveRefreshRate&quot;:200,&quot;mouseDrag&quot;:true,&quot;touchDrag&quot;:true,&quot;transitionStyle&quot;:&quot;fade&quot;}"
                                                    class="owl-slider-wrapper owl-carousel">

                                                    <div>
                                                        <div class="views-field views-field-body">
                                                            <div class="field-content">
                                                                <p><iframe
                                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                                        allowfullscreen="" frameborder="0"
                                                                        src="https://www.youtube.com/embed/PDJ7W220RME?si=bNrUSaPQRQCLvYgD"
                                                                        title="YouTube video player"></iframe></p>
                                                            </div>
                                                        </div>
                                                        <div class="views-field views-field-title"><span
                                                                class="field-content">NMPA Corporate video</span></div>
                                                    </div>
                                                    <div>
                                                        <div class="views-field views-field-body">
                                                            <div class="field-content">
                                                                <p><iframe
                                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                                        allowfullscreen="" height="315"
                                                                        src="https://www.youtube.com/embed/GDWBcrTaiMM?si=cQ1I_E0Xz9vlyOLS"
                                                                        title="YouTube video player"
                                                                        width="560"></iframe></p>
                                                            </div>
                                                        </div>
                                                        <div class="views-field views-field-title"><span
                                                                class="field-content">
                                                                &quot;Vigilance Awareness Week -2023- Campaign on
                                                                Preventive
                                                                Vigilance measures&quot;.</span></div>
                                                    </div>
                                                    <div>
                                                        <div class="views-field views-field-body">
                                                            <div class="field-content">
                                                                <p><iframe
                                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                        allowfullscreen="" height="315"
                                                                        src="https://www.youtube.com/embed/oQn8aA11_Vg"
                                                                        title="YouTube video player"
                                                                        width="560"></iframe></p>
                                                            </div>
                                                        </div>
                                                        <div class="views-field views-field-title"><span
                                                                class="field-content">NMPA Green Port
                                                                Initiatives</span></div>
                                                    </div>
                                                    <div>
                                                        <div class="views-field views-field-body">
                                                            <div class="field-content">
                                                                <p><iframe
                                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                        allowfullscreen="" height="315"
                                                                        src="https://www.youtube.com/embed/yTwW1wo9SKc"
                                                                        title="YouTube video player"
                                                                        width="560"></iframe></p>
                                                            </div>
                                                        </div>
                                                        <div class="views-field views-field-title"><span
                                                                class="field-content">NMPA International Cruise
                                                                Terminal</span>
                                                        </div>
                                                    </div>


                                                </div>






                                                <footer>
                                                    <a href="videos" target="_blank">View all</a>
                                                </footer>


                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--End: Bottom widgets -->



        <!-- Start: Related widget -->
@include('frontend.main.mainrelated')
        <!--End: Related widget -->



    </div>
    @endsection

    <script type="application/json" data-drupal-selector="drupal-settings-json">{"path":{"baseUrl":"\/","scriptPath":null,"pathPrefix":"","currentPath":"node","currentPathIsAdmin":false,"isFront":true,"currentLanguage":"en"},"pluralDelimiter":"\u0003","suppressDeprecationErrors":true,"ajaxPageState":{"libraries":"blazy\/animate,blazy\/bio.ajax,blazy\/blazy,blazy\/blur,blazy\/classlist,blazy\/column,blazy\/grid,blazy\/load,blazy\/polyfill,blazy\/promise,blazy\/raf,blazy\/ratio,blazy\/webp,calendar\/calendar.theme,classy\/file,construction_zymphonies_theme\/bootstrap,construction_zymphonies_theme\/flexslider,construction_zymphonies_theme\/fontawesome,construction_zymphonies_theme\/global-components,construction_zymphonies_theme\/owl,construction_zymphonies_theme\/smartmenus,extlink\/drupal.extlink,flexslider\/integration,owlcarousel\/owlcarousel,superfish\/superfish,superfish\/superfish_hoverintent,superfish\/superfish_smallscreen,superfish\/superfish_supersubs,superfish\/superfish_supposition,superfish\/superfish_touchscreen,system\/base,video_embed_field\/responsive-video,views\/views.ajax,views\/views.module,views_slideshow\/jquery_hoverIntent,views_slideshow\/widget_info,views_slideshow_cycle\/jquery_cycle,views_slideshow_cycle\/json2,views_slideshow_cycle\/views_slideshow_cycle","theme":"construction_zymphonies_theme","theme_token":null},"ajaxTrustedUrl":{"\/index.php\/search\/node":true},"data":{"extlink":{"extTarget":true,"extTargetNoOverride":false,"extNofollow":true,"extNoreferrer":true,"extFollowNoOverride":false,"extClass":"0","extLabel":"(link is external)","extImgClass":false,"extSubdomains":false,"extExclude":"","extInclude":"","extCssExclude":"","extCssExplicit":"","extAlert":true,"extAlertText":"This link will take you to an external web site.","mailtoClass":"mailto","mailtoLabel":"(link sends email)","extUseFontAwesome":false,"extIconPlacement":"append","extFaLinkClasses":"fa fa-external-link","extFaMailtoClasses":"fa fa-envelope-o","whitelistedDomains":[]}},"viewsSlideshowCycle":{"#views_slideshow_cycle_main_gallery-block_1":{"num_divs":5,"id_prefix":"#views_slideshow_cycle_main_","div_prefix":"#views_slideshow_cycle_div_","vss_id":"gallery-block_1","effect":"turnLeft","transition_advanced":0,"timeout":5000,"speed":700,"delay":0,"sync":1,"random":0,"pause":1,"pause_on_click":0,"action_advanced":0,"start_paused":0,"remember_slide":0,"remember_slide_days":1,"pause_in_middle":0,"pause_when_hidden":0,"pause_when_hidden_type":"full","amount_allowed_visible":"","nowrap":0,"fixed_height":1,"items_per_slide":1,"items_per_slide_first":0,"items_per_slide_first_number":1,"wait_for_image_load":1,"wait_for_image_load_timeout":3000,"cleartype":0,"cleartypenobg":0,"advanced_options":"{}","advanced_options_choices":0,"advanced_options_entry":""},"#views_slideshow_cycle_main_whatsnew-block_1":{"num_divs":3,"id_prefix":"#views_slideshow_cycle_main_","div_prefix":"#views_slideshow_cycle_div_","vss_id":"whatsnew-block_1","effect":"scrollUp","transition_advanced":1,"timeout":5000,"speed":700,"delay":0,"sync":1,"random":0,"pause":1,"pause_on_click":0,"action_advanced":0,"start_paused":0,"remember_slide":0,"remember_slide_days":1,"pause_in_middle":0,"pause_when_hidden":0,"pause_when_hidden_type":"full","amount_allowed_visible":"","nowrap":0,"fixed_height":1,"items_per_slide":1,"items_per_slide_first":0,"items_per_slide_first_number":1,"wait_for_image_load":1,"wait_for_image_load_timeout":3000,"cleartype":0,"cleartypenobg":0,"advanced_options":"{}","advanced_options_choices":0,"advanced_options_entry":""},"#views_slideshow_cycle_main_tender-block_1":{"num_divs":5,"id_prefix":"#views_slideshow_cycle_main_","div_prefix":"#views_slideshow_cycle_div_","vss_id":"tender-block_1","effect":"scrollUp","transition_advanced":0,"timeout":5000,"speed":700,"delay":0,"sync":1,"random":0,"pause":1,"pause_on_click":0,"action_advanced":0,"start_paused":0,"remember_slide":0,"remember_slide_days":1,"pause_in_middle":0,"pause_when_hidden":0,"pause_when_hidden_type":"full","amount_allowed_visible":"","nowrap":0,"fixed_height":1,"items_per_slide":1,"items_per_slide_first":0,"items_per_slide_first_number":1,"wait_for_image_load":1,"wait_for_image_load_timeout":3000,"cleartype":0,"cleartypenobg":0,"advanced_options":"{}","advanced_options_choices":0,"advanced_options_entry":""}},"viewsSlideshow":{"gallery-block_1":{"methods":{"goToSlide":["viewsSlideshowPager","viewsSlideshowSlideCounter","viewsSlideshowCycle"],"nextSlide":["viewsSlideshowPager","viewsSlideshowSlideCounter","viewsSlideshowCycle"],"pause":["viewsSlideshowControls","viewsSlideshowCycle"],"play":["viewsSlideshowControls","viewsSlideshowCycle"],"previousSlide":["viewsSlideshowPager","viewsSlideshowSlideCounter","viewsSlideshowCycle"],"transitionBegin":["viewsSlideshowPager","viewsSlideshowSlideCounter"],"transitionEnd":[]},"paused":0},"whatsnew-block_1":{"methods":{"goToSlide":["viewsSlideshowPager","viewsSlideshowSlideCounter","viewsSlideshowCycle"],"nextSlide":["viewsSlideshowPager","viewsSlideshowSlideCounter","viewsSlideshowCycle"],"pause":["viewsSlideshowControls","viewsSlideshowCycle"],"play":["viewsSlideshowControls","viewsSlideshowCycle"],"previousSlide":["viewsSlideshowPager","viewsSlideshowSlideCounter","viewsSlideshowCycle"],"transitionBegin":["viewsSlideshowPager","viewsSlideshowSlideCounter"],"transitionEnd":[]},"paused":0},"tender-block_1":{"methods":{"goToSlide":["viewsSlideshowPager","viewsSlideshowSlideCounter","viewsSlideshowCycle"],"nextSlide":["viewsSlideshowPager","viewsSlideshowSlideCounter","viewsSlideshowCycle"],"pause":["viewsSlideshowControls","viewsSlideshowCycle"],"play":["viewsSlideshowControls","viewsSlideshowCycle"],"previousSlide":["viewsSlideshowPager","viewsSlideshowSlideCounter","viewsSlideshowCycle"],"transitionBegin":["viewsSlideshowPager","viewsSlideshowSlideCounter"],"transitionEnd":[]},"paused":0}},"views":{"ajax_path":"\/views\/ajax","ajaxViews":{"views_dom_id:1e4f0a3d93bb5da4e47583d71de9e1d4fc7a757a9164aed6a3e6d2404c6e28e2":{"view_name":"tender","view_display_id":"block_1","view_args":"","view_path":"\/node","view_base_path":"tenders","view_dom_id":"1e4f0a3d93bb5da4e47583d71de9e1d4fc7a757a9164aed6a3e6d2404c6e28e2","pager_element":0},"views_dom_id:bbcd20bec521c18846491b8cb77c0bee0c7c40edc01ff4cd1c93ddd3a49e5f34":{"view_name":"related_links","view_display_id":"block_1","view_args":"","view_path":"\/node","view_base_path":null,"view_dom_id":"bbcd20bec521c18846491b8cb77c0bee0c7c40edc01ff4cd1c93ddd3a49e5f34","pager_element":0}}},"flexslider":{"optionsets":{"default":{"animation":"fade","animationSpeed":1000,"direction":"vertical","slideshow":true,"easing":"linear","smoothHeight":true,"reverse":false,"slideshowSpeed":7000,"animationLoop":true,"randomize":false,"startAt":0,"itemWidth":0,"itemMargin":0,"minItems":0,"maxItems":0,"move":0,"directionNav":true,"controlNav":true,"thumbCaptions":false,"thumbCaptionsBoth":false,"keyboard":true,"multipleKeyboard":true,"mousewheel":false,"touch":true,"prevText":"Previous","nextText":"Next","namespace":"flex-","selector":".slides \u003E li","sync":"","asNavFor":"","initDelay":10,"useCSS":true,"video":false,"pausePlay":true,"pauseText":"Pause","playText":"Play","pauseOnAction":false,"pauseOnHover":false,"controlsContainer":".flex-control-nav-container","manualControls":""}},"instances":{"flexslider-1":"default"}},"superfish":{"superfish-main":{"id":"superfish-main","sf":{"animation":{"opacity":"show","height":"show"},"speed":"fast"},"plugins":{"touchscreen":{"mode":"window_width"},"smallscreen":{"mode":"window_width","title":"Main navigation"},"supposition":true,"supersubs":true}}},"blazy":{"loadInvisible":false,"offset":100,"saveViewportOffsetDelay":50,"validateDelay":25,"container":"","loader":true,"unblazy":false,"compat":true},"blazyIo":{"disconnect":false,"rootMargin":"0px","threshold":[0,0.25,0.5,0.75,1]},"user":{"uid":0,"permissionsHash":"d55522667b46ae59e6d74d280b43e2e2dafbb0111d94511d14bb2b00dfeb8b54"}}</script>
    <script src="{{ asset('assets/frontend/js/main.js') }}"></script>


    <script>
        (function(d) {
            var s = d.createElement("script");
            s.setAttribute("data-account", "wFuknyxNOi");
            s.setAttribute("src", "https://cdn.userway.org/widget.js");
            (d.body || d.head).appendChild(s);
        })(document)
    </script><noscript>Please ensure Javascript is enabled for purposes of <a
            href="https://userway.org">website accessibility</a></noscript>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8BHW77LG04"></script>
    <!-- <script src="https://use.fontawesome.com/25461716d1.js"></script> -->
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-8BHW77LG04');
    </script>
</body>

</html>

