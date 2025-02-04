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
        
        <button id="requestOtpBtn" class="text-blue-600 hover:underline">{{ __('resend_otp') }}</button>
        <p id="message"></p>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    let otpButton = $('#requestOtpBtn');
    let messageDiv = $('#message');
    let cooldownTime = 180; // 3 minutes in seconds
    let timer;

    // Function to start the cooldown timer
    function startCooldown() {
        otpButton.prop('disabled', true); // Disable the button
        let remainingTime = cooldownTime;

        // Update the button text every second
        timer = setInterval(function () {
            let minutes = Math.floor(remainingTime / 60);
            let seconds = remainingTime % 60;

            otpButton.text(`طلب رمز جديد (${minutes}:${seconds.toString().padStart(2, '0')})`);
            remainingTime--;

            // Stop the timer when cooldown is over
            if (remainingTime < 0) {
                clearInterval(timer);
                otpButton.prop('disabled', false);
                otpButton.text('طلب رمز جديد');
                messageDiv.text('');
            }
        }, 1000);
    }

    // Function to request OTP
    function requestOtp() {
        $.ajax({
            url: `{{ route('auth.otp.resend') }}`, // Your Laravel route
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Laravel CSRF token
            },
            success: function (response) {
                if (response.status) {
                    messageDiv.text('تم طلب رمز جديد!');
                    startCooldown(); // Start the 3-minute cooldown
                } else {
                    messageDiv.text(response.message); // Show error message
                    if (response.last_reset_time) {
                        // Calculate remaining cooldown time
                        let lastResetTime = new Date(response.last_reset_time);
                        let currentTime = new Date();
                        let elapsedTime = Math.floor((currentTime - lastResetTime) / 1000);
                        let remainingTime = cooldownTime - elapsedTime;

                        if (remainingTime > 0) {
                            startCooldown(remainingTime); // Start cooldown with remaining time
                        }
                    }
                }
            },
            error: function (xhr, status, error) {
                messageDiv.text('An error occurred. Please try again.');
            },
        });
    }

    // Attach click event to the button
    otpButton.click(function () {
        requestOtp();
    });
});
</script>
@include('auth.footer')