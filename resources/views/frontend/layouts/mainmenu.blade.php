 <div class="region region-primary-menu">
    <div id="block-mainnavigation-3" class="block block-superfish block-superfishmain">
        <div class="content">
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

        <ul id="superfish-main" class="menu sf-menu sf-main sf-horizontal sf-style-none">
            <li id="main-menu-link-content3e671f6f-9b8b-4c77-9340-1d8390ae2430" class="active-trail sf-depth-1 sf-no-children"><a href="/index.php/" class="icon-home is-active sf-depth-1" title="Home">.</a></li>
                <!--Dynamic mainmenu-->
                @foreach ($mainsubmenus as $menuitem)
                                               
                    @foreach ($menuitem->mainmenu_sub as $maindata)
                                            
                        <li id="main-menu-link-content77a94666-a2a3-485e-b50a-eb254895c7e2" class="sf-depth-1 menuparent">
                            <a href="/index.php/brief-history"  class="sf-depth-1 menuparent" title="About">{{$maindata->title}}</a>                
                                <ul>
                                    @foreach($menuitem->sub_menu as $sub_menu)
                                                
                                        @foreach($sub_menu->submenusub as $subtitle)
                                             
                                            @if($sub_menu->menulinktype_id== 11)
                                                {{-- hashtag --}}
                                                <li id="main-menu-link-contenteb868c68-e201-4944-9cba-ad63939306af" class="sf-depth-2 sf-no-children">
                                                    <a href="#" class="sf-depth-2">
                                                        {{$subtitle['title']}}
                                                    </a>
                                                </li>
                                            @elseif($sub_menu->menulinktype_id == 12)
                                                {{-- url --}}
                                                <li id="main-menu-link-contenteb868c68-e201-4944-9cba-ad63939306af" class="sf-depth-2 sf-no-children">
                                                    <a href="{{$sub_menu->url}}" class="sf-depth-2">
                                                        {{$subtitle['title']}}
                                                    </a>
                                                </li>
                                            @elseif($sub_menu->menulinktype_id == 13)
                                                {{-- file --}}
                                                <li id="main-menu-link-contenteb868c68-e201-4944-9cba-ad63939306af" class="sf-depth-2 sf-no-children">
                                                    <a href="#" class="sf-depth-2">
                                                        {{$subtitle['title']}}
                                                    </a>
                                                </li>
                                            @elseif($sub_menu->menulinktype_id == 14)
                                                {{-- article --}}   
                                                @php $article_name =Str::slug(strtolower($subtitle['title']));
                                                $encryptedId = Crypt::encryptString($sub_menu['articletype_id']);
                                                @endphp
                                                <li id="main-menu-link-contenteb868c68-e201-4944-9cba-ad63939306af" class="sf-depth-2 sf-no-children">
                                                    <a href="{{ route('mainarticle',[$article_name,$encryptedId]) }}" class="sf-depth-2" value="{{$subtitle['id']}}">
                                                        {{$subtitle['title']}}
                                                    </a>
                                                </li>
                                            @endif 
                                        @endforeach    
                                                             
                                    @endforeach
                                </ul>  
                    @endforeach
                @endforeach  
            </li>      
           <!--Dynamic mainmenu-->
        </ul>
        </div>
    </div>
</div>