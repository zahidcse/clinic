@foreach($selected_consent as $item)
    <div class="blog-box blog-list row">
        <div class="col-sm-3">
            <img class="img-fluid sm-100-w" src="{{ asset($item->consent_from->file_path) }}" alt="">
        </div>
        <div class="col-sm-9">
            <div class="blog-details">
                <div class="blog-date"><span>05</span> January 2024</div>
                <h4>{{ $item->consent_from->title }} </h4>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>Status:</li>
                        <li>Signed</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endforeach
