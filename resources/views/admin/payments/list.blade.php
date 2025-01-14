@include('admin.header')

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
            @foreach($payments as $payment)
            <tr class="odd:bg-white even:bg-gray-100  border-b border-gray-100">
                <td class="px-6 py-4"> {{ $payment->id }} </td>
                <td class="px-6 py-4"> {{ __($payment->status) }} </td>
                <td class="px-6 py-4"> SAR {{ $payment->amount }} </td>
                <td class="px-6 py-4"> {{ $payment->payment_id }} </td>
                <td class="px-6 py-4"> {{ $payment->created_at }} </td>
                <td class="px-6 py-4 flex gap-4">
                    <a href="{{ route('admin.invoice' , $payment->id)  }}" class="text-blue-500 underline"> {{__('view')}} </a>                    
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>


    <div class="text-left mt-10" dir="rtl">
        {{ $payments->onEachSide(5)->links('pagination::tailwind') }}
    </div>
</div>


<script>
    function confirmDelete() {
        return confirm(" {{__('delete_confirmation')}}" );        
    }
</script>

@include('admin.footer')