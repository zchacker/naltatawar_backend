@include('admin.header')

<div class="mt-4 flex flex-col gap-8">
    <h2 class="font-bold text-xl"> {{__('create_ticket')}} </h2>

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

        <form action="{{ route('admin.support.create.action') }}" method="post" class="w-full flex flex-col gap-4">
            @csrf

            <select name="title" id="title" class="input">
                <option value="{{ __('publish_issue_1') }}"> {{ __('publish_issue_1') }} </option>
                <option value="{{ __('publish_issue_2') }}"> {{ __('publish_issue_2') }} </option>
                <option value="{{ __('publish_issue_3') }}"> {{ __('publish_issue_3') }} </option>
                <option value="{{ __('payment_issue_1') }}"> {{ __('payment_issue_1') }} </option>
                <option value="{{ __('payment_issue_2') }}"> {{ __('payment_issue_2') }} </option>
                <option value="{{ __('user_issue_1') }}"> {{ __('user_issue_1') }} </option>
                <option value="{{ __('user_issue_2') }}"> {{ __('user_issue_2') }} </option>
                <option value="{{ __('user_issue_3') }}"> {{ __('user_issue_3') }} </option>
                <option value="{{ __('performance_issue_1') }}"> {{ __('performance_issue_1') }} </option>
                <option value="{{ __('performance_issue_2') }}"> {{ __('performance_issue_2') }} </option>
                <option value="{{ __('performance_issue_3') }}"> {{ __('user_issue_3') }} </option>
            </select>            

            <textarea name="message" class="input" id="message" cols="30" rows="10" placeholder="{{ __('issue_description') }}" required></textarea>            

            <button type="submit" class="submit_btn self-start">{{__('save')}}</button>

        </form>
    </div>

</div>

@include('admin.footer')