<div class="card">
    <div class="card-body">
        <ul class="nav nav-pills nav-primary" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-tab11" data-bs-toggle="pill" href="#pills-pane11" role="tab" aria-controls="pills-pane11" aria-selected="true">{{ $panel1 }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-tab22" data-bs-toggle="pill" href="#pills-pane22" role="tab" aria-controls="pills-pane22" aria-selected="false">{{ $panel2 }}</a>
            </li>
        </ul>
        <div class="tab-content mt-2 mb-3" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-pane11" role="tabpanel" aria-labelledby="pills-tab11">
                {{ $body1 }}
            </div>
            <div class="tab-pane fade" id="pills-pane22" role="tabpanel" aria-labelledby="pills-tab22">
                {{ $body2 }}
            </div>
        </div>
    </div>
</div>
