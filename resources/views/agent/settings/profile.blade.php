@include('agent.header')

<div class="mt-4 flex flex-col gap-8 w-full">
    <h2 class="font-bold text-xl"> {{__('update_data')}} </h2>

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

        <fieldset class="border border-gray-300 rounded-lg p-6 shadow-sm bg-white">
            <legend class="text-lg font-semibold text-gray-700 px-2">{{ __('personal_data') }}</legend>
            <form action="{{ route('agent.settings.update.profile') }}" id="myform" method="post" class="w-full flex flex-col gap-4">
                @csrf

                <input type="text" name="name" class="input w-full" placeholder="{{__('name')}}" value="{{ old('name') ?? $user->name }}" required autocomplete="off"/>

                <input type="tel" name="phone" dir="rtl" class="input w-full" placeholder="{{__('phone')}}" value="{{ old('phone') ?? $user->phone }}" required autocomplete="off"/>

                <input type="email" name="email" class="input w-full" placeholder="{{__('email')}}" value="{{ old('email') ?? $user->email }}" required autocomplete="off"/>

                <button type="submit" class="submit_btn self-start">{{__('save')}}</button>
            </form>
        </fieldset>


        <fieldset class="border border-gray-300 rounded-lg p-6 shadow-sm bg-white mt-16">
            <legend class="text-lg font-semibold text-gray-700 px-2">{{ __('update_password') }}</legend>
            <form action="{{ route('agent.settings.update.password') }}" id="myform" method="post" class="w-full flex flex-col gap-4">
                @csrf

                <input type="password" name="current-password" class="input w-full" placeholder="{{__('current_password')}}" required />

                <input type="password" name="new-password" dir="rtl" class="input w-full" placeholder="{{__('new_password')}}" required />

                <input type="password" name="re-password" class="input w-full" placeholder="{{__('re-password')}}" required />

                <button type="submit" class="submit_btn self-start">{{__('save')}}</button>
            </form>
        </fieldset>
    </div>

</div>

@include('agent.footer')