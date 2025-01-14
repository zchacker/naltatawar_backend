@include('admin.header')

<div class="mt-4 flex flex-col gap-4">
    <h2 class="font-bold text-xl"> طلبات الاتصال </h2>
    <table class="table-fixed rounded-md overflow-hidden">
        <thead class="text-md text-gray-700 uppercase bg-blue-200">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3"> الاسم </th>
                <th scope="col" class="px-6 py-3"> رقم الهاتف </th>
                <th scope="col" class="px-6 py-3"> الرسالة </th>
                <th scope="col" class="px-6 py-3"> رقم التعريف للعقار </th>
                <th scope="col" class="px-6 py-3"> إجراء </th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr class="odd:bg-white even:bg-gray-100  border-b border-gray-100">
                <td class="px-6 py-4"> {{ $contact->id }} </td>
                <td class="px-6 py-4"> {{ Str::limit($contact->name,30) }} </td>
                <td class="px-6 py-4"> {{ $contact->phone }} </td>
                <td class="px-6 py-4"> {{ Str::limit($contact->message, 30) }} </td>
                <td class="px-6 py-4"> {{ $contact->property_no }} </td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.contacts.details' , $contact->id) }}" class="text-blue-500 underline"> عرض </a>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>

    <div class="text-left mt-10" dir="rtl">
        {{ $contacts->onEachSide(5)->links('pagination::tailwind') }}
    </div>
</div>

@include('admin.footer')