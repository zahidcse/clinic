@extends('layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flatpickr/flatpickr.min.css') }}">
    <link href="{{ asset('assets/toastr/toastr.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker/daterangepicker.css') }}" />
@endsection
@section('content')
    <div class="card-header">

        <div class="col-xl-12 col-md-12 col-sm-12">
            <div class="row">
                <div class="col-xl-9 col-md-6 col-sm-12">
                    <h4 class="mb-3">Apoinment List</h4>
                    @if (session()->has('msg-success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <p style="color: green;">{{ session('msg-success') }}</p>
                        </div>
                    @endif
                    @if (session()->has('msg-error'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <p style="color: red;">{{ session('msg-error') }}</p>
                        </div>
                    @endif
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12 text-end">
                    <a href="{{ url('create-appointment') }}" class="btn btn-primary" type="button"><i class="fa fa-plus"
                            aria-hidden="true"></i>
                        Create Appoinment</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Title End -->

    <!-- Body Start  -->
    <div class="edit-profile mb-20">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12">
                <div class="card card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12">
                                <span class="font-weight-bold"><b>Sort By</b></span>
                                <div class="row mt-2">
                                    <div class="col-xl-3 col-md-3 col-sm-12">
                                        <select class="form-control form-select" id="doctor_id" name="doctor_id" required>
                                            <option selected="" value="">All Provider</option>
                                            @foreach ($doctors as $doctor)
                                                <option value="{{ $doctor->id }}"
                                                    {{ request()->doctor_id == $doctor->id ? 'selected' : '' }}>
                                                    {{ $doctor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xl-3 col-md-3 col-sm-12">
                                        <input type="text" class="form-control" name="datefilter" id="reportrange"
                                            placeholder="Select date range" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive theme-scrollbar">
                                <table class="data-table" id="">
                                    <thead>
                                        <tr>
                                            <th>Patient</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Provider</th>
                                            <th>Appointment Date</th>
                                            <th>Checked In</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Body End -->
    <!-- checked in modal -->
    <div class="modal fade" id="checkedinModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Checked In</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Would you like to update the status?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="modal_confirm_checkedin" class="btn btn-success">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- delete modal -->
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
                    Are you sure you want to cancel the appointment?
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    <button type="button" id="modal_confirm_delete" class="btn btn-success">Yes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('assets/js/flat-pickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/flat-pickr/custom-flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/js/tooltip-init.js') }}"></script>
    <script src="{{ asset('assets/js/height-equal.js') }}"></script>
    <script src="{{ asset('assets/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/daterangepicker/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/daterangepicker/daterangepicker.min.js') }}"></script>
    <script>
        $(function() {
            var table = $('.data-table').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                processing: true,
                serverSide: true,
                iDisplayLength: 25,
                retrieve: true,
                order: [
                    [3, 'desc']
                ],
                ajax: {
                    url: "{{ url('/all-appointments') }}",
                    data: function(d) {
                        d.search = $('input[type="search"]').val(),
                            d.doctor_id = $('#doctor_id').val(),
                            d.daterange = $('#reportrange').val()
                    }
                },
                columns: [{
                        data: 'patient_name',
                        name: 'patient_name'
                    },
                    {
                        data: 'patient_email',
                        name: 'patient_email'
                    },
                    {
                        data: 'patient_phone',
                        name: 'patient_phone'
                    },
                    {
                        data: 'doctor_name',
                        name: 'doctor_name'
                    },
                    {
                        data: 'appointment_date',
                        name: 'start'
                    },
                    {
                        data: 'checked_in',
                        name: 'checked_in'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#doctor_id').change(function() {
                table.draw();
            });

            //daterange picker
            $('input[name="datefilter"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                },
                showDropdowns: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            });

            $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                    'MM/DD/YYYY'));
                table.draw();
            });

            $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                table.draw();
            });

        });

        function loadCheckedInModal(id, text) {
            $('#modal_confirm_checkedin').attr('onclick', `checkedIn(${id})`);
            $('#checkedinModal').modal('show');
        }

        function checkedIn(id) {
            $.ajax({
                url: "{{ url('update-checkedin-status') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'id': id,
                },
                beforeSend: function() {
                    $('#modal_confirm_checkedin').prop('disabled', true).text('Updating...');
                },
                complete: function() {
                    $('#modal_confirm_checkedin').prop('disabled', false).text('Update');
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        $('.data-table').DataTable().draw(false);
                        successMessage(data.success);
                    } else {
                        errorMessage(data.error);
                    }

                    $('#checkedinModal').modal('hide');
                },
                error: function(error) {
                    console.log(error);
                    $('#modal_confirm_checkedin').prop('disabled', false).text('Update');
                    errorMessage(error);
                }
            });
        }

        function loadDeleteModal(id) {
            $('#modal_confirm_delete').attr('onclick', `confirmDelete(${id})`);
            $('#deleteModal').modal('show');
        }

        function confirmDelete(id) {
            $.ajax({
                url: "{{ url('delete-appointment') }}",
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
                        $('.data-table').DataTable().draw(false);
                        successMessage(data.success);
                    } else {
                        errorMessage(data.error);
                    }

                    $('#deleteModal').modal('hide');
                },
                error: function(error) {
                    console.log(error);
                    $('#modal_confirm_delete').prop('disabled', false).text('Yes');
                    errorMessage(error);
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
