@include('client.header')

<div class="mt-4 flex flex-col gap-8">
    
    <h2 class="font-bold text-xl"> {{__('payments')}} </h2>               

    <div class="flex gap-4 justify-between">
        <span> {{ __('total') }} ({{ $sum }})  </span>
        <a href="{{ route('client.card.list') }}" class="text-blue-400 font-bold text-md hover:underline">{{ __('credi_cards') }}</a>
    </div>

    <table class="table-fixed rounded-md overflow-hidden">
        <thead class="text-md text-gray-700 uppercase bg-blue-200">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3"> {{__('status')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('amount')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('ref_no')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('create_date')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('action')}} </th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr class="odd:bg-white even:bg-gray-100  border-b border-gray-100">
                <td class="px-6 py-4"> {{ $contact->id }} </td>
                <td class="px-6 py-4"> {{ __($contact->status) }} </td>
                <td class="px-6 py-4"> SAR {{ $contact->amount }} </td>
                <td class="px-6 py-4"> {{ $contact->payment_id }} </td>
                <td class="px-6 py-4"> {{ $contact->created_at }} </td>
                <td class="px-6 py-4 flex gap-4">
                    <a href="{{ route('client.invoice' , $contact->id)  }}" class="text-blue-500 underline"> {{__('view')}} </a>                    
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>


    <div class="text-left mt-10" dir="rtl">
        {{ $contacts->onEachSide(5)->links('pagination::tailwind') }}
    </div>
</div>


<script>
    function confirmDelete() {
        //return confirm(" {{__('delete_confirmation')}}" );

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