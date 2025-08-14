<div class="card">
    <div class="card-body">
        <ul class="nav nav-pills nav-primary" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-tab111" data-bs-toggle="pill" href="#pills-pane111" role="tab" aria-controls="pills-pane111" aria-selected="true">{{ $panel1 }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-tab222" data-bs-toggle="pill" href="#pills-pane222" role="tab" aria-controls="pills-pane222" aria-selected="false">{{ $panel2 }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-tab333" data-bs-toggle="pill" href="#pills-pane333" role="tab" aria-controls="pills-pane333" aria-selected="false">{{ $panel3 }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-tab444" data-bs-toggle="pill" href="#pills-pane444" role="tab" aria-controls="pills-pane444" aria-selected="false">{{ $panel4 }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-tab555" data-bs-toggle="pill" href="#pills-pane555" role="tab" aria-controls="pills-pane555" aria-selected="false">{{ $panel5 }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-tab666" data-bs-toggle="pill" href="#pills-pane666" role="tab" aria-controls="pills-pane666" aria-selected="false">{{ $panel6 }}</a>
            </li>
        </ul>
        <div class="tab-content mt-2 mb-3" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-pane111" role="tabpanel" aria-labelledby="pills-tab111">
                {{ $body1 }}
            </div>
            <div class="tab-pane fade" id="pills-pane222" role="tabpanel" aria-labelledby="pills-tab222">
                {{ $body2 }}
            </div>
            <div class="tab-pane fade" id="pills-pane333" role="tabpanel" aria-labelledby="pills-tab333">
                {{ $body3 }}
            </div>
            <div class="tab-pane fade" id="pills-pane444" role="tabpanel" aria-labelledby="pills-tab444">
                {{ $body4 }}
            </div>
            <div class="tab-pane fade" id="pills-pane555" role="tabpanel" aria-labelledby="pills-tab555">
                {{ $body5 }}
            </div>
            <div class="tab-pane fade" id="pills-pane666" role="tabpanel" aria-labelledby="pills-tab666">
                {{ $body6 }}
            </div>
        </div>
    </div>
</div>
