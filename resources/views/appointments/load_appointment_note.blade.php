@if (count($appointment_notes) > 0)
    @foreach ($appointment_notes as $appointment_note)
        <div class="general_note_wrapper mb-20">
            <div class="pull-right">
                <a onclick="loadEditModal({{ $appointment_note }})" class="">
                    <span class="text-primary">Edit</span>
                </a>
                <a onclick="loadDeleteModal({{ $appointment_note->id }})" class="">
                    <span class="text-danger">Delete</span>
                </a>
            </div>
            <ul>
                <li>Date:
                    <b>{{ Carbon\Carbon::parse($appointment_note->created_at)->format('m/d/Y') }}</b>
                </li>
                <li class="">Author:
                    <b>{{ App\Models\User::user_info($appointment_note->created_by)->name }}</b>
                </li>
                @if ($appointment_note->modified_by != '')
                    <li class="mb-10">Edited By:
                        <b>{{ App\Models\User::user_info($appointment_note->modified_by)->name }}</b>
                    </li>
                @endif
                <br>
                {{-- {!! $appointment_note->note !!} --}}
                <div class="content-wrapper">
                    @php
                        $isContentLong = strlen(strip_tags($appointment_note->note)) > 200;
                    @endphp

                    <div class="content-preview">
                        {!! $isContentLong ? Str::limit($appointment_note->note, 200) : $appointment_note->note !!}
                    </div>

                    @if ($isContentLong)
                        <div class="content-full" style="display: none;">
                            {!! $appointment_note->note !!}
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
