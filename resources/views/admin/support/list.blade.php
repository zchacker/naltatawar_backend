@include('admin.header')

<div class="mt-4 flex flex-col gap-8">
    <h2 class="font-bold text-xl"> {{__('support')}} </h2>    
    
    <div>
        <form action="{{ route('admin.support.list') }}" method="get" class="flex gap-2 items-center">
            <input type="text" name="query" class="input w-1/2" placeholder=" رقم التذكرة" value="{{ old('query') }}" />
            <button type="submit" class="submit_btn">بحث</button>
            <a href="{{ route('admin.support.list') }}">مسح</a>
        </form>
    </div>

    <table class="table-fixed rounded-md overflow-hidden">
        <span> {{ __('total') }} ({{ $sum }})  </span>
        <thead class="text-md text-gray-700 uppercase bg-blue-200">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3"> {{__('ticket_title')}} </th>                
                <th scope="col" class="px-6 py-3"> {{__('ticket_status')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('create_date')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('action')}} </th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr class="odd:bg-white even:bg-gray-100  border-b border-gray-100">
                <td class="px-6 py-4"> {{ $item->id }} </td>
                <td class="px-6 py-4"> {{ __($item->title) }} </td>                
                <td class="px-6 py-4"> {{ __($item->status ? 'open' : 'closed') }} </td>
                <td class="px-6 py-4"> {{ $item->created_at }} </td>
                <td class="px-6 py-4 flex gap-4">
                    <a href="{{ route( 'admin.support.update' , $item->id ) }}" class="text-blue-500 underline"> {{__('view')}} </a>                    
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>


    <div class="text-left mt-10" dir="rtl">
        {{ $items->onEachSide(5)->links('pagination::tailwind') }}
    </div>
</div>


<script>
    function confirmDelete() {
        return confirm(" {{__('delete_confirmation')}}" );        
    }
</script>

@include('admin.footer')