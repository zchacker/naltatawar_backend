@include('auth.header')
<div class="container flex flex-col mx-auto">

    <div class="flex items-center justify-center pt-10">
        <img src="{{ asset('imgs/n-logo.png') }}" class="w-[200px]" alt="web site logo">
    </div>

    <!-- login form -->
    <div class="flex flex-col space-y-2 w-[400px] mx-auto mt-10 items-center">
        <form action="{{ route('auth.sign_up.action') }}" method="post" class="flex flex-col space-y-4 w-full">
            <h1 class="font-bold"> {{ __('register') }} </h1>
            @csrf

            @if(Session::has('errors'))
            <div class="my-3 w-full p-4 flex flex-col gap-4 space-y-8 bg-orange-500 text-white text-sm rounded-md">
                {!! session('errors')->first('register_error') !!}
            </div>
            @endif

            <input type="text" name="name" class="input" placeholder="{{ __('name') }}">

            <input type="tel" name="phone" dir="rtl" class="input" placeholder="{{ __('phone') }}">

            <input type="email" name="email" class="input" placeholder="{{ __('email') }}">

            <input type="password" name="password" class="input" placeholder="{{ __('password') }}">

            <button type="submit" class="submit_btn">{{ __('register_account') }}</button>
        </form>
        <a href="{{ route('auth.login') }}" class="text-blue-600 hover:underline">{{ __('login') }}</a>
    </div>

</div>
@include('auth.footer')