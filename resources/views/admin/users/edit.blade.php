@include('admin.header')

<div class="mt-4 flex flex-col gap-8 w-full">
    <h2 class="font-bold text-xl"> {{__('edit_user')}} </h2>

    <a href="{{ route('admin.users.impersonate' , $data->id) }}" class="font-bold text-md text-blue-500 hover:underline">الدخول باسمه</a>

    <div class="md:w-full flex flex-col gap-4 pb-8">

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

        <fieldset >
            <legend > تحديث بيانات المستخدم</legend>            
            <form action="{{ route('admin.users.edit.action' , $data->id) }}" method="post" class="w-full flex flex-col gap-4">
                @csrf    
                
                <div class="flex justify-items-stretch gap-4 w-full">
                    <div class="flex-1">
                        <label for="phone">{{__('name')}}</label>
                        <input type="text" name="name" class="input w-full" placeholder="{{__('name')}}" value="{{ $data->name }}" required />
                    </div>

                    <div class="flex-1">
                        <label for="phone">{{__('phone')}}</label>
                        <input type="tel" name="phone" dir="rtl" class="input w-full" placeholder="{{__('phone')}}" value="{{ $data->phone }}" required/>
                    </div>
                    
                    <div class="flex-1">
                        <label for="phone">{{__('email')}}</label>
                        <input type="email" name="email" class="input w-full" placeholder="{{__('email')}}" value="{{ $data->email }}" required/>
                    </div>
                    
                    <div class="flex-1">
                        <label for="phone">{{ __('password') }}</label>
                        <input type="password"  name="password" class="input w-full" placeholder="{{__('password')}}"  />
                        <span class="text-red-700 text-xs">{{ __('leave_empty_not_change_password') }}</span>
                    </div>
                    
                </div>

                <button type="submit" class="submit_btn self-start">{{__('save')}}</button>            
            </form>
        </fieldset>
        
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
                    <div class="py-1 px-3 rounded-md bg-red-600 text-white">
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

        <fieldset>
            <legend>تعديل الاشتراك</legend>
            <form action="{{ route('admin.users.subcription.update' , $data->id) }}" method="post" class="w-full flex flex-col gap-4">                
                @csrf    
                
                <div class="flex justify-items-stretch items-end gap-4 w-full">

                    <div class="flex flex-col flex-1 gap-2">
                        <label for="end_date">تاريخ إنتهاء الاشتراك</label>
                        <input type="date" name="end_date" class="input w-full" placeholder="تاريخ الاشتراك" value="{{ $subscription->end_date }}" required />                    
                    </div>

                    <div class="flex flex-col flex-1 gap-2">
                        <label for="plans">خطة الاشتراك</label>
                        <select name="plan" id="plans" class="input w-full">
                            @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{ $subscription->plan_id == $plan->id ? 'selected' : '' }}>{{ $plan->name }} - {{ __($plan->billing_cycle) }} ( {{ __($plan->plan_type) }} )</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col flex-1 gap-2">
                        <button type="submit" class="submit_btn self-start">تحديث الاشتراك</button>
                    </div>

                </div>
            </form>
        </fieldset>

        <fieldset>
            <legend>{{__('payments')}}</legend>

            <div class="mt-4 flex flex-col gap-8">             

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

        </fieldset>

    </div>

</div>

@include('admin.footer')