@include('agent.header')

<div class="grid grid-cols-4 gap-4 items-center justify-center">
    <div class="flex flex-col gap-4 justify-center items-center bg-light-secondary p-6 rounded-lg ">
        <h2 class="font-bold text-xl">إجمالي العقارات</h2>
        <p>( {{ $total }} )</p>
    </div>

    <div class="flex flex-col gap-4 justify-center items-center bg-light-secondary p-6 rounded-lg ">
        <h2 class="font-bold text-xl"> للاستثمار </h2>
        <p>( {{ $sell_count }} )</p>
    </div>

    <div class="flex flex-col gap-4 justify-center items-center bg-light-secondary p-6 rounded-lg ">
        <h2 class="font-bold text-xl"> للإيجار </h2>
        <p>( {{ $invest_count }} )</p>
    </div>

    <div class="flex flex-col gap-4 justify-center items-center bg-light-secondary p-6 rounded-lg ">
        <h2 class="font-bold text-xl"> للبيع </h2>
        <p>( {{ $rent_count }} )</p>
    </div>
</div>

<div class="flex gap-6 mt-8">

    @if( auth()->user()->permissions["add_real_estate"] )
    <a href="{{ route('client.property.create') }}" class="bg-cta px-8 py-2 items-center rounded-full flex gap-2">
        <img src="{{ asset('imgs/add.png') }}" alt="" class="w-[20px]" />
        <span class="font-medium text-white">إضافة عقار</span>
    </a> 
    @endif   

    <a href="{{ route('client.support.create') }}" class="bg-cta px-8 py-2 items-center rounded-full flex gap-2">
        <img src="{{ asset('imgs/support.png') }}" alt="" class="w-[20px]" />
        <span class="font-medium text-white"> إنشاء تذكرة دعم </span>
    </a>
</div>

<div class="mt-16 flex flex-col gap-4">
    <h2 class="font-bold text-xl">العقارات المضافة مؤخراً</h2>
    <table class="table-fixed rounded-md overflow-hidden">
        <thead class="text-md text-gray-700 uppercase bg-blue-200">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">اسم العقار</th>
                <th scope="col" class="px-6 py-3">المدينة</th>
                <th scope="col" class="px-6 py-3">السعر</th>
                <th scope="col" class="px-6 py-3">اضيف بواسطة</th>
                <th scope="col" class="px-6 py-3">معاينة</th>
                <th scope="col" class="px-6 py-3">الحالة</th>
                <th scope="col" class="px-6 py-3">تاريخ الاضافة</th>
            </tr>
        </thead>
        <tbody>
            @foreach($properties as $proprety)
            <tr class="odd:bg-white even:bg-gray-100  border-b border-gray-100">
                <td class="px-6 py-4">{{ $proprety->property_number }}</th>
                <td class="px-6 py-4">{{ $proprety->title }}</th>
                <td class="px-6 py-4">{{ $proprety->city }}</th>
                <td class="px-6 py-4">{{ $proprety->price }}</th>
                <td class="px-6 py-4">{{ $proprety->add_by()->name }}</th>
                <td class="px-6 py-4">
                    @if($proprety->status == 'pending')
                    <a href="javascript:not_published()" class="text-blue-500">معاينة</a>
                    @elseif($proprety->status == 'published')
                    <a href="https://naltatawar.com/?post_type=real_estate&p={{ $proprety->property_number }}&preview=false" class="text-blue-500" target="_blank">معاينة</a>
                    @endif
                </td>
                <td class="px-6 py-4"> {{ __($proprety->status) }} </td>
                <td class="px-6 py-4">{{ $proprety->created_at }}</th>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<script>
    function not_published() {
        Swal.fire({
            title: `{{ __('proprety_pending') }}`,
            //text: `{{ __('proprety_pending') }}`,
            icon: 'warning',
            confirmButtonText: `{{ __('ok') }}`
        });
    }
</script>
@include('agent.footer')