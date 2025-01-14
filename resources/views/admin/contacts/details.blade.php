@include('admin.header')

<div class="mt-4 flex flex-col gap-4">
    
    <h2 class="font-bold text-xl"> تفاصل الطلب </h2>

    <div class="flex flex-col gap-4 mt-8">
        <div class="flex gap-4">
            <h2 class="font-bold text-xl">الاسم:</h2>
            <p>{{ $data->name }}</p>
        </div>

        <div class="flex gap-4">
            <h2 class="font-bold text-xl">رقم الهاتف:</h2>
            <p>{{ $data->phone }}</p>
        </div>

        <div class="flex gap-4">
            <h2 class="font-bold text-xl">رقم العقار:</h2>
            <p>{{ $data->property_no }}</p>
        </div>

        <div class="flex gap-4">
            <h2 class="font-bold text-xl">الرسالة :</h2>
            <p>{{ $data->message }}</p>
        </div>
    </div>

    <div class="mt-20">
        <a href="javascript:history.back()" class="submit_btn">عودة</a>
    </div>

</div>

@include('admin.footer')