@include('payments.header')

<div class="container flex flex-col mx-auto pb-16">

    <div class="flex items-center justify-center pt-10 mb-8">
        <img src="{{ asset('imgs/n-logo.png') }}" class="w-[200px]" alt="web site logo">
    </div>

    <div class="border-primary border rounded-md shadow-xl w-[500px] flex flex-col gap-4 items-center justify-center self-center p-8">
        <img src="{{ asset('imgs/error.png') }}" alt="faild" class="w-36" />
        <h2 class="text-center font-bold text-xl">عملية الدفع<br/> فشلت</h2>
        <p class="text-gray-600"> فشل الدفع بسبب {{ $payment_error }} </p>        

        <a href="{{ route('client.home') }}" class="submit_btn px-32 w-full text-center">الذهاب إلى لوحة التحكم</a>
    </div>

</div>

@include('payments.footer')