<!-- box header booking pages -->
<div class="container-fluid mt-4 ">
    <div class="d-flex flex-xl-row flex-column" style="gap: 10px;min-height:120px">
        <div class=" w-100 m-dash rounded">
            <div class=" rounded h-100 booking-all d-flex flex-row align-items-center" style="min-height:120px">
                <div class="h-100 col  text-white icon-d-2  icon-circle">
                    <i class="fa-solid fa-clipboard-list  icon-dashboard "></i>
                </div>
                <div class="col d-flex flex-column align-items-center text-white">
                    <div class="text-white ">ทั้งหมด</div>
                    <div style="font-size: 4rem;line-height: 80%;"id="alllist">{{ $Alllist }}</div>
                    <div>รายการ </div>
                </div>
            </div>
        </div>

        <div class="w-100  m-dash rounded">
            <div class=" rounded h-100 pending  d-flex flex-row align-items-center " style="min-height:120px">
                <div class="h-100 col icon-d-2 icon-circle  "> <i class="fa-solid fa-hourglass-end icon-dashboard "></i>
                </div>
                <div class="col text-white d-flex flex-column align-items-center">
                    <div>รอดำเนินการ</div>
                    <div style="font-size: 4rem;line-height: 80%;" id="alllistpending">{{ $Alllistpending }}</div>
                    <div>รายการ</div>
                </div>
            </div>
        </div>
        <div class="w-100  m-dash rounded">
            <div class="rounded text-white h-100 confirm d-flex flex-row align-items-center"style="min-height:120px">

                <div class="h-100  col icon-d-2 icon-circle  "><i class="fa-solid fa-circle-check icon-dashboard "></i>
                </div>
                <div class="col  d-flex flex-column align-items-center  ">
                    <div>อนุมัติแล้ว</div>
                    <div style="font-size: 4rem;line-height: 80%;" id="alllistapprove">{{ $Alllistapprove }}</div>
                    <div>รายการ</div>
                </div>
            </div>
        </div>

        <div class="w-100  m-dash rounded">
            <div class=" bg-cancel rounded h-100 w-100 cancel  d-flex flex-row align-items-center"
                style="min-height:120px">

                <div class=" h-100 icon-d-2 icon-circle col"><i class="fa-solid fa-circle-xmark icon-dashboard "></i>
                </div>
                <div class="col text-white d-flex flex-column align-items-center ">
                    <div>ยกเลิกแล้ว</div>
                    <div style="font-size: 4rem;line-height: 80%;" id="alllistcancle">{{ $Alllistcancle }}</div>
                    <div>รายการ</div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="pt-5">
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
</div> --}}
    <!-- end box header booking pages -->
