@extends('frontend.layouts.main_header')

@section('content')

    <body class="path-frontpage">
        <a href="#main-content" class="visually-hidden focusable skip-link">
            Skip to main content
        </a>

        <div class="dialog-off-canvas-main-canvas" data-off-canvas-main-canvas>

            <!-- Start: UpperTop widget -->
            <div class="uppertop" id="uppertop">
                <div class="container">
                    <div class="row uptopwidget-list clearfix">
                        <div class="">
                            <div class="region region-uptop-first">
                                <nav role="navigation" aria-labelledby="block-topmenu-menu" id="block-topmenu">

                                    <h2 class="visually-hidden" id="block-topmenu-menu">Topmenu</h2>


                                    <ul class="menu">
                                        <li class="menu-item">
                                            <a href="/index.php/sitemap" title="Sitemap"
                                                data-drupal-link-system-path="node/519">Sitemap</a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="/index.php/screen-reader-access" title="Screen Reader"
                                                data-drupal-link-system-path="node/95">Screen Reader</a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="#skmc" title="Skip to main content">Skip to main content</a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="/index.php/contact" target="_blank" title="Feedback"
                                                data-drupal-link-system-path="contact">Feedback</a>
                                        </li>
                                    </ul>



                                </nav>

                            </div>
                        </div>
                        <div class="">
                            <div class="region region-uptop-second">
                                <div id="block-langswitchcustom"
                                    class="block block-block-content block-block-contentf7b4c070-cad5-4525-a8c5-0aeba0ccc8cf">


                                    <div class="content">

                                        <div
                                            class="clearfix text-formatted field field--name-body field--type-text-with-summary field--label-hidden field__item">
                                            <div class="text-align-center" style="float:right; width:110px; right:0px;"><a
                                                    aria-label="NMPA English website"
                                                    href="https://newmangaloreport.gov.in/"
                                                    style="color:#fff; background:#1d5409; padding:2px; font-size:11px;"
                                                    title="NMPA English website">English</a>&nbsp; |&nbsp; <a
                                                    aria-label="NMPA Hindi website"
                                                    href="https://newmangaloreport.gov.in/hi"
                                                    style="color:#fff; background:#1d5409; padding:2px;font-size:11px;"
                                                    title="NMPA Hindi website">Hindi</a></div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="">
                            <div class="region region-uptop-third">
                                <div class="search-block-form block block-search" data-drupal-selector="search-block-form"
                                    id="block-construction-zymphonies-theme-search" role="search">

                                    <h2 class="visually-hidden">Search</h2>

                                    <form action="/index.php/search/node" method="get" id="search-block-form"
                                        accept-charset="UTF-8">
                                        <div
                                            class="js-form-item form-item js-form-type-search form-type-search js-form-item-keys form-item-keys form-no-label">
                                            <label for="edit-keys" class="visually-hidden">Search</label>
                                            <input title="Enter the terms you wish to search for."
                                                data-drupal-selector="edit-keys" type="search" id="edit-keys"
                                                name="keys" value="" size="15" maxlength="128"
                                                class="form-search" />

                                        </div>
                                        <div data-drupal-selector="edit-actions"
                                            class="form-actions js-form-wrapper form-wrapper" id="edit-actions"><input
                                                data-drupal-selector="edit-submit" type="submit" id="edit-submit"
                                                value="Search" class="button js-form-submit form-submit" />
                                        </div>

                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End: UpperTop widget -->



            <!-- Start: Header -->
            <div class="header">
                <div class="headbg">
                    <div class="container-">
                        <div class="row">

                            <div class="navbar-header col-md-5">
                                <button type="button" class="navbar-toggle" data-toggle="collapse"
                                    data-target="#main-navigation">
                                    <i class="fas fa-bars"></i>
                                </button>
                                <div class="region region-header">
                                    <div id="block-construction-zymphonies-theme-branding"
                                        class="site-branding block block-system block-system-branding-block">


                                        <div class="brand logo">
                                            <a href="/index.php/" title="Home" rel="home" class="site-branding__logo">
                                                <img src="{{ asset('assets/frontend/images/nmptlogonew-14n2-en.png') }}"
                                                    alt="Home" />
                                            </a>
                                        </div>
                                        <div class="brand site-name">
                                            <div class="site-branding__name">
                                                <a href="/index.php/" title="Home" rel="home">New Mangalore Port
                                                    Authority</a><span class="site-branding__slogan"></span>
                                            </div>
                                            <!--  -->
                                        </div>
                                    </div>

                                </div>

                            </div>



                            <div class="col-md-7 menu-wrap">

                                <div class="region region-search">
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

                                </div>


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
                                                                <div class="text-align-left"
                                                                    style="color:#ffdf30!important; font-weight:500; font-size:22px; padding-top:30px; word-spacing:3px;">
                                                                    A GREEN WELCOME TO 100% SOLAR POWERED PORT</div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End: UpperTop2 widget -->


                                <div class="region region-primary-menu">
                                    <div id="block-mainnavigation-3" class="block block-superfish block-superfishmain">


                                        <div class="content">

                                            <ul id="superfish-main"
                                                class="menu sf-menu sf-main sf-horizontal sf-style-none">

                                                <li id="main-menu-link-content3e671f6f-9b8b-4c77-9340-1d8390ae2430"
                                                    class="active-trail sf-depth-1 sf-no-children"><a href="/index.php/"
                                                        class="icon-home is-active sf-depth-1" title="Home">.</a></li>
                                                <li id="main-menu-link-content77a94666-a2a3-485e-b50a-eb254895c7e2"
                                                    class="sf-depth-1 menuparent"><a href="/index.php/brief-history"
                                                        class="sf-depth-1 menuparent" title="About">About us</a>
                                                    <ul>
                                                        <li id="main-menu-link-contenteb868c68-e201-4944-9cba-ad63939306af"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/brief-history" class="sf-depth-2">Brief
                                                                History</a></li>
                                                        <li id="main-menu-link-content3f13e2e0-f080-4cd5-a013-f689baa7aa04"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/mission-vision" class="sf-depth-2"
                                                                title="Mission/Vision">Mission/Vision</a></li>
                                                        <li id="main-menu-link-content20b0fc50-d1ed-4731-8ef6-a2d65dbc476e"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/milestones" class="sf-depth-2"
                                                                title="Milestones">Milestones</a></li>
                                                        <li id="main-menu-link-contentbb857d4e-2c9d-41f4-969d-ec6a959337a9"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/board-of-members" class="sf-depth-2"
                                                                title="Board Members">Board Members</a></li>
                                                        <li id="main-menu-link-contenta09446f7-bafb-4bd4-9f9b-6b39d3b813f8"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/whos-who" class="sf-depth-2"
                                                                title="Who&#039;s Who">Who&#039;s Who</a></li>
                                                        <li id="main-menu-link-content45debe01-fb91-4c2b-a344-dfe732c9c3ec"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/quality-policy" class="sf-depth-2"
                                                                title="Quality Policy Objective">Quality Policy &amp;
                                                                Objective</a></li>
                                                        <li id="main-menu-link-content2c58bd80-5f24-44da-acfe-c76843aba6b4"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/chief-officers" class="sf-depth-2">Chief
                                                                Officers</a></li>
                                                    </ul>
                                                </li>
                                                <li id="main-menu-link-content6b115ab9-fd2b-4ace-8dbc-abae67fa19bd"
                                                    class="sf-depth-1 menuparent"><a href=""
                                                        class="sf-depth-1 menuparent"
                                                        title="Facilities &amp; Services">Facilities &amp; Services</a>
                                                    <ul>
                                                        <li id="main-menu-link-content6bd297b9-e532-4150-a434-966891be0f00"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/what-we-offer" class="sf-depth-2"
                                                                title="What we Offer">What we Offer</a></li>
                                                        <li id="main-menu-link-content393ddfc7-9b6e-4171-b0ad-c9c6ce9a675c"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/port-tariff" class="sf-depth-2"
                                                                title="Port Tariff">Port Tariff</a></li>
                                                        <li id="main-menu-link-contenteccda0fc-61fd-4888-9e77-477d0d3af0e9"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/facilities" class="sf-depth-2"
                                                                title="Facilities">Facilities</a></li>
                                                        <li id="main-menu-link-content6486aef5-a53f-4e0d-a888-660849afdea2"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/cruise-port" class="sf-depth-2"
                                                                title="Cruise Port">Cruise Port</a></li>
                                                        <li id="main-menu-link-content62c1307f-3b26-4073-b895-afd7cda90239"
                                                            class="sf-depth-2 sf-no-children"><a href="/index.php/estate"
                                                                class="sf-depth-2" title="Estate">Estate</a></li>
                                                        <li id="main-menu-link-contente3a5cb24-861b-43f9-bd7b-c0784e3d1c97"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/rfid-pass-system" class="sf-depth-2"
                                                                title="RFID Pass System">RFID Pass System</a></li>
                                                        <li id="main-menu-link-content1bd636db-52ae-4de5-8407-c89455a88515"
                                                            class="sf-depth-2 sf-no-children"><a href="/index.php/eodb"
                                                                class="sf-depth-2" title="EoDB">EoDB</a></li>
                                                        <li id="main-menu-link-content3bdcde10-51fc-4b97-b304-d1c135703099"
                                                            class="sf-depth-2 sf-no-children"><a href="/index.php/iso"
                                                                class="sf-depth-2" title="ISO">ISO</a></li>
                                                        <li id="main-menu-link-contente01b81c9-a1f1-45f3-9c65-82e50d879246"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/our-partners" class="sf-depth-2"
                                                                title="Our Partners">Our Partners</a></li>
                                                    </ul>
                                                </li>
                                                <li id="main-menu-link-contentc43922ee-a0d8-4baa-8822-155d9b614665"
                                                    class="sf-depth-1 menuparent"><a href=""
                                                        class="sf-depth-1 menuparent"
                                                        title="Notifications">Notifications</a>
                                                    <ul>
                                                        <li id="main-menu-link-content13822c84-5517-4ff3-bac2-a481a04fc49d"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/projects" class="sf-depth-2"
                                                                title="Projects">Projects</a></li>
                                                        <li id="main-menu-link-content3aad6d4a-7fe2-4bfc-9940-f8e5df05a93b"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/circular-tradenotice" class="sf-depth-2"
                                                                title="Circulars &amp; Trade Notice">Circulars &amp; Trade
                                                                Notice</a></li>
                                                        <li id="main-menu-link-content2fa8f5a4-dacc-47fb-aaf9-0501cfdbf2db"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/daily-vessel-position" class="sf-depth-2"
                                                                title="Daily Vessel Positions">Daily Vessel Positions</a>
                                                        </li>
                                                        <li id="main-menu-link-content1e8e3b25-459c-49cc-88c3-706c4a93b06d"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/act-rules" class="sf-depth-2"
                                                                title="Acts &amp; Rules">Acts &amp; Rules</a></li>
                                                        <li id="main-menu-link-content037e92fc-66e7-4a3c-bbdf-b99dfbef2d2e"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/downloads" class="sf-depth-2"
                                                                title="Downloads">Downloads</a></li>
                                                        <li id="main-menu-link-content7c0fa8f4-d78c-4c16-ba2a-95e1aac32ba6"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/office-memorandums" class="sf-depth-2"
                                                                title="Office Memorandums">Office Memorandums</a></li>
                                                        <li id="main-menu-link-content17acbe72-edca-446c-89a2-e0890ce5e46d"
                                                            class="sf-depth-2 sf-no-children"><a href="/index.php/reports"
                                                                class="sf-depth-2" title="Reports">Reports</a></li>
                                                        <li id="main-menu-link-content5547c664-6a05-4bb6-8718-c783ec8f6fdf"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/statistics" class="sf-depth-2"
                                                                title="Statistics">Statistics</a></li>
                                                        <li id="main-menu-link-content732698ce-94b1-44fc-9a04-453930c0e714"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/tender-contract-awarded"
                                                                class="sf-depth-2" title="Tender Contract Awarded">Tender
                                                                Contract Awarded</a></li>
                                                    </ul>
                                                </li>
                                                <li id="main-menu-link-contenta940fb2b-eec5-4858-ba11-866fd28a83af"
                                                    class="sf-depth-1 sf-no-children"><a href="/index.php/tenders"
                                                        class="sf-depth-1" title="Tenders">Tenders</a></li>
                                                <li id="main-menu-link-contentf19df569-d2d5-4227-8410-f3aca1d57238"
                                                    class="sf-depth-1 sf-no-children"><a href="/index.php/vacancy"
                                                        class="sf-depth-1" title="Careers">Careers</a></li>
                                                <li id="main-menu-link-content49ec717d-b166-4d8e-ac03-2f97ad0ff48c"
                                                    class="sf-depth-1 menuparent"><a href=""
                                                        class="sf-depth-1 menuparent" title="News &amp; Media">News &amp;
                                                        Media</a>
                                                    <ul>
                                                        <li id="main-menu-link-content4fbbe851-3bb9-4c24-9653-27d3c0515802"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/awards-certifications" class="sf-depth-2"
                                                                title="Awards &amp; Certifications">Awards &amp;
                                                                Certifications</a></li>
                                                        <li id="main-menu-link-content72aed7f2-df67-4612-87c2-387b6e860b2e"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/pressrelease" class="sf-depth-2"
                                                                title="Press Release">Press Release</a></li>
                                                        <li id="main-menu-link-content9480c21e-3eaf-4d29-af57-4f609ebad8a6"
                                                            class="sf-depth-2 sf-no-children"><a href="/index.php/gallery"
                                                                class="sf-depth-2" title="Photo Gallery">Photo Gallery</a>
                                                        </li>
                                                        <li id="main-menu-link-contentc82d24a0-fc5a-414e-ab9e-896cc74017a3"
                                                            class="sf-depth-2 sf-no-children"><a href="/index.php/videos"
                                                                class="sf-depth-2" target="_blank"
                                                                title="Videos">Videos</a></li>
                                                        <li id="main-menu-link-contentd1d2daf4-270a-4b3b-bc8d-95976ae63f1e"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/public-notice" class="sf-depth-2">Public
                                                                Notice</a></li>
                                                    </ul>
                                                </li>
                                                <li id="main-menu-link-contenta1939ffb-2ca3-4054-8753-29af87bbbee6"
                                                    class="sf-depth-1 menuparent"><a href=""
                                                        class="sf-depth-1 menuparent"
                                                        title="Citizen&#039;s Corner">Citizen&#039;s Corner</a>
                                                    <ul>
                                                        <li id="main-menu-link-contentacd7a126-bac6-4d02-8957-800ce0262f24"
                                                            class="sf-depth-2 sf-no-children"><a href="/index.php/rti"
                                                                class="sf-depth-2" title="RTI">RTI</a></li>
                                                        <li id="main-menu-link-content034231c0-40ee-4aaf-ad7a-73d9757e68c0"
                                                            class="sf-depth-2 sf-no-children"><a href="/index.php/csr"
                                                                class="sf-depth-2">CSR</a></li>
                                                        <li id="main-menu-link-contentc025cf19-f0c1-43be-ae0b-31748fd82678"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="/index.php/citizens-charter" class="sf-depth-2"
                                                                title="Citizens Charter">Citizens Charter</a></li>
                                                        <li id="main-menu-link-content330ecc24-d3c0-4bc1-a1e2-af2e51e3c00b"
                                                            class="sf-depth-2 sf-no-children"><a
                                                                href="http://pgportal.gov.in/"
                                                                class="sf-depth-2 sf-external" target="_blank"
                                                                title="Public Grievances">Public Grievances</a></li>
                                                    </ul>
                                                </li>
                                                <li id="main-menu-link-content8a6a9053-a0bc-4f98-9d66-293d8558ede6"
                                                    class="sf-depth-1 sf-no-children"><a href="/index.php/contact-us"
                                                        class="sf-depth-1" title="Contact us">Contact us</a></li>
                                            </ul>

                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- End: Header -->


            <!-- Start: Slides -->
            <!-- End: Slides -->


            <!--Start: Top Message -->
            <div class="top-message">
                <div class="">
                    <div class="region region-top-message">
                        <div class="views-element-container block block-views block-views-blockhome-slideshow-block-1"
                            id="block-views-block-home-slideshow-block-1">


                            <div class="content">
                                <div>
                                    <div
                                        class="topslidetext js-view-dom-id-ceb4b44f4940d8f0e1168f5863a28987e4d9602e8e967f9448f4005fb13fa162">









                                        <div>

                                            <div id="flexslider-1" class="flexslider optionset-default">

                                                <ul class="slides">

                                                    <li>
                                                        <div class="views-field views-field-field-image">
                                                            <div class="field-content"> <img
                                                                    src="{{ asset('assets/frontend/banner/banner6.jpg') }}"
                                                                    width="1920" height="640" alt="Ship"
                                                                    loading="lazy" typeof="foaf:Image"
                                                                    class="image-style-front-slideshow" />


                                                            </div>
                                                        </div>
                                                        <div class="views-field views-field-field-description">
                                                            <div class="field-content"></div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="views-field views-field-field-image">
                                                            <div class="field-content"> <img
                                                                    src="{{ asset('assets/frontend/banner/banner55.jpg') }}"
                                                                    width="1920" height="640" alt="Port"
                                                                    loading="lazy" typeof="foaf:Image"
                                                                    class="image-style-front-slideshow" />


                                                            </div>
                                                        </div>
                                                        <div class="views-field views-field-field-description">
                                                            <div class="field-content"></div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="views-field views-field-field-image">
                                                            <div class="field-content"> <img
                                                                    src="{{ asset('assets/frontend/banner/banner4.jpg') }}"
                                                                    width="1920" height="640" alt="Ship"
                                                                    loading="lazy" typeof="foaf:Image"
                                                                    class="image-style-front-slideshow" />


                                                            </div>
                                                        </div>
                                                        <div class="views-field views-field-field-description">
                                                            <div class="field-content"></div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="views-field views-field-field-image">
                                                            <div class="field-content"> <img
                                                                    src="{{ asset('assets/frontend/banner/banner3a.jpg') }}"
                                                                    width="1920" height="640" alt="Ship"
                                                                    loading="lazy" typeof="foaf:Image"
                                                                    class="image-style-front-slideshow" />


                                                            </div>
                                                        </div>
                                                        <div class="views-field views-field-field-description">
                                                            <div class="field-content"></div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="views-field views-field-field-image">
                                                            <div class="field-content"> <img
                                                                    src="{{ asset('assets/frontend/slideimg/pic1.jpg') }}"
                                                                    width="1920" height="640" alt="NMPA"
                                                                    loading="lazy" typeof="foaf:Image"
                                                                    class="image-style-front-slideshow" />


                                                            </div>
                                                        </div>
                                                        <div class="views-field views-field-field-description">
                                                            <div class="field-content"></div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="views-field views-field-field-image">
                                                            <div class="field-content"> <img
                                                                    src="{{ asset('assets/frontend/slideimg/pic2a.jpg') }}"
                                                                    width="1920" height="640" alt="NMPA"
                                                                    loading="lazy" typeof="foaf:Image"
                                                                    class="image-style-front-slideshow" />


                                                            </div>
                                                        </div>
                                                        <div class="views-field views-field-field-description">
                                                            <div class="field-content"></div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>








                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <!--End: Top Message -->

            <!--Start: Top Marquee -->
            <div class="top-message circular" id="skmc">
                <div class="">
                    <div class="marqueehead">
                        <div class="region region-top-marqueehead">
                            <div id="block-circulartradenotice"
                                class="circularhead block block-block-content block-block-content4f5d0dc3-fac6-4726-80c1-a6e8fc047413">

                                <h2 class="title">Circular &amp; Trade Notice</h2>

                                <div class="content">

                                    <div
                                        class="clearfix text-formatted field field--name-body field--type-text-with-summary field--label-hidden field__item">
                                        <p style="visibility:hidden;">#page-title</p>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="marquee">
                        <div class="scroll">
                            <div class="region region-top-marquee">
                                <div class="views-element-container circular block block-views block-views-blockcircular-trade-notice-block-1"
                                    id="block-views-block-circular-trade-notice-block-1">


                                    <div class="content">
                                        <div>
                                            <div
                                                class="marqueescroll js-view-dom-id-7a801e53dd6fb765d463cbc220d9e425994661ef9fbca488a9c3f70eea3db210">









                                                <div class="item-list">

                                                    <ul class="arrow_list">

                                                        <li><span class="views-field views-field-title"><span
                                                                    class="field-content"><a
                                                                        href="/bad-weather-advisory-oil-terminal-berths-0"
                                                                        hreflang="en">Bad weather advisory for Oil
                                                                        Terminal Berths.</a></span></span></li>
                                                        <li><span class="views-field views-field-title"><span
                                                                    class="field-content"><a
                                                                        href="/bad-weather-advisory-port-users-ppp-terminals"
                                                                        hreflang="en">BAD WEATHER ADVISORY FOR PORT USERS
                                                                        &amp; PPP TERMINALS.</a></span></span></li>
                                                        <li><span class="views-field views-field-title"><span
                                                                    class="field-content"><a
                                                                        href="/berthing-policy-dry-bulk-cargo-vessels-new-mangalore-port-authority"
                                                                        hreflang="en">Berthing Policy for Dry Bulk Cargo
                                                                        Vessels at New Mangalore Port
                                                                        Authority.</a></span></span></li>
                                                        <li><span class="views-field views-field-title"><span
                                                                    class="field-content"><a
                                                                        href="/indexation-scale-rates-sor-1st-may-2024"
                                                                        hreflang="en">Indexation of Scale of Rates (SOR)
                                                                        from 1st May 2024.</a></span></span></li>
                                                        <li><span class="views-field views-field-title"><span
                                                                    class="field-content"><a
                                                                        href="/bad-weather-advisory-oil-terminal-berths"
                                                                        hreflang="en">Bad Weather Advisory for Oil
                                                                        Terminal Berths.</a></span></span></li>

                                                    </ul>

                                                </div>








                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="marqueeviewall">
                        <div class="region region-top-marqueeviewall">
                            <div id="block-circularviewall"
                                class="block block-block-content block-block-content210fd2f7-439d-4689-9930-71e9565548a3">


                                <div class="content">

                                    <div
                                        class="clearfix text-formatted field field--name-body field--type-text-with-summary field--label-hidden field__item">
                                        <p><a href="circular-tradenotice" title="Circular Trade Notice">View all</a></p>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--End: Top Marquee -->

            <!-- Start: Middle widgets -->
            <div class="midwidget" id="midwidget">
                <div class="containerlg">


                    <div class="row midwidget-list">
                        <div class="col-md-12">
                            <div class="region region-midwidget-first">
                                <div class="views-element-container counttype block block-views block-views-blockcounter-block-1"
                                    id="block-views-block-counter-block-1">


                                    <div class="content">
                                        <div>
                                            <div
                                                class="counter js-view-dom-id-6ea8c46914926f73abd701c142d6efcdf0b11125bcae7926aaaf2f98a8346c87">








                                                <div class="item-list item-list--blazy item-list--blazy-column">
                                                    <ul class="blazy blazy--view blazy--view--counter blazy--view--counter--block-1 blazy--view--counter-block-block-1 blazy--grid block-column block-count-5 small-block-column-1 medium-block-column-5 large-block-column-5"
                                                        data-blazy="" id="blazy-views-counter-block-block-1-1">
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-image">
                                                                    <div class="field-content img"> <img
                                                                            src="{{ asset('assets/frontend/icon/icon805_0.png') }}"
                                                                            width="80" height="80"
                                                                            alt="Average Pre-berthing detention"
                                                                            loading="lazy" typeof="foaf:Image" />

                                                                    </div>
                                                                </div>
                                                                <div class="views-field views-field-body">
                                                                    <p>0.82 days</p>
                                                                </div>
                                                                <div class="views-field views-field-field-text">
                                                                    <div class="field-content text">Average Pre-berthing
                                                                        detention</div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-image">
                                                                    <div class="field-content img"> <img
                                                                            src="{{ asset('assets/frontend/icon/icon805_1.png') }}"
                                                                            width="80" height="80"
                                                                            alt="Average. TRT" loading="lazy"
                                                                            typeof="foaf:Image" />

                                                                    </div>
                                                                </div>
                                                                <div class="views-field views-field-body">
                                                                    <p>40.44&nbsp;Hrs</p>
                                                                </div>
                                                                <div class="views-field views-field-field-text">
                                                                    <div class="field-content text">Average. TRT</div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-image">
                                                                    <div class="field-content img"> <img
                                                                            src="{{ asset('assets/frontend/icon/icon805_2.png') }}"
                                                                            width="80" height="80"
                                                                            alt="Average. Output per berth day"
                                                                            loading="lazy" typeof="foaf:Image" />

                                                                    </div>
                                                                </div>
                                                                <div class="views-field views-field-body">
                                                                    <p>19,218 Tonnes</p>
                                                                </div>
                                                                <div class="views-field views-field-field-text">
                                                                    <div class="field-content text">Average. Output per
                                                                        berth day</div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-image">
                                                                    <div class="field-content img"> <img
                                                                            src="{{ asset('assets/frontend/icon/icon805_3.png') }}"
                                                                            width="80" height="80"
                                                                            alt="Operating Ratio" loading="lazy"
                                                                            typeof="foaf:Image" />

                                                                    </div>
                                                                </div>
                                                                <div class="views-field views-field-body">
                                                                    <p>34.29%</p>
                                                                </div>
                                                                <div class="views-field views-field-field-text">
                                                                    <div class="field-content text">Operating Ratio</div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-image">
                                                                    <div class="field-content img"> <img
                                                                            src="{{ asset('assets/frontend/icon/icon805_3.png') }}"
                                                                            width="80" height="80"
                                                                            alt="Solar Power generated upto April 2024 "
                                                                            loading="lazy" typeof="foaf:Image" />

                                                                    </div>
                                                                </div>
                                                                <div class="views-field views-field-body">
                                                                    <p>47.31 Million Units</p>
                                                                </div>
                                                                <div class="views-field views-field-field-text">
                                                                    <div class="field-content text">Solar Power generated
                                                                        upto April 2024 </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
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
            <!--End: Middle widgets -->

            <!-- Start: Top widget -->
            <div class="topwidget" id="topwidget">
                <div class="container">

                    <div class="row topwidget-list clearfix">

                        <div class="col-sm-12">
                            <div class="region region-topwidget-first">
                                <div class="views-element-container mcblock block block-views block-views-blockminister-chairman-block-1"
                                    id="block-views-block-minister-chairman-block-1">


                                    <div class="content">
                                        <div>
                                            <div
                                                class="js-view-dom-id-d6eccc1050946ec2945ce6a5789b82d920e7a4e727d0534c746a054fe5cfdbc6">

                                                <div class="item-list item-list--blazy item-list--blazy-grid">
                                                    <ul class="blazy blazy--view blazy--view--minister-chairman blazy--view--minister-chairman--block-1 blazy--view--minister-chairman-block-block-1 blazy--grid block-grid block-count-3 small-block-grid-1 medium-block-grid-3 large-block-grid-3"
                                                        data-blazy="" id="blazy-views-minister-chairman-block-block-1-2">
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-body">
                                                                    <div class="field-content"><img
                                                                            alt="shipping-minister"
                                                                            data-entity-type="file"
                                                                            data-entity-uuid="52346b63-9af0-4d1b-9054-ba79e5495957"
                                                                            height="185"
                                                                            src="{{ asset('assets/frontend/boardmember/minister1.jpg') }}"
                                                                            style="margin:30px auto 15px auto;"
                                                                            width="154" class="align-center"
                                                                            loading="lazy" /></div>
                                                                </div>
                                                                <div class="views-field views-field-title"><span
                                                                        class="field-content leadhead">Shri
                                                                        Sarbananda Sonowal</span></div>
                                                                <div class="views-field views-field-field-designation">
                                                                    <div class="field-content leaddesig">Honorable Union
                                                                        Cabinet Minister (PSW)</div>
                                                                </div>
                                                                <div class="views-field views-field-field-file">
                                                                    <div class="field-content">
                                                                        <span
                                                                            class="file file--mime-application-pdf file--application-pdf">
                                                                            <a href="sites/default/files/2024-06/Shri%20Sarbananda%20Sonawala.pdf"
                                                                                type="application/pdf" target="_blank"
                                                                                title="Shri Sarbananda Sonawala.pdf">View
                                                                                more</a></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-body">
                                                                    <div class="field-content">
                                                                        <p></p>
                                                                        <img alt="Shri Shantanu Thakur"
                                                                            data-entity-type="file"
                                                                            data-entity-uuid="30253198-c4c8-44da-9025-aed2b11ca12a"
                                                                            height="165"
                                                                            src="{{ asset('assets/frontend/boardmember/minister2_1.jpg') }}"
                                                                            style="margin-bottom:15px;" width="138"
                                                                            class="align-center" loading="lazy" />
                                                                    </div>
                                                                </div>
                                                                <div class="views-field views-field-title"><span
                                                                        class="field-content leadhead">Shri
                                                                        Shantanu Thakur</span></div>
                                                                <div class="views-field views-field-field-designation">
                                                                    <div class="field-content leaddesig">Honorable Minister
                                                                        of State (PSW)</div>
                                                                </div>
                                                                <div class="views-field views-field-field-file">
                                                                    <div class="field-content">
                                                                        <span
                                                                            class="file file--mime-application-pdf file--application-pdf">
                                                                            <a href="sites/default/files/2024-06/Shri%20Shantanu%20Thakur.pdf"
                                                                                type="application/pdf" target="_blank"
                                                                                title="Shri Shantanu Thakur.pdf">View
                                                                                more</a></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-body">
                                                                    <div class="field-content">
                                                                        <p> </p>
                                                                        <img alt=" Dr.Venkata Ramana Akkaraju, Chairman"
                                                                            data-entity-type="file"
                                                                            data-entity-uuid="24fe21d1-5477-46c1-8ce8-1bd90d9e5cd2"
                                                                            height="155"
                                                                            src="{{ asset('assets/frontend/boardmember/chairman_0.jpg') }}"
                                                                            style="margin:30px auto 20px auto;"
                                                                            width="129" class="align-center"
                                                                            loading="lazy" />
                                                                    </div>
                                                                </div>
                                                                <div class="views-field views-field-title"><span
                                                                        class="field-content leadhead">
                                                                        Dr.Venkata Ramana Akkaraju</span></div>
                                                                <div class="views-field views-field-field-designation">
                                                                    <div class="field-content leaddesig">Chairperson</div>
                                                                </div>
                                                                <div class="views-field views-field-field-file">
                                                                    <div class="field-content">
                                                                        <span
                                                                            class="file file--mime-application-pdf file--application-pdf">
                                                                            <a href="sites/default/files/2022-08/chairmans-message-aug5.pdf"
                                                                                type="application/pdf" target="_blank"
                                                                                title="chairmans-message-aug5.pdf">Message</a></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
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
            <!--End: Top widget -->

            <!-- Start: Updates widgets -->
            <div class="topupbg">


                <div class="updates" id="updates">
                    <div class="container">


                        <div class="row updates-list">
                            <div class="col-md-6">
                                <div class="region region-updates-first">
                                    <div class="views-element-container block block-views block-views-blocktender-block-1"
                                        id="block-views-block-tender-block-1">

                                        <h2 class="title">Tender</h2>

                                        <div class="content">
                                            <div>
                                                <div
                                                    class="js-view-dom-id-1e4f0a3d93bb5da4e47583d71de9e1d4fc7a757a9164aed6a3e6d2404c6e28e2">








                                                    <div class="skin-default">

                                                        <div id="views_slideshow_cycle_main_tender-block_1"
                                                            class="views_slideshow_cycle_main views_slideshow_main">
                                                            <div id="views_slideshow_cycle_teaser_section_tender-block_1"
                                                                class="views_slideshow_cycle_teaser_section">
                                                                <div id="views_slideshow_cycle_div_tender-block_1_0"
                                                                    class="views_slideshow_cycle_slide views_slideshow_slide views-row-1 views-row-odd">
                                                                    <div
                                                                        class="views-row views-row-0 views-row-odd views-row-first">
                                                                        <div class="views-field views-field-title">
                                                                            <h4 class="field-content"><a
                                                                                    href="/programming-plc-unit-air-compressor-tug-iswari-0"
                                                                                    hreflang="en">Programming of PLC unit
                                                                                    of Air Compressor on tug Iswari.</a>
                                                                            </h4>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div id="views_slideshow_cycle_div_tender-block_1_1"
                                                                    class="views_slideshow_cycle_slide views_slideshow_slide views-row-2 views_slideshow_cycle_hidden views-row-even">
                                                                    <div class="views-row views-row-1 views-row-even">
                                                                        <div class="views-field views-field-title">
                                                                            <h4 class="field-content"><a
                                                                                    href="/comprehensive-operation-and-maintenance-contract-2-nos-italgru-make-63-t-capacity-mobile-harbor"
                                                                                    hreflang="en">Comprehensive Operation
                                                                                    and Maintenance contract for 2 Nos.
                                                                                    Italgru make, 63 T Capacity, Mobile
                                                                                    Harbor Cranes (MHCs) of NMPA, for a
                                                                                    period of 3 years.</a></h4>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div id="views_slideshow_cycle_div_tender-block_1_2"
                                                                    class="views_slideshow_cycle_slide views_slideshow_slide views-row-3 views_slideshow_cycle_hidden views-row-odd">
                                                                    <div class="views-row views-row-2 views-row-odd">
                                                                        <div class="views-field views-field-title">
                                                                            <h4 class="field-content"><a
                                                                                    href="/procurement-low-sulphur-high-flash-high-speed-diesel-lshf-hsd"
                                                                                    hreflang="en">Procurement of Low
                                                                                    Sulphur High Flash High Speed Diesel
                                                                                    (LSHF HSD)</a></h4>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div id="views_slideshow_cycle_div_tender-block_1_3"
                                                                    class="views_slideshow_cycle_slide views_slideshow_slide views-row-4 views_slideshow_cycle_hidden views-row-even">
                                                                    <div class="views-row views-row-3 views-row-even">
                                                                        <div class="views-field views-field-title">
                                                                            <h4 class="field-content"><a
                                                                                    href="/partly-dismantling-and-re-construction-compound-wall-33kv-south-side-inside-wharf-area"
                                                                                    hreflang="en">PARTLY DISMANTLING AND
                                                                                    RE- CONSTRUCTION OF COMPOUND WALL AT
                                                                                    33KV SOUTH SIDE INSIDE WHARF AREA.</a>
                                                                            </h4>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div id="views_slideshow_cycle_div_tender-block_1_4"
                                                                    class="views_slideshow_cycle_slide views_slideshow_slide views-row-5 views_slideshow_cycle_hidden views-row-odd">
                                                                    <div
                                                                        class="views-row views-row-4 views-row-odd views-row-last">
                                                                        <div class="views-field views-field-title">
                                                                            <h4 class="field-content"><a
                                                                                    href="/providing-pvc-mesh-fencing-over-compound-wall-9th-avenue-door-no-2-9-9th-street-no-2-nmpa-colony"
                                                                                    hreflang="en">Providing PVC Mesh
                                                                                    fencing over compound wall at 9th
                                                                                    Avenue, Door No-2 &amp; 9, 9th Street
                                                                                    No- 2 at NMPA Colony.</a></h4>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>


                                                    </div>






                                                    <footer>
                                                        <a href="tenders">view all</a>
                                                    </footer>


                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="region region-updates-third">
                                    <div class="views-element-container block block-views block-views-blockwhatsnew-block-1"
                                        id="block-views-block-whatsnew-block-1">

                                        <h2 class="title">What&#039;s New</h2>

                                        <div class="content">
                                            <div>
                                                <div
                                                    class="js-view-dom-id-edd401e38966cabc204602da7f76fec8310c0aedf83af4bb7b57d1874a92aaeb">








                                                    <div class="skin-default">

                                                        <div id="views_slideshow_cycle_main_whatsnew-block_1"
                                                            class="views_slideshow_cycle_main views_slideshow_main">
                                                            <div id="views_slideshow_cycle_teaser_section_whatsnew-block_1"
                                                                class="views_slideshow_cycle_teaser_section">
                                                                <div id="views_slideshow_cycle_div_whatsnew-block_1_0"
                                                                    class="views_slideshow_cycle_slide views_slideshow_slide views-row-1 views-row-odd">
                                                                    <div
                                                                        class="views-row views-row-0 views-row-odd views-row-first">
                                                                        <div class="views-field views-field-title">
                                                                            <h4 class="field-content"><a
                                                                                    href="/curtain-raiser-global-maritime-india-summit-2023-held-mumbai-tuesday-18th-july-2023-st-regis-mumbai"
                                                                                    hreflang="en">Curtain raiser for
                                                                                    Global Maritime India Summit 2023, held
                                                                                    in Mumbai on Tuesday, 18th July 2023,
                                                                                    St. Regis, Mumbai.</a></h4>
                                                                        </div>
                                                                        <div class="views-field views-field-field-file">
                                                                            <div class="field-content"><a
                                                                                    href="/sites/default/files/2023-07/OM%20Curtain%20Raiser.pdf"
                                                                                    target="_blank"
                                                                                    rel="noopener noreferrer"
                                                                                    title="The pdf file Open in new window">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                        <div class="views-field views-field-field-link">
                                                                            <div class="field-content"></div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div id="views_slideshow_cycle_div_whatsnew-block_1_1"
                                                                    class="views_slideshow_cycle_slide views_slideshow_slide views-row-2 views_slideshow_cycle_hidden views-row-even">
                                                                    <div class="views-row views-row-1 views-row-even">
                                                                        <div class="views-field views-field-title">
                                                                            <h4 class="field-content"><a
                                                                                    href="/time-table-hindi-competitions-be-conducted-port-connection-hindi-month-2023"
                                                                                    hreflang="en">The time table of Hindi
                                                                                    Competitions to be conducted in the Port
                                                                                    in connection with Hindi Month-2023.
                                                                                </a></h4>
                                                                        </div>
                                                                        <div class="views-field views-field-field-file">
                                                                            <div class="field-content"><a
                                                                                    href="/sites/default/files/2023-08/Hinidi%20Day%20Competition-2023.pdf"
                                                                                    target="_blank"
                                                                                    rel="noopener noreferrer"
                                                                                    title="The pdf file Open in new window">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                        <div class="views-field views-field-field-link">
                                                                            <div class="field-content"></div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div id="views_slideshow_cycle_div_whatsnew-block_1_2"
                                                                    class="views_slideshow_cycle_slide views_slideshow_slide views-row-3 views_slideshow_cycle_hidden views-row-odd">
                                                                    <div
                                                                        class="views-row views-row-2 views-row-odd views-row-last">
                                                                        <div class="views-field views-field-title">
                                                                            <h4 class="field-content"><a
                                                                                    href="/results-hindi-competitions-conducted-2023"
                                                                                    hreflang="en">Results of Hindi
                                                                                    competitions conducted in 2023</a></h4>
                                                                        </div>
                                                                        <div class="views-field views-field-field-file">
                                                                            <div class="field-content"><a
                                                                                    href="/sites/default/files/2023-12/%E0%A4%B5%E0%A4%B0%E0%A5%8D%E0%A4%B7%202023%20%E0%A4%AE%E0%A5%87%E0%A4%82%20%E0%A4%86%E0%A4%AF%E0%A5%8B%E0%A4%9C%E0%A4%BF%E0%A4%A4%20%E0%A4%B9%E0%A4%BF%E0%A4%A8%E0%A5%8D%E0%A4%A6%E0%A5%80%20%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%A4%E0%A4%BF%E0%A4%AF%E0%A5%8B%E0%A4%97%E0%A4%BF%E0%A4%A4%E0%A4%BE%E0%A4%93%E0%A4%82%20%20%E0%A4%95%E0%A4%BE%20%E0%A4%AA%E0%A4%B0%E0%A4%BF%E0%A4%A3%E0%A4%BE%E0%A4%AE.pdf"
                                                                                    target="_blank"
                                                                                    rel="noopener noreferrer"
                                                                                    title="The pdf file Open in new window">View
                                                                                    Details</a></div>
                                                                        </div>
                                                                        <div class="views-field views-field-field-link">
                                                                            <div class="field-content"></div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>


                                                    </div>






                                                    <footer>
                                                        <a href="whatsnew">view all</a>
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
            <div class="highlighted">
                <div class="container">
                    <div class="region region-highlighted">
                        <div data-drupal-messages-fallback class="hidden"></div>
                        <div class="views-element-container wwdo block block-views block-views-blocktop-home-icons-block-1"
                            id="block-views-block-top-home-icons-block-1">

                            <h2 class="title">What We Do</h2>

                            <div class="content">
                                <div>
                                    <div
                                        class="js-view-dom-id-bfbf0f07125cd9ae4221b4218cfabf436996c1647b7974beeceed3e575ddd6e3">








                                        <div class="item-list item-list--blazy item-list--blazy-grid">
                                            <ul class="blazy blazy--view blazy--view--top-home-icons blazy--view--top-home-icons--block-1 blazy--view--top-home-icons-block-block-1 blazy--grid block-grid block-count-12 small-block-grid-2 medium-block-grid-3 large-block-grid-6"
                                                data-blazy="" id="blazy-views-top-home-icons-block-block-1-3">
                                                <li class="grid">
                                                    <div class="grid__content">
                                                        <div class="views-field views-field-field-link">
                                                            <div class="field-content"><a
                                                                    href="https://newmangaloreport.gov.in/eodb"
                                                                    target="_blank"> <img
                                                                        src="{{ asset('assets/frontend/whatwedo/eodb_0.png') }}"
                                                                        width="170" height="170"
                                                                        alt="Ease of Doing Business" loading="lazy"
                                                                        typeof="Image" />

                                                                </a></div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="grid">
                                                    <div class="grid__content">
                                                        <div class="views-field views-field-field-link">
                                                            <div class="field-content"><a
                                                                    href="https://newmangaloreport.gov.in/estate"
                                                                    target="_blank"> <img
                                                                        src="{{ asset('assets/frontend/whatwedo/estate.png') }}"
                                                                        width="170" height="170" alt="Estate"
                                                                        loading="lazy" typeof="Image" />

                                                                </a></div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="grid">
                                                    <div class="grid__content">
                                                        <div class="views-field views-field-field-link">
                                                            <div class="field-content"><a
                                                                    href="https://newmangaloreport.gov.in/daily-vessel-position"
                                                                    target="_blank"> <img
                                                                        src="{{ asset('assets/frontend/whatwedo/vessel-position.png') }}"
                                                                        width="170" height="170"
                                                                        alt="Daily Vessel Positions" loading="lazy"
                                                                        typeof="Image" />

                                                                </a></div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="grid">
                                                    <div class="grid__content">
                                                        <div class="views-field views-field-field-link">
                                                            <div class="field-content"><a
                                                                    href="https://newmangaloreport.gov.in/customer-corner"
                                                                    target="_blank"> <img
                                                                        src="{{ asset('assets/frontend/whatwedo/customer-corner.png') }}"
                                                                        width="170" height="170"
                                                                        alt="Customers Corner" loading="lazy"
                                                                        typeof="Image" />

                                                                </a></div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="grid">
                                                    <div class="grid__content">
                                                        <div class="views-field views-field-field-link">
                                                            <div class="field-content"><a
                                                                    href="https://newmangaloreport.gov.in/tenders"
                                                                    target="_blank"> <img
                                                                        src="{{ asset('assets/frontend/whatwedo/tender.png') }}"
                                                                        width="170" height="170" alt="Tenders"
                                                                        loading="lazy" typeof="Image" />

                                                                </a></div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="grid">
                                                    <div class="grid__content">
                                                        <div class="views-field views-field-field-link">
                                                            <div class="field-content"><a
                                                                    href="https://newmangaloreport.gov.in/vacancy"
                                                                    target="_blank"> <img
                                                                        src="{{ asset('assets/frontend/whatwedo/careers.png') }}"
                                                                        width="170" height="170" alt="Careers"
                                                                        loading="lazy" typeof="Image" />

                                                                </a></div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="grid">
                                                    <div class="grid__content">
                                                        <div class="views-field views-field-field-link">
                                                            <div class="field-content"><a
                                                                    href="https://newmangaloreport.gov.in/environment-and-safety"
                                                                    target="_blank"> <img
                                                                        src="{{ asset('assets/frontend/whatwedo/enviornment.png') }}"
                                                                        width="170" height="170"
                                                                        alt="Environment &amp; Safety" loading="lazy"
                                                                        typeof="Image" />

                                                                </a></div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="grid">
                                                    <div class="grid__content">
                                                        <div class="views-field views-field-field-link">
                                                            <div class="field-content"><a
                                                                    href="https://newmangaloreport.gov.in/vigilance"
                                                                    target="_blank"> <img
                                                                        src="{{ asset('assets/frontend/whatwedo/vigilance.png') }}"
                                                                        width="170" height="170" alt="vigilance"
                                                                        loading="lazy" typeof="Image" />

                                                                </a></div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="grid">
                                                    <div class="grid__content">
                                                        <div class="views-field views-field-field-link">
                                                            <div class="field-content"><a
                                                                    href="https://newmangaloreport.gov.in/rti"
                                                                    target="_blank"> <img
                                                                        src="{{ asset('assets/frontend/whatwedo/rti.png') }} "
                                                                        width="170" height="170" alt="RTI"
                                                                        loading="lazy" typeof="Image" />

                                                                </a></div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="grid">
                                                    <div class="grid__content">
                                                        <div class="views-field views-field-field-link">
                                                            <div class="field-content"><a
                                                                    href="https://newmangaloreport.gov.in/employees-corner"
                                                                    target="_blank"> <img
                                                                        src="{{ asset('assets/frontend/whatwedo/employee-corner.png') }}"
                                                                        width="170" height="170"
                                                                        alt="Employee Corner" loading="lazy"
                                                                        typeof="Image" />

                                                                </a></div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="grid">
                                                    <div class="grid__content">
                                                        <div class="views-field views-field-field-link">
                                                            <div class="field-content"><a
                                                                    href="https://nmpt.in:4443/login-register.jsp"
                                                                    target="_blank"> <img
                                                                        src="{{ asset('assets/frontend/whatwedo/pensioners-new.png') }}"
                                                                        width="170" height="170"
                                                                        alt="Pensioners Corner" loading="lazy"
                                                                        typeof="Image" />

                                                                </a></div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="grid">
                                                    <div class="grid__content">
                                                        <div class="views-field views-field-field-link">
                                                            <div class="field-content"><a
                                                                    href="https://newmangaloreport.gov.in/important-links"
                                                                    target="_blank"> <img
                                                                        src="{{ asset('assets/frontend/whatwedo/weblinks.png') }}"
                                                                        width="170" height="170"
                                                                        alt="Important links" loading="lazy"
                                                                        typeof="Image" />

                                                                </a></div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>







                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
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
                                                                                        src="{{ asset('assets/frontend/gallery/Slide1_3.jpg') }}"
                                                                                        width="595" height="300"
                                                                                        alt="" loading="lazy"
                                                                                        typeof="foaf:Image"
                                                                                        class="image-style-gallery" />

                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="views-field views-field-title"><span
                                                                                class="field-content">&quot; Celebration of
                                                                                133rd Birthday of Bharath Ratna Dr.B.R.
                                                                                Ambedkar on 14.04.2024 at NMPA&quot;.</span>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div id="views_slideshow_cycle_div_gallery-block_1_1"
                                                                    class="views_slideshow_cycle_slide views_slideshow_slide views-row-2 views_slideshow_cycle_hidden views-row-even">
                                                                    <div class="views-row views-row-1 views-row-even">
                                                                        <div class="views-field views-field-field-image">
                                                                            <div class="field-content"> <a
                                                                                    href="/seven-seas-mariner-6th-cruise-ship-arrived-new-mangalore-port-31032024"><img
                                                                                        src="{{ asset('assets/gallery/gallery/Slide1_1.jfif') }}"
                                                                                        width="595" height="300"
                                                                                        alt="" loading="lazy"
                                                                                        typeof="foaf:Image"
                                                                                        class="image-style-gallery" />

                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="views-field views-field-title"><span
                                                                                class="field-content">&quot;Seven Seas
                                                                                Mariner - 6th Cruise Ship arrived at New
                                                                                Mangalore Port on 31.03.2024&quot;.</span>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div id="views_slideshow_cycle_div_gallery-block_1_2"
                                                                    class="views_slideshow_cycle_slide views_slideshow_slide views-row-3 views_slideshow_cycle_hidden views-row-odd">
                                                                    <div class="views-row views-row-2 views-row-odd">
                                                                        <div class="views-field views-field-field-image">
                                                                            <div class="field-content"> <a
                                                                                    href="/61st-national-maritime-day-celebration-05042024-nmpa"><img
                                                                                        src="{{ asset('assets/gallery/gallery/Slide1.JPG') }}"
                                                                                        width="595" height="300"
                                                                                        alt="" loading="lazy"
                                                                                        typeof="foaf:Image"
                                                                                        class="image-style-gallery" />

                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="views-field views-field-title"><span
                                                                                class="field-content">61st National
                                                                                Maritime Day celebration on 05.04.2024 at
                                                                                NMPA.</span></div>
                                                                    </div>

                                                                </div>

                                                                <div id="views_slideshow_cycle_div_gallery-block_1_3"
                                                                    class="views_slideshow_cycle_slide views_slideshow_slide views-row-4 views_slideshow_cycle_hidden views-row-even">
                                                                    <div class="views-row views-row-3 views-row-even">
                                                                        <div class="views-field views-field-field-image">
                                                                            <div class="field-content"> <a
                                                                                    href="/valedictory-function-53rd-national-safety-week-celebration-11032024-nmpa"><img
                                                                                        src="./sites/default/files/styles/gallery/public/2024-03/Slide1_3.JPG?itok=zfvzrj7N"
                                                                                        width="595" height="300"
                                                                                        alt="" loading="lazy"
                                                                                        typeof="foaf:Image"
                                                                                        class="image-style-gallery" />

                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="views-field views-field-title"><span
                                                                                class="field-content">&quot;Valedictory
                                                                                function of the 53rd National Safety Week
                                                                                Celebration on 11.03.2024 at
                                                                                NMPA&quot;.</span></div>
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
                                                                                        width="595" height="300"
                                                                                        alt="" loading="lazy"
                                                                                        typeof="foaf:Image"
                                                                                        class="image-style-gallery" />

                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="views-field views-field-title"><span
                                                                                class="field-content">&quot;Celebration of
                                                                                International Women&#039;s Day at New
                                                                                Mangalore Port Authority on
                                                                                08.03.2024&quot;.</span></div>
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
                                                                            height="315"
                                                                            src="https://www.youtube.com/embed/PDJ7W220RME?si=bNrUSaPQRQCLvYgD"
                                                                            title="YouTube video player"
                                                                            width="560"></iframe></p>
                                                                </div>
                                                            </div>
                                                            <div class="views-field views-field-title"><span
                                                                    class="field-content">NMPA Corporate video</span>
                                                            </div>
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
                                                                    class="field-content"> &quot;Vigilance Awareness Week
                                                                    -2023- Campaign on Preventive Vigilance
                                                                    measures&quot;.</span></div>
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
                                                                    Terminal</span></div>
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
                                                    src="{{ asset('assets/frontend/images/portmapnew.png') }}"
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

            <!-- Start: Related widget -->
            <div class="relatetop" id="relatedtop">
                <div class="container">
                    <div class="row topwidget-list clearfix">
                        <div class=col-sm-12>
                            <div class="region region-related-first">
                                <div class="views-element-container block block-views block-views-blockrelated-links-block-1"
                                    id="block-views-block-related-links-block-1">


                                    <div class="content">
                                        <div>
                                            <div
                                                class="js-view-dom-id-bbcd20bec521c18846491b8cb77c0bee0c7c40edc01ff4cd1c93ddd3a49e5f34">








                                                <div class="item-list item-list--blazy item-list--blazy-grid">
                                                    <ul class="blazy blazy--view blazy--view--related-links blazy--view--related-links--block-1 blazy--view--related-links-block-block-1 blazy--grid block-grid block-count-16 small-block-grid-6 medium-block-grid-6 large-block-grid-6"
                                                        data-blazy="" id="blazy-views-related-links-block-block-1-4">
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-link">
                                                                    <div class="field-content"><a
                                                                            href="https://newmangaloreport.gov.in/ipos"
                                                                            target="_blank"> <img
                                                                                src="{{ asset('assets/frontend/relatedlinks/ipos.jpg') }}"
                                                                                width="220" height="79"
                                                                                alt="Integreted Port Operating System"
                                                                                loading="lazy" typeof="Image"
                                                                                class="image-style-medium" />


                                                                        </a></div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-link">
                                                                    <div class="field-content"><a
                                                                            href="https://www.nmpt.in/nmpt_ext/Login"
                                                                            target="_blank"> <img
                                                                                src="{{ asset('assets/frontend/relatedlinks/GIS_LOGO.png') }}"
                                                                                width="220" height="79"
                                                                                alt="GIS Login" loading="lazy"
                                                                                typeof="Image"
                                                                                class="image-style-medium" />


                                                                        </a></div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-link">
                                                                    <div class="field-content"><a
                                                                            href="https://newmangaloreport.gov.in/rfid-pass-system"
                                                                            target="_blank"> <img
                                                                                src="{{ asset('assets/frontend/relatedlinks/online-pass.jpg') }}"
                                                                                width="220" height="79"
                                                                                alt="Online Pass Issuance System"
                                                                                loading="lazy" typeof="Image"
                                                                                class="image-style-medium" />


                                                                        </a></div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-link">
                                                                    <div class="field-content"><a
                                                                            href="https://nmpt.in:4443/login-register.jsp"
                                                                            target="_blank"> <img
                                                                                src="{{ asset('assets/frontend/relatedlinks/pensioner-portal.jpg') }}"
                                                                                width="220" height="79"
                                                                                alt="Pensioners Portal" loading="lazy"
                                                                                typeof="Image"
                                                                                class="image-style-medium" />


                                                                        </a></div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-link">
                                                                    <div class="field-content"><a
                                                                            href="https://eoffice.nmpt.in:8443"
                                                                            target="_blank"> <img
                                                                                src="{{ asset('assets/frontend/relatedlinks/Eoffice_0.png') }}"
                                                                                width="220" height="83"
                                                                                alt="NMPA E-Office" loading="lazy"
                                                                                typeof="Image"
                                                                                class="image-style-medium" />


                                                                        </a></div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-link">
                                                                    <div class="field-content"><a
                                                                            href="https://nmpt.in:4443/IncidentAcidentReport.jsp"
                                                                            target="_blank"> <img
                                                                                src="{{ asset('assets/frontend/relatedlinks/Incident_reporting_0.png') }}"
                                                                                width="220" height="83"
                                                                                alt="Incident Accident Report"
                                                                                loading="lazy" typeof="Image"
                                                                                class="image-style-medium" />


                                                                        </a></div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-link">
                                                                    <div class="field-content"><a
                                                                            href="https://nmpt.in:4443/nmptCruiseFeedback.jsp"
                                                                            target="_blank"> <img
                                                                                src="{{ asset('assets/frontend/relatedlinks/Cruise_FB.png') }}"
                                                                                width="220" height="79"
                                                                                alt="Cruise Feedback" loading="lazy"
                                                                                typeof="Image"
                                                                                class="image-style-medium" />


                                                                        </a></div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-link">
                                                                    <div class="field-content"><a
                                                                            href="https://nlpmarine.gov.in/"
                                                                            target="_blank"> <img
                                                                                src="{{ asset('assets/frontend/relatedlinks/Picture3.jpg') }}"
                                                                                width="203" height="76"
                                                                                alt="NLP-Marine" loading="lazy"
                                                                                typeof="Image"
                                                                                class="image-style-medium" />


                                                                        </a></div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-link">
                                                                    <div class="field-content"><a
                                                                            href="https://parichay.nic.in/Accounts/NIC/index.html?service=SPARROWSHIPMIN"
                                                                            target="_blank"> <img
                                                                                src="{{ asset('assets/frontend/relatedlinks/parichay.jpg') }}"
                                                                                width="220" height="79"
                                                                                alt="Parichay Portal" loading="lazy"
                                                                                typeof="Image"
                                                                                class="image-style-medium" />


                                                                        </a></div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-link">
                                                                    <div class="field-content"><a
                                                                            href="https://jeevanpramaan.gov.in/"
                                                                            target="_blank"> <img
                                                                                src="{{ asset('assets/frontend/relatedlinks/jeevan_pramaan.jpg') }}"
                                                                                width="220" height="79"
                                                                                alt="Jeevan Pramaan" loading="lazy"
                                                                                typeof="Image"
                                                                                class="image-style-medium" />


                                                                        </a></div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-link">
                                                                    <div class="field-content"><a
                                                                            href="https://eoffice.gov.in"
                                                                            target="_blank"> <img
                                                                                src="{{ asset('assets/frontend/relatedlinks/eoffice_0.jpg') }}"
                                                                                width="220" height="79"
                                                                                alt="E-Office Ministry" loading="lazy"
                                                                                typeof="Image"
                                                                                class="image-style-medium" />


                                                                        </a></div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-link">
                                                                    <div class="field-content"><a
                                                                            href="https://www.india.gov.in/"
                                                                            target="_blank"> <img
                                                                                src="{{ asset('assets/frontend/relatedlinks/National_portal_0.png') }}"
                                                                                width="220" height="70"
                                                                                alt="National Portal of India"
                                                                                loading="lazy" typeof="Image"
                                                                                class="image-style-medium" />


                                                                        </a></div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-link">
                                                                    <div class="field-content"><a
                                                                            href="http://pgportal.gov.in/"
                                                                            target="_blank"> <img
                                                                                src="{{ asset('assets/frontend/relatedlinks/public-grievance.jpg') }}"
                                                                                width="220" height="79"
                                                                                alt="Public Grievances" loading="lazy"
                                                                                typeof="Image"
                                                                                class="image-style-medium" />


                                                                        </a></div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-link">
                                                                    <div class="field-content"><a
                                                                            href="http://onlinevacancy.shipmin.nic.in/"
                                                                            target="_blank"> <img
                                                                                src="{{ asset('assets/frontend/relatedlinks/online-application-portal.jpg') }}"
                                                                                width="220" height="79"
                                                                                alt="Online Application Portal"
                                                                                loading="lazy" typeof="Image"
                                                                                class="image-style-medium" />


                                                                        </a></div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-link">
                                                                    <div class="field-content"><a
                                                                            href="https://email.gov.in" target="_blank">
                                                                            <img src="{{ asset('assets/frontend/relatedlinks/mail-gov.jpg') }}"
                                                                                width="220" height="79"
                                                                                alt="" loading="lazy"
                                                                                typeof="Image"
                                                                                class="image-style-medium" />


                                                                        </a></div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="grid">
                                                            <div class="grid__content">
                                                                <div class="views-field views-field-field-link">
                                                                    <div class="field-content"><a
                                                                            href="https://newmangaloreport.gov.in/online-vigilance-complaint"
                                                                            target="_blank"> <img
                                                                                src="{{ asset('assets/frontend/relatedlinks/online-vigilance.jpg') }}"
                                                                                width="220" height="79"
                                                                                alt="Online Vigilance Complaint"
                                                                                loading="lazy" typeof="Image"
                                                                                class="image-style-medium" />


                                                                        </a></div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
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
            <!--End: Related widget -->

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






        </div>
    @endsection