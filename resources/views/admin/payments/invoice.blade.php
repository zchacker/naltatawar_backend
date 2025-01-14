@include('admin.header')


<div id="contentToPrint" class="max-w-3xl print:w-full print:mt-0 mx-auto mt-10 bg-white shadow-md rounded-lg border border-gray-200 p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>            
            <h1 class="text-2xl font-bold text-gray-700">فاتورة</h1>
            <p class="text-gray-500">التاريخ: <span id="invoice-date">{{$formattedDate}}</span></p>
            <button id="printButton" class="text-blue-500 hover:underline">طباعة</button>
        </div>
        <div class="text-right">
            <h2 class="text-lg font-semibold text-gray-700">{{ env('COMPANY_NAME') }}</h2>
            <p class="text-sm text-gray-500">{{ env('COMPANY_ADDRESS') }}</p>
            <p class="text-sm text-gray-500">{{ env('COMPANY_EMAIL') }}</p>
            <p class="text-sm text-gray-500" dir="ltr">{{ env('COMPANY_PHONE') }}</p>
        </div>
    </div>

    <hr class="my-4">

    <!-- User Information -->
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-700">مفوترة إلى:</h3>
        <p class="text-gray-600">{{ auth()->user()->name }}</p>
        <p class="text-gray-600">{{ auth()->user()->email }}</p>
        <p class="text-gray-600">{{ auth()->user()->phone }}</p>
    </div>

    <!-- Subscription Details -->
    <table class="table-fixed w-full text-right border-collapse">
        <thead>
            <tr class="border-b">
                <th class="py-2 font-bold text-gray-800">الوصف</th>
                <th class="py-2 font-bold text-gray-800 text-right">المبلغ</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b">
                <td class="py-2 text-gray-700 text-right">{{ $payment_data->description }}</td>
                <td class="py-2 text-gray-700 text-right">{{ $payment_data->amount - ($payment_data->amount * 0.15) }} SAR</td>
            </tr>
            <tr class="border-b-0">
                <td class="py-2 text-gray-700 text-right">{{ __('VAT') }}</td>
                <td class="py-2 text-gray-700 text-right">{{ $payment_data->amount * 0.15 }} SAR</td>
            </tr>
        </tbody>
    </table>

    <!-- Total -->
    <div class="flex justify-between items-center mt-6">
        <h3 class="text-lg font-bold text-gray-700">الإجمالي</h3>
        <p class="text-xl font-bold text-gray-800">SAR {{ $payment_data->amount }}</p>
    </div>

    <div class="flex justify-center my-8 print:my-0">
        <img src="{{ $displayQRCodeAsBase64 }}" alt="QR Code" class="w-40" />
    </div>

    <!-- Footer -->
    <div class="text-center mt-8 text-sm text-gray-500">
        شكرا لتعاملك معنا! <br> إذا كان لديك اي استفسار عن هذه الفاتورة لا تتردد بالتواصل معنا!
    </div>
</div>

<script>
    document.getElementById('printButton').addEventListener('click', function () {
        window.print();
    });
</script>
@include('admin.footer')