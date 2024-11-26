@include('client.header')

<div class="mt-4 flex flex-col gap-8">
    <h2 class="font-bold text-xl"> {{__('users')}} </h2>

    @if( ($max_user - $sum) > 0 )
    <a href="{{ route('client.users.create.form') }}" class="bg-cta px-8 py-2 items-center rounded-full flex gap-2 self-start">
        <img src="{{ asset('imgs/add.png') }}" alt="" class="w-[20px]" />
        <span class="font-medium text-white"> {{__('add_new')}} </span>
    </a>
    @else
    <a href="javascript:alert('{{ __('max_users_reached') }}')" class="bg-cta px-8 py-2 items-center rounded-full flex gap-2 self-start">
        <img src="{{ asset('imgs/add.png') }}" alt="" class="w-[20px]" />
        <span class="font-medium text-white"> {{__('add_new')}} </span>
    </a>
    @endif

    <table class="table-fixed rounded-md overflow-hidden">
        <span> {{ __('users') }} ({{ $sum }}) - {{__('remain')}} : {{ $max_user - $sum }} </span>
        <thead class="text-md text-gray-700 uppercase bg-blue-200">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3"> {{__('name')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('phone')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('email')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('create_date')}} </th>
                <th scope="col" class="px-6 py-3"> {{__('action')}} </th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr class="odd:bg-white even:bg-gray-100  border-b border-gray-100">
                <td class="px-6 py-4"> {{ $contact->id }} </td>
                <td class="px-6 py-4"> {{ Str::limit($contact->name,30) }} </td>
                <td class="px-6 py-4"> {{ $contact->phone }} </td>
                <td class="px-6 py-4"> {{ Str::limit($contact->email, 40) }} </td>
                <td class="px-6 py-4"> {{ $contact->created_at }} </td>
                <td class="px-6 py-4 flex gap-4">
                    <a href="{{ route('client.users.edit.form' , $contact->id) }}" class="text-blue-500 underline"> {{__('edit')}} </a>
                    <form action="{{ route('client.users.delete.action' , $contact->id) }}" method="POST" onsubmit="return confirmDelete()">
                        @method('DELETE')
                        @csrf

                        <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
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