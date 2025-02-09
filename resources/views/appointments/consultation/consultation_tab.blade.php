<div class="tab-pane fade show active" id="consultation" role="tabpanel">
    <div class="col-xl-12 col-md-12 col-sm-12">
        <div class="row">
            <div class="col-xl-3 col-md-3 col-sm-12 mb-20">
                <div class="card card-round p-3">
                    <div class="nav flex-column nav-pills nav-primary p-3" id="ver-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        <a class="nav-link active" id="ver-pills-home-tab" data-bs-toggle="pill" href="#ver-pills-home"
                            role="tab" aria-controls="ver-pills-home" aria-selected="true">General
                            Information</a>
                        <a class="nav-link" id="ver-pills-components-tab" data-bs-toggle="pill"
                            href="#ver-pills-components" role="tab" aria-controls="ver-pills-components"
                            aria-selected="false">Condition</a>
                        <a class="nav-link" id="ver-pills-pages-tab" data-bs-toggle="pill" href="#ver-pills-pages"
                            role="tab" aria-controls="ver-pills-pages" aria-selected="false">Medical
                            History</a>
                        <a class="nav-link" id="ver-pills-settings-tab" data-bs-toggle="pill" href="#ver-pills-settings"
                            role="tab" aria-controls="ver-pills-settings" aria-selected="false">Recommendation</a>
                    </div>

                </div>
            </div>

            <div class="col-xl-9 col-md-9 col-sm-12 mb-20">
                <div class="card card-round p-3">

                    <div class="tab-content" id="ver-pills-tabContent">

                        <div class="tab-pane fade active show" id="ver-pills-home" role="tabpanel"
                            aria-labelledby="ver-pills-home-tab">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-sm-12 border_rt_lt p-4">
                                    <input type="hidden" id="patient_id" value="{{ $patient_info->id }}">
                                    <ul class="user_wrapper2">
                                        <li><span><b>Sex :</b></span>
                                            <div class="col-md-12 position-relative">
                                                <select class="form-select" id="validationTooltip04" required="">
                                                    <option selected="" disabled="" value="">Choose...
                                                    </option>
                                                    <option>Male </option>
                                                    <option>Female </option>
                                                    <option>Other </option>
                                                </select>
                                            </div>
                                        </li>
                                        <li><span><b>Race:</b></span>
                                            <div class="col-md-12 position-relative">
                                                <select class="form-select" id="validationTooltip04" required="">
                                                    <option selected="" disabled="" value="">Choose...
                                                    </option>
                                                    <option>Male </option>
                                                    <option>Female </option>
                                                    <option>Other </option>
                                                </select>
                                            </div>
                                        </li>
                                        <li><span><b>DOB:</b></span>
                                            <input class="form-control" id="" type="date" placeholder="Type"
                                                required="">
                                        </li>
                                        <li><span><b>Height:</b></span>
                                            <input class="form-control" id="" type="text" placeholder="Type"
                                                required="">
                                        </li>
                                        <li><span><b>Weight</b></span>
                                            <input class="form-control" id="" type="text" placeholder="Type"
                                                required="">
                                        </li>
                                        <li><span><b>BMI:</b></span>
                                            <input class="form-control" id="" type="text" placeholder=""
                                                required="">
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-xl-6 col-md-6 col-sm-12 p-4">
                                    <input type="hidden" id="patient_id" value="{{ $patient_info->id }}">
                                    <ul class="user_wrapper2">
                                        <li><span><b>Source :</b></span>
                                            <div class="col-md-12 position-relative">
                                                <select class="form-select" id="validationTooltip04" required="">
                                                    <option selected="" disabled="" value="">Choose...
                                                    </option>
                                                    <option>Facebook </option>
                                                    <option>Google </option>
                                                    <option>Website </option>
                                                    <option>Other </option>
                                                </select>
                                            </div>
                                        </li>
                                        <li><span><b>Languages:</b></span>
                                            <div class="col-md-12 position-relative">
                                                <select class="form-select" id="validationTooltip04" required="">
                                                    <option selected="" disabled="" value="">Choose...
                                                    </option>
                                                    <option>English </option>
                                                    <option>Spanish </option>
                                                    <option>Other </option>
                                                </select>
                                            </div>
                                        </li>
                                        <li><span><b>Additional Information:</b></span>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="ver-pills-components" role="tabpanel"
                            aria-labelledby="ver-pills-components-tab">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12">
                                    <div class="card card-round">
                                        <div id="new_medical_history">
                                            <div class="card-header">
                                                <div class="pull-left">
                                                    <h4>Conditions</h4>
                                                </div>

                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="card-body">
                                                <div class="card card-round">
                                                    <form class="" id="medical_history_form" action=""
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="tab">
                                                            <div class="g-3">
                                                                <textarea id="mhContent" name="details" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="pull-right m-t-20">
                                                            <button id="add_note"
                                                                class="btn btn-primary add_medical_history"
                                                                style="width:200px" type="submit"
                                                                name="add_medical_history">Add</button>
                                                        </div>

                                                    </form>
                                                </div>

                                                <div class="general_note_wrapper  m-t-20">
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
                            </div>
                        </div>


                        <div class="tab-pane fade" id="ver-pills-pages" role="tabpanel"
                            aria-labelledby="ver-pills-pages-tab">
                            <div class="row">
                                <div class="col-xl-8 col-md-8 col-sm-12">
                                    <div class="card card-round">
                                        <div id="new_medical_history">
                                            <div class="card-header">
                                                <h4>Medical History</h4>
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
                                        <form class="" id="medical_history_form" action="" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="tab">
                                                <div class="row g-3">
                                                    <div class="col-sm-12">
                                                        <select class="form-control" name="type" required>
                                                            <option value="">Select Type</option>
                                                            @foreach ($medical_history_type as $mhtype)
                                                                <option value="{{ $mhtype->id }}">
                                                                    {{ $mhtype->type_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="patient_id"
                                                            value="{{ $patient_info->id }}">
                                                    </div>

                                                    <textarea id="mhContent" name="details" required></textarea>

                                                </div>
                                            </div>
                                            <div class="p-4">
                                                <div class="text-end">
                                                    <button id="add_note" class="btn btn-primary add_medical_history"
                                                        type="submit" name="add_medical_history">Add</button>
                                                </div>

                                            </div>
                                        </form>
                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="tab-pane fade" id="ver-pills-settings" role="tabpanel"
                            aria-labelledby="ver-pills-settings-tab">
                            <div class="row">
                                <div class="col-xl-8 col-md-8 col-sm-12">
                                    <div class="card card-round">
                                        <div id="new_medical_history">
                                            <div class="card-header">
                                                <h4>Recomandations</h4>
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
                                        <form class="" id="medical_history_form" action="" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="tab">
                                                <div class="row g-3">
                                                    <textarea id="mhContent" name="details" required></textarea>
                                                </div>
                                            </div>
                                            <div class="p-4">
                                                <div class="text-end">
                                                    <button id="add_note" class="btn btn-primary add_medical_history"
                                                        type="submit" name="add_medical_history">Add</button>
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
