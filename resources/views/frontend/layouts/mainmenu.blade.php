  <!-- Start: Header -->
  <div class="header">
      <div class="headbg">
          <div class="container-fluid">

              <div class="row">
                  <div class="navbar-header col-md-12 ">
                      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navigation">
                          <img src="{{ asset('assets/frontend/images/settings.svg') }}" alt="">
                      </button>
                      <div class="logos">
                          <div class="region region-header">
                              <div id="block-construction-zymphonies-theme-branding"
                                  class="site-branding block block-system block-system-branding-block">
                                  <div class="brand logo">
                                      <a href="/index.php/" title="Home" rel="home" class="site-branding__logo">
                                          <img src="{{ asset('assets/frontend/images/nmptlogonew-14n2-en.png') }}"
                                              class="main-logo" alt="Home" />
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div id="block-solartext"
                              class="block block-block-content block-block-content547d3074-89cc-454c-a58b-2d1d01c91936">
                              <div class="content">
                                  <div
                                      class="clearfix text-formatted field field--name-body field--type-text-with-summary field--label-hidden field__item">
                                      <div class="greenwel text-align-left">
                                          A GREEN WELCOME TO 100% SOLAR POWERED PORT</div>
                                  </div>
                              </div>
                          </div>
                          <div class="region region-header">
                              <div id="block-construction-zymphonies-theme-branding"
                                  class="site-branding block block-system block-system-branding-block">
                                  <div class="brand logo">
                                      <a href="/index.php/" title="Home" rel="home" class="site-branding__logo">
                                        <img src="{{ asset('assets/frontend/images/gj_copy.png') }}"
                                        class="jub-logo" alt="Home" />
                                          <img src="{{ asset('assets/frontend/images/sagarmala-new.png') }}"
                                              class="sag-logo" alt="Home" />
                                      </a>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-md-12 menu-wrap d-flex justify-content-center">
                      <div class="region region-primary-menu expan">
                          <div id="block-mainnavigation-3" class="block block-superfish block-superfishmain">
                              <div class="content">
                                  <ul id="superfish-main"
                                      class="menu sf-menu sf-main sf-horizontal sf-style-none sf-expanded">

                                      <li id="main-menu-link-content3e671f6f-9b8b-4c77-9340-1d8390ae2430"
                                          class="active-trail sf-depth-1 sf-no-children">
                                          <a href="/index.php/" class="icon-home is-active sf-depth-1"
                                              title="Home">.</a>
                                      </li>

                                      @foreach ($mainsubmenus as $menuitem)
                                          @foreach ($menuitem->mainmenu_sub as $maindata)


                                                       {{-- menu list --}}
                                                        {{--
                                                        11. hashtag just hashid
                                                        12. url target blank
                                                        13. file  download
                                                        14. article article detail
                                                        15. form
                                                        16. route routename
                                                        17. submenu
                                                        --}}
                                        @if($menuitem->menulinktype_id == 11)
                                        {{-- hashtag --}}
                                          <li><a class="nav-link scrollto" href="#{{ $menuitem->menulinktype_data }}"><span><i class="{{ $menuitem->iconclass ?? '' }}"></i> &nbsp; {{ $maindata->title }}</span></a></li>

                                        @elseif($menuitem->menulinktype_id == 12)
                                        {{-- url --}}
                                          <li><a class="nav-link" href="{{ $menuitem->menulinktype_data }}" target="_blank"><span><i class="{{ $menuitem->iconclass ?? '' }}"></i> &nbsp; {{ $maindata->title }}</span></a></li>

                                        @elseif($menuitem->menulinktype_id == 13)
                                        {{-- file --}}
                                          <li><a class="nav-link" href="{{ asset('uploads/Mainmenu/'.$menuitem->menulinktype_data) }}" target="_blank"><span><i class="{{ $menuitem->iconclass ?? '' }}"></i> &nbsp; {{ $maindata->title }}</span></a></li>

                                        @elseif($menuitem->menulinktype_id == 14)
                                        {{-- article --}}

                                                @php  $enarticletype_id = \Crypt::encryptString($menuitem->articletype_id) @endphp


                                                    <li><a class="nav-link" href="{{ route('mainarticle' , $enarticletype_id) }}"><span><i class="{{ $menuitem->iconclass ?? '' }}"></i> &nbsp; {{ $maindata->title }}</span></a></li>

                                                @elseif($menuitem->menulinktype_id == 16)
                                                {{-- route --}}

                                                 @if(isset($ensbutypeid))
                                                  <li><a class="nav-link" href="{{ url($menuitem->menulinktype_data."/".$ensbutypeid) }}"><span><i class="{{ $menuitem->iconclass ?? '' }}"></i> &nbsp; {{ $maindata->title }}</span></a></li>
                                                @else
                                                   <li><a class="nav-link" href="{{ url($menuitem->menulinktype_data) }}"><span><i class="{{ $menuitem->iconclass ?? '' }}"></i> &nbsp; {{ $maindata->title }}</span></a></li>
                                                @endif

                                        @elseif($menuitem->menulinktype_id == 17)
                                        {{-- submenu --}}
                                        <li class="dropdown menu-z-index-fix"><a href="#"><span><i class="{{ $menuitem->iconclass ?? '' }}"></i> {{ $maindata->title }}</span> <i class="bi bi-chevron-down"></i></a>
                                                <ul class="menu-z-index-fix">
                                                        @foreach ($menuitem['sub_menu'] as $subdata)
                                                        @foreach ($subdata['submenusub'] as $subitem)
                                                        @if($subdata->menulinktype_id == 14)
                                                        {{-- article --}}

                                                        @php
                                                        $enarticletype_id = \Crypt::encryptString($subdata->articletype_id);
                                                        $cleanTitle = strtolower(str_replace([' ', '/'], '_', $subitem->title));
                                                        // $cleanTitle = preg_replace('/[^A-Za-z0-9 ]/', '', $subitem->title);
                                                        @endphp

                                                        {{-- <li><a class="nav-link" href="{{ route('article', [$ensbutypeid ,$enarticletype_id]) }}"><span><i class="{{ $menuitem->iconclass ?? '' }}"></i> &nbsp; {{ $maindata->title }}</span></a></li> --}}

                                                          <li><a href="{{ route('mainarticle' , [$cleanTitle,$enarticletype_id]) }}">{{ $subitem->title }} </a></li>

                                                        {{-- <li><a href="{{ route('article', [$ensbutypeid ,$enarticletype_id]) }}">{{ $subitem->title }}</a></li> --}}

                                                      @elseif($subdata->menulinktype_id == 12)

                                                        <li><a href="{{ $subdata->menulinktype_data }}" target="_blank">{{ $subitem->title }}</a></li>

                                                        @elseif($subdata->menulinktype_id == 13)

                                                        <li><a href="{{ asset('uploads/Submenu/'.$subdata->menulinktype_data) }}" target="_blank">{{ $subitem->title }}</a></li>

                                                      @elseif($subdata->menulinktype_id == 16)
                                                          {{-- route --}}
                                                        @if(isset($ensbutypeid))
                                                          <li><a href="{{ url($subdata->menulinktype_data."/".$ensbutypeid) }}">{{ $subitem->title }}</a></li>
                                                        @else
                                                          <li><a href="{{ url($subdata->menulinktype_data) }}">{{ $subitem->title }}</a></li>
                                                        @endif

                                                      @elseif($subdata->menulinktype_id == 17)
                                                       <li class="dropdown menu-z-index-fix"><a href="#">{{ $subitem->title }} <i class="bi bi-chevron-right"></i></a>
                                                        @foreach ($subdata['subsubmenu'] as $subsuitem)
                                                        @endforeach
                                                      @elseif ($subdata->menulinktype_id == 22)
                                                      <li><a href="{{ route('milestoneview') }}">{{ $subitem->title }} </a></li>
                                                      @elseif ($subdata->menulinktype_id == 23)
                                                      <li><a href="{{ route('bodview') }}">{{ $subitem->title }} </a></li>
                                                      @elseif ($subdata->menulinktype_id == 24)
                                                      <li><a href="{{ route('whoswhoview') }}">{{ $subitem->title }} </a></li>
                                                      @elseif ($subdata->menulinktype_id == 25)
                                                      <li><a href="{{ route('chiefofficers') }}">{{ $subitem->title }} </a></li>
                                                      @elseif ($subdata->menulinktype_id == 26)
                                                      <li><a href="{{ route('whatweoffer') }}">{{ $subitem->title }} </a></li>
                                                      @endif

                                                        @endforeach
                                                        @endforeach
                                                </ul>
                                        @endif
                                        @endforeach
                                      @endforeach
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
  <!-- End: Header -->
