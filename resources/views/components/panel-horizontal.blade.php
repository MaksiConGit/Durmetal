<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ $title }}</h4>
    </div>
    <div class="card-body">
        <ul class="nav nav-pills nav-primary" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">{{ $panel1 }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">{{ $panel2 }}</a>
            </li>
        </ul>
        <div class="tab-content mt-2 mb-3" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                {{ $body1 }}
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                {{ $body2 }}
            </div>
        </div>
    </div>
</div>
