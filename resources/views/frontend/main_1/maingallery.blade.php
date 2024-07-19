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
                                                      {{-- <div id="views_slideshow_cycle_div_gallery-block_1_0" class="views_slideshow_cycle_slide views_slideshow_slide views-row-1 views-row-odd">
                                                          <div class="views-row views-row-0 views-row-odd views-row-first">
                                                              <div class="views-field views-field-field-image">
                                                                  <div class="field-content">
                                                                    <a href="/celebration-133rd-birthday-bharath-ratna-drbr-ambedkar-14042024-nmpa"><img
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

                                                      </div> --}}
                                                      @foreach ($gallery as $gallerys)
                                                          @foreach ($gallerys->gallery_sub as $gallery_sub)
                                                              <div id="views_slideshow_cycle_div_gallery-block_1_1"
                                                                  class="views_slideshow_cycle_slide views_slideshow_slide views-row-2 views_slideshow_cycle_hidden views-row-even">
                                                                  <div class="views-row views-row-1 views-row-even">
                                                                      <div class="views-field views-field-field-image">
                                                                          <div class="field-content">
                                                                             <a href="/seven-seas-mariner-6th-cruise-ship-arrived-new-mangalore-port-31032024">
                                                                                  <img src="{{ asset('/assets/backend/uploads/Gallerymain/'.$gallerys->file) }}"
                                                                                      alt="" loading="lazy"
                                                                                      typeof="foaf:Image"
                                                                                      class="image-style-gallery" />

                                                                              </a>
                                                                          </div>
                                                                      </div>
                                                                      <div class="views-field views-field-title"><span
                                                                              class="field-content">&quot;{{ $gallery_sub->title  }}&quot;.</span>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                          @endforeach
                                                      @endforeach


                                                      {{-- <div id="views_slideshow_cycle_div_gallery-block_1_2"
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

                                                      </div> --}}

                                                      {{-- <div id="views_slideshow_cycle_div_gallery-block_1_3"
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

                                                      </div> --}}

                                                      {{-- <div id="views_slideshow_cycle_div_gallery-block_1_4"
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

                                                      </div> --}}

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
                                                                  title="YouTube video player" width="560"></iframe>
                                                          </p>
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
                                                                  title="YouTube video player" width="560"></iframe>
                                                          </p>
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
                                                                  title="YouTube video player" width="560"></iframe>
                                                          </p>
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
