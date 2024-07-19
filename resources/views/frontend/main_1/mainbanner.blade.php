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
                                        @foreach($mainbanner as $mainbannerdetails)
                                        @foreach($mainbannerdetails->banner_sub as $banner_sub)
                                         <ul class="slides">

                                             <li>
                                                 <div class="views-field views-field-field-image">
                                                     <div class="field-content"> <img
                                                             src="{{ asset('/assets/backend/uploads/banner/'.$banner_sub->poster) }}"
                                                             width="1920" height="640" alt="Ship" loading="lazy"
                                                             typeof="foaf:Image" class="image-style-front-slideshow" />
                                                     </div>
                                                 </div>
                                                 <div class="views-field views-field-field-description">
                                                     <div class="field-content"></div>
                                                 </div>
                                             </li>
                                             {{-- <li>
                                                 <div class="views-field views-field-field-image">
                                                     <div class="field-content"> <img
                                                             src="./sites/default/files/styles/front_slideshow/public/2021-06/banner55.jpg?itok=SV_MpTif"
                                                             width="1920" height="640" alt="Port" loading="lazy"
                                                             typeof="foaf:Image" class="image-style-front-slideshow" />
                                                     </div>
                                                 </div>
                                                 <div class="views-field views-field-field-description">
                                                     <div class="field-content"></div>
                                                 </div>
                                             </li>
                                             <li>
                                                 <div class="views-field views-field-field-image">
                                                     <div class="field-content"> <img
                                                             src="./sites/default/files/styles/front_slideshow/public/2021-06/banner4.jpg?itok=6eINXoFf"
                                                             width="1920" height="640" alt="Ship" loading="lazy"
                                                             typeof="foaf:Image" class="image-style-front-slideshow" />


                                                     </div>
                                                 </div>
                                                 <div class="views-field views-field-field-description">
                                                     <div class="field-content"></div>
                                                 </div>
                                             </li>
                                             <li>
                                                 <div class="views-field views-field-field-image">
                                                     <div class="field-content"> <img
                                                             src="./sites/default/files/styles/front_slideshow/public/2021-06/banner3a.jpg?itok=RJZCcgKV"
                                                             width="1920" height="640" alt="Ship" loading="lazy"
                                                             typeof="foaf:Image" class="image-style-front-slideshow" />
                                                     </div>
                                                 </div>
                                                 <div class="views-field views-field-field-description">
                                                     <div class="field-content"></div>
                                                 </div>
                                             </li>
                                             <li>
                                                 <div class="views-field views-field-field-image">
                                                     <div class="field-content"> <img
                                                             src="./sites/default/files/styles/front_slideshow/public/2022-08/pic1.jpg?itok=_ji2R0yx"
                                                             width="1920" height="640" alt="NMPA" loading="lazy"
                                                             typeof="foaf:Image" class="image-style-front-slideshow" />
                                                     </div>
                                                 </div>
                                                 <div class="views-field views-field-field-description">
                                                     <div class="field-content"></div>
                                                 </div>
                                             </li>
                                             <li>
                                                 <div class="views-field views-field-field-image">
                                                     <div class="field-content"> <img
                                                             src="./sites/default/files/styles/front_slideshow/public/2022-08/pic2a.jpg?itok=h1ea8zcG"
                                                             width="1920" height="640" alt="NMPA" loading="lazy"
                                                             typeof="foaf:Image" class="image-style-front-slideshow" />
                                                     </div>
                                                 </div>
                                                 <div class="views-field views-field-field-description">
                                                     <div class="field-content"></div>
                                                 </div>
                                             </li> --}}
                                         @endforeach
                                         @endforeach
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
