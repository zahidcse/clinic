<div class="tab-pane fade" id="intake" role="tabpanel">
    <div class="col-xl-12 col-md-12 col-sm-12">
        <div class="row">

            <div class="col-xl-9 col-md-9 col-sm-12 mb-20">
                <div class="card card-round p-3">
                    <div class="blog-box blog-list row">
                        <div class="col-sm-3"><img class="img-fluid sm-100-w" src="../assets/images/faq/1.jpg"
                                alt=""></div>
                        <div class="col-sm-9">
                            <div class="blog-details">
                                <div class="blog-date"><span>05</span> January 2024</div>
                                <h4>Form: Stem Cell Intake </h4>
                                <div class="blog-bottom-content">
                                    <ul class="blog-social">
                                        <li>Status:</li>
                                        <li>Signed</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="blog-box blog-list row">
                        <div class="col-sm-3"><img class="img-fluid sm-100-w" src="../assets/images/faq/1.jpg"
                                alt=""></div>
                        <div class="col-sm-9">
                            <div class="blog-details">
                                <div class="blog-date"><span>05</span> January 2024</div>
                                <h4>Form: Stem Cell Intake </h4>
                                <div class="blog-bottom-content">
                                    <ul class="blog-social">
                                        <li>Status:</li>
                                        <li>Signed</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="blog-box blog-list row">
                        <div class="col-sm-3"><img class="img-fluid sm-100-w" src="../assets/images/faq/1.jpg"
                                alt=""></div>
                        <div class="col-sm-9">
                            <div class="blog-details">
                                <div class="blog-date"><span>05</span> January 2024</div>
                                <h4>Form: Stem Cell Intake </h4>
                                <div class="blog-bottom-content">
                                    <ul class="blog-social">
                                        <li>Status:</li>
                                        <li>Signed</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>

            <div class="col-xl-3 col-md-3 col-sm-12 mb-20">

                <div class="card card-round p-3">
                    <div class="d-flex justify-content-between m-b-30">
                        <div class="m-t-20">
                            <a class="btn btn-pill btn-outline-primary btn-air-primary" onclick="loadConsentFormModal()">Upload</a>
                        </div>

                        <div class="m-t-20">
                            <a href="#">
                                <button class="btn btn-pill btn-primary-gradien btn-air-primary" type="button"
                                    title="">Choose</button>
                            </a>
                        </div>

                    </div>
                    @php $consent_form_ids = []; @endphp
                    <div class="consent-all-list">
                        @foreach($consent_history_user as $consent_history)
                            @php $consent_form_ids[] = isset($consent_history->user_consent_form->form_id)?$consent_history->user_consent_form->form_id:''  @endphp
                            <div class="d-block text-left m-t-20">
                                <div class="btn btn-outline-primary d-block text-left txt-dark {{ isset($consent_history->user_consent_form->form_id)?'selected':'' }}">
                                    {{ $consent_history->title }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @php
                        $consent_form_ids = implode(",",array_filter($consent_form_ids));
                    @endphp



                    <div class="d-flex m-t-30 justify-content-end">
                        <input type="hidden" id="consent_form_ids" value="{{ $consent_form_ids }}">
                        <input type="hidden" id="patient_id" value="{{ $patient_info->patient_id }}">
                        <a class="btn btn-primary" onclick="updateuserConsentForm()">Add</a>
                    </div>
                </div>


            </div>



        </div>

    </div>
</div>
