<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ $title }}</h4>
    </div>
    <div class="card-body">
        <ul class="nav nav-pills nav-primary" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-tab1" data-bs-toggle="pill" href="#pills-pane1" role="tab" aria-controls="pills-pane1" aria-selected="true">{{ $panel1 }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-tab2" data-bs-toggle="pill" href="#pills-pane2" role="tab" aria-controls="pills-pane2" aria-selected="false">{{ $panel2 }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-tab3" data-bs-toggle="pill" href="#pills-pane3" role="tab" aria-controls="pills-pane3" aria-selected="false">{{ $panel3 }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-tab4" data-bs-toggle="pill" href="#pills-pane4" role="tab" aria-controls="pills-pane4" aria-selected="false">{{ $panel4 }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-tab5" data-bs-toggle="pill" href="#pills-pane5" role="tab" aria-controls="pills-pane5" aria-selected="false">{{ $panel5 }}</a>
            </li>
        </ul>
        <div class="tab-content mt-2 mb-3" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-pane1" role="tabpanel" aria-labelledby="pills-tab1">
                {{ $body1 }}
            </div>
            <div class="tab-pane fade" id="pills-pane2" role="tabpanel" aria-labelledby="pills-tab2">
                {{ $body2 }}
            </div>
            <div class="tab-pane fade" id="pills-pane3" role="tabpanel" aria-labelledby="pills-tab3">
                {{ $body3 }}
            </div>
            <div class="tab-pane fade" id="pills-pane4" role="tabpanel" aria-labelledby="pills-tab4">
                {{ $body4 }}
            </div>
            <div class="tab-pane fade" id="pills-pane5" role="tabpanel" aria-labelledby="pills-tab5">
                {{ $body5 }}
            </div>
        </div>
    </div>
</div>
