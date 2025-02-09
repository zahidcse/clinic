@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/toastr/toastr.min.css') }}" rel="stylesheet">
    <style>
        .appointment_note_scroll {
            height: 475px;
            overflow-y: auto;
        }

        .read-more-link {
            color: #7d33ff;
            /* Primary color */
            font-size: 16px;
            text-decoration: none;
            cursor: pointer;
            transition: color 0.3s ease, text-shadow 0.3s ease;
        }

        .read-more-link:hover {
            color: #0056b3;
            /* Darker shade on hover */
            text-shadow: 0px 1px 5px rgba(0, 0, 0, 0.2);
            /* Glow effect */
        }

        .read-more-link:active {
            color: #003f88;
            /* Even darker shade on click */
        }

        .nav-tabs .nav-link.active {
            /* background-color: #7d33ff; */
            color: #003f88;
            border-radius: 15px;
            border-color: #7d33ff;
            margin-bottom: 5px;
        }

        .nav-tabs .nav-link {
            color: #003f88;
            transition: background-color 0.3s, color 0.3s;
        }

        .nav-tabs .nav-link:hover {
            color: #000;
            background-color: #e9ecef;
        }

        @media (max-width: 992px) {
            .nav-tabs {
                justify-content: center;
            }

            .nav-tabs .nav-item {
                display: flex;
                justify-content: center;
            }
        }
    </style>
