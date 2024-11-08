<div class="page-inner" style="padding-left:50px">
    <div class="d-flex justify-content-center pl-5">
        {{-- style="border: 1px solid black; padding-left:40px" --}}
        <div class="row">
            <div class="row mb-4">
                <h3 class="fw-bold mb-3">Dashboard</h3>
                <h6 class="op-7 mb-2">Laguna University Queuing Management System</h6>
            </div>
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="d-flex align-items-center card queue-ongoing-card pb-2">

                        <div class="d-flex flex-column justify-content-center align-items-center queue-window">
                            <h5 id="now-serving">Waiting...</h5>

                            <h1><span id="client-number">---</span></h1>
                            <h6>Cashier Transaction</h6> {{-- waiting --}}
                            <p><span id="client-name">---</span></p>
                        </div>
                        <div>
                            <button class="btn btn-primary btn-sm" id="fetch-oldest-client">Next</button>
                            <button class="btn btn-primary btn-sm" id="notify-button">Notify</button>
                            <button class="btn btn-primary btn-sm" id="wait-button">Wait</button>
                        </div>
                    </div>
                </div>
                <div class="cold-12 col-md-4">
                    <div class="card queue-stack-card">
                        <div class="card-header text-center"> Cashier Queue Stack </div>
                        <ul class="list-group list-group-flush" id="user-list">
                            <li class="list-group-item"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
