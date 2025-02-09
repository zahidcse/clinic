<div class="tab-pane fade" id="appointment-notes" role="tabpanel">
    <div class="col-xl-12 col-md-12 col-sm-12">
        <div class="row">
            <div class="col-xl-3 col-md-3 col-sm-12 mb-20">
                <div class="card card-round p-3">
                    <div class="nav flex-column nav-pills nav-primary p-3" id="ver-pills-tab2" role="tablist"
                        aria-orientation="vertical">
                        <a class="nav-link active" id="ver-pills-components-tab2" data-bs-toggle="pill"
                            href="#ver-pills-components2" role="tab" aria-controls="ver-pills-components"
                            aria-selected="false">Vitals</a>
                        <a class="nav-link" id="ver-pills-pages-tab2" data-bs-toggle="pill" href="#ver-pills-pages2"
                            role="tab" aria-controls="ver-pills-pages" aria-selected="false">Diagram
                            Identification</a>
                        <a class="nav-link" id="ver-pills-settings-tab2" data-bs-toggle="pill"
                            href="#ver-pills-settings2" role="tab" aria-controls="ver-pills-settings"
                            aria-selected="false">Appointment Notes
                        </a>
                    </div>

                </div>

            </div>

            <div class="col-xl-9 col-md-9 col-sm-12 mb-20">
                <div class="card card-round p-3">

                    <div class="tab-content" id="ver-pills-tabContent2">

                        <div class="tab-pane fade active show" id="ver-pills-components2" role="tabpanel"
                            aria-labelledby="ver-pills-components-tab2">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-sm-12 border_rt_lt p-4">
                                    <input type="hidden" id="patient_id" value="{{ $patient_info->id }}">
                                    <ul class="user_wrapper2">
                                        <li><span><b>Blood Pressure :</b></span>
                                            <div class="col-md-12 position-relative">
                                                <input class="form-control" id="" type="text"
                                                    required="">
                                            </div>
                                        </li>
                                        <li><span><b>Pulse:</b></span>
                                            <div class="col-md-12 position-relative">
                                                <input class="form-control" id="" type="text"
                                                    required="">
                                            </div>
                                        </li>
                                        <li><span><b>Respiration:</b></span>
                                            <input class="form-control" id="" type="text" required="">
                                        </li>
                                        <li><span><b>Temparature:</b></span>
                                            <input class="form-control" id="" type="text" required="">
                                        </li>
                                        <li><span><b>Oxygen Saturation</b></span>
                                            <input class="form-control" id="" type="text" required="">
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-xl-6 col-md-6 col-sm-12 p-4">
                                    <input type="hidden" id="patient_id" value="{{ $patient_info->id }}">
                                    <ul class="user_wrapper2">
                                        <li><span><b>Height :</b></span>
                                            <div class="col-md-12 position-relative">
                                                <input class="form-control" id="" type="text"
                                                    required="">
                                            </div>
                                        </li>
                                        <li><span><b>Weight:</b></span>
                                            <div class="col-md-12 position-relative">
                                                <input class="form-control" id="" type="text"
                                                    required="">
                                            </div>
                                        </li>
                                        <li><span><b>BMI:</b></span>
                                            <div class="col-md-12 position-relative">
                                                <input class="form-control" id="" type="text"
                                                    required="">
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="ver-pills-pages2" role="tabpanel"
                            aria-labelledby="ver-pills-pages-tab2">
                            <div class="row daiagram_identification">

                                <div
                                    class="col-xl-6 col-md-6 col-sm-12 border b-primary border-1 rounded custom-width-col6 card card-round p-3">
                                    <div class="d-flex justify-content-between m-b-30">
                                        <div class="m-t-20">
                                            <a href="#">
                                                <button class="btn btn-pill btn-primary-gradien btn-air-primary"
                                                    type="button" title="">Draw</button>
                                            </a>
                                        </div>

                                        <div class="m-t-20">
                                            <a href="#">
                                                <button class="btn btn-pill btn-primary-gradien btn-air-primary"
                                                    type="button" title="">Circle</button>
                                            </a>
                                        </div>

                                        <div class="m-t-20">
                                            <a href="#">
                                                <button class="btn btn-pill btn-primary-gradien btn-air-primary"
                                                    type="button" title="">Line</button>
                                            </a>
                                        </div>

                                    </div>
                                    <div>image</div>
                                </div>

                                <div
                                    class="col-xl-3 col-md-3 col-sm-12 border b-primary border-1 rounded custom-width-col3 card card-round p-3">
                                    <div class="m-t-20 text-center">
                                        <a href="#">
                                            <button class="btn btn-pill btn-primary-gradien btn-air-primary"
                                                type="button" title="">Add</button>
                                        </a>
                                    </div>
                                </div>

                                <div
                                    class="col-xl-3 col-md-3 col-sm-12 border b-primary border-1 rounded custom-width-col3 card card-round p-3">
                                    <div class="m-t-20 text-center">
                                        <a href="#">
                                            <button class="btn btn-pill btn-primary-gradien btn-air-primary"
                                                type="button" title="">Completed</button>
                                        </a>
                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="tab-pane fade" id="ver-pills-settings2" role="tabpanel"
                            aria-labelledby="ver-pills-settings-tab2">
                            <div class="row">
                                <div class="col-xl-8 col-md-8 col-sm-12">
                                    <div class="card card-round">
                                        <div id="">
                                            <div class="card-header">
                                                <h4>Appointments Notes</h4>
                                            </div>
                                            <div class="card-body align-items-center">
                                                <div class="general_note_wrapper">
                                                    <div class="pull-right">
                                                        <a class="">
                                                            <span class="text-primary">Edit</span>
                                                        </a>
                                                        <a class="">
                                                            <span class="text-danger">Delete</span>
                                                        </a>
                                                    </div>
                                                    <ul>
                                                        <li>Date:
                                                            <b>18/01/2025</b>
                                                        </li>
                                                        <li class="">Author:
                                                            <b>Test Author</b>
                                                        </li>
                                                        <li class="mb-10">Edited By:
                                                            <b>Test Author</b>
                                                        </li>
                                                        <br>
                                                        <div class="content-wrapper">
                                                            The patient is a 45-year-old male presenting with complaints
                                                            of intermittent chest pain radiating to the left arm,
                                                            accompanied by shortness of breath and fatigue over the
                                                            pas.
                                                        </div>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-4 col-sm-12 general_note_wrapper">
                                    <div class="card card-round column-text-center text-center">
                                        <form class="" id="appointment_note_form" action=""
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="tab">
                                                <div class="row g-3">
                                                    <div class="col-sm-12">
                                                        <input type="hidden" id="appointment_id"
                                                            name="appointment_id" value="{{ $appointment_info->id }}">
                                                        <input type="hidden" name="patient_id"
                                                            value="{{ $patient_info->id }}">
                                                    </div>

                                                    <textarea id="summernote" name="note" required></textarea>

                                                </div>
                                            </div>
                                            <div class="p-4">
                                                <div class="text-end">
                                                    <button id="add_note" class="btn btn-primary add_note"
                                                        type="submit" name="add_note">Add</button>
                                                </div>

                                            </div>
                                        </form>
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
