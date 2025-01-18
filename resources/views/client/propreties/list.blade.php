@include('client.header')

<div class="mt-4 flex flex-col gap-4">
    <h2 class="font-bold text-xl"> {{__('your_properties')}} </h2>  
    
    @if( ($max_items - $items_used) > 0 && $valid_subscribe == true)
    <a href="{{ route('client.property.create') }}" class="bg-cta px-8 py-2 items-center rounded-full flex gap-2 self-start">
        <img src="{{ asset('imgs/add.png') }}" alt="" class="w-[20px]" />
        <span class="font-medium text-white"> {{ __('create_proprety') }} </span>
    </a>
    @else 
    <a href="javascript:no_add_item()" class="bg-cta px-8 py-2 items-center rounded-full flex gap-2 self-start">
        <img src="{{ asset('imgs/add.png') }}" alt="" class="w-[20px]" />
        <span class="font-medium text-white"> {{ __('create_proprety') }} </span>
    </a>
    @endif

    <div>
        <form action="{{ route('client.property.list') }}" method="get" class="flex gap-2 items-center">
            <input type="text" name="query" class="input w-1/2" placeholder="رقم العقار، او اسم العقار" value="{{ old('query') }}" />
            <button type="submit" class="submit_btn">بحث</button>
            <a href="{{ route('client.property.list') }}">مسح</a>
        </form>
    </div>

    <div class="mt-0 flex flex-col gap-4">
        <span> {{ __('your_properties') }} ({{ $items_used }}) - {{__('remain_this_month')}} : {{ $max_items - $items_used }} </span>
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
                @foreach($propreties as $proprety)                
                <tr class="odd:bg-white even:bg-gray-100  border-b border-gray-100">
                    <td class="px-6 py-4"> {{ $proprety->property_number }} </td>
                    <td class="px-6 py-4"> {{ $proprety->title }} </td>
                    <td class="px-6 py-4"> {{ $proprety->city }} </td>
                    <td class="px-6 py-4"> {{ $proprety->price }} </td>
                    <td class="px-6 py-4"> {{ $proprety->add_by()->name }} </td>
                    <td class="px-6 py-4"> 
                        @if($proprety->status == 'pending')
                        <a href="javascript:not_published()" class="text-blue-500">معاينة</a>
                        @elseif($proprety->status == 'published')
                        <a href="https://naltatawar.com/?post_type=real_estate&p={{ $proprety->property_number }}&preview=false" class="text-blue-500" target="_blank">معاينة</a>
                        @endif
                    </td>
                    <td class="px-6 py-4"> {{ __($proprety->status) }} </td>
                    <td class="px-6 py-4"> {{ $proprety->created_at }} </td>
                </tr>
                @endforeach        
            </tbody>
        </table>
    </div>

</div>

<script>
    function no_add_item(){

        @if($valid_subscribe)
        
            Swal.fire({
                title: 'خطأ',
                text: `{{ __('max_items_reached') }}`,
                icon: 'error',
                confirmButtonText: `{{ __('ok') }}`
            });

        @else

            Swal.fire({
                title: 'خطأ',
                text: `{{ __('subscription_expired') }}`,
                icon: 'error',
                confirmButtonText: `{{ __('ok') }}`
            });

        @endif
        
    }

    function not_published(){
        Swal.fire({
            title: `{{ __('proprety_pending') }}`,
            //text: `{{ __('proprety_pending') }}`,
            icon: 'warning',
            confirmButtonText: `{{ __('ok') }}`
        });
    }
</script>

@include('client.footer')