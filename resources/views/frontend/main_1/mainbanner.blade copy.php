<!--Start: Top Message -->
<div class="top-message">
    <div class="">
        <div class="region region-top-message">
            <div class="views-element-container block block-views block-views-blockhome-slideshow-block-1" id="block-views-block-home-slideshow-block-1">
                <div class="content">
                    <div>
                        <div class="topslidetext js-view-dom-id-ceb4b44f4940d8f0e1168f5863a28987e4d9602e8e967f9448f4005fb13fa162">
                            <div>
                                <div id="flexslider-1" class="flexslider optionset-default">
                                <!-- <div id="app" class="headertext"></div> -->

                                 @foreach($mainbanner as $mainbannerdetails)
                                 @foreach($mainbannerdetails->banner_sub as $banner_sub)
                                    <ul class="slides">
                                        <li>
                                            <div class="views-field views-field-field-image">
                                                <div class="field-content">
                                                    <img src="{{ asset('/assets/backend/uploads/banner/'.$banner_sub->poster) }}" width="1920" height="640" alt="banner2"  />
                                                 </div>

                                            </div>
                                            <div class="views-field views-field-field-description">
                                                <div class="field-content"></div>
                                                </div>
                                        </li>
                                    </ul>
                                    @endforeach
                                    @endforeach
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
