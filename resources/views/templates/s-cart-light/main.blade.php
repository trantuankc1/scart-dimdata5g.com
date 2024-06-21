<!DOCTYPE html>
<html class="wide wow-animation" lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css"
          href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700%7CLato%7CKalam:300,400,700">
    <link rel="canonical" href="{{ request()->url() }}"/>
    <meta name="description" content="{{ $description??sc_store('description') }}">
    <meta name="keywords" content="{{ $keyword??sc_store('keyword') }}">
    <title>{{$title??sc_store('title')}}</title>
    <link rel="icon" href="{{ sc_file(sc_store('icon', null, 'images/icon.png')) }}" type="image/png" sizes="16x16">
    <meta property="og:image" content="{{ !empty($og_image)?sc_file($og_image):sc_file('images/org.jpg') }}"/>
    <meta property="og:url" content="{{ \Request::fullUrl() }}"/>
    <meta property="og:type" content="Website"/>
    <meta property="og:title" content="{{ $title??sc_store('title') }}"/>
    <meta property="og:description" content="{{ $description??sc_store('description') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- css default for item s-cart -->
    @include($sc_templatePath.'.common.css')
    <!--//end css defaut -->

    <!--Module header -->
    @includeIf($sc_templatePath.'.common.render_block', ['positionBlock' => 'header'])
    <!--//Module header -->

    <link rel="stylesheet" href="{{ sc_file($sc_templateFile.'/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ sc_file($sc_templateFile.'/css/fonts.css')}}">
    <link rel="stylesheet" href="{{ sc_file($sc_templateFile.'/css/style.css')}}">
    <style>
        {!! sc_store_css() !!}
    </style>
    <style>.ie-panel {
            display: none;
            background: #212121;
            padding: 10px 0;
            box-shadow: 3px 3px 5px 0 rgba(0, 0, 0, .3);
            clear: both;
            text-align: center;
            position: relative;
            z-index: 1;
        }
        .rd-navbar-nav-wrap{
            font-family: "Roboto", sans-serif;
            font-weight: 700;
            font-style: normal;
        }
        .product{
            font-family: "Roboto", sans-serif !important;
            font-weight: 700 !important;;
            font-style: normal !important;;
        }
        .sim_data_qa_phone_support{
            color: black;
            font-family: "Roboto", sans-serif;
            font-style: normal;
            font-weight: bolder;

        }
        .button-secondary{
            font-weight: bold;
        }
        .bg-default{
            font-family: "Roboto", sans-serif;
            font-weight: 550;
            font-style: normal;
            color: black;
        }

        html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {
            display: block;
        }</style>
    @stack('styles')
</head>
<body>
<div class="ie-panel">
    <a href="http://windows.microsoft.com/en-US/internet-explorer/">
        <img src="{{ sc_file($sc_templateFile.'/images/ie8-panel/warning_bar_0000_us.jpg')}}" height="42" width="820"
             alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today.">
    </a>
</div>

