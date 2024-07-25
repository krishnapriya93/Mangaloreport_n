<!DOCTYPE html>
<html lang="en" dir="ltr"
    prefix="content: http://purl.org/rss/1.0/modules/content/  dc: http://purl.org/dc/terms/  foaf: http://xmlns.com/foaf/0.1/  og: http://ogp.me/ns#  rdfs: http://www.w3.org/2000/01/rdf-schema#  schema: http://schema.org/  sioc: http://rdfs.org/sioc/ns#  sioct: http://rdfs.org/sioc/types#  skos: http://www.w3.org/2004/02/skos/core#  xsd: http://www.w3.org/2001/XMLSchema# ">

<head>
    <meta name="title" content="New Mangalore Port Authority">
    <meta charset="utf-8" />
    <link rel="canonical" href="https://newmangaloreport.gov.in/" />
    <meta name="robots" content="index, follow" />
    <link rel="shortlink" href="https://newmangaloreport.gov.in/" />

    <link rel="alternate" hreflang="en" href="https://www.newmangaloreport.gov.in/" />
    <link rel="alternate" hreflang="hi" href="https://www.newmangaloreport.gov.in/hi" />
    <meta name="MobileOptimized" content="width" />
    <meta name="HandheldFriendly" content="true" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- <link rel="icon" href="favicon.ico" type="image/png" /> --}}
    <link id="favicon" rel="icon" href="favicon.ico" type="image/x-icon" />

    <link rel="alternate" type="application/rss+xml" title="" href="https://newmangaloreport.gov.in/rss.xml" />

    <meta name="lang" content="English">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @if (isset($articledetails))
        @foreach ($articledetails['articleval_sub'] as $details)
        <meta name="title" content="{{ strip_tags($details->title ?? '') }} - Mangalore Port" >
        <meta name="description" content="{{ strip_tags($details->subtitle ?? '') }}" >
        <meta name="keywords" content="{{ strip_tags($details->subtitle ?? '') }},New Mangalore Port, Mangalore Port, Mangalore, State of Karnataka" >
        <title>{{ strip_tags($details->title ?? '') }} - Mangalore Port</title>
        @endforeach
    @else
    <meta name="news_keywords" content="New Mangalore Port, Mangalore Port, Mangalore, State of Karnataka" />
    <meta name="description"
        content="New Mangalore Port situated in Panambur, Mangalore in the state of Karnataka is run and governed new Mangalore trust." />
    <meta name="keywords" content="New Mangalore Port, Mangalore Port, Mangalore, State of Karnataka" />
    <title>New Mangalore Port</title>
    @endif

    <link rel="stylesheet" media="all" href="{{ asset('assets/frontend/css/style.css') }}" />
    <link rel="stylesheet" media="all" href="{{ asset('assets/frontend/css/main.css') }}" />
    <link rel="stylesheet" media="all" href="{{ asset('assets/frontend/css/custom.css') }}" />

    <style>
        .navbar-header {
            background-image: url('{{ asset('/assets/frontend/images/green.jpg') }}');
            background-size: inherit;
            background-color: #013304db;
            background-blend-mode: overlay;
        }

        .region-primary-menu li a.icon-home {
            background: url('{{ asset('/assets/frontend/images/home24.png') }}') no-repeat left center transparent !important;
            width: 50px;
        }

        .menu-wrap {
            background-image: url({{ asset('/assets/frontend/images/6758688_7811.jpg') }} );
            background-size: cover;
            background-position: center;
        }

        .midwidget {
            /* background: url(../3585502_66347.jpg); */
            background: url({{ asset('/assets/frontend/images/239641.jpg') }} );
            background-size: cover;
            padding: 40px 0px 30px 0px;
            background-position: center;
        }

        .topupbg {
            background: url({{ asset('/assets/frontend/images/88.jpg') }});
            padding: 55px 10px 80px 10px !important;
            background-size: cover;
            background-position: center;
            /* box-shadow: 1px 1px 35px #b0a975; */
            background-color: #00000070;
            background-blend-mode: overlay;
        }

        .updates .region .title {
            padding: 9px 23px;
            border-radius: 0px 0px 7px 7px;
            background: url({{ asset('/assets/frontend/images/got.jpg') }});
            background-size: cover;
            background-position: bottom;
            display: flex;
            align-items: center;
            color: #Fff;
        }

        .wedo .grid .card {
            background: url({{ asset('/assets/frontend/images/6758688_7811.jpg') }});
            background-size: cover;
            background-position: center;
            padding: 16px 5px;
            border-radius: 0px 17px 0 17px;
            min-height: 147px;
            transition: all .3s ease-in-out;
            box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
            border: none;
        }

        #search-block-form input.form-submit {
            background: url({{ asset('/assets/frontend/images/search.png') }}) no-repeat center;
            font-size: 0;
            width: 100%;
            height: 30px;
            padding: 0 20px;
            vertical-align: top;
        }

        .wave:nth-of-type(3) {
            bottom: 0;
            animation: wave 20s -1s linear infinite;
            opacity: 0.5;
            z-index: 102;
        }

        .wave {
            /* background: url(data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 88.7'%3E%3Cpath d='M800 56.9c-155.5 0-204.9-50-405.5-49.9-200 0-250 49.9-394.5 49.9v31.8h800v-.2-31.6z' fill='%23003F7C'/%3E%3C/svg%3E); */
            background: url({{ asset('/assets/frontend/images/sea1.svg') }});
            position: absolute;
            width: 200%;
            height: 100%;
            animation: wave 10s -3s linear infinite;
            transform: translate3d(0, 0, 0);
            opacity: 0.8;
        }

        .bottombg {
            background: url({{ asset('/assets/frontend/images/551.jpg') }});
            background-attachment: fixed;
            background-size: cover;
        }
    </style>

</head>

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
                                        <a href="{{ route('sitemap') }}" title="Sitemap">Sitemap</a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="{{ route('screenreader') }}" title="Screen Reader">Screen Reader</a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="#skmc" title="Skip to main content">Skip to main content</a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="{{ route('feedback') }}" target="_blank" title="Feedback"
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
                                        <div class="text-align-center mr-2 lang"
                                            style="float:right; width:110px; right:0px;">
                                            <a aria-label="NMPA English website " class="active"
                                                href="{{ route('main.index') }}"
                                                title="NMPA English website">English</a>&nbsp; |&nbsp;
                                            <a aria-label="NMPA Hindi website"
                                                href="{{ route('main.malhome', ['id' => 2]) }}"
                                                style=""title="NMPA Hindi website">Hindi</a>
                                        </div>
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
                                        class="form-actions js-form-wrapper form-wrapper" id="edit-actions">
                                        <input data-drupal-selector="edit-submit" type="submit" id="edit-submit"
                                            value="Search" class="button js-form-submit form-submit" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('frontend.layouts.mainmenu')



        @yield('content')

        @include('frontend.layouts.included_script')
        @include('frontend.layouts.main_footer')
