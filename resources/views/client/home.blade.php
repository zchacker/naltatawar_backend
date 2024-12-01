@include('client.header')

    <div class="grid grid-cols-4 gap-4 items-center justify-center">
        <div class="flex flex-col gap-4 justify-center items-center bg-light-secondary p-6 rounded-lg ">
            <h2 class="font-bold text-xl">إجمالي العقارات</h2>
            <p>(0)</p>
        </div>

        <div class="flex flex-col gap-4 justify-center items-center bg-light-secondary p-6 rounded-lg ">
            <h2 class="font-bold text-xl"> للاستثمار </h2>
            <p>(0)</p>
        </div>

        <div class="flex flex-col gap-4 justify-center items-center bg-light-secondary p-6 rounded-lg ">
            <h2 class="font-bold text-xl"> للإيجار </h2>
            <p>(0)</p>
        </div>

        <div class="flex flex-col gap-4 justify-center items-center bg-light-secondary p-6 rounded-lg ">
            <h2 class="font-bold text-xl"> للبيع </h2>
            <p>(0)</p>
        </div>
    </div>

    <div class="flex gap-6 mt-8">
        <a href="#" class="bg-cta px-8 py-2 items-center rounded-full flex gap-2">
            <img src="{{ asset('imgs/add.png') }}" alt="" class="w-[20px]" />
            <span class="font-medium text-white">إضافة عقار</span>
        </a>

        <a href="{{ route('client.users.create.form') }}" class="bg-cta px-8 py-2 items-center rounded-full flex gap-2">
            <img src="{{ asset('imgs/user.png') }}" alt="" class="w-[20px]" />
            <span class="font-medium text-white">إضافة مستخدم</span>
        </a>

        <a href="{{ route('client.support.create') }}" class="bg-cta px-8 py-2 items-center rounded-full flex gap-2">
            <img src="{{ asset('imgs/support.png') }}" alt="" class="w-[20px]" />
            <span class="font-medium text-white"> إنشاء تذكرة دعم </span>
        </a>
    </div>

    <div class="mt-16 flex flex-col gap-4">
        <h2 class="font-bold text-xl">العقارات المضافة مؤخراً</h2>
        <table class="table-fixed rounded-md overflow-hidden">
            <thead class="text-md text-gray-700 uppercase bg-blue-200">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">اسم العقار</th>
                    <th scope="col" class="px-6 py-3">المدينة</th>
                    <th scope="col" class="px-6 py-3">السعر</th>
                    <th scope="col" class="px-6 py-3">اضيف بواسطة</th>
                    <th scope="col" class="px-6 py-3">تاريخ الاضافة</th>
                </tr>
            </thead>
            <tbody>
                {{--
                <tr class="odd:bg-white even:bg-gray-100  border-b border-gray-100">
                    <td class="px-6 py-4"> Silver </td>
                    <td class="px-6 py-4"> Silver </td>
                    <td class="px-6 py-4"> Silver </td>
                    <td class="px-6 py-4"> Silver </td>
                    <td class="px-6 py-4"> Silver </td>
                    <td class="px-6 py-4"> Silver </td>
                </tr>
                --}}            
            </tbody>
        </table>
    </div>

@include('client.footer')