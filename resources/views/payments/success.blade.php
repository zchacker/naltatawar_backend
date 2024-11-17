@include('payments.header')

<div class="container flex flex-col mx-auto pb-16">

    <div class="flex items-center justify-center pt-10 mb-8">
        <img src="{{ asset('imgs/n-logo.png') }}" class="w-[200px]" alt="web site logo">
    </div>

    <div class="border-primary border rounded-md shadow-xl w-[500px] flex flex-col gap-4 items-center justify-center self-center p-8">
        <img src="{{ asset('imgs/check_mark.png') }}" alt="success" class="w-36" />
        <h2 class="text-center font-bold text-xl">عملية الدفع<br/> تمت بنجاح</h2>
        <p class="text-gray-600">سيتم إرسال نسخة من الفاتورة إلى بريدك الالكتروني</p>

        <h3 class="text-xl font-bold">الفاتورة</h3>
        <p>13234324234</p>

        <a href="#" class="submit_btn px-32 w-full text-center">الذهاب إلى الموقع</a>
    </div>

</div>

@include('payments.footer')