<div class="page">
    {{-- Block header --}}
    @section('block_header')
        @include($sc_templatePath.'.block_header')
    @show
    {{--// Block header --}}

    {{-- Block top --}}
    @section('block_top')
        @include($sc_templatePath.'.block_top')

        <!--Breadcrumb -->
        @section('breadcrumb')
            @include($sc_templatePath.'.common.breadcrumb')
        @show
        <!--//Breadcrumb -->

        <!--Notice -->
        @include($sc_templatePath.'.common.notice')
        <!--//Notice -->
    @show
    {{-- //Block top --}}

    {{-- Block main --}}
    @section('block_main')
        <section class="section section-xxl bg-default text-md-left">
            <div class="container">
                <div class="row row-50">
                    @section('block_main_content')

                        @if (empty($hiddenBlockLeft))
                            <!--Block left-->
                            <div class="col-lg-4 col-xl-3">
                                @section('block_main_content_left')
                                    @include($sc_templatePath.'.block_main_content_left')
                                @show
                            </div>
                            <!--//Block left-->

                            <!--Block center-->
                            <div class="col-lg-9 col-xl-9">
                                @section('block_main_content_center')
                                    @include($sc_templatePath.'.block_main_content_center')
                                @show
                            </div>
                            <!--//Block center-->
                        @else
                            <!--Block center-->
                            @section('block_main_content_center')
                                @include($sc_templatePath.'.block_main_content_center')
                            @show
                            <!--//Block center-->
                        @endif

                        @if (empty($hiddenBlockRight))
                            <!--Block right -->
                            @section('block_main_content_right')
                                @include($sc_templatePath.'.block_main_content_right')
                            @show
                            <!--//Block right -->
                        @endif

                    @show
                </div>
            </div>
        </section>
    @show
    {{-- //Block main --}}

    <!-- Render include view -->
    @include($sc_templatePath.'.common.include_view')
    <!--// Render include view -->

    <div class="container sim_data_qa_phone_support mt-3">
        <div class="sim_data_text_content_phone_support">
            <h2>Điện thoại của tôi có <span class="sim_data_text_active">hỗ trợ eSIM</span> không ?</h2>
        </div>
        <nav class="nav nav-pills nav-fill sim_data_trademark_phone text-capitalize">
            <a class="nav-link active sim_data_trademark_phone" aria-current="page" href="#" data-tab="tab1">Apple</a>
            <a class="nav-link sim_data_trademark_phone" href="#" data-tab="tab2">Samsung</a>
            <a class="nav-link sim_data_trademark_phone" href="#" data-tab="tab4">google</a>
            <a class="nav-link sim_data_trademark_phone" href="#" data-tab="tab3">Nhãn hàng khác</a>
        </nav>

        <div class="tab-container">
            <div class="tab-content active mt-3" id="tab1">
                <div class="row">
                    <div class="col-md-3">
                        <div class="sim_data_description_apple">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fa fa-check"></i> <span class="name-dive-support">iPhone 14, 14 Plus, Pro, 14
                                        Pro Max</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i> <span class="name-dive-support">iPhone 13, 13 Mini, 13 Pro,
                                        13 Pro Max, SE 3 (2022)</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i> <span class="name-dive-support">iPhone 12, 12 Mini, 12 Pro,
                                        12 Pro Max</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i> <span class="name-dive-support">iPhone 11, 11 Pro, 11 Pro Max</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i> <span class="name-dive-support">iPhone XS, XS Max, XR</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i> <span class="name-dive-support">iPhone SE (2020, 2022)</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i> <span class="name-dive-support">iPad Pro 11-inch (thế hệ 1,
                                        2, 3)</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="sim_data_description_apple">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fa fa-check"></i> <span class="name-dive-support">iPad Pro 12.9-inch (thế hệ 3,
                                        4, 5)</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i> <span class="name-dive-support">iPad (thế hệ 7, 8, 9)</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i> <span class="name-dive-support">iPad Mini (thế hệ 5, 6)</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i> <span class="name-dive-support">Apple watch series 3, 4, 5</span>
                                    and 6
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i> <span class="name-dive-support">iPhone XS, XS Max, XR</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i> <span class="name-dive-support">Apple watch SE</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i> <span class="name-dive-support">iPad Pro 12.9-inch (thế hệ 3,
                                        4, 5)</span>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 bg-esim-qa">
                        <img src="{{ asset('images/iphone-4s-svgrepo-com.svg') }}" alt="" srcset=""
                             width="400px">
                    </div>
                </div>
            </div>
            <div class="tab-content mt-3" id="tab2">
                <div class="row">
                    <div class="col-md-3">
                        <div class="sim_data_description_apple">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Galaxy S23, S23, S23 Ultra</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Galaxy S22, S22+ 5G, S22</span>
                                    Ultra 5G
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Galaxy S21, S21+ 5G, S21
                                        Ultra 5G</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Galaxy S20, S20+, S20 Ultra</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="sim_data_description_apple">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Galaxy Note 20, 20+, 20 Ultra</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Galaxy Z Fold, Fold 2, Fold
                                        3, Fold 4</span>

                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Galaxy Watch</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Galaxy Z Flip, Flip 3, Flip 4</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 bg-esim-qa">
                        <img src="{{ asset('images/samsung.svg') }}" alt="" srcset="" width="400px">
                    </div>
                </div>
            </div>
            <div class="tab-content mt-3" id="tab3">
                <div class="row">
                    <div class="col-md-3">
                        <div class="sim_data_description_apple">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Huawei P40, P40 Pro</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Huawei Mate 40 pro</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Oppo Find X5, X5 Pro, X3 Pro</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Oppo Reno 5A, Reno 6 Pro 5G</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Sony Xperia 1 IV</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Sony Xperia 10 IV</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Sony Xperia 10 III Lite</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="sim_data_description_apple">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Motorola Razr (2019), Razr 5G</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Microsoft Surface Duo</span>

                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Nuu Mobile X5</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Honor Magic 4 Pro</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Fairphone 4</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 bg-esim-qa">
                        <img src="{{ asset('images/orther.svg') }}" alt="" srcset="" width="300px">
                    </div>
                </div>
            </div>

            <div class="tab-content mt-3" id="tab4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="sim_data_description_apple">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Google Pixel 2</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Google Pixel 4/ 4XL/ 4a</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Google Pixel 6/ 6Pro, 6a</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Google Pixel 8/ 8Pro</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="sim_data_description_apple">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fa fa-check"></i><span class="name-dive-support">Google Pixel 7, 7 Pro</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i>
                                    <span class="name-dive-support">Google Pixel 3/ 3XL/ 3a</span>

                                </li>
                                <li class="list-group-item"><span class="name-dive-support">Google Pixel 5/ 5a</span>

                                </li>
                                <li class="list-group-item"><i class="fa fa-check"></i>
                                    <span class="name-dive-support">Google Pixel 7/ 7Pro</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 bg-esim-qa">
                        <img src="{{ asset('images/google-phone.svg') }}" alt="" srcset="" width="400px">
                    </div>
                </div>
            </div>


        </div>
    </div>

    {{-- Block bottom --}}
    @section('block_bottom')
        @include($sc_templatePath.'.block_bottom')
    @show
    {{-- //Block bottom --}}

    {{-- Block footer --}}
    @section('block_footer')
        @include($sc_templatePath.'.block_footer')
    @show
    {{-- //Block footer --}}

</div>

<div id="sc-loading">
    <div class="sc-overlay"><i class="fa fa-spinner fa-pulse fa-5x fa-fw "></i></div>
</div>

<script src="{{ sc_file($sc_templateFile.'/js/core.min.js')}}"></script>
<script src="{{ sc_file($sc_templateFile.'/js/script.js')}}"></script>

<!-- js default for item s-cart -->
@include($sc_templatePath.'.common.js')
<!--//end js defaut -->
@stack('scripts')

</body>
</html>


<style>
    .name-dive-support{
        margin-left: 5px;
    }
    .tab-content {
        text-align: justify;
    }

    .nav-pills .nav-link.active {
        background-color: grey;
    }

    .sim_data_trademark_phone {
        background-color: aliceblue;
    }

    .tab-content {
        display: none;
    }

    .tab-content1 {
        display: none;
    }

    .tab-content1.active_global {
        display: block;
    }

    .tab-content.active {
        display: block;
    }

    /* Màn hình rất nhỏ (điện thoại di động) */
    @media only screen and (max-width: 480px) {
        /* CSS cho màn hình rất nhỏ */
        .sim_data_background_search {
            display: none;
        }

        .sim_data_input_search {
            width: 100%;
        }

        .bg-esim-qa {
            display: none;
        }

        .tab-content {
            text-align: justify;
        }
    }

    /* Màn hình nhỏ (điện thoại di động ngang, máy tính bảng) */
    @media only screen and (min-width: 481px) and (max-width: 768px) {
        /* CSS cho màn hình nhỏ */
        .sim_data_background_search {
            display: none;
        }

        .sim_data_input_search {
            width: 100%;
        }

        .bg-esim-qa {
            display: none;
        }
    }

    /* Màn hình trung bình (máy tính bảng ngang, laptop) */
    @media only screen and (min-width: 769px) and (max-width: 1024px) {
        /* CSS cho màn hình trung bình */
        .sim_data_background_search {
            display: none;
        }

        .sim_data_input_search {
            width: 100%;
        }

        .bg-esim-qa {
            display: none;
        }

    }

    /* Màn hình lớn (máy tính, máy tính để bàn) */
    @media only screen and (min-width: 1025px) {
        /* CSS cho màn hình lớn */
    }

</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Định nghĩa hàm để xử lý sự kiện khi nhấn vào tab
        function handleTabClick(event) {
            event.preventDefault();
            const targetTab = this.getAttribute('data-tab');
            const tabContents = document.querySelectorAll('.tab-content');
            const tabs = document.querySelectorAll('.nav-link');

            tabs.forEach(t => t.classList.remove('active')); // Loại bỏ active từ tất cả các tab
            this.classList.add('active'); // Thêm active vào tab được bấm vào
            tabContents.forEach(content => {
                if (content.id === targetTab) {
                    content.classList.add('active');
                } else {
                    content.classList.remove('active');
                }
            });
        }

        // Lấy danh sách các tab Apple và Samsung
        const appleTab = document.querySelector('[data-tab="tab1"]');
        const samsungTab = document.querySelector('[data-tab="tab2"]');
        const nhanhangkhac = document.querySelector('[data-tab="tab3"]');
        const google = document.querySelector('[data-tab="tab4"]');

        // Gán sự kiện khi nhấn vào tab cho các tab Apple và Samsung
        appleTab.addEventListener('click', handleTabClick);
        samsungTab.addEventListener('click', handleTabClick);
        nhanhangkhac.addEventListener('click', handleTabClick);
        google.addEventListener('click', handleTabClick);
    });


    document.addEventListener("DOMContentLoaded", function () {
        // Định nghĩa hàm để xử lý sự kiện khi nhấn vào tab
        function handleTabClick(event) {
            event.preventDefault();
            const targetTab = this.getAttribute('data-tab');
            const tabContents = document.querySelectorAll('.tab-content1');
            const tabs = document.querySelectorAll('.nav-link');

            tabs.forEach(t => t.classList.remove('active_global')); // Loại bỏ active từ tất cả các tab
            this.classList.add('active_global'); // Thêm active vào tab được bấm vào
            tabContents.forEach(content => {
                if (content.id === targetTab) {
                    content.classList.add('active_global');
                } else {
                    content.classList.remove('active_global');
                }
            });
        }

        // Lấy danh sách các tab Apple và Samsung
        const quocgia = document.querySelector('[data-tab="tab11"]');
        const chauluc = document.querySelector('[data-tab="tab12"]');
        const toancau = document.querySelector('[data-tab="tab13"]');

        // Gán sự kiện khi nhấn vào tab cho các tab Apple và Samsung
        quocgia.addEventListener('click', handleTabClick);
        chauluc.addEventListener('click', handleTabClick);
        toancau.addEventListener('click', handleTabClick);
    });


    function setActiveLink() {
        var links = document.querySelectorAll(".nav-link");

        links.forEach(function (link) {
            link.addEventListener("click", function (event) {
                // Loại bỏ lớp 'active' từ tất cả các liên kết
                links.forEach(function (link) {
                    link.classList.remove("active");
                });

                // Thêm lớp 'active' cho liên kết được bấm
                this.classList.add("active");
            });
        });
    }

    // Gọi hàm để thiết lập sự kiện cho các liên kết
    setActiveLink();

</script>