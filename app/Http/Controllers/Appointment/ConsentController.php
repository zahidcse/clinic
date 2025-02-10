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

class ConsentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update_consent_form(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'image' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => "Please Check The Required Field."]);
            }
            $title = $request->title;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = md5(uniqid(rand(), true)).'.'.strtolower(pathinfo($file->getClientOriginalName(),PATHINFO_EXTENSION)) ;
                $destinationPath = 'uploads/consent_image/' ;
                $file->move($destinationPath,$fileName);
                $filePath = $destinationPath.$fileName;
            }

            $consent = new ConsentForm();
            $consent->title = $title;
            $consent->file_path = $filePath;
            $consent->clinic_id = Auth::id();
            $consent->push();

            $message = "Appointment Note Updated Successfully.";
            return response()->json(['success' => $message, 'id'=>$consent->id ,'this_consent' => '<div class="d-block text-left m-t-20"><div class="btn btn-outline-primary d-block text-left txt-dark selected">'.$title.'</div></div>']);

        } catch (Exception $e) {
            Log::info("update appointment note exception " . $e->getMessage());
            return response()->json(['error' => "Failed to update appointment note. Try again."]);
        }
    }


    public function update_user_consent_form(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'consent_form_ids' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => "Please Check The Required Field."]);
            }
            $consent_form_ids = $request->consent_form_ids;

            $consent_form_ids = explode(",", $consent_form_ids);


            UserConsentForm::where('user_id',$request->patient_id)->delete();

            foreach ($consent_form_ids as $id=>$consent_form_id) {
                $UserConsentForm = new UserConsentForm;
                $UserConsentForm->form_id = $consent_form_id;
                $UserConsentForm->user_id = $request->patient_id;
                $UserConsentForm->push();
            }

            $selected_consent = UserConsentForm::where('user_id', $request->patient_id)->orderby('id','desc')->get();


            $view = view('appointments.selected_consent_info', ['selected_consent' => $selected_consent])->render();

            $message = "Appointment Note Updated Successfully.";
            $myArray['content'] = $view;
            $myArray['success'] =$message;

            return response()->json($myArray);

        } catch (Exception $e) {
            Log::info("update appointment note exception " . $e->getMessage());
            return response()->json(['error' => "Failed to update appointment note. Try again."]);
        }
    }


}
