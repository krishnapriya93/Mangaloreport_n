 <!-- Start: Middle widgets -->
 <div class="midwidget" id="midwidget">
     <div class="container">
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
                                             @foreach ($midwidget as $midwidgets)
                                                 @foreach ($midwidgets->link_sub as $link_sub)
                                                     <li class="grid">
                                                         <img class="bg"
                                                             src="{{ asset('/assets/frontend/images/banner-bg-02.png') }}"
                                                             alt="">
                                                         <div class="grid__content">
                                                             <div class="views-field views-field-body">
                                                                 <p>{{ $link_sub->title }}</p>
                                                             </div>
                                                             <div class="views-field views-field-field-text">
                                                                 <div class="field-content text">{{  $link_sub->alternatetext }}
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </li>
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
 </div>
 <!--End: Middle widgets -->
