@include('admin.header')

<div class="mt-4 flex flex-col gap-8 w-full">
    <h2 class="font-bold text-xl"> {{__('add_user')}} </h2>

    <div class="md:w-1/2">

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

        <form action="{{ route('admin.plan.edit.action' , $data->id) }}" method="post" class="w-full flex flex-col gap-4">
            @csrf    
    
            <label for="name">{{__('name')}}</label>
            <input type="text" name="name" class="input w-full" placeholder="{{__('name')}}" value="{{ $data->name }}" required />

            <label for="price">{{__('price')}}</label>
            <input type="number" step="0.01" name="price" dir="rtl" class="input w-full" placeholder="{{__('price')}}" value="{{ $data->price }}" required/>

            <label for="items">العقارات شهريا</label>
            <input type="number" name="items" class="input w-full" placeholder="العقارات شهريا" value="{{ $data->items }}" required/>

            <label for="items">المستخدمون</label>
            <input type="number" name="user" class="input w-full" placeholder="المستخدمون" value="{{ $data->user }}" required/>

            <label for="billing_cycle">شهرية / سنوية</label>
            <select name="billing_cycle" id="billing_cycle" class="input w-full" >
                <option value="monthly" {{ $data->billing_cycle == 'monthly' ? 'selected' : '' }} >{{ __('monthly') }}</option>
                <option value="yearly"  {{ $data->billing_cycle == 'yearly' ? 'selected' : '' }} >{{ __('yearly') }}</option>
            </select>

            <label for="plan_type">نوع الخطة</label>
            <select name="plan_type" id="plan_type" class="input w-full" >
                <option value="individuals" {{ $data->plan_type == 'individuals' ? 'selected' : '' }} >{{ __('individuals') }}</option>
                <option value="businesses"  {{ $data->plan_type == 'businesses' ? 'selected' : '' }} >{{ __('yearly') }}</option>
            </select>          

            <button type="submit" class="submit_btn self-start">{{__('save')}}</button>
        </form>
    
    </div>

</div>

@include('admin.footer')