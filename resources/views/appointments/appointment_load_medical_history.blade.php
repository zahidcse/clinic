@if (count($patient_medical_history) > 0)
    @foreach ($patient_medical_history as $mHistory)
        <div class="general_note_wrapper mb-20">
            <div class="pull-right">
                <a onclick="loadMedicalHistoryEditModal({{ $mHistory }})" class="">
                    <span class="text-primary">Edit</span>
                </a>
                <a onclick="loadMedicalHistoryDeleteModal({{ $mHistory->id }})" class="">
                    <span class="text-danger">Delete</span>
                </a>
            </div>
            <ul>
                <li>Date:
                    <b>{{ Carbon\Carbon::parse($mHistory->created_at)->format('m/d/Y') }}</b>
                </li>
                <li class="">Author:
                    <b>{{ App\Models\User::user_info($mHistory->created_by)->name }}</b>
                </li>
                @if ($mHistory->modified_by != '')
                    <li class="mb-10">Edited By:
                        <b>{{ App\Models\User::user_info($mHistory->modified_by)->name }}</b>
                    </li>
                @endif
                <br>
                Type: {{ App\Models\MedicalHistoryType::getType($mHistory->type)->type_name }}
                <div class="content-wrapper">
                    @php
                        $isContentLong = strlen(strip_tags($mHistory->details)) > 200;
                    @endphp

                    <div class="content-preview">
                        {!! $isContentLong ? Str::limit($mHistory->details, 200) : $mHistory->details !!}
                    </div>

                    @if ($isContentLong)
                        <div class="content-full" style="display: none;">
                            {!! $mHistory->details !!}
                        </div>
                        <a class="read-more-link" onclick="toggleContent()">Read
                            More</a>
                    @endif
                </div>

            </ul>
        </div>
    @endforeach
@else
    <img class="img-fluid for-light" src="{{ asset('assets/images/user/note-remove.png') }}" alt="" />
@endif
