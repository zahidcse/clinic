<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;
use Auth;

trait CheckAgreement
{
    function checkAgreement($id){
        $data['custom_redirect'] = 0;
        $user = User::find($id);
        if($user ->done_agreement==0){

            $data['custom_redirect'] = 1;
            $data['url'] = 'client/tos-view/'.$user ->id;
        }

        return $data;
    }
        
    
}
