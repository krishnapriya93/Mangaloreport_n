<!--Start: Top Marquee -->
<div class="top-message circular" id="skmc">
    <div class="innr">
        <div class="marqueehead">
            <div class="region region-top-marqueehead">
                <div id="block-circulartradenotice"
                    class="circularhead block block-block-content block-block-content4f5d0dc3-fac6-4726-80c1-a6e8fc047413">

                    <img src="{{ asset('assets/frontend/images/notice.svg') }}" alt="">

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

                                            @foreach ($circulartrades as $circulartrade)
                                                @foreach ($circulartrade->publicrelsub as $publicrelsub)
                                                <li><span class="views-field views-field-title">
                                                    <span class="field-content">
                                                    <a href="/bad-weather-advisory-oil-terminal-berths-0" hreflang="en">{{ $publicrelsub->title }}</a></span></span>
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
        <div class="marqueeviewall">
            <div class="region region-top-marqueeviewall">
                <div id="block-circularviewall"
                    class="block block-block-content block-block-content210fd2f7-439d-4689-9930-71e9565548a3">
                    <div class="content">
                        <div
                            class="clearfix text-formatted field field--name-body field--type-text-with-summary field--label-hidden field__item">
                            <p class="mb-0"><a href="circular-tradenotice"
                                    title="Circular Trade Notice">View all</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End: Top Marquee -->
