@include('agent.header')

<div class="mt-4 flex flex-col gap-8">
    <h2 class="font-bold text-xl"> {{__('support')}} </h2>  
    
    <a href="{{ route('agent.support.create') }}" class="bg-cta px-8 py-2 items-center rounded-full flex gap-2 self-start">
        <img src="{{ asset('imgs/support.png') }}" alt="" class="w-[20px]" />
        <span class="font-medium text-white"> {{ __('create_ticket') }} </span>
    </a>

    <table class="table-fixed rounded-md overflow-hidden">
        <span> {{ __('total') }} ({{ $sum }})  </span>
        <thead class="text-md text-gray-700 uppercase bg-blue-200">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3"> {{__('ticket_title')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('issue_description')}} </th>
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
                <td class="px-6 py-4"> {{ Str::limit($item->message ,30) }} </td>
                <td class="px-6 py-4"> {{ __($item->status ? 'open' : 'closed') }} </td>
                <td class="px-6 py-4"> {{ $item->created_at }} </td>
                <td class="px-6 py-4 flex gap-4">
                    <a href="{{ route( 'agent.support.update' , $item->id ) }}" class="text-blue-500 underline"> {{__('view')}} </a>                    
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

@include('agent.footer')