@include('client.header')

<div class="mt-4 flex flex-col gap-4">
    <h2 class="font-bold text-xl"> {{__('your_properties')}} </h2>  
    
    <a href="{{ route('client.property.create') }}" class="bg-cta px-8 py-2 items-center rounded-full flex gap-2 self-start">
        <img src="{{ asset('imgs/add.png') }}" alt="" class="w-[20px]" />
        <span class="font-medium text-white"> {{ __('create_proprety') }} </span>
    </a>

    <div class="mt-0 flex flex-col gap-4">
        
        <table class="table-fixed rounded-md overflow-hidden">
            <thead class="text-md text-gray-700 uppercase bg-blue-200">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">اسم العقار</th>
                    <th scope="col" class="px-6 py-3">المدينة</th>
                    <th scope="col" class="px-6 py-3">السعر</th>
                    <th scope="col" class="px-6 py-3">اضيف بواسطة</th>
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
                    <td class="px-6 py-4"> {{ $proprety->created_at }} </td>
                </tr>
                @endforeach        
            </tbody>
        </table>
    </div>

</div>

@include('client.footer')