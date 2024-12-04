@include('client.header')

<div class="mt-4 flex flex-col gap-8">
    <h2 class="font-bold text-xl"> {{__('create_proprety')}} </h2>

    <div class="md:w-full">

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

        <form action="{{ route('client.property.create.action') }}" method="post" enctype="multipart/form-data" class="w-full flex flex-col gap-4">
            @csrf

            <input type="text" name="title" class="input" placeholder="عنوان العقار" value="{{ old('title') }}" required />
            
            <textarea name="description" class="input" id="description" cols="30" rows="10" placeholder="وصف للعقار" required>{{ old('description') }}</textarea>            
            
            <div class="flex gap-4 items-stretch justify-stretch">
                
                <select name="type" id="type" class="input w-1/3">
                    <option value="" disabled selected>نوع العقار</option>
                    <option value="20"> شقة </option>
                    <option value="22"> فيلا </option>
                    <option value="19"> عمارة </option>                
                </select>  
                
                <select name="purpose" id="purpose" class="input w-1/3">
                    <option value="" disabled selected>الغرض</option>
                    <option value="25"> {{ __('sell') }} </option>
                    <option value="26"> {{ __('rent') }} </option>
                    <option value="27"> {{ __('invest') }} </option>                
                </select> 
                
                <input type="text" name="license_no" class="input w-1/3" placeholder=" رقم الترخيص" value="{{ old('license_no') }}" required />
            
            </div>

            <div class="my-8">
                <label for="image">صورة الغلاف</label>
                <input type="file" name="image" class="" />
            </div>
                        
            <input type="text" name="neighborhood" class="input" placeholder="اسم الحي" value="{{ old('neighborhood') }}" required />
            
            <div class="flex gap-4">
                                
                <input type="text" name="city" class="input w-1/2" placeholder="المدينة" value="{{ old('city') }}" required />
                
                <input type="text" name="location" class="input w-1/2" placeholder="احداثيات العقار على الخريطة" value="{{ old('location') }}" required />
                
            </div>
            
            <div class="flex gap-4">

                <input type="number" name="space" class="input w-1/5" placeholder="المساحة" value="{{ old('space') }}" required />
                
                <input type="number" name="price" class="input w-1/5" placeholder="السعر" value="{{ old('price') }}" required />
                
                <input type="number" name="rooms" class="input w-1/5" placeholder="عدد الغرف" value="{{ old('rooms') }}" required />
                
                <input type="number" name="kitchen" class="input w-1/5" placeholder="{{__('kitchen')}}" value="{{ old('kitchen') }}" required />
                
                <input type="number" name="bathrooms" class="input w-1/5" placeholder="عدد دورات المياه" value="{{ old('bathrooms') }}" required />
                
            </div>

            <div class="my-8 flex flex-col gap-4">
                <h2 class="font-bold text-md">المرافق</h2>
                <div class="grid grid-cols-3 gap-4 w-full  border border-light-secondary p-2 rounded-md">

                    <label for="hall" class="w-full">
                        <input type="checkbox" name="hall" id="hall" value="1"/>
                        {{__('hall')}} 
                    </label>

                    <label for="living_room"  class="w-full">
                        <input type="checkbox" name="living_room" id="living_room" value="1"/>
                        {{__('living_room')}}
                    </label>

                    <label for="elevator"  class="w-full">
                        <input type="checkbox" name="elevator" id="elevator" value="1"/>
                        {{__('elevator')}}
                    </label>

                    <label for="fiber"  class="w-full">
                        <input type="checkbox" name="fiber" id="fiber" value="1"/>
                        {{__('fiber')}}
                    </label>
                    
                    <label for="school" class="w-full">
                        <input type="checkbox" name="school" id="school" value="1"/>
                        {{__('school')}}
                    </label>

                    <label for="mosque" class="w-full">
                        <input type="checkbox" name="mosque" id="mosque" value="1"/>
                        {{__('mosque')}}
                    </label>
                    
                    <label for="garden" class="w-full">
                        <input type="checkbox" name="garden" id="garden" value="1"/>
                        {{__('garden')}}
                    </label>

                    <label for="pool" class="w-full">
                        <input type="checkbox" name="pool" id="pool" value="1"/>
                        {{__('pool')}}
                    </label>


                </div>
            </div>


            <button type="submit" class="submit_btn self-start">{{__('save')}}</button>

        </form>
    </div>

</div>

@include('client.footer')