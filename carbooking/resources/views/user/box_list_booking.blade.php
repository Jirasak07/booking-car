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
</div>
