  <div class="container">
            <div class="region region-highlighted">
                <div data-drupal-messages-fallback class="hidden"></div>
                <div class="views-element-container wwdo block block-views block-views-blocktop-home-icons-block-1"
                    id="block-views-block-top-home-icons-block-1">
                    <h2 class="title">What We Do</h2>
                    <div class="content">
                        <div>

                            <div class="js-view-dom-id-bfbf0f07125cd9ae4221b4218cfabf436996c1647b7974beeceed3e575ddd6e3">
                                <div class="item-list item-list--blazy item-list--blazy-grid">
                                    <ul class="blazy wedo blazy--view blazy--view--top-home-icons blazy--view--top-home-icons--block-1 blazy--view--top-home-icons-block-block-1 blazy--grid block-grid block-count-12 small-block-grid-2 medium-block-grid-3 large-block-grid-6"
                                        data-blazy="" id="blazy-views-top-home-icons-block-block-1-3">

                                        @foreach ($whatwedo as $whatwedos)

                                        @foreach ($whatwedos->link_sub as $whatwelink)

                                        <li class="grid">
                                           <div class="card">
                                            <a href="https://newmangaloreport.gov.in/eodb" target="_blank">
                                            <div class="grid__content">
                                                <div class="views-field views-field-field-link">
                                                    <img width="60" src="{{ asset('/assets/backend/uploads/Linkicon/'.$whatwedos->file) }}" alt="">
                                                    <div class="field-content">
                                                        <p>{{ $whatwelink['title'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
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
