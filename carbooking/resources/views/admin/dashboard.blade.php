@extends('layouts.layout')
@section('content')
    @include('layouts.header')
    <div class="container mt-3  " style="max-width: 1080px;min-width:375px">
        <div class="mx-5 my-3 text-default" style="font-weight: 700;font-size:1.2rem"> รายการจอง</div>
        <div class="d-flex flex-xl-row flex-column mx-3   " style="gap: 10px;min-height:120px">

            <div class=" w-100  rounded">
                <div class=" rounded h-100 booking-all d-flex flex-row align-items-center" style="min-height:120px">
                    <div class="h-100 col   icon-d-2  ">
                        <i class="fa-solid fa-clipboard-list  icon-dashboard "></i>
                    </div>
                    <div class="col d-flex flex-column align-items-center ">
                        <div class=" ">ทั้งหมด</div>
                        <div style="font-size: 4rem;line-height: 80%;"id="all">0</div>
                        <div class="">รายการ </div>
                    </div>
                </div>
            </div>

            <div class="w-100   rounded">
                <div class=" rounded pending h-100 d-flex flex-row align-items-center  " style="min-height:120px;">
                    <div class="h-100 col icon-d-2   "> <i class="fa-solid fa-hourglass-end icon-dashboard "></i>
                    </div>
                    <div class="col  d-flex flex-column align-items-center">
                        <div>รอดำเนินการ</div>
                        <div style="font-size: 4rem;line-height: 80%;" id="pending">0</div>
                        <div>รายการ</div>
                    </div>
                </div>
            </div>
            <div class="w-100   rounded">
                <div class="rounded  h-100 confirm d-flex flex-row align-items-center"style="min-height:120px">

                    <div class="h-100  col icon-d-2   "><i class="fa-solid fa-circle-check icon-dashboard "></i>
                    </div>
                    <div class="col  d-flex flex-column align-items-center  ">
                        <div>อนุมัติแล้ว</div>
                        <div style="font-size: 4rem;line-height: 80%;" id="approve">0</div>
                        <div>รายการ</div>
                    </div>
                </div>
            </div>

            <div class="w-100   rounded">
                <div class=" bg-cancel rounded h-100 w-100 cancel  d-flex flex-row align-items-center"
                    style="min-height:120px">

                    <div class=" h-100 icon-d-2 col"><i class="fa-solid fa-circle-xmark icon-dashboard "></i>
                    </div>
                    <div class="col  d-flex flex-column align-items-center ">
                        <div>ยกเลิกแล้ว</div>
                        <div style="font-size: 4rem;line-height: 80%;" id="cancel">0</div>
                        <div>รายการ</div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" d-flex flex-column justify-content-between flex-lg-row pb-2  w-100">
            <div class="mt-3   col-12 col-lg-8 ">
                <canvas class="bg-white rounded  w-100 h-100 " style=" max-height: 520px;" id="Chart"></canvas>
            </div>
            <div class="mt-3  col-12 col-lg-4">
                <canvas class=" bg-white rounded  w-100 " style=" max-height: 420px;" id="myChart"></canvas>
            </div>
        </div>
        <div class="d-flex flex-column justify-content-center align-items-center mb-3 ">
            <div class="flex-column flex-lg-row  d-flex justify-content-between  w-100  ">
                @foreach ($car as $cars)
                    <div class="col-12 col-lg  mt-3 w-100 ">
                        <div class=" p-1 rounded d-flex flex-row   info-car " style="height: 110px;">

                            <div class="logo-car  col  d-flex flex-column align-items-center justify-content-center"
                                style="margin:0;">
                                <i class="fa-solid fa-car-rear icon-car-dashboard my-1 " style="font-size: 4rem;"></i>
                                <div class="lc_car " style="font-size: 0.8em;font-weight:500;">
                                    {{ $cars['car_license'] }}</div>
                            </div>
                            <div class="title-cars col">
                                <div class="brand-car  text-capitalize"
                                    style="font-size: 0.8em;font-weight:500;line-height:100%">
                                    {{ $cars['car_model'] }}</div>

                                <div class="res_car  ml-3 " style="font-size:3rem;line-height:80%;"
                                    id="tcar-{{ $cars['id'] }}">0</div>
                                <div class=" ml-3" style="font-size: 0.8em"> รายการ</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @if ($message = Session::get('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'การจองสำเร็555',
                    text: 'โปรดรอการอนุมัติ',
                })
            </script>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger" id="ERROR_COPY" style="display:none;">
                <ul style="list-style: none;">
                    @foreach ($errors->all() as $error)
                        <!-- ทำการ วน Loop เพื่อแสดง Error ของ validation ขึ้นมาทั้งหมด -->
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="bg-white p-3 rounded ml-3 mr-3 ">
            <div class="d-flex mb-3 head-beforcalendar"> หมายเหตุ <div class="ml-3 d-flex align-items-center"
                    style="font-size: 14px;gap:5px"><i class="fa-solid fa-square" style="color: #06d6a0"></i>
                    อนุมัติเรียบร้อย
                </div>
                <div class="ml-3 d-flex align-items-center" style="font-size: 14px;gap:5px"><i class="fa-solid fa-square"
                        style="color: #ffd166"></i>
                    รอดำเนินการ</div>
            </div>
            @include('admin.calendar_show')

        </div>
        <div class="mb-5"></div>
    </div>
    @push('js')
        <script>
            var has_error = {{ $errors->count() > 0 ? 'true' : 'false' }};
            if (has_error) {
                Swal.fire({
                    title: 'Error',
                    icon: 'error',
                    type: 'error',
                    html: jQuery("#ERROR_COPY").html(),
                    showCloseButton: true,
                });
            }
        </script>
    @endpush
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bookingcar1 = @json($bookingcarin);
            var allbook = @json($allbook);
            console.log("111", allbook);
            var car = @json($car);
            console.log(car);
            var allcar1 = @json($allcar1);
            var allcar2 = @json($allcar2);
            let i = 1;
            bookingcar1.forEach(element => {
                console.log(element, i);
                $('#tcar-' + i).html(bookingcar1[i - 1].suppercarcare);
                i++;
            });

            const ctx = document.getElementById('myChart');
            document.getElementById('all').innerHTML = allbook;
            document.getElementById('pending').innerHTML = @json($pending);
            document.getElementById('cancel').innerHTML = @json($cancel);
            document.getElementById('approve').innerHTML = @json($approve);

            // document.getElementById('car1').innerHTML = ;
            // document.getElementById('car2').innerHTML = bookingcar1[1].suppercarcare;
            // document.getElementById('car3').innerHTML = bookingcar1[2].suppercarcare;
            new Chart(ctx, {
                type: 'doughnut',

                data: data = {
                    labels: [
                        'รถภายใน',
                        'รถภายนอก',

                    ],
                    datasets: [{
                        label: 'มีการใช้งาน ครั้ง',
                        data: [allcar1[0].allcar1, allcar2[0].allcar2],
                        backgroundColor: [
                            'rgba( 18, 188, 0, 0.6 )',
                            'rgba( 248, 108, 0, 0.6 )',

                        ],
                        borderColor: [
                            '#12BC00',
                            '#F86C00',
                        ],
                        hoverOffset: 4
                    }],

                },
                options: {

                    maintainAspectRatio: false,
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'สัดส่วนการใช้งานของรถภายในและรถภายนอก'
                        }
                    }
                }
            });


        })
        var ctx = document.getElementById('Chart');
        const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
            'Oct', 'Nov', 'Dec'
        ];
        datab = [
            '5',
            '2'
        ]
        var countcar1 = @json($data1);
        var countcar2 = @json($data2);
        var car1 = [];
        var car2 = [];
        var teststore = [];
        for (let i = 0; i < 12; i++) {
            countcar1.forEach(a => {
                if (a.month == i) {

                    car1[i - 1] = a.data

                } else if (a.month != i) {
                    car1[i] = '0'
                }
            })
        }
        for (let i = 0; i < 12; i++) {
            countcar2.forEach(a => {
                if (a.month == i) {

                    car2[i - 1] = a.data

                } else if (a.month != i) {
                    car2[i] = '0'
                }
            })
        }



        console.log(teststore)
        // console.log('ชาร์ต',countcar1)
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'รถภายใน',
                    data: car1,
                    backgroundColor: 'rgba( 18, 188, 0, 0.6 )',
                    borderColor: '#12BC00',
                    borderWidth: 2
                }, {
                    label: 'รถภายนอก',
                    data: car2,
                    backgroundColor: 'rgba( 248, 108, 0, 0.6 )',
                    borderColor: '#F86C00',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'การใช้งานของรถภายในและรถภายนอกในปี 2565'
                    }
                }
            }
        });

        setInterval(() => {
            $.ajax({
                url: '/admin/dashboard/refresh',
                method: 'GET',
                success: function(data) {
                    $('#all').html(data.allbooking);
                    $('#pending').html(data.pending);
                    $('#cancel').html(data.cancel);
                    $('#approve').html(data.approve);
                }
            })
        }, 5000);
    </script>
@endsection
