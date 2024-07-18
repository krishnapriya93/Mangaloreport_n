<!-- Start: Top widget -->
<div class="topwidget" id="topwidget">
    <div class="container">

        <div class="row topwidget-list clearfix">

            <div class="col-sm-12">
                <div class="region region-topwidget-first">
                    <div class="views-element-container mcblock block block-views block-views-blockminister-chairman-block-1" id="block-views-block-minister-chairman-block-1">


                        <div class="content">
                            <div>
                                <div class="js-view-dom-id-d6eccc1050946ec2945ce6a5789b82d920e7a4e727d0534c746a054fe5cfdbc6">

                                    <div class="item-list item-list--blazy item-list--blazy-grid">
                                        <ul class="blazy blazy--view blazy--view--minister-chairman blazy--view--minister-chairman--block-1 blazy--view--minister-chairman-block-block-1 blazy--grid block-grid block-count-3 small-block-grid-1 medium-block-grid-3 large-block-grid-3" data-blazy="" id="blazy-views-minister-chairman-block-block-1-2">

                                            @foreach ($bod as $bods)
                                            @foreach ($bods->bodsub as $bodsub)
                                            <li class="grid">
                                                <div class="grid__content">
                                                    <div class="views-field views-field-body">
                                                        <div class="field-content"><img alt="shipping-minister" data-entity-type="file" data-entity-uuid="52346b63-9af0-4d1b-9054-ba79e5495957" height="185" src="{{ asset('/assets/backend/uploads/bod/'.$bods->photo) }}" style="margin:30px auto 15px auto;" width="154" class="align-center" loading="lazy" /></div>
                                                    </div>
                                                    <div class="views-field views-field-title"><span class="field-content leadhead">{{ $bodsub->name }}</span></div>
                                                    <div class="views-field views-field-field-designation">
                                                        <div class="field-content leaddesig">{{ $bodsub->desig_id }}</div>
                                                    </div>
                                                    <div class="views-field views-field-field-file">
                                                        <div class="field-content">
                                                            <span class="file file--mime-application-pdf file--application-pdf">
                                                                <a href="sites/default/files/2024-06/Shri%20Sarbananda%20Sonawala.pdf" type="application/pdf" target="_blank" title="Shri Sarbananda Sonawala.pdf">View
                                                                    more</a></span>
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
<!--End: Top widget -->
