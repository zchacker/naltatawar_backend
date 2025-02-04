@include('client.header')

<div class="mt-4 flex flex-col gap-8">
    
    <h2 class="font-bold text-xl"> {{__('payments')}} </h2>               

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

    <div class="flex justify-between items-center p-4 rounded-md border-primary border-dashed border">
        <div>
            <p>{!! __( 'subscription_end_date' , [ 'date' => $subscription->end_date ]) !!}</p>
        </div>

        @if($valid_subscribe == true)
        <form action="{{ route('client.update.subscription.status') }}" method="post">
            @csrf
            @if($subscription->status == 'active')
            <button type="submit" class="cancel_btn">{{ __('cancel_subscription') }}</button>
            @else
            <button type="submit" class="ok_btn">{{ __('retrit_cancel_subscription') }}</button>
            @endif
        </form>
        @else
        <a href="{{ route('payment.pay' , $subscription->plan_id ) }}" class="cancel_btn" >{{ __('renew_subscription') }}</a>
        @endif
    </div>

    <fieldset>
        <legend>تفاصيل الاشتراك</legend>
        <div class="flex gap-5">
            <div class="flex gap-1 items-center">
                <strong>حالة الاشتراك : </strong>
                @if($subscription->status == 'active')
                <div class="py-1 px-3 rounded-md bg-green-700 text-white">
                    <span class="text-sm">{{__($subscription->status)}}</span>
                </div>
                @else
                <div class="py-1 px-3 rounded-md bg-orange-500 text-white">
                    <span class="text-sm">{{__($subscription->status)}}</span>
                </div>
                @endif
            </div>

            <div class="flex gap-1 items-center">
                <span>اسم الباقة : </span>
                <strong>{{ $subscription->plan->name }}</strong>
            </div>

            <div class="flex gap-1 items-center">
                <span>أفراد / شركات : </span>
                <strong>{{ __($subscription->plan->plan_type) }}</strong>
            </div>

            <div class="flex gap-1 items-center">
                <span>تاريخ أول اشتراك : </span>
                <strong>{{ __($subscription->start_date) }}</strong>
            </div>

            <div class="flex gap-1 items-center">
                <span>إنتهاء الاشتراك : </span>
                <strong>{{ __($subscription->end_date) }}</strong>
            </div>

        </div>
    </fieldset>

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
            @foreach($payments as $payment)
            <tr class="odd:bg-white even:bg-gray-100  border-b border-gray-100">
                <td class="px-6 py-4"> {{ $payment->id }} </td>
                <td class="px-6 py-4"> {{ __($payment->status) }} </td>
                <td class="px-6 py-4"> SAR {{ $payment->amount }} </td>
                <td class="px-6 py-4"> {{ $payment->payment_id }} </td>
                <td class="px-6 py-4"> {{ $payment->created_at }} </td>
                <td class="px-6 py-4 flex gap-4">
                    <a href="{{ route('client.invoice' , $payment->id)  }}" class="text-blue-500 underline"> {{__('view')}} </a>                    
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