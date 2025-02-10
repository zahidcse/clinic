<?php

namespace App\Http\Controllers\Appointment;

use App\Models\ConsentForm;
use App\Models\UserConsentForm;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\TimeZone;
use App\Models\Appointment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DoctorDateSlot;
use App\Models\DoctorTimeSlot;
use App\Models\AppointmentNote;
use App\Models\MedicalHistoryType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function formatPhoneNumber($phoneNumber)
    {
        try {
            $phoneUtil = PhoneNumberUtil::getInstance();
            $numberProto = $phoneUtil->parse($phoneNumber, 'US');

            if ($phoneUtil->isValidNumber($numberProto)) {
                return $phoneUtil->format($numberProto, PhoneNumberFormat::NATIONAL);
            } else {
                return $phoneNumber;
            }
        } catch (\libphonenumber\NumberParseException $e) {
            Log::error("phone no formatting error: " . $e->getMessage());
            return $phoneNumber;
        }
    }

    public function dashboard_appointments(Request $request)
    {
        $start_date = $request->start;
        $end_date = $request->end;


        $appointments = Appointment::where('clinic_id', Auth::user()->clinic_id)->whereDate('start', '>=', $start_date)->whereDate('end', '<=', $end_date)->get();
        $result = [];
        $data = [];
        foreach ($appointments as $appointment) {
            $doctor_info = User::where('id', $appointment->doctor_id)->first();
            $timezone_name = TimeZone::where('id', $doctor_info->timezone_id)->pluck('tz_identifier')->first();

            $patient_info = User::where('id', $appointment->patient_id)->first();

            $result['backgroundColor'] = '#2c1259';
            $result['start'] = Carbon::parse($appointment->start)->shiftTimezone('UTC')->setTimezone($timezone_name)->toDateTimeString();
            $result['end'] = Carbon::parse($appointment->end)->shiftTimezone('UTC')->setTimezone($timezone_name)->toDateTimeString();
            $result['id'] = $appointment->id;
            $result['title'] = "Phone consultation";
            $result['extendedProps'] = [
                "patient_name" => $patient_info->name,
                "patient_phone" => $this->formatPhoneNumber($patient_info->phone)
            ];
            $data[] = $result;
        }
        return response()->json($data);
    }

    public function all_appointments(Request $request)
    {
        if ($request->ajax()) {
            $data = Appointment::where('clinic_id', Auth::user()->clinic_id)->where('status', 1);
            return DataTables::of($data)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {
                    if ($request->get('doctor_id') != "") {
                        $doctor_id = $request->get('doctor_id');
                        $instance->where('doctor_id', $doctor_id);
                    }

                    if ($request->get('daterange') != '') {
                        $daterange = $request->get('daterange');
                        $dates = explode(' - ', $daterange);

                        $from = date("Y-m-d", strtotime($dates[0]));
                        $to = date("Y-m-d", strtotime($dates[1]));
                        $instance->whereDate('start', '>=', $from)->whereDate('start', '<=', $to);
                    }

                    if (!empty($request->get('search'))) {
                        $search_terms = $request->get('search');
                        $instance->where(function ($query) use ($search_terms) {
                            $query->where('start', 'LIKE', '%' . $search_terms . '%');
                        });
                    }
                })
                ->addColumn('doctor_name', function ($row) {
                    $doctor_info = User::where('id', $row->doctor_id)->first();
                    return $doctor_info->name;
                })
                ->addColumn('patient_name', function ($row) {
                    $patient_info = User::where('id', $row->patient_id)->first();
                    return $patient_info->name;
                })
                ->addColumn('patient_email', function ($row) {
                    $patient_info = User::where('id', $row->patient_id)->first();
                    return $patient_info->email;
                })
                ->addColumn('patient_phone', function ($row) {
                    $patient_info = User::where('id', $row->patient_id)->first();
                    return $this->formatPhoneNumber($patient_info->phone);
                })
                ->addColumn('appointment_date', function ($row) {
                    $doctor_info = User::where('id', $row->doctor_id)->first();
                    $timezone_name = TimeZone::where('id', $doctor_info->timezone_id)->first();
                    $appointment_date = Carbon::parse($row->start)->shiftTimezone('UTC')->setTimezone($timezone_name->tz_identifier)->format('m/d/Y H:i a');
                    return $appointment_date . " " . $timezone_name->tz_abbreviation;
                })
                ->addColumn('checked_in', function ($row) {
                    $checked_in_status = ($row->checked_in) == 1 ? "Yes" : "No";
                    $btn_class = ($row->checked_in) == 1 ? "btn-success" : "btn-danger";
                    $btn = '<a class="btn  ' . $btn_class . ' text-white" onclick="loadCheckedInModal(' . $row->id . ')">' . $checked_in_status . '</a>';
                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    // $btn = '<div class="dropdown">
                    //                     <button class="btn btn-sm btn-primary dropdown-toggle text-white" type="button" id="actionMenuButton"
                    //                         data-bs-toggle="dropdown" aria-expanded="false">
                    //                         Actions
                    //                     </button>
                    //                     <ul class="dropdown-menu dropdown-menu-action" aria-labelledby="actionMenuButton">
                    //                         <li>
                    //                             <a class="dropdown-item" href="' . url('/view-appointment/' . $row->id) . '">
                    //                                 <i class="fa fa-eye"></i> View Details
                    //                             </a>
                    //                         </li>
                    //                         <li>
                    //                             <a class="dropdown-item text-danger" onclick="loadDeleteModal(' . $row->id . ')">
                    //                                 <i class="fa fa-trash"></i> Delete
                    //                             </a>
                    //                         </li>
                    //                     </ul>
                    //                 </div>';
                    $btn = '<a class="btn btn-sm btn-primary" href="' . url('/view-appointment/' . $row->id) . '">
                                <i class="fa fa-eye"></i> View
                            </a>
                            <a class="btn btn-sm btn-primary" style="background-color:#ff0000!important;" onclick="loadDeleteModal(' . $row->id . ')">
                                <i class="fa fa-trash"></i>
                            </a>';
                    return $btn;
                })
                ->rawColumns(['patient_email', 'patient_name', 'patient_phone', 'doctor_name', 'appointment_date', 'checked_in', 'action'])
                ->make(true);
        }

        $doctors = User::where('type', 4)->where('status', 1)->where('clinic_id', Auth::user()->clinic_id)->get();

        return view("appointments.all_appointments", compact('doctors'));
    }
    public function create_appointment(Request $request)
    {
        $doctors = User::where('type', 4)->where('status', 1)->where('clinic_id', Auth::user()->clinic_id)->orderBy('id', 'DESC')->get();
        $patients = User::where('type', 3)->where('status', 1)->where('clinic_id', Auth::user()->clinic_id)->orderBy('id', 'DESC')->get();

        return view("appointments.create_appointment", compact('doctors', 'patients'));
    }

    public function get_available_date(Request $request)
    {
        $start_date = $request->start;
        $end_date = $request->end;
        $doctor_id = $request->doctor_id;


        $availableSlots = DoctorDateSlot::where('doctor_id', $doctor_id)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->get();
        $result = [];
        $data = [];
        foreach ($availableSlots as $availableSlot) {
            $result['display'] = 'background';
            // $result['className'] = 'ps-avaiable';
            $result['backgroundColor'] = '#7d33ff';
            $result['start'] = Carbon::parse($availableSlot->date)->format('Y-m-d');
            $result['end'] = Carbon::parse($availableSlot->date)->format('Y-m-d');
            $data[] = $result;
        }
        return response()->json($data);
    }


    public function get_available_time(Request $request)
    {
        $date = $request->date;
        $doctor_id = $request->doctor_id;

        $doctor_info = User::where('id', $doctor_id)->first();
        $timezone_name = TimeZone::where('id', $doctor_info->timezone_id)->pluck('tz_identifier')->first();

        $availableDateSlots = DoctorDateSlot::where('doctor_id', $doctor_id)->whereDate('date', $date)->get();

        $potentialSlots = [];

        foreach ($availableDateSlots as $availableSlot) {
            $time_slots = DoctorTimeSlot::where('date_slot_id', $availableSlot->id)->get();

            foreach ($time_slots as $time_slot) {
                $start_date = Carbon::parse($date . ' ' . $time_slot->start_time)
                    ->shiftTimezone('UTC')
                    ->setTimezone($timezone_name);
                $end_date = Carbon::parse($date . ' ' . $time_slot->end_time)
                    ->shiftTimezone('UTC')
                    ->setTimezone($timezone_name);

                $interval = $time_slot->duration;
                $start = $start_date->copy();
                $end = $end_date->copy();

                while ($start->lessThan($end)) {
                    $endSlot = (clone $start)->addMinutes($interval);
                    if ($endSlot->greaterThan($end)) {
                        break;
                    }
                    $potentialSlots[] = [
                        'start' => $start->copy(),
                        'end' => $endSlot,
                        'duration' => $interval,
                    ];
                    $start->addMinutes($interval);
                }
            }
        }

        $appointments = Appointment::where('doctor_id', $doctor_id)
            ->whereDate('start', $date)
            ->get();


        $filteredSlots = collect($potentialSlots)->filter(function ($slot) use ($appointments, $timezone_name) {
            foreach ($appointments as $appointment) {
                $appointmentStart = Carbon::parse($appointment->start)->shiftTimezone('UTC')
                    ->setTimezone($timezone_name);
                $appointmentEnd = Carbon::parse($appointment->end)->shiftTimezone('UTC')
                    ->setTimezone($timezone_name);

                if (
                    $slot['start']->lessThan($appointmentEnd) &&
                    $slot['end']->greaterThan($appointmentStart)
                ) {
                    return false;
                }
            }
            return true;
        });


        $formattedAvailableTimeSlots = $filteredSlots->map(function ($slot) {
            return [
                'start' => $slot['start']->format('g:i A'),
                'interval' => $slot['duration'],
            ];
        })->values();

        return response()->json([
            'success' => true,
            'time' => $formattedAvailableTimeSlots,
            'date' => Carbon::parse($date)->format('D, F j, Y'),
        ]);
    }


    public function book_appointment(Request $request)
    {
        try {
            $clinic_id = Auth::user()->clinic_id;
            $doctor_id = $request->doctor_id;
            $patient_id = $request->patient_id;
            $duration = $request->duration;
            $created_by = Auth::user()->id;

            $doctor_info = User::where('id', $doctor_id)->first();
            $timezone_name = TimeZone::where('id', $doctor_info->timezone_id)->first();

            $start = Carbon::parse(Str::trim($request->date) . Str::trim($request->time))->shiftTimezone($timezone_name->tz_identifier)->setTimezone('UTC')->toDateTimeString();
            $end = Carbon::parse(Str::trim($request->date) . Str::trim($request->time))->addMinute(30)->shiftTimezone($timezone_name->tz_identifier)->setTimezone('UTC')->toDateTimeString();

            $appointment = Appointment::create([
                "clinic_id" => $clinic_id,
                "patient_id" => $patient_id,
                "start" => $start,
                "end" => $end,
                "doctor_id" => $doctor_id,
                "duration" => $duration,
                "created_by" => $created_by
            ]);
            return response()->json(['success' => 'Appointment created successfully.', "appointment" => $appointment]);
        } catch (Exception $e) {
            Log::info("save appointment exception " . $e->getMessage());
            return response()->json(['error' => "Failed to create appointment. Try again."]);
        }
    }

    public function update_checkedin_status(Request $request)
    {
        try {
            $appointment_info = Appointment::where('id', $request->id)->first();

            $checkedin_status = 1;
            if ($appointment_info->checked_in == 1) {
                $checkedin_status = 0;
            }

            $appointment = Appointment::where('id', $request->id)->update([
                "checked_in" => $checkedin_status
            ]);

            return response()->json(['success' => 'Checked in status updated successfully.']);
        } catch (Exception $e) {
            Log::info("checked in status update exception " . $e->getMessage());
            return response()->json(['error' => "Failed to update checked in status. Try again."]);
        }
    }

    public function delete_appointment(Request $request)
    {
        DB::beginTransaction();
        try {

            $appointment = Appointment::where('id', $request->id)->update([
                "status" => 0
            ]);

            $appointment_note = AppointmentNote::where('appointment_id', $request->id)->update([
                "status" => 0
            ]);

            DB::commit();

            return response()->json(['success' => 'Appointment deleted successfully.']);
        } catch (Exception $e) {
            DB::rollback();
            Log::info("appointment delete exception " . $e->getMessage());
            return response()->json(['error' => "Failed to delete appointment. Try again."]);
        }
    }

    public function view_appointment($id)
    {
        try {
            $appointment_info = Appointment::findOrFail($id);

            $patient_info = User::findOrFail($appointment_info->patient_id);
            $doctor_info = User::where('id', $appointment_info->doctor_id)->first();
            $timezone_info = TimeZone::where('id', $doctor_info->timezone_id)->first();
            $appointment_date_time = Carbon::parse($appointment_info->start)->shiftTimezone('UTC')->setTimezone($timezone_info->tz_identifier)->toDateTimeString();
            $formatted_date_time = Carbon::parse($appointment_date_time)->format('m/d/Y H:i a') . " " . $timezone_info->tz_abbreviation;
            $medical_history_type = MedicalHistoryType::where('clinic_id', Auth::user()->clinic_id)->where('status', 1)->get();
            $consent_history_user = ConsentForm::where('clinic_id', Auth::id())->get();
            $selected_consent = UserConsentForm::where('user_id', $appointment_info->patient_id)->orderby('id','desc')->get();

            return view('appointments.view_appointment', compact('appointment_info', 'patient_info', 'doctor_info', 'formatted_date_time', 'medical_history_type','consent_history_user','selected_consent'));
        } catch (Exception $e) {
            Log::info("view appointment exception " . $e->getMessage());
            return redirect()->back()->with('msg-error', 'Something wrong.');
        }
    }

    public function save_appointment_note(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'note' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => "Please Check The Required Field."]);
            }

            $note = $request->note;

            $note = AppointmentNote::create([
                'appointment_id'  => $request->appointment_id,
                'patient_id' => $request->patient_id,
                'note' => $note,
                'created_by' => Auth::user()->id
            ]);

            $message = "Appointment Note added successfully.";

            return response()->json(['success' => $message]);
        } catch (Exception $e) {
            Log::info("save appointment note exception " . $e->getMessage());
            return response()->json(['error' => "Failed to add appointment note. Try again."]);
        }
    }

    public function delete_appointment_note(Request $request)
    {
        try {
            $appointment = AppointmentNote::where('id', $request->id)->update([
                "status" => 0
            ]);

            return response()->json(['success' => 'Appointment note deleted successfully.']);
        } catch (Exception $e) {
            Log::info("appointment note delete exception " . $e->getMessage());
            return response()->json(['error' => "Failed to delete appointment note. Try again."]);
        }
    }

    public function update_appointment_note(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'new_note' => 'required',
                'appointment_note_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => "Please Check The Required Field."]);
            }

            $note = $request->new_note;
            $appointment_note_id = $request->appointment_note_id;

            $note = AppointmentNote::where('id', $appointment_note_id)->update([
                'note' => $note,
                'modified_by' => Auth::user()->id
            ]);

            $message = "Appointment Note Updated Successfully.";

            return response()->json(['success' => $message]);
        } catch (Exception $e) {
            Log::info("update appointment note exception " . $e->getMessage());
            return response()->json(['error' => "Failed to update appointment note. Try again."]);
        }
    }



    public function load_appointment_notes(Request $request)
    {
        $myArray = array();

        $appointment_id = $request->appointment_id;
        $appointment_notes =  AppointmentNote::where('appointment_id', $appointment_id)->where('status', 1)->orderBy("created_at", "DESC")->get();

        $view = view('appointments.load_appointment_note', ['appointment_notes' => $appointment_notes])->render();

        $myArray['content'] = $view;
        $myArray['content_count'] = count($appointment_notes);

        return response()->json($myArray);
    }
}
