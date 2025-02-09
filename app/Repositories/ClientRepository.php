<?php

namespace App\Repositories;


use App\Models\AccessControl;
use App\Models\BillingPreference;
use App\Models\Country;
use App\Models\Floor;
use App\Models\PrivateClientContract;
use App\Models\Room;
use App\Models\User;
use App\Models\UserTermsDoc as UserDocument;
use App\Models\UsState;
use App\Models\Clinic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mpdf\Mpdf;
use PDF;

class ClientRepository 
{
    private function RandomString()
    {
        // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $randString = '';
        // for ($i = 0; $i < strlen($characters); $i++) {
        //     $randString = $characters[rand(0, strlen($characters))];
        // }
        return Str::random(30);
    }

    public function getClinicByUserId($user_id){
        $user = User::find($user_id);
        return Clinic::find($user->clinic_id);
    }

    public function getClientById($clientId)
    {
        return User::find($clientId);
    }

    public function getUsStates()
    {
        return UsState::all();
    }

    public function getCountries()
    {
        return Country::orderBy('id')->get();
    }

    public function clientSingUp($clientId, $newClient)
    {
        $client = $this->getClientById($clientId);

       

        if ($client && $client->onboarding_token == $newClient['token']) {
            $client->email = $newClient['email'];
            $client->password = Hash::make($newClient['password']);
            $client->status = 1;
            
            $client->onboarding_token = null;
            
            $client->save();

            return $client;
        }

        return false;
    }

    public function getClinicById($clinic_id){
        return Clinic::find($clinic_id);

    }

    public function updateProfile($clientId, $profileData)
    {
        $client = $this->getClinicByUserId($clientId);

        if ($client) {
         
            $client->street_address = $profileData['street_address'] ?? $profileData['street_address'];
            $client->city = $profileData['city'];
            $client->state = $profileData['state'];
            $client->country = $profileData['country'];
            $client->zip = $profileData['zip_code'];
            $client->street_address= $profileData['street_address'];
            $client->save();

            return $client;
        }

        return false;
    }

    public function tosSignature($clientId, $data)
    {
        $client = $this->getClientById($clientId);

        if (isset($data['name'])) {
            $client->first_name = $data['name'];
        }

        $signature = "data:image/png;base64, " . $data['signature'];

        $mpdf = new Mpdf(['tempDir' => public_path('singedTos/temp'), 'mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->SetTitle('R3Alliance terms of service');
        $mpdf->SetAuthor('R3Alliance services');
        $tosImage = public_path('assets/images/tos');
        $html = view('client.tosPdf', ['client' => $client, 'data' => $data, 'tosImage' => $tosImage, 'signature' => $signature])->render();
        $mpdf->WriteHTML($html);
        File::makeDirectory(public_path('singedTos/' . $client->id), 0777, true, true);
        $fileName = 'terms_of_service_' . time() . '.pdf';
        $storagePath = public_path('singedTos/' . $client->id . '/' . $fileName);
        $mpdf->Output($storagePath, 'F');

        $client->onboarding_token = '';
        $client->done_agreement = 1;
        if (isset($data['role_title'])) {
            $client->role_title = $data['role_title'];
        }
        $client->save();
        // session()->put('initial', '1');

        $this->storeDocument($client->id, 'Terms of Service', 'singedTos/' . $client->id . '/' . $fileName);
        return $storagePath;
    }

    public function billingPreference($clientId, $billingPreference)
    {
        $billingPreference = new BillingPreference();
        $billingPreference->user_id = $clientId;
        $billingPreference->valuation_type = $billingPreference['valuationType'];
        $billingPreference->valuation_price_type = $billingPreference['valuationPriceType'];
        $billingPreference->save();

        return true;
    }

    public function clientValuationSubmit($clientData)
    {
        $client = $this->getClientById($clientData['clientId']);
        $client->client_valuation = $clientData['terms_of_service'] ?? $clientData['additional_coverage'];
        $client->save();
        return $client;
    }

   

   

    public function documentData($clientId)
    {
        return UserDocument::where('author', $clientId)->orderBy('created_at', 'DESC');
    }

    public function documentDataById($documentId)
    {
        return UserDocument::find($documentId);
    }

    public function valuationPdf($client)
    {
        $mpdf = new Mpdf(['tempDir' => public_path('singedTos/temp'), 'mode' => 'utf-8', 'format' => 'A4']);
        $html = view('client.valuationPdf', ['client' => $client])->render();
        $mpdf->WriteHTML($html);
        $fileName = 'sing_up_valuation_' . time() . '.pdf';
        $storagePath = public_path('singedTos/' . $client->id . '/' . $fileName);
        $mpdf->Output($storagePath, 'F');

        $this->storeDocument($client->id, 'Sing up valuation', 'singedTos/' . $client->id . '/' . $fileName);

        return true;
    }

    public function storeDocument($clientId, $title, $filePath)
    {
        $userDoc = new UserDocument();
        $userDoc->author = $clientId;
        $userDoc->title = $title;
        $userDoc->file_path = $filePath;
        return $userDoc->save();
    }
}