@endsection
@section('content')
    <!-- Header Title -->

    <div class="card-header">
        <div class="col-xl-12 col-md-12 col-sm-12">
            <div class="row">
                <div class="col-xl-9 col-md-6 col-sm-12">
                    <h4 class="mb-3">Appointment Details</h4>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12 text-end">
                    <a href="{{ URL::previous() }}">
                        <button class="btn btn-primary" type="button" data-bs-toggle="tooltip"
                            data-bs-original-title="btn btn-primary btn-lg">Back</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Title End -->
    <!-- Body Start  -->
    <div class="edit-profile mb-15">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12">
                <div class="card card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12">
                                <div class="row">
                                    <div class="col-xl-4 col-md-4 col-sm-12 border_rt_lt">
                                        <input type="hidden" id="patient_id" value="{{ $patient_info->id }}">
                                        <ul class="user_wrapper2">
                                            <li><span><b>Appointment ID:</b> {{ $appointment_info->id }}</span></li>
                                            <li><span><b>Appointment Title:</b>
                                                    Phone Consultation</span>
                                            </li>
                                            <li><span><b>Date & Time:</b> {{ $formatted_date_time }}</span></li>
                                            <li><span><b>Provider:</b>
                                                    {{ $doctor_info->name }}</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-xl-4 col-md-4 col-sm-12">

                                        <ul class="user_wrapper">
                                            <a href="{{ url('patient-details/' . $patient_info->id) }}">
                                                <li>
                                                    <span
                                                        class="user_info_icon"></span><span>{{ $patient_info->name }}</span>

                                                </li>
                                            </a>
                                            <li><span class="sms_info_icon"></span><span>{{ $patient_info->email }}</span>
                                            </li>
                                            <li><span
                                                    class="phn_info_icon"></span><span>{{ $patient_info->phone ?? 'N/A' }}</span>
                                            </li>
                                            <li><span class="map_info_icon"></span>
                                                <span>
                                                    {{ $patient_info->address ? $patient_info->address . ',' : '' }}
                                                    {{ $patient_info->state ? $patient_info->state . ',' : '' }}{{ $patient_info->city ? $patient_info->city . ',' : '' }}
                                                    {{ $patient_info->zip ? $patient_info->zip : '' }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>


                <div class="row mt-20 profile_notes_wrapper">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <div class="row">
                            <div class="col-xl-8 col-md-8 col-sm-12 mb-20">
                                <div class="card card-round p-3">
                                    {{-- <div class="card-header">
                                        <h4>Appoinments Notes</h4>
                                    </div>
                                    <div class="card-body align-items-left text-left appointment_note_scroll appNote">

                                    </div> --}}
                                    <div class="tabs-container">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" id="mh"
                                                    href="#medical-history" role="tab">Medical History</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" id="rc"
                                                    href="#recommendation" role="tab">Recommendation</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" id="an"
                                                    href="#appointment-notes" role="tab">Appointment Notes</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <!-- Medical History Tab -->
                                            <div class="tab-pane fade show active" id="medical-history" role="tabpanel">
                                                <div class="card-header">
                                                    <div class="row g-3">
                                                        <div class="col-xl-4 col-md-4 col-sm-12">
                                                            <select id="medical_history_type" class="form-control"
                                                                name="medical_history_type" required>
                                                                <option value="">All Types</option>
                                                                @foreach ($medical_history_type as $mhtype)
                                                                    <option value="{{ $mhtype->id }}">
                                                                        {{ $mhtype->type_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div
                                                    class="card-body align-items-left text-left appointment_note_scroll medicalHistory">

                                                </div>
                                            </div>

                                            <!-- Recommendation Tab -->
                                            <div class="tab-pane fade" id="recommendation" role="tabpanel">
                                                <div class="card-header">
                                                </div>
                                                <div
                                                    class="card-body align-items-left text-left appointment_note_scroll recomandations">

                                                </div>
                                            </div>

                                            <!-- Appointment Notes Tab -->
                                            <div class="tab-pane fade" id="appointment-notes" role="tabpanel">
                                                <div class="card-header">
                                                </div>
                                                <div
                                                    class="card-body align-items-left text-left appointment_note_scroll appNote">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 col-sm-12 mb-20">
                                <div class="card card-round">
                                    <div id="new_medical_history">
                                        <div class="card-header">
                                            <h4>New Medical History</h4>
                                        </div>
                                        <div class="card-body align-items-center">
                                            <div class="general_note_wrapper mb-20">
                                                <form class="" id="medical_history_form" action="" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="tab">
                                                        <div class="row g-3">
                                                            <div class="col-sm-12">
                                                                <label for="name">Type</label><span
                                                                    class="txt-danger">*</span>
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
                                                            <button id="add_note"
                                                                class="btn btn-primary add_medical_history" type="submit"
                                                                name="add_medical_history">Add</button>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                    <div id="new_recomandation" style="display: none;">
                                        <div class="card-header">
                                            <h4>New Recomandation</h4>
                                        </div>
                                        <div class="card-body align-items-center">
                                            <div class="general_note_wrapper mb-20">
                                                <form class="" id="recomandation_form" action=""
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="tab">
                                                        <div class="row g-3">
                                                            <div class="col-sm-12">
                                                                <input type="hidden" name="patient_id"
                                                                    value="{{ $patient_info->id }}">
                                                            </div>

                                                            <textarea id="recom" name="recomandation" required></textarea>

                                                        </div>
                                                    </div>
                                                    <div class="p-4">
                                                        <div class="text-end">
                                                            <button id="add_recomandation"
                                                                class="btn btn-primary add_recomandation" type="submit"
                                                                name="add_recomandation">Add</button>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                    <div id="new_appointment_note" style="display: none;">
                                        <div class="card-header">
                                            <h4>New Appointment Note</h4>
                                        </div>
                                        <div class="card-body align-items-center">
                                            <div class="general_note_wrapper mb-20">
                                                <form class="" id="appointment_note_form" action=""
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="tab">
                                                        <div class="row g-3">
                                                            <div class="col-sm-12">
                                                                <input type="hidden" id="appointment_id"
                                                                    name="appointment_id"
                                                                    value="{{ $appointment_info->id }}">
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
    </div>

    <!-- Body End -->
    <!-- delete modal -->
    <div class="modal fade" id="medicalHistoryDeleteModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Would you like to delete this medical history?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    <button type="button" id="modal_confirm_delete_medical_history" class="btn btn-success">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="recomandationDeleteModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Would you like to delete this recomandation?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    <button type="button" id="modal_confirm_delete_recomandation" class="btn btn-success">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Would you like to delete this note?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    <button type="button" id="modal_confirm_delete" class="btn btn-success">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- update modal -->
    <div class="modal fade" id="tooltipmodalMhEdit" tabindex="-1" data-bs-backdrop="static" role="dialog"
        aria-labelledby="tooltipmodalMhEdit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Medical History</h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="" id="update_medical_history_form" action="" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="tab">
                            <div class="row g-3 mb-2">
                                <select class="form-control" name="type" required>
                                    <option value="">Select Type</option>
                                    @foreach ($medical_history_type as $mhtype)
                                        <option value="{{ $mhtype->id }}">
                                            {{ $mhtype->type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row g-3">
                                <textarea id="mhContentEdit" name="details" required></textarea>
                                <input type="hidden" id="medical_history_id" name="medical_history_id" value="">
                            </div>
                        </div>
                </div>
                <div class="p-4">
                    <div class="pull-left">

                    </div>
                    <div class="text-end pull-right">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button id="update_medical_history" class="btn btn-primary update_medical_history" type="submit"
                            name="update_medical_history">Update</button>
                    </div>

                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="tooltipmodalRcEdit" tabindex="-1" data-bs-backdrop="static" role="dialog"
        aria-labelledby="tooltipmodalRcEdit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Recomandation</h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="" id="update_recomandation_form" action="" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="tab">
                            <div class="row g-3">
                                <textarea id="recomEdit" name="recomandation" required></textarea>
                                <input type="hidden" id="recomandation_id" name="recomandation_id" value="">
                            </div>
                        </div>
                </div>
                <div class="p-4">
                    <div class="pull-left">

                    </div>
                    <div class="text-end pull-right">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button id="update_recomandation" class="btn btn-primary update_recomandation" type="submit"
                            name="update_recomandation">Update</button>
                    </div>

                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="tooltipmodal" tabindex="-1" data-bs-backdrop="static" role="dialog"
        aria-labelledby="tooltipmodal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Note</h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="" id="update_note_form" action="" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="tab">
                            <div class="row g-3">
                                <textarea id="updateNote" name="new_note" required></textarea>
                                <input type="hidden" id="appointment_note_id" name="appointment_note_id"
                                    value="">
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="pull-left">

                            </div>
                            <div class="text-end pull-right">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                <button id="update_note" class="btn btn-primary update_note" type="submit"
                                    name="update_note">Update</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('assets/toastr/toastr.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote,#updateNote').summernote({
                placeholder: 'Write appointment note here',
                tabsize: 2,
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear', 'italic']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            $('#mhContent, #mhContentEdit').summernote({
                placeholder: 'Write medical history',
                tabsize: 2,
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
            $('#recom, #recomEdit').summernote({
                placeholder: 'Write recomandation',
                tabsize: 2,
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });


            // Hide all divs initially
            $('#new_medical_history #new_recomandation, #new_appointment_note').hide();

            // Show the corresponding div when a tab is clicked
            $('#mh').on('click', function() {
                console.log('medical history');
                $('#new_medical_history').show();
                $('#new_recomandation, #new_appointment_note').hide();
            });

            $('#rc').on('click', function() {
                $('#new_recomandation').show();
                $('#new_medical_history, #new_appointment_note').hide();
            });

            $('#an').on('click', function() {
                $('#new_appointment_note').show();
                $('#new_medical_history, #new_recomandation').hide();
            });

        });

        function successMessage(message) {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": 3000,
                "extendedTimeOut": 0,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "tapToDismiss": false
            }
            toastr.success(message, 'Success');
        }

        function errorMessage(message) {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": 4000,
                "extendedTimeOut": 0,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "tapToDismiss": false
            }
            toastr.error(message, 'Error');
        }

        loadMedicalHistory(type = "");
        loadRecomandation();
        loadAppointmentNotes();

        function loadMedicalHistory(type = "") {
            $('.medicalHistory').empty();
            var holder = {
                patient_id: $('#patient_id').val(),
                medical_history_type: type
            };
            console.log(holder);
            holdload = true;
            $.ajax({
                url: "{{ url('/appointment-load-medical-history') }}",
                type: "GET",
                data: holder,
                dataType: "json",
                beforeSend: function() {
                    $('.medicalHistory').html('<p>Loading....</p>');
                },
                success: function(data) {
                    $('.medicalHistory').empty();
                    $('.medicalHistory').append(data.content);
                }
            })
        }

        function loadRecomandation() {
            $('.recomandations').empty();
            var holder = {
                patient_id: $('#patient_id').val()
            };
            console.log(holder);
            holdload = true;
            $.ajax({
                url: "{{ url('/appointment-load-recomandation') }}",
                type: "GET",
                data: holder,
                dataType: "json",
                beforeSend: function() {
                    $('.recomandations').html('<p>Loading....</p>');
                },
                success: function(data) {
                    $('.recomandations').empty();
                    $('.recomandations').append(data.content);
                }
            })
        }

        function loadAppointmentNotes() {
            $('.appNote').empty();
            var holder = {
                appointment_id: $('#appointment_id').val()
            };
            console.log(holder);
            holdload = true;
            $.ajax({
                url: "{{ url('/load-appointment-notes') }}",
                type: "GET",
                data: holder,
                dataType: "json",
                beforeSend: function() {
                    $('.appNote').html('<p>Loading....</p>');
                },
                success: function(data) {
                    $('.appNote').empty();
                    $('.appNote').append(data.content);
                }
            })
        }

        function toggleContent() {
            const preview = document.querySelector('.content-preview');
            const fullContent = document.querySelector('.content-full');
            const button = document.querySelector('.read-more-link');

            if (fullContent.style.display === 'none') {
                fullContent.style.display = 'block';
                preview.style.display = 'none';
                button.textContent = 'Read Less';
            } else {
                fullContent.style.display = 'none';
                preview.style.display = 'block';
                button.textContent = 'Read More';
            }
        }

        $('#medical_history_form').on('submit', function(e) {
            e.preventDefault();

            var _token = $("input[name='_token']").val();
            const formData = new FormData(this);

            $.ajax({
                url: "{{ url('/save-medical-history') }}",
                type: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.add_medical_history').prop('disabled', true).text('Adding...');
                },
                complete: function() {
                    $('.add_medical_history').prop('disabled', false).text('Add');
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        $('#medical_history_form')[0].reset();
                        $('#mhContent').summernote('code', '');
                        loadMedicalHistory();

                        successMessage(data.success);
                    } else {
                        errorMessage(data.error);
                    }
                },
                error: function(error) {
                    console.log(error);
                    $('.add_medical_history').prop('disabled', false).text('Add');
                    errorMessage(error);
                }
            });

        });

        $('#recomandation_form').on('submit', function(e) {
            e.preventDefault();

            var _token = $("input[name='_token']").val();
            const formData = new FormData(this);

            $.ajax({
                url: "{{ url('/save-recomandation') }}",
                type: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.add_recomandation').prop('disabled', true).text('Adding...');
                },
                complete: function() {
                    $('.add_recomandation').prop('disabled', false).text('Add');
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        $('#recomandation_form')[0].reset();
                        $('#recom').summernote('code', '');
                        loadRecomandation();

                        successMessage(data.success);
                    } else {
                        errorMessage(data.error);
                    }
                },
                error: function(error) {
                    console.log(error);
                    $('.add_recomandation').prop('disabled', false).text('Add');
                    errorMessage(error);
                }
            });

        });

        $('#appointment_note_form').on('submit', function(e) {
            e.preventDefault();

            var _token = $("input[name='_token']").val();
            const formData = new FormData(this);

            $.ajax({
                url: "{{ url('/save-appointment-note') }}",
                type: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.add_note').prop('disabled', true).text('Adding...');
                },
                complete: function() {
                    $('.add_note').prop('disabled', false).text('Add Note');
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        successMessage(data.success);
                        $('#appointment_note_form')[0].reset();
                        loadAppointmentNotes();
                    } else {
                        errorMessage(data.error);
                    }
                },
                error: function(error) {
                    console.log(error);
                    $('.add_note').prop('disabled', false).text('Add');
                    errorMessage(error);
                }
            });

        });

        function loadMedicalHistoryDeleteModal(id) {
            $('#modal_confirm_delete_medical_history').attr('onclick', `confirmDeleteMedicalHistory(${id})`);
            $('#medicalHistoryDeleteModal').modal('show');
        }

        function loadRecomandationDeleteModal(id) {
            $('#modal_confirm_delete_recomandation').attr('onclick', `confirmDeleteRecomandation(${id})`);
            $('#recomandationDeleteModal').modal('show');
        }

        function loadDeleteModal(id) {
            $('#modal_confirm_delete').attr('onclick', `confirmDelete(${id})`);
            $('#deleteModal').modal('show');
        }

        function confirmDeleteMedicalHistory(id) {
            $.ajax({
                url: "{{ url('delete-medical-history') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'id': id,
                },
                beforeSend: function() {
                    $('#modal_confirm_delete_medical_history').prop('disabled', true).text('Deleting...');
                },
                complete: function() {
                    $('#modal_confirm_delete_medical_history').prop('disabled', false).text('Yes');
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        successMessage(data.success);
                        $('.medicalHistory').empty();
                        loadMedicalHistory();
                    } else {
                        errorMessage(data.error);
                    }

                    $('#medicalHistoryDeleteModal').modal('hide');
                },
                error: function(error) {
                    console.log(error);
                    $('#modal_confirm_delete_medical_history').prop('disabled', false).text('Yes');
                    errorMessage(error);
                }
            });
        }

        function confirmDeleteRecomandation(id) {
            $.ajax({
                url: "{{ url('delete-recomandation') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'id': id,
                },
                beforeSend: function() {
                    $('#modal_confirm_delete_recomandation').prop('disabled', true).text('Deleting...');
                },
                complete: function() {
                    $('#modal_confirm_delete_recomandation').prop('disabled', false).text('Yes');
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        successMessage(data.success);
                        $('.recomandations').empty();
                        loadRecomandation();
                    } else {
                        errorMessage(data.error);
                    }

                    $('#recomandationDeleteModal').modal('hide');
                },
                error: function(error) {
                    console.log(error);
                    $('#modal_confirm_delete_recomandation').prop('disabled', false).text('Yes');
                    errorMessage(error);
                }
            });
        }

        function confirmDelete(id) {
            $.ajax({
                url: "{{ url('delete-appointment-note') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'id': id,
                },
                beforeSend: function() {
                    $('#modal_confirm_delete').prop('disabled', true).text('Deleting...');
                },
                complete: function() {
                    $('#modal_confirm_delete').prop('disabled', false).text('Yes');
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        successMessage(data.success);
                    } else {
                        errorMessage(data.error);
                    }
                    $('#deleteModal').modal('hide');
                    loadAppointmentNotes();
                },
                error: function(error) {
                    console.log(error);
                    $('#modal_confirm_delete').prop('disabled', false).text('Yes');
                    $('#deleteModal').modal('hide');
                    errorMessage(error);
                }
            });
        }



        function loadMedicalHistoryEditModal(medical_history) {
            $('#medical_history_id').val(medical_history.id);
            $('#mhContentEdit').summernote('code', medical_history.details);
            $('#tooltipmodalMhEdit').modal('show');
        }

        function loadRecomandationEditModal(recomandation) {
            $('#recomandation_id').val(recomandation.id);
            $('#recomEdit').summernote('code', recomandation.recomandation);
            $('#tooltipmodalRcEdit').modal('show');
        }

        function loadEditModal(appointment_note) {
            $('#appointment_note_id').val(appointment_note.id);
            $('#updateNote').summernote('code', appointment_note.note);
            $('#tooltipmodal').modal('show');
        }

        $('#update_medical_history_form').on('submit', function(e) {
            e.preventDefault();

            var _token = $("input[name='_token']").val();
            const formData = new FormData(this);

            $.ajax({
                url: "{{ url('/update-medical-history') }}",
                type: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.update_medical_history').prop('disabled', true).text('Updating...');
                },
                complete: function() {
                    $('.update_medical_history').prop('disabled', false).text('Update');
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        successMessage(data.success);
                        $('#tooltipmodalMhEdit').modal('hide');
                        loadMedicalHistory();
                    } else {
                        errorMessage(data.error);
                    }
                },
                error: function(error) {
                    console.log(error);
                    $('.update_medical_history').prop('disabled', false).text('Update');
                    errorMessage(error);
                }
            });

        });

        $('#update_recomandation_form').on('submit', function(e) {
            e.preventDefault();

            var _token = $("input[name='_token']").val();
            const formData = new FormData(this);

            $.ajax({
                url: "{{ url('/update-recomandation') }}",
                type: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.update_recomandation').prop('disabled', true).text('Updating...');
                },
                complete: function() {
                    $('.update_recomandation').prop('disabled', false).text('Update');
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        successMessage(data.success);
                        $('#tooltipmodalRcEdit').modal('hide');
                        loadRecomandation();
                    } else {
                        errorMessage(data.error);
                    }
                },
                error: function(error) {
                    console.log(error);
                    $('.update_recomandation').prop('disabled', false).text('Update');
                    errorMessage(error);
                }
            });

        });

        $('#update_note_form').on('submit', function(e) {
            e.preventDefault();

            var _token = $("input[name='_token']").val();
            const formData = new FormData(this);

            $.ajax({
                url: "{{ url('/update-appointment-note') }}",
                type: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.update_note').prop('disabled', true).text('Updating...');
                },
                complete: function() {
                    $('.update_note').prop('disabled', false).text('Update');
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        successMessage(data.success);
                        $('#update_note_form')[0].reset();
                        $('#tooltipmodal').modal('hide');
                        loadAppointmentNotes();
                    } else {
                        errorMessage(data.error);
                    }
                },
                error: function(error) {
                    console.log(error);
                    $('#tooltipmodal').modal('hide');
                    $('.update_note').prop('disabled', false).text('Update');
                    errorMessage(error);
                }
            });

        });

        $('#medical_history_type').on('change', function(e) {
            e.preventDefault();

            var medical_history_type = $(this).val();
            loadMedicalHistory(medical_history_type);

        });
    </script>
@endpush
