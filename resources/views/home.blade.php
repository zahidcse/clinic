@extends('layouts.app')
@section('css')
    <!-- daterange picker css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker/daterangepicker.css') }}" />
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />
    <style>
        /* Custom Tooltip Theme */
        .tippy-box[data-theme~='custom'] {
            background-color: #2C1259;
            /* Background color */
            color: #ffffff;
            /* Text color */
            border-radius: 5px;
            font-size: 14px;
            padding: 8px;
            text-align: left;
        }

        .tippy-box[data-theme~='custom'] .tippy-arrow {
            color: #2C1259;
            /* Arrow color matches tooltip background */
        }
    </style>
@endsection
@section('content')
    <div class="card-header">
        <div class="col-xl-12 col-md-12 col-sm-12">
            <div class="row">
                <div class="col-xl-4 col-md-4 col-sm-12">
                    <h4 class="m-t-10 f-18">Dashboard</h4>
                </div>
                <div class="col-4 col-xl-4 col-sm-12 page-title">
                    <h5 class="f-w-700 f-18">
                        {{ \Carbon\Carbon::now()->format('l, F jS, Y ') }}
                    </h5>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-12 text-center">
                    <div id="reportrange" class="btn-gradient-2">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                        <input type="hidden" id="start_date" name="start_date">
                        <input type="hidden" id="end_date" name="end_date">

                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card-body">
        <div class="row" id="wrap">
            <div class="col-xxl-12 box-col-12">
                <div class="col-xl-12 col-md-12 proorder-md-1">
                    <div class="row">
                        <div class="col-xl-3 col-sm-12">
                            <div class="card">
                                <div class="card-body student card_wht_bg">
                                    <div class="d-flex gap-2 align-items-end">
                                        <div class="flex-grow-1">
                                            <p class="f-14">Total Patients</p>

                                            <div class="d-flex student-arrow text-truncate">
                                                <p class="mb-0 text-truncate f-w-700 total_patient"> 0 </p>
                                                {{-- <p class="mb-0 up-arrow bg-light-danger">
                                                    <i class="icon-arrow-down font-danger"></i>
                                                </p> --}}
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0"><img
                                                src="{{ asset('assets/images/dashboard-4/icon/profile-2user.png') }}"
                                                alt=""></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-12">
                            <div class="card">
                                <div class="card-body student-2 card_wht_bg">
                                    <div class="d-flex gap-2 align-items-end">
                                        <div class="flex-grow-1">
                                            <p class="f-14">Total Appointments</p>

                                            <div class="d-flex student-arrow text-truncate">
                                                <p class="mb-0 text-truncate f-w-700 total_appointments">0 </p>
                                                {{-- <p class="mb-0 up-arrow bg-light-success">
                                                    <i class="icon-arrow-up font-success"></i>
                                                </p> --}}
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0"><img
                                                src="{{ asset('assets/images/dashboard-4/icon/calendar.png') }}"
                                                alt=""></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-12">
                            <div class="card">
                                <div class="card-body student-3 card_wht_bg">
                                    <div class="d-flex gap-2 align-items-end">
                                        <div class="flex-grow-1">
                                            <p class="f-14"> Total Procedures</p>

                                            <div class="d-flex student-arrow text-truncate">
                                                <p class="mb-0 text-truncate f-w-700 total_procedures">0 </p>
                                                {{-- <p class="mb-0 up-arrow bg-light-success">
                                                    <i class="icon-arrow-up font-success"></i>
                                                </p> --}}
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0"><img
                                                src="{{ asset('assets/images/dashboard-4/icon/clipboard-text.png') }}"
                                                alt=""></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-12">
                            <div class="card">
                                <div class="card-body student-3 card_wht_bg">
                                    <div class="d-flex gap-2 align-items-end">
                                        <div class="flex-grow-1">
                                            <p class="f-14"> Total Revenue</p>

                                            <div class="d-flex student-arrow text-truncate">
                                                <p class="mb-0 text-truncate f-w-700 total_revenue">0 </p>
                                                {{-- <p class="mb-0 up-arrow bg-light-success">
                                                    <i class="icon-arrow-up font-success"></i>
                                                </p> --}}
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0"><img
                                                src="{{ asset('assets/images/dashboard-4/icon/savings_icon.png') }}"
                                                alt=""></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-md-12 proorder-md-1">
                    <div class="card">
                        <div class="card-body card_wht_bg">
                            <div class="calendar-default" id="calendar-container">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('script')
    <!-- Add Popper.js first -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <!-- Then Tippy.js -->
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script type="text/javascript" src="{{ asset('assets/js/daterangepicker/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/daterangepicker/daterangepicker.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/daterangepicker/custom-script.js') }}"></script> --}}
    <script src="{{ asset('assets/js/calendar/fullcalendar.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/calendar/fullcalendar-custom.js') }}"></script> --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            /* initialize the calendar
              -----------------------------------------------------------------*/

            var calendarEl = document.getElementById("calendar");
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
                },
                initialView: "dayGridMonth",
                navLinks: true,
                editable: true,
                selectable: true,
                nowIndicator: true,
                editable: false,
                droppable: false,
                eventSources: [{
                    url: "{{ url('/dashboard-appointment-calendar') }}",
                    method: 'GET',
                    contentType: "application/json; charset=utf-8",
                    success: function(data) {
                        console.log('Events fetched successfully:', data);
                        $('#loaderContainer').css('display', 'none');
                    },
                    failure: function(error) {
                        console.error('Error fetching events:', error);
                    }
                }],
                eventContent: function(arg) {
                    const timeEl = arg.timeText ?
                        `<div class="fc-event-time" style="font-size: 15px;">${arg.timeText}</div>` :
                        '';

                    const titleEl =
                        `<div class="fc-event-title" style="font-size: 15px;">${arg.event.extendedProps.patient_name}</div>`;

                    return {
                        html: `${timeEl}${titleEl}`
                    };
                },
                eventDidMount: function(arg) {
                    // Create tooltip content
                    const tooltipContent = `
                            <div class="event-tooltip">
                            <strong>${arg.event.title}</strong>
                            <strong>${arg.event.extendedProps.patient_name}</strong>
                            <div>${arg.event.extendedProps.patient_phone}</div>
                            </div>
                        `;

                    // Initialize Tippy tooltip
                    tippy(arg.el, {
                        content: tooltipContent,
                        allowHTML: true,
                        placement: 'top',
                        interactive: true,
                        arrow: true,
                        theme: 'custom',
                        animation: 'scale',
                        duration: 300,
                        animateFill: true,
                    });
                },
                eventClick: function(info) {
                    window.location.href = "{{ url('view-appointment') }}/" + info
                        .event.id;
                }
            });
            calendar.render();


            setupDateRangePicker();
            loadData($('#start_date').val(), $('#end_date').val());
        });


        function setupDateRangePicker() {
            var start = moment().subtract(29, 'days');
            var end = moment();

            function updateRange(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                    'MMMM D, YYYY'));
                $('#start_date').val(start.format('YYYY-MM-DD'));
                $('#end_date').val(end.format('YYYY-MM-DD'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment()
                        .subtract(1, 'month').endOf('month')
                    ]
                }
            }, updateRange);

            updateRange(start, end);
        }

        function loadData(startDate, endDate) {
            $.ajax({
                url: "{{ url('/get-dashboard-data') }}",
                type: 'GET',
                data: {
                    start_date: startDate,
                    end_date: endDate
                },
                beforeSend: function() {
                    $('.page-wrapper').prepend(`<div class="loader-wrapper" style="text-align: center;
                        vertical-align: middle;
                        display: inline-flex;
                        opacity: 0.8;">
                            <div class="loader loader-1">
                                <div class="loader-outter"></div>
                                <div class="loader-inner"></div>
                                <div class="loader-inner-1"></div>
                            </div>
                        </div>`);
                },
                complete: function() {
                    $('.page-wrapper .loader-wrapper').remove();
                },
                success: function(response) {
                    console.log("Filtered Data:", response);
                    $(".total_patient").empty();
                    $(".total_appointments").empty();
                    $(".total_procedures").empty();
                    $(".total_revenue").empty();

                    $(".total_patient").html(response.total_patient);
                    $(".total_appointments").html(response.total_appointment);
                    $(".total_procedures").html(response.total_procedure);
                    $(".total_revenue").html(response.total_revenue);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        $('#reportrange').on('apply.daterangepicker', function() {
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            loadData(startDate, endDate);
        });
    </script>
@endpush
