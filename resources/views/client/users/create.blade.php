@include('client.header')

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

        <form action="{{ route('client.users.create.action') }}" id="myform" method="post" class="w-full flex flex-col gap-4">
            @csrf    

            <input type="text" name="name" class="input w-full" placeholder="{{__('name')}}" required />

            <input type="tel" name="phone" dir="rtl" class="input w-full" placeholder="{{__('phone')}}" required/>

            <input type="email" name="email" class="input w-full" placeholder="{{__('email')}}" required/>

            <input type="password" dir="rtl" name="password" class="input w-full" placeholder="{{__('password')}}" required/>

            <div class="mt-8 flex flex-col gap-4">
                <h3 class="font-bold">{{__('permissions')}}</h3>

                <div class="flex gap-4">
                    <label for="add_real_estate">
                        <input type="checkbox" name="add_real_estate" id="add_real_estate" />
                        {{__('add_real_estate')}} 
                    </label>

                    <label for="edit_real_estate">
                        <input type="checkbox" name="edit_real_estate" id="edit_real_estate" />
                        {{__('edit_real_estate')}}
                    </label>

                    <label for="billing">
                        <input type="checkbox" name="billing" id="billing" />
                        {{__('billing')}}
                    </label>
                </div>
            </div>

            <button type="submit" class="submit_btn self-start">{{__('save')}}</button>
        </form>
    </div>

</div>



@include('client.footer')