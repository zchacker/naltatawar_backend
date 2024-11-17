@include('auth.header')
<div class="container flex flex-col mx-auto">

    <div class="flex items-center justify-center pt-10">
        <img src="{{ asset('imgs/n-logo.png') }}" class="w-[200px]" alt="web site logo">
    </div>

    <!-- login form -->
    <div class="flex flex-col space-y-2 w-[400px] mx-auto mt-10 items-center">
        <form action="" method="post" class="flex flex-col space-y-4 w-full">
            <h1 class="font-bold"> {{ __('enter_otp') }} </h1>
            
            <input type="text" name="otp" class="input" placeholder="{{ __('otp') }}">                        

            <button type="submit" class="submit_btn">{{ __('verify_otp') }}</button>
        </form>
        <a href="#" class="text-blue-600 hover:underline">{{ __('resend_otp') }}</a>
    </div>

</div>
@include('auth.footer')