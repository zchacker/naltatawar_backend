<!DOCTYPE html>
@if(app()->getLocale() == 'ar')
<html lang="ar" dir="rtl">
@else
<html lang="en" dir="ltr">
@endif

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <!-- alerts  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    

    @vite(['resources/css/app.css' , 'resources/js/app.js'])    
    <title>{{ __('controle_panel') }}</title>
    <style>
        html, * {
            font-family: 'Cairo', sans-serif;            
        }
    </style>
</head>

<body>
<div class="container flex">

<div class="fixed w-[280px] bg-light-secondary h-[100vh] py-8 print:hidden print:w-0">
    <a href="http://naltatawar.com" >
        <img src="{{ asset('imgs/n-logo.png') }}" alt="" class="w-[100px]" />
    </a>

    <div class="items-list mt-4">

        <a href="{{ route('client.home') }}">
            <div class="flex items-center gap-4 border-t-[1px] border-white text-white p-2 py-3 bg-secondary active_nav_item1 hover:bg-primary">
                <img src="{{ asset('imgs/home.png') }}" alt="" class="h-[30px]">
                <h3>الرئيسية</h3>
            </div>
        </a>

        <a href="{{ route('client.property.list') }}">
            <div class="flex items-center gap-4 border-t-[1px] border-white text-white p-2 py-3 bg-secondary hover:bg-primary">
                <img src="{{ asset('imgs/houses.png') }}" alt="" class="h-[30px]">
                <h3>الوحدات العقارية</h3>
            </div>
        </a>

        <a href="{{ route('client.contacts.home') }}">
            <div class="flex items-center gap-4 border-t-[1px] border-white text-white p-2 py-3 bg-secondary hover:bg-primary">
                <img src="{{ asset('imgs/envelope.png') }}" alt="" class="h-[30px]">
                <h3> طلبات التواصل </h3>
            </div>
        </a>

        <a href="{{ route('client.users.home') }}">
            <div class="flex items-center gap-4 border-t-[1px] border-white text-white p-2 py-3 bg-secondary hover:bg-primary">
                <img src="{{ asset('imgs/users.png') }}" alt="" class="h-[30px]">
                <h3> المستخدمون </h3>
            </div>
        </a>

        <a href="{{ route('client.payments') }}">
            <div class="flex items-center gap-4 border-t-[1px] border-white text-white p-2 py-3 bg-secondary hover:bg-primary">
                <img src="{{ asset('imgs/invoice.png') }}" alt="" class="h-[30px]">
                <h3> الفوترة والاشتراك </h3>
            </div>
        </a>

        <a href="{{ route('client.support.list') }}">
            <div class="flex items-center gap-4 border-t-[1px] border-white text-white p-2 py-3 bg-secondary hover:bg-primary">
                <img src="{{ asset('imgs/support.png') }}" alt="" class="h-[30px]">
                <h3> الدعم الفني </h3>
            </div>
        </a>

        <a href="{{ route('client.settings') }}">
            <div class="flex items-center gap-4 border-t-[1px] border-white text-white p-2 py-3 bg-secondary hover:bg-primary">
                <img src="{{ asset('imgs/settings.png') }}" alt="" class="h-[30px]">
                <h3> الاعدادات </h3>
            </div>
        </a>

    </div>

    <div class="absolute bottom-0 right-0 left-0">
        <a href="{{ route('client.logout') }}">
            <div class="flex items-center gap-4 border-t-[1px] border-white text-white p-2 py-3 bg-[#FF6062]">
                <img src="{{ asset('imgs/logout.png') }}" alt="" class="h-[30px]">
                <h3>تسجيل الخروج</h3>
            </div>
        </a>
    </div>
</div>

<!-- start content  -->
<div class="ms-[300px] py-8 mx-auto w-full">