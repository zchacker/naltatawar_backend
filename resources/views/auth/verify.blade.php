@include('auth.header')
<div class="container flex flex-col mx-auto">

    <div class="flex items-center justify-center pt-10">
        <img src="{{ asset('imgs/n-logo.png') }}" class="w-[200px]" alt="web site logo">
    </div>

    <!-- login form -->
    <div class="flex flex-col space-y-2 w-[400px] mx-auto mt-10 items-center">
    
        @if(Session::has('errors'))
        <div class="my-3 w-full p-4 flex flex-col gap-4 space-y-8 bg-orange-500 text-white text-sm rounded-md">
            {!! session('errors')->first('register_error') !!}
        </div>
        @endif

        <form action="{{ route('auth.otp.confirm') }}" method="post" class="flex flex-col space-y-4 w-full">
            @csrf 
            
            <h1 class="font-bold"> {{ __('enter_otp') }} </h1>
            
            <input type="text" name="otp" class="input" placeholder="{{ __('otp') }}">                        

            <button type="submit" class="submit_btn">{{ __('verify_otp') }}</button>

        </form>

        <a href="#" class="text-blue-600 hover:underline">{{ __('resend_otp') }}</a>

    </div>

</div>
@include('auth.footer')