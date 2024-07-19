<!-- Start: Related widget -->
<div class="relatetop" id="relatedtop">
    <div class="container">
        <div class="row topwidget-list clearfix">
            <div class=col-sm-12>
                <div class="region region-related-first">
                    <div class="views-element-container block block-views block-views-blockrelated-links-block-1"
                        id="block-views-block-related-links-block-1">
                        <div class="content">
                            <div>
                                <div
                                    class="js-view-dom-id-bbcd20bec521c18846491b8cb77c0bee0c7c40edc01ff4cd1c93ddd3a49e5f34">
                                    <div class="item-list item-list--blazy item-list--blazy-grid">
                                        <ul class="blazy blazy--view blazy--view--related-links blazy--view--related-links--block-1 blazy--view--related-links-block-block-1 blazy--grid block-grid block-count-16 small-block-grid-6 medium-block-grid-6 large-block-grid-6"
                                            data-blazy="" id="blazy-views-related-links-block-block-1-4">

                                            @foreach ($relatedlinks as $relatedlink)


                                            <li class="grid">
                                                <div class="grid__content">
                                                    <div class="views-field views-field-field-link">
                                                        <div class="field-content"><a
                                                                href="https://newmangaloreport.gov.in/ipos"
                                                                target="_blank"> <img
                                                                    src="{{ asset('/assets/backend/uploads/Linkicon/'.$relatedlink->file) }}"
                                                                    width="220" height="79"
                                                                    alt="Integreted Port Operating System"
                                                                    loading="lazy" typeof="Image"
                                                                    class="image-style-medium" />


                                                            </a></div>
                                                    </div>
                                                </div>
                                            </li>

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



        <!--End: Related widget -->
