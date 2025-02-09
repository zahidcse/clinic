@if (count($recomandations) > 0)
    @foreach ($recomandations as $recomandation)
        <div class="general_note_wrapper mb-20">
            <div class="pull-right">
                <a onclick="loadRecomandationEditModal({{ $recomandation }})" class="">
                    <span class="text-primary">Edit</span>
                </a>
                <a onclick="loadRecomandationDeleteModal({{ $recomandation->id }})" class="">
                    <span class="text-danger">Delete</span>
                </a>
            </div>
            <ul>
                <li>Date:
                    <b>{{ Carbon\Carbon::parse($recomandation->created_at)->format('m/d/Y') }}</b>
                </li>
                <li class="">Author:
                    <b>{{ App\Models\User::user_info($recomandation->created_by)->name }}</b>
                </li>
                @if ($recomandation->edited_by != '')
                    <li class="mb-10">Edited By:
                        <b>{{ App\Models\User::user_info($recomandation->edited_by)->name }}</b>
                    </li>
                @endif
                <br>
                <div class="content-wrapper">
                    @php
                        $isContentLong = strlen(strip_tags($recomandation->recomandation)) > 200;
                    @endphp

                    <div class="content-preview">
                        {!! $isContentLong ? Str::limit($recomandation->recomandation, 200) : $recomandation->recomandation !!}
                    </div>

                    @if ($isContentLong)
                        <div class="content-full" style="display: none;">
                            {!! $recomandation->recomandation !!}
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
