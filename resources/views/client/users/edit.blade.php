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

        <form action="{{ route('client.users.edit.action' , $data->id) }}" method="post" class="w-full flex flex-col gap-4">
            @csrf    

            <label for="phone">{{__('name')}}</label>
            <input type="text" name="name" class="input w-full" placeholder="{{__('name')}}" value="{{ $data->name }}" required />

            <label for="phone">{{__('phone')}}</label>
            <input type="tel" name="phone" dir="rtl" class="input w-full" placeholder="{{__('phone')}}" value="{{ $data->phone }}" required/>

            <label for="phone">{{__('email')}}</label>
            <input type="email" name="email" class="input w-full" placeholder="{{__('email')}}" value="{{ $data->email }}" required/>

            <div>
                <label for="phone">{{ __('password') }}</label>
                <input type="password" dir="rtl" name="password" class="input w-full" placeholder="{{__('password')}}"  />
                <span class="text-red-700 text-xs">{{ __('leave_empty_not_change_password') }}</span>
            </div>

            <div class="mt-8 flex flex-col gap-4">
                <h3 class="font-bold">{{ __('permissions') }}</h3>

                <div class="flex flex-wrap gap-4">
                    <label for="add_real_estate">
                        <input type="checkbox" name="add_real_estate" id="add_real_estate" {{ $data->permissions["add_real_estate"] ? 'checked' : '' }}/>
                        {{ __('add_real_estate') }} 
                    </label>

                    <label for="edit_real_estate">
                        <input type="checkbox" name="edit_real_estate" id="edit_real_estate" {{ $data->permissions["edit_real_estate"] ? 'checked' : '' }}/>
                        {{ __('edit_real_estate') }}
                    </label>

                    <label for="delete_real_estate">
                        <input type="checkbox" name="delete_real_estate" id="delete_real_estate" {{ $data->permissions["delete_real_estate"] ? 'checked' : '' }}/>
                        {{ __('delete_real_estate') }}
                    </label>

                    <label for="billing">
                        <input type="checkbox" name="billing" id="billing" {{ $data->permissions["billing"] ? 'checked' : '' }}/>
                        {{ __('billing') }}
                    </label>                    

                    <label for="can_show_contact">
                        <input type="checkbox" name="can_show_contact" id="can_show_contact" {{ $data->permissions["can_show_contact"] ? 'checked' : '' }}/>
                        {{ __('can_show_contact') }}
                    </label>
                </div>
            </div>

            <button type="submit" class="submit_btn self-start">{{__('save')}}</button>
        </form>
    </div>

</div>

@include('client.footer')