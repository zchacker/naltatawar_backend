@include('client.header')

<div class="mt-4 flex flex-col gap-8">
    <h2 class="font-bold text-xl"> {{__('payments')}} </h2>   

    <table class="table-fixed rounded-md overflow-hidden">
        <span> {{ __('total') }} ({{ $sum }})  </span>
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
                <td class="px-6 py-4"> {{ $contact->amount }} </td>
                <td class="px-6 py-4"> {{ $contact->payment_id }} </td>
                <td class="px-6 py-4"> {{ $contact->created_at }} </td>
                <td class="px-6 py-4 flex gap-4">
                    <a href="#" class="text-blue-500 underline"> {{__('view')}} </a>                    
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
        return confirm(" {{__('delete_confirmation')}}" );        
    }
</script>

@include('client.footer')