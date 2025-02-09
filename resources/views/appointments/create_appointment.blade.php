@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/toastr/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <style>
        .widgets-time {
            margin-top: 60px;
            width: 65%;
        }

        ul.timeslot {
            list-style: none;
            height: 80%;
            overflow-y: auto;
            width: 100%;
            scrollbar-width: thin;
        }

        li.time-slot span {
            cursor: pointer;
        }

        li.time-slot span,
        li.time-slot-disabled span {
            align-items: center;
            background: #2c1259;
            border: 2px solid #7d33ff !important;
            border-radius: 4px;
            box-sizing: border-box;
            color: #fff;
            display: flex;
            font-size: 14px;
            font-weight: 500;
            height: 50px;
            justify-content: center;
            text-align: center;
            transition: all .2s ease;
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="card-header">
        <div class="col-xl-12 col-md-12 col-sm-12">
            <div class="row">
                <div class="col-xl-9 col-md-6 col-sm-12">
                    <h4 class="mb-3">Appointment</h4>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12 text-center">
                    {{-- <a href="{{ URL::previous() }}">
                        <button class="btn btn-primary" type="button"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                            Back</button> --}}
                </div>
            </div>
        </div>

    </div>
    <div class="card-body">
        <div class="row" id="wrap">
            <div class="col-xxl-12 box-col-12">
                <div class="col-xl-10 col-md-10 proorder-md-1">
                    <div class="card">
                        <div class="card-body student card_wht_bg">
                            <div class="row">
                                <div class="col-xl-6 col-sm-12">
                                    <label class="form-label" for="doctor_id">Patient<span
                                            class="txt-danger">*</span></label>
                                    <select class="form-control form-select" id="patient_id" name="patient_id" required>
                                        <option selected="" value="">Select Patient</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}">
                                                {{ $patient->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-6 col-sm-12">
                                    <label class="form-label" for="doctor_id">Provider<span
                                            class="txt-danger">*</span></label>
                                    <select class="form-control form-select" id="doctor_id" name="doctor_id" required>
                                        <option selected="" value="">Select Provider</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}">
                                                {{ $doctor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xl-12 col-md-12 proorder-md-1">
                    <div class="row">
                        <div class="col-xl-10 col-md-10">
                            <div class="card">
                                <div class="card-body card_wht_bg">
                                    <div class="calendar-default" id="calendar-container">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-2 col-xs-12">
                            <div class="widgets-time">
                                <ul class="timeslot">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- add modal -->
    <div class="modal fade" id="tooltipmodal" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="tooltipmodal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Appointment Details</h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form class="" id="appointment_form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="tab">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="name">Patient Name</label><span class="txt-danger">*</span>
                                    <input class="form-control" id="patient_name" type="text" placeholder="Patient"
                                        name="patient_name" autocomplete="off" readonly>
                                    <input type="hidden" id="patientid" name="patientid" value="">
                                </div>
                                <div class="col-sm-6">
                                    <label for="name">Doctor Name</label><span class="txt-danger">*</span>
                                    <input class="form-control" id="doctor_name" type="text" placeholder="Doctor"
                                        name="doctor_name" autocomplete="off" readonly>
                                    <input type="hidden" id="doctorid" name="doctorid" value="">
                                </div>
                                <div class="col-sm-6">
                                    <label for="date_time">Date & Time</label><span class="txt-danger">*</span>
                                    <input class="form-control" id="date_time" type="text" placeholder="Date & Time"
                                        name="date_time" autocomplete="off" readonly>
                                </div>

                                {{-- <textarea id="summernote" name="note" required></textarea> --}}

                            </div>
                        </div>
                        <div class="p-4">
                            <div class="pull-left">

                            </div>
                            <div class="text-end pull-right">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                <button id="add_appointment" class="btn btn-primary add_appointment" type="submit"
                                    name="add_appointment">Create</button>
                            </div>

                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>

    <!-- Loader Container -->
    <div id="loaderContainer" style="display: none;">
        <div class="form-loading">
            <div class="loading"></div>
            <div class="loading-text">Loading.. Please wait..</div>
        </div>

        <div class="form-overlay"></div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('assets/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/calendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            var calendarEl = document.getElementById("calendar");
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth",
                },
                initialView: "dayGridMonth",
                navLinks: true,
                editable: true,
                selectable: true,
                nowIndicator: true,
                eventSources: [],
                editable: false,
                droppable: false,
                dateClick: function(info) {
                    // alert('Clicked on: ' + info.dateStr);
                    // // change the day's background color just for fun
                    // info.dayEl.style.backgroundColor = 'red';
                    if ($("#doctor_id").val() == "") {
                        errorMessage("Select a doctor.");
                    } else if ($("#patient_id").val() == "") {
                        errorMessage("Select a patient.");
                    }
                }
            });
            calendar.render();

        });

        $('#doctor_id').select2({
            theme: "classic"
        });

        $('#patient_id').select2({
            theme: "classic"
        });

        $("#doctor_id").change(function() {
            var doctor_id = $("#doctor_id").val();
            $('#loaderContainer').css('display', 'flex');
            RenderCalendar(doctor_id);
        });

        function RenderCalendar(doctor_id) {

            const today = new Date().toISOString().split('T')[0];

            var calendarEl = document.getElementById("calendar");
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth",
                },
                initialView: "dayGridMonth",
                navLinks: true,
                editable: true,
                selectable: true,
                nowIndicator: true,
                displayEventTime: true,
                displayEventEnd: true,
                editable: false,
                droppable: false,
                eventSources: [{
                    url: "{{ url('/get-available-date') }}",
                    method: 'GET',
                    contentType: "application/json; charset=utf-8",
                    extraParams: {
                        doctor_id: doctor_id
                    },
                    success: function(data) {
                        console.log('Events fetched successfully:', data);
                        $('#loaderContainer').css('display', 'none');
                    },
                    failure: function(error) {
                        console.error('Error fetching events:', error);
                    }
                }],
                // eventSourceSuccess: function(events, xhr) {
                //     $('#loaderContainer').css('display', 'none');
                //     $('.ps_calandar').removeClass('ps_loading');
                //     $('.ps_loader').hide();
                //     var dateCells = document.querySelectorAll('.fc-daygrid-day');
                //     dateCells.forEach(function(cell) {
                //         var cellDate = cell.getAttribute('data-date');
                //         var hasEvent = events.some(function(event) {
                //             return event.start === cellDate;
                //         });
                //         if (hasEvent) {
                //             cell.classList.add('ps-available');
                //         }
                //     });
                //     return events.eventArray;
                // },
                dateClick: function(info) {
                    const clickedDate = info.dateStr;
                    // info.dayEl.style.backgroundColor = 'red';
                    if ($("#doctor_id").val() == "") {
                        errorMessage("Select a doctor.");
                        return;
                    } else if ($("#patient_id").val() == "") {
                        errorMessage("Select a patient.");
                        return;
                    }

                    if (clickedDate < today) {
                        $('.timeslot').empty();
                        $('.timeslot').append(
                            `<li class='list-group-item list-group-item-primary disabled'><span>No time slots available</span></li>`
                        )
                        setTimeout(() => {
                            $('#loaderContainer').css('display', 'none');
                        }, 700);
                        return;
                    }
                    fetchTimeSlots(info.dateStr, $("#doctor_id").val());

                }
            });
            calendar.render();

        }

        function fetchTimeSlots(date, doctor_id) {
            $.ajax({
                url: "{{ url('/get-available-time') }}",
                method: 'GET',
                data: {
                    date: date,
                    doctor_id: doctor_id
                },
                beforeSend: function() {
                    $('#loaderContainer').css('display', 'flex');
                },
                complete: function() {
                    $('#loaderContainer').css('display', 'none');
                },
                success: function(response) {
                    console.log("response " + response);
                    displayTimeSlots(response);
                },
                error: function(error) {
                    console.error('Error fetching time slots:', error);
                }
            });
        }

        function displayTimeSlots(timeslots) {
            console.log(timeslots);
            const timeslotsDiv = $('.timeslot');
            timeslotsDiv.empty();
            if (!timeslots.success || $.isEmptyObject(timeslots['time'])) {
                timeslotsDiv.append(
                    "<li class='time-slot disabled'><span>No time slots available</span></li>"
                );
            } else {
                timeslots['time'].forEach(slot => {
                    timeslotsDiv.append(
                        `<li class='time-slot' data-date="${timeslots.date}" data-time="${slot.start}" data-duration="${slot.interval}"><span>${slot.start}</span></li><br>`
                    );
                });
            }
            setTimeout(() => {
                $('#loaderContainer').css('display', 'none');
            }, 1000);

        }


        var ps_date = "";
        var ps_time = "";
        var duration = "";

        $('body').on('click', '.time-slot', function($e) {
            $e.preventDefault();
            ps_date = $(this).attr('data-date');
            ps_time = $.trim($(this).attr('data-time'));
            duration = $.trim($(this).attr('data-duration'));

            var doctor_id = $("#doctor_id").val();
            var patient_id = $("#patient_id").val();

            console.log(doctor_id + " dp id " + patient_id);

            var doctor_name = $('#doctor_id').find(":selected").text();
            var patient_name = $('#patient_id').find(":selected").text();
            $('#doctor_name').val("");
            $('#doctor_name').val(doctor_name);
            $('#patient_name').val("");
            $('#patient_name').val(patient_name);

            $('#patientid').val("");
            $('#doctorid').val("");
            $('#patientid').val(patient_id);
            $('#doctorid').val(doctor_id);

            $('#date_time').val("");
            $('#date_time').val(ps_date + "," + ps_time);

            $('#tooltipmodal').modal('show');

            book_appointment(ps_date, ps_time, duration, doctor_id, patient_id);

        });

        function book_appointment(ps_date, ps_time, duration, doctor_id, patient_id) {
            $('#appointment_form').on('submit', function(e) {
                e.preventDefault();

                if (ps_date != "" && ps_time != "") {
                    $.ajax({
                        url: "{{ url('/book-appointment') }}",
                        type: 'POST',
                        data: {
                            doctor_id: doctor_id,
                            patient_id: patient_id,
                            date: ps_date,
                            time: ps_time,
                            duration: duration,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function() {
                            $('.add_appointment').prop('disabled', true).text('Creating...');
                        },
                        complete: function() {
                            $('.add_appointment').prop('disabled', false).text('Create');
                        },
                        success: function(data) {
                            if ($.isEmptyObject(data.error)) {
                                $('#appointment_form')[0].reset();
                                ps_date = "";
                                ps_time = "";
                                duration = "";
                                $('#tooltipmodal').modal('hide');
                                successMessage(data.success);
                                setTimeout(function() {
                                    window.location.href = "{{ url('view-appointment') }}/" +
                                        data
                                        .appointment.id;
                                }, 2000);
                            } else {
                                errorMessage(data.error);
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            $('.add_appointment').prop('disabled', false).text('Create');
                            errorMessage(error);
                        }
                    });

                }

            });

        }






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
    </script>
@endpush
