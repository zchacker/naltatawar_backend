@include('client.header')

<div class="mt-4 flex flex-col gap-8">
    <h2 class="font-bold text-xl"> {{__('credi_cards')}} </h2> 

    @if(Session::has('errors'))
    <div class="my-3 w-full p-4 flex flex-col gap-0 space-y-2 bg-orange-500 text-white text-sm rounded-md">
        {!! session('errors')->first('error') !!}
    </div>
    @endif

    @if(Session::has('success'))
    <div class="my-3 w-full p-4 flex flex-col gap-0 space-y-2 bg-green-700 text-white text-sm rounded-md">
        {!! session('success') !!}
    </div>
    @endif
    
    @if( !$cards->isEmpty() )
    <table class="table-fixed rounded-md overflow-hidden">
        <thead class="text-md text-gray-700 uppercase bg-blue-200">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3"> {{__('card_digits')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('card_company')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('added_date')}} </th>                
                <th scope="col" class="px-6 py-3"> {{__('action')}} </th>
            </tr>
        </thead>
        <tbody>
            @foreach($cards as $card)
            <tr class="odd:bg-white even:bg-gray-100  border-b border-gray-100 text-center">
                <td class="px-6 py-4"> {{ $card->id }} </td>
                <td class="px-6 py-4"> {{ $card->card_digits }} </td>
                <td class="px-6 py-4"> {{ __($card->company) }} </td>                              
                <td class="px-6 py-4"> {{ $card->created_at }} </td>
                <td class="px-6 py-4 flex gap-4">
                <form action="{{ route('client.card.delete' , $card->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                    @method('DELETE')
                    @csrf

                    <button type="submit" class="text-red-600 hover:text-red-900" title="{{__('delete')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>

    <div class="text-left mt-10" dir="rtl">
        {{ $cards->onEachSide(5)->links('pagination::tailwind') }}
    </div>
    @else
    <div class="bg-gray-100 border border-dashed border-gray-300 h-[200px] flex flex-col gap-2 items-center justify-center rounded-md">        
        <h1 class="text-lg font-bold text-gray-800">لا توجد بطاقة محفوظة</h1>
        <a href="{{ route('client.card.add') }}" class="text-blue-600 hover:underline">أضف بطاقة</a>
    </div>
    @endif

</div>


<script>
    function confirmDelete(event) {        

        event.preventDefault(); // Prevent form submission initially
        Swal.fire({
            title: "{{ __('delete_confirmation') }}",
            //text: "Are you sure you want to delete this?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "{{ __('comfirm') }}",
            cancelButtonText: "{{ __('retreat') }}",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form programmatically if confirmed
                event.target.submit();
            } else {
                console.log("User cancelled deletion.");
            }
        });
        
    }
</script>

@include('client.footer')