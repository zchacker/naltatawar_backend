@include('auth.header')
<div class="container flex flex-col mx-auto">

    <div class="flex items-center justify-center pt-10">
        <img src="{{ asset('imgs/n-logo.png') }}" class="w-[200px]" alt="web site logo">
    </div>

    <!-- login form -->
    <div class="flex flex-col space-y-2 w-[400px] mx-auto mt-10 items-center">
        <form action="" method="post" class="flex flex-col space-y-4 w-full">
            <h1 class="font-bold"> {{ __('enter_new_password') }} </h1>
            
            <input type="password" name="password" class="input" placeholder="{{ __('password') }}">

            <input type="password" name="re_password" class="input" placeholder="{{ __('re-password') }}">                        

            <button type="submit" class="submit_btn">{{ __('save_and_login') }}</button>
        </form>
        
    </div>

</div>
@include('auth.footer')