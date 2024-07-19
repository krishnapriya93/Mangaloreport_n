<div class="col-md-6">
    <div class="region region-updates-first">
        <h2 class="title"><img src="{{ asset('/assets/frontend/images/auction.svg') }}" alt="">Tender</h2>
        <div class="tender views-element-container  block block-views block-views-blocktender-block-1"
            id="block-views-block-tender-block-1">
            <div class="content">
                <div>
                    <div class="js-view-dom-id-1e4f0a3d93bb5da4e47583d71de9e1d4fc7a757a9164aed6a3e6d2404c6e28e2">

                        <div class="skin-default">

                            <div id="views_slideshow_cycle_main_tender-block_1"
                                class="views_slideshow_cycle_main views_slideshow_main">
                                <div id="views_slideshow_cycle_teaser_section_tender-block_1"
                                    class="views_slideshow_cycle_teaser_section">

                                    @foreach ($tender as $tenders)
                                        @foreach ($tenders->tender_sub as $tender_sub)
                                            <div id="views_slideshow_cycle_div_tender-block_1_0"
                                                class="views_slideshow_cycle_slide views_slideshow_slide views-row-1 views-row-odd">
                                                <div class="views-row views-row-0 views-row-odd views-row-first">
                                                    <div class="views-field views-field-title">
                                                        <h4 class="field-content"><a
                                                                href="/programming-plc-unit-air-compressor-tug-iswari-0"
                                                                hreflang="en">{{ $tender_sub->title }}</a></h4>
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    @endforeach
                                    {{-- <div id="views_slideshow_cycle_div_tender-block_1_1"
                                        class="views_slideshow_cycle_slide views_slideshow_slide views-row-2 views_slideshow_cycle_hidden views-row-even">
                                        <div class="views-row views-row-1 views-row-even">
                                            <div class="views-field views-field-title">
                                                <h4 class="field-content"><a
                                                        href="/comprehensive-operation-and-maintenance-contract-2-nos-italgru-make-63-t-capacity-mobile-harbor"
                                                        hreflang="en">Comprehensive Operation
                                                        and
                                                        Maintenance contract for 2 Nos. Italgru
                                                        make, 63
                                                        T Capacity, Mobile Harbor Cranes (MHCs)
                                                        of NMPA,
                                                        for a period of 3 years.</a></h4>
                                            </div>
                                        </div>

                                    </div> --}}

                                    {{-- <div id="views_slideshow_cycle_div_tender-block_1_2"
                                        class="views_slideshow_cycle_slide views_slideshow_slide views-row-3 views_slideshow_cycle_hidden views-row-odd">
                                        <div class="views-row views-row-2 views-row-odd">
                                            <div class="views-field views-field-title">
                                                <h4 class="field-content"><a
                                                        href="/procurement-low-sulphur-high-flash-high-speed-diesel-lshf-hsd"
                                                        hreflang="en">Procurement of Low
                                                        Sulphur High
                                                        Flash High Speed Diesel (LSHF HSD)</a>
                                                </h4>
                                            </div>
                                        </div>

                                    </div> --}}

                                    {{-- <div id="views_slideshow_cycle_div_tender-block_1_3"
                                        class="views_slideshow_cycle_slide views_slideshow_slide views-row-4 views_slideshow_cycle_hidden views-row-even">
                                        <div class="views-row views-row-3 views-row-even">
                                            <div class="views-field views-field-title">
                                                <h4 class="field-content"><a
                                                        href="/partly-dismantling-and-re-construction-compound-wall-33kv-south-side-inside-wharf-area"
                                                        hreflang="en">PARTLY DISMANTLING AND
                                                        RE-
                                                        CONSTRUCTION OF COMPOUND WALL AT 33KV
                                                        SOUTH SIDE
                                                        INSIDE WHARF AREA.</a></h4>
                                            </div>
                                        </div>

                                    </div> --}}

                                    {{-- <div id="views_slideshow_cycle_div_tender-block_1_4"
                                        class="views_slideshow_cycle_slide views_slideshow_slide views-row-5 views_slideshow_cycle_hidden views-row-odd">
                                        <div
                                            class="views-row views-row-4 views-row-odd views-row-last">
                                            <div class="views-field views-field-title">
                                                <h4 class="field-content"><a
                                                        href="/providing-pvc-mesh-fencing-over-compound-wall-9th-avenue-door-no-2-9-9th-street-no-2-nmpa-colony"
                                                        hreflang="en">Providing PVC Mesh
                                                        fencing over
                                                        compound wall at 9th Avenue, Door No-2
                                                        &amp; 9,
                                                        9th Street No- 2 at NMPA Colony.</a>
                                                </h4>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <footer>
                            <a href="tenders">view all</a>
                        </footer>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
