<!-- ======== sidebar-nav start =========== -->

<aside class="sidebar-nav-wrapper">

  <div class="navbar-logo">
  @if(Auth::user()->role_id==1)
    <a href="{{route('masteradminhome')}}">
  @elseif(Auth::user()->role_id==2)
   <a href="{{route('siteadminhome')}}">
   @elseif(Auth::user()->role_id==3)
   <a href="{{route('planninghome')}}">
   @elseif(Auth::user()->role_id==4)
   <a href="{{route('secretaryhome')}}">
   @elseif(Auth::user()->role_id==5)
   <a href="{{route('Sbuadminhome')}}">
  @endif    
      <img src="{{asset('assets/frontend/images/nmptlogonew-14n2-en.png')}}" class="logo-size" alt="logo" />
    </a>
  </div>

  <nav class="sidebar-nav main-nav">
    <ul>
     
      <li class="nav-item nav-item-has-children main-active">
        <a href="#0" data-bs-toggle="collapse" data-bs-target="#ddmenu_1" aria-controls="ddmenu_1" aria-expanded="false" aria-label="Toggle navigation">
          <span class="icon">
            <svg width="22" height="22" viewBox="0 0 22 22">
              <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z"/>
            </svg>
          </span>
          <span class="text">Dashboard</span>
        </a>
        <ul id="ddmenu_1" class="collapse show dropdown-nav ">
          <li class="sub-active">
            <!-- <a href="index.html" class="active"> Main Dashboard </a> -->

            @if(Auth::user()->role_id==1)
              <a href="{{route('masteradminhome')}}"> Main Dashboard </a>
            @elseif(Auth::user()->role_id==2)
              <a href="{{route('siteadminhome')}}"> Main Dashboard </a>
            @elseif(Auth::user()->role_id==3)
              <a href="{{route('planninghome')}}"> Main Dashboard </a>
            @elseif(Auth::user()->role_id==4)
              <a href="{{route('secretaryhome')}}"> Main Dashboard </a>
            @elseif(Auth::user()->role_id==5)
              <a href="{{route('Sbuadminhome')}}"> Main Dashboard </a>
            @endif  
           
          </li>
        </ul>
      </li>

      <li class="nav-item nav-item-has-children main-active">
        <a  href="#0" class="" data-bs-toggle="collapse" data-bs-target="#ddmenu_3" aria-controls="ddmenu_3" aria-expanded="false" aria-label="Toggle navigation">
          <span class="icon">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" >
              <path d="M12.9067 14.2908L15.2808 11.9167H6.41667V10.0833H15.2808L12.9067 7.70917L14.2083 6.41667L18.7917 11L14.2083 15.5833L12.9067 14.2908ZM17.4167 2.75C17.9029 2.75 18.3692 2.94315 18.713 3.28697C19.0568 3.63079 19.25 4.0971 19.25 4.58333V8.86417L17.4167 7.03083V4.58333H4.58333V17.4167H17.4167V14.9692L19.25 13.1358V17.4167C19.25 17.9029 19.0568 18.3692 18.713 18.713C18.3692 19.0568 17.9029 19.25 17.4167 19.25H4.58333C3.56583 19.25 2.75 18.425 2.75 17.4167V4.58333C2.75 3.56583 3.56583 2.75 4.58333 2.75H17.4167Z"/>
            </svg>
          </span>
          <span class="text">Settings</span>
        </a>

      <ul id="ddmenu_3" class="collapse dropdown-nav {{isset($navbar) ? 'show':''}}">
        @foreach($navbar as $navbardata)
                 <li class="sub-active {{ ($navbardata->url=='/'.\Request::path()) ? 'activesideNav' : ((isset($Navid->id)) ? (($Navid->id==$navbardata->id) ? 'activesideNav' : '') :'') }}">
                
                    <input type="hidden" name="navid" value="{{\Crypt::encryptString($navbardata->id)}}">
               
                    <a  class="setting_components" href="{{$navbardata->url}}"> {{$navbardata->component->name}} </a>
                    
                </li>
        @endforeach   

        @if(Auth::user()->id == 14)     
                <li class="sub-active">
                    <a  class="setting_components" href="{{ route('sbu.waterlevel') }}"> Water level </a>
                </li>     
                <li class="sub-active">
                    <a  class="setting_components" href="{{ route('sbu.majorgroup') }}"> Major group  </a>
                </li> 
                <li class="sub-active">
                    <a  class="setting_components" href="{{ route('sbu.majorstation') }}"> Major station  </a>
                </li>    
                <li class="sub-active">
                    <a  class="setting_components" href="{{ route('sbu.statisticsupload') }}"> System statistics  </a>
                </li>   
                <li class="sub-active">
                    <a  class="setting_components" href="{{ route('sbu.importupload') }}"> Import  </a>
                </li> 
                <li class="sub-active">
                    <a  class="setting_components" href="{{ route('sbu.exportupload') }}"> Export  </a>
                </li> 
                <li class="sub-active">
                    <a  class="setting_components" href="{{ route('sbu.consumptionupload') }}"> Consumption </a>
                </li> 
                <li class="sub-active">
                    <a  class="setting_components" href="{{ route('sbu.abstractupload') }}"> Day Abstract </a>
                </li> 
                <li class="sub-active">
                    <a  class="setting_components" href="{{ route('sbu.recordupload') }}"> Records </a>
                </li> 
                <li class="sub-active">
                    <a  class="setting_components" href="{{ route('sbu.historicdata') }}"> Historic Data </a>
                </li>
         
        @endif
     
      </ul>
      </li>
      <span class="divider"><hr /></span>
    </ul>

  </nav>

</aside>
<div class="overlay"></div>
<!-- ======== sidebar-nav End =========== -->

<!-- ========== header start ========== -->
<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-6">
                <div class="header-left d-flex align-items-center">
                    <div class="menu-toggle-btn mr-20">
                        <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                            <i class="lni lni-chevron-left me-2"></i> Menu
                        </button>
                    </div>
                    <div class="header-search d-none d-md-flex">
                        <form action="#">
                            <input type="text" placeholder="Search..." />
                            <button><i class="lni lni-search-alt"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
                <div class="header-right">
                    <!-- profile start -->
    <div class="profile-box ml-15">
        <button
          class="dropdown-toggle bg-transparent border-0"
          type="button"
          id="profile"
          data-bs-toggle="dropdown"
         
        >
          <div class="profile-info">
            <div class="info">
                <h6>{{$user->fullname}} <br>({{$user->name}})</h6>
            </div>
          </div>
          <i class="lni lni-chevron-down"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
          <li>
            <a href="{{route('logout')}}"> <i class="lni lni-exit"></i> Sign Out </a>
          </li>
        </ul>
      </div>
                </div>
            </div>
        </div>
    </div>
</header>