@include('admin.header')

<div class="mt-4 flex flex-col gap-8">
    <h2 class="font-bold text-xl"> {{__('payments')}} </h2>   

    <table class="table-fixed rounded-md overflow-hidden">
        <h3 class="font-bold text-2xl">أفراد</h3>
        <span> {{ __('total') }} ({{ $sum }})  </span>
        <thead class="text-md text-gray-700 uppercase bg-blue-200">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3"> {{__('name')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('price')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('items')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('users')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('billing_cycle')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('plan_type')}} </th>                
                <th scope="col" class="px-6 py-3"> {{__('action')}} </th>
            </tr>
        </thead>
        <tbody>
            @foreach($individuals as $individual)
            <tr class="odd:bg-white even:bg-gray-100  border-b border-gray-100">
                <td class="px-6 py-4"> {{ $individual->id }} </td>
                <td class="px-6 py-4"> {{ $individual->name }} </td>
                <td class="px-6 py-4"> SAR {{ $individual->price }} </td>
                <td class="px-6 py-4"> {{ $individual->items }} </td>
                <td class="px-6 py-4"> {{ $individual->user }} </td>
                <td class="px-6 py-4"> {{ __($individual->billing_cycle) }} </td>
                <td class="px-6 py-4"> {{ __($individual->plan_type) }} </td>                                
                <td class="px-6 py-4 flex gap-4">
                    <a href="{{ route('admin.plan.edit' , $individual->id)  }}" class="text-blue-500 underline"> {{__('edit')}} </a>                    
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>

    <table class="table-fixed rounded-md overflow-hidden">
        <h3 class="font-bold text-2xl">شركات</h3>
        <span> {{ __('total') }} ({{ $sum }})  </span>
        <thead class="text-md text-gray-700 uppercase bg-blue-200">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3"> {{__('name')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('price')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('items')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('users')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('billing_cycle')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('plan_type')}} </th>                
                <th scope="col" class="px-6 py-3"> {{__('action')}} </th>
            </tr>
        </thead>
        <tbody>
            @foreach($businesses as $businesse)
            <tr class="odd:bg-white even:bg-gray-100  border-b border-gray-100">
                <td class="px-6 py-4"> {{ $businesse->id }} </td>
                <td class="px-6 py-4"> {{ $businesse->name }} </td>
                <td class="px-6 py-4"> SAR {{ $businesse->price }} </td>
                <td class="px-6 py-4"> {{ $businesse->items }} </td>
                <td class="px-6 py-4"> {{ $businesse->user }} </td>
                <td class="px-6 py-4"> {{ __($businesse->billing_cycle) }} </td>
                <td class="px-6 py-4"> {{ __($businesse->plan_type) }} </td>                                
                <td class="px-6 py-4 flex gap-4">
                    <a href="{{ route('admin.plan.edit' , $businesse->id)  }}" class="text-blue-500 underline"> {{__('edit')}} </a>                    
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>

    {{--
    <div class="text-left mt-10" dir="rtl">
        {{ $individuals->onEachSide(5)->links('pagination::tailwind') }}
    </div>
    --}}

</div>


<script>
    function confirmDelete() {
        return confirm(" {{__('delete_confirmation')}}" );        
    }
</script>

@include('admin.footer')