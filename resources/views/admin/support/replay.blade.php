@include('admin.header')

<div class="mt-4 flex flex-col gap-8">
    <h2 class="font-bold text-xl"> {{__('support')}} </h2>

    <div class="md:w-3/4">        

        <fieldset class="border-2 border-gray-400 rounded-md p-4 mb-8">
            <legend class="font-bold text-xl">معلومات العميل:</legend>
            <div class="flex flex-col gap-2">
                <div class="flex gap-2 items-center">
                    <h2 class="font-bold">الاسم: </h2>
                    <span>{{ $support->customer_data->name }}</span>
                </div>
                <div class="flex gap-2 items-center">
                    <h2 class="font-bold">الايميل: </h2>
                    <span>{{ $support->customer_data->email }}</span>
                </div>
                <div class="flex gap-2 items-center">
                    <h2 class="font-bold">رقم الهاتف: </h2>
                    <span>{{ $support->customer_data->phone }}</span>
                </div>
            </div>
        </fieldset>

        <div class="flex flex-col gap-4">
            <div class="flex gap-4">
                <h2 class="font-bold">{{ __('ticket_title') }} : </h2>
                <p>{{ $support->title }}</p>
            </div>
            <div class="flex flex-col gap-2">
                <h3 class="font-bold">{{ __('issue_description') }}</h3>
                <div>{{ $support->message }}</div>
            </div>
        </div>

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

        <div class="border-t border-b border-gray-400 mt-8 pt-4 mb-4 pb-4">
            <form action="{{ route('admin.support.update.action' , $support->id) }}" method="post" class="w-full flex flex-col gap-4">
                @csrf 

                <textarea name="message" id="" cols="30" rows="10" class="input" placeholder="{{ __('ticket_replay') }}" required></textarea>

                <button type="submit" class="submit_btn self-start">{{__('save')}}</button>
            </form>
        </div>

        <div class="flex flex-col gap-4">
            @foreach($support->replaies as $replay)
                <div class="flex flex-col gap-2 ">
                    <p class="font-bold">{{ $replay->user->name }} {{ $replay->user->account_type }}</p>
                    @if($replay->user->account_type != 1)
                    <div class="bg-blue-200 p-4 rounded-md relative">
                    @else
                    <div class="bg-light-secondary p-4 rounded-md relative">
                    @endif
                        <span class="text-lg">{!! nl2br($replay->message) !!}</span>
                        <div class="absolute left-2 bottom-1">
                            <span class="text-xs">{{ $replay->created_at }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

@include('admin.footer')