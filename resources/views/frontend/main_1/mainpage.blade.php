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



      @include('frontend.main.maingallery')



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

