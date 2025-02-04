@include('admin.header')

<div class="mt-4 flex flex-col gap-4">
    <h2 class="font-bold text-xl"> {{__('your_properties')}} </h2>     

    <a href="{{ route('admin.property.create') }}" class="bg-cta px-8 py-2 items-center rounded-full flex gap-2 self-start">
        <img src="{{ asset('imgs/add.png') }}" alt="" class="w-[20px]" />
        <span class="font-medium text-white"> {{ __('create_proprety') }} </span>
    </a>

    <div>
        <form action="{{ route('admin.property.list') }}" method="get" class="flex gap-2 items-center">
            <input type="text" name="query" class="input w-1/2" placeholder="رقم العقار، او اسم العقار" value="{{ old('query') }}" />
            <button type="submit" class="submit_btn">بحث</button>
            <a href="{{ route('admin.property.list') }}">مسح</a>
        </form>
    </div>

    <div class="mt-0 flex flex-col gap-4">
        <div class="relative overflow-x-auto">        
            <table class="table-fixed rounded-md overflow-hidden">
                <thead class="text-md text-gray-700 uppercase bg-blue-200">
                    <tr>
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3">الاسم</th>
                        <th scope="col" class="px-6 py-3">المدينة</th>
                        <th scope="col" class="px-6 py-3">السعر</th>
                        <th scope="col" class="px-6 py-3">بواسطة</th>
                        <th scope="col" class="px-6 py-3">#الترخيص</th>
                        <th scope="col" class="px-6 py-3">الحالة</th>
                        <th scope="col" class="px-6 py-3">نشر</th>
                        <!-- <th scope="col" class="px-6 py-3">تاريخ الاضافة</th> -->
                        <th scope="col" class="px-6 py-3"> إجراء  </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($propreties as $proprety)                
                    <tr class="odd:bg-white even:bg-gray-100  border-b border-gray-100">
                        <td class="px-6 py-4"> {{ $proprety->property_number }} </td>
                        <td class="px-6 py-4"> {{ Str::limit($proprety->title , 18) }} </td>
                        <td class="px-6 py-4"> {{ $proprety->city }} </td>
                        <td class="px-6 py-4"> {{ $proprety->price }} </td>
                        <td class="px-6 py-4"> {{ $proprety->add_by->name }} </td>
                        <td class="px-6 py-4 flex gap-2"> 
                            <a href="javascript:copy('{{ $proprety->property_number }}')" class="text-blue-500 flex items-center">
                                {{ $proprety->property_number }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16" id="copy">
                                    <path fill="#3b82f6" d="M4.00029246,4.08524952 L4,10.5 C4,11.8254834 5.03153594,12.9100387 6.33562431,12.9946823 L6.5,13 L10.9143985,13.000703 C10.7082819,13.5829319 10.1528467,14 9.5,14 L6,14 C4.34314575,14 3,12.6568542 3,11 L3,5.5 C3,4.84678131 3.41754351,4.29108512 4.00029246,4.08524952 Z M11.5,2 C12.3284271,2 13,2.67157288 13,3.5 L13,10.5 C13,11.3284271 12.3284271,12 11.5,12 L6.5,12 C5.67157288,12 5,11.3284271 5,10.5 L5,3.5 C5,2.67157288 5.67157288,2 6.5,2 L11.5,2 Z M11.5,3 L6.5,3 C6.22385763,3 6,3.22385763 6,3.5 L6,10.5 C6,10.7761424 6.22385763,11 6.5,11 L11.5,11 C11.7761424,11 12,10.7761424 12,10.5 L12,3.5 C12,3.22385763 11.7761424,3 11.5,3 Z"></path>
                                </svg>
                            </a>
                            <a href="https://eservicesredp.rega.gov.sa/auth/queries/Elanat" target="_blank" class="text-orange-500 flex items-center">                                
                                <svg xmlns="http://www.w3.org/2000/svg"  width="20" height="20" viewBox="0 0 24 24" id="link">
                                    <path fill="orange" d="M12.11,15.39,8.23,19.27a2.52,2.52,0,0,1-3.5,0,2.47,2.47,0,0,1,0-3.5l3.88-3.88a1,1,0,1,0-1.42-1.42L3.31,14.36a4.48,4.48,0,0,0,6.33,6.33l3.89-3.88a1,1,0,0,0-1.42-1.42ZM20.69,3.31a4.49,4.49,0,0,0-6.33,0L10.47,7.19a1,1,0,1,0,1.42,1.42l3.88-3.88a2.52,2.52,0,0,1,3.5,0,2.47,2.47,0,0,1,0,3.5l-3.88,3.88a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0l3.88-3.89A4.49,4.49,0,0,0,20.69,3.31ZM8.83,15.17a1,1,0,0,0,.71.29,1,1,0,0,0,.71-.29l4.92-4.92a1,1,0,1,0-1.42-1.42L8.83,13.75A1,1,0,0,0,8.83,15.17Z"></path>
                                </svg>
                            </a>
                        </td>
                        <td class="px-6 py-4"> {{ __($proprety->status) }} </td>
                        <td class="px-6 py-4 flex gap-1">
                            <a href="javascript:publish( {{ $proprety->id }} , 'publish' )" class="text-blue-400 underline">نشر</a>
                            <span>/</span>
                            <a href="javascript:publish( {{ $proprety->id }} , 'rejected' )" class="text-red-400 underline">رفض</a>
                        </td>
                        <!-- <td class="px-6 py-4"> {{ $proprety->created_at }} </td> -->
                        <td class="px-6 py-4"> 
                            <div class="flex gap-2">
                                <a href="{{ route('admin.property.edit' , $proprety->id) }}">تعديل</a> 
                                <form action="{{ route('admin.property.delete' , $proprety->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                    @method('DELETE')
                                    @csrf
                                    
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>    
                            </div>
                        </td>                        
                    </tr>
                    @endforeach        
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{ asset('js/notify.min.js') }}"></script>
<script>
    function no_add_item(){
        Swal.fire({
            title: 'خطأ',
            text: `{{ __('max_items_reached') }}`,
            icon: 'error',
            confirmButtonText: `{{ __('ok') }}`
        });
    }

    function copy(text)
    {        
        // const notyf = new Notyf();
        // notyf.success('Success message!');
        // notyf.error('Error message!');

        // for docs : https://github.com/caroso1222/notyf 
        const notyf = new Notyf();
        
        // Copy the text to clipboard
        navigator.clipboard.writeText(text)
            .then(() => notyf.success(' تم النسخ! ')  )
            .catch(err => notyf.error(' خطأ في النسخ ' + err ));
    }

    function publish(properity_id , status)
    {
        const notyf = new Notyf();        

        $.ajax({
            url: `{{ route('admin.property.publish') }}`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                item_status: status,
                properity_id: properity_id,
            },
            success: function(response) {
                console.log(response);
                if (response.status === true)
                {
                    notyf.success(response.done);
                }else{
                    notyf.error(response.done);
                }
            },
            error: function() {
                notyf.error("Error happened");
            }
        });
    }

    function not_published(){
        Swal.fire({
            title: `{{ __('proprety_pending') }}`,
            //text: `{{ __('proprety_pending') }}`,
            icon: 'warning',
            confirmButtonText: `{{ __('ok') }}`
        });
    }
</script>

@include('admin.footer')