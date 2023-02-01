<!-- box header booking pages -->
<div class="container-fluid mt-4 ">
    <div class="d-flex flex-xl-row flex-column" style="gap: 10px;min-height:120px">
        <div class="card w-100 rounded text-darker" style="background-color: #427AA1;">
            <div class=" rounded h-100 d-flex flex-row align-items-center"
                style="min-height:120px;">
                <div class="h-100 col icon-d-2 icon-circle text-white">
                    <i class="fa-solid fa-clipboard-list  icon-dashboard "></i>
                </div>
                <div class="col d-flex flex-column align-items-center text-white">
                    <div class="">ทั้งหมด</div>
                    <div style="font-size: 4rem;line-height: 80%;"id="alllist">{{ $Alllist }}</div>
                    <div>รายการ </div>
                </div>
            </div>
        </div>

        <div class=" card w-100 rounded" style="background-color: #FFB400;">
            <div class=" rounded h-100 d-flex flex-row align-items-center"
                style="min-height:120px;">
                <div class="h-100 col icon-d-2 icon-circle">
                    <i class="fa-solid fa-hourglass-end icon-dashboard "></i>
                </div>
                <div class="col d-flex flex-column align-items-center text-white">
                    <div>รอดำเนินการ</div>
                    <div style="font-size: 4rem;line-height: 80%;" id="alllistpending">{{ $Alllistpending }}</div>
                    <div>รายการ</div>
                </div>
            </div>
        </div>
        <div class=" card w-100 rounded" style="background-color: #00A878;">
            <div class="rounded h-100 d-flex flex-row align-items-center"style="min-height:120px;">
                <div class="h-100 col icon-d-2 icon-circle">
                    <i class="fa-solid fa-circle-check icon-dashboard "></i>
                </div>
                <div class="col d-flex flex-column align-items-center text-white">
                    <div>อนุมัติแล้ว</div>
                    <div style="font-size: 4rem;line-height: 80%;" id="alllistapprove">{{ $Alllistapprove }}</div>
                    <div>รายการ</div>
                </div>
            </div>
        </div>

        <div class=" card w-100 rounded" style="background-color: #FF6B6B;">
            <div class="rounded h-100 w-100 d-flex flex-row align-items-center"
                style="min-height:120px;">
                <div class=" h-100 icon-d-2 icon-circle col">
                    <i class="fa-solid fa-circle-xmark icon-dashboard "></i>
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
