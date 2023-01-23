<!-- box header booking pages -->
<div class="pt-5">
    <div class="container-fluid">
        <div class="">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h3 class="card-title text-uppercase text-muted mb-0">การจองทั้งหมด</h3>
                                    <span class="h2 font-weight-bold mb-0" id="alllist">{{ $Alllist }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fa-solid fa-calendar-check"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h3 class="card-title text-uppercase text-muted mb-0">ยกเลิการจอง</h3>
                                    <span class="h2 font-weight-bold mb-0" id="alllistcancle">{{ $Alllistcancle }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fa-solid fa-ban"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h3 class="card-title text-uppercase text-muted mb-0">กำลังดำเนินการ</h3>
                                    <span class="h2 font-weight-bold mb-0" id="alllistpending">{{ $Alllistpending }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fa-regular fa-clock" style="font-size: 24px"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h3 class="card-title text-uppercase text-muted mb-0">ดำเนินการเสร็จสิ้น</h3>
                                    <span class="h2 font-weight-bold mb-0" id="alllistapprove">{{ $Alllistapprove }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                        <i class="fa-regular fa-circle-check" style="font-size: 24px"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end box header booking pages -->
