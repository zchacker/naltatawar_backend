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

        <form action="{{ route('client.property.create.action') }}" method="post" class="w-full flex flex-col gap-4">
            @csrf

            <input type="text" name="title" class="input" placeholder="عنوان العقار" required />
            
            <textarea name="description" class="input" id="description" cols="30" rows="10" placeholder="وصف للعقار" required></textarea>            
            
            <div class="flex gap-4 items-stretch justify-stretch">
                
                <select name="type" id="type" class="input w-1/2">
                    <option value="" disabled selected>نوع العقار</option>
                    <option value="شقة"> شقة </option>
                    <option value="فيلا"> فيلا </option>
                    <option value="عمارة"> عمارة </option>                
                </select>  
                
                <select name="purpose" id="purpose" class="input w-1/2">
                    <option value="" disabled selected>الغرض</option>
                    <option value="{{ __('rent') }}"> {{ __('rent') }} </option>
                    <option value="{{ __('sell') }}"> {{ __('sell') }} </option>
                    <option value="{{ __('invest') }}"> {{ __('invest') }} </option>                
                </select> 
                
            </div>
            
            <input type="text" name="license_no" class="input w-1/2" placeholder=" رقم الترخيص" required />
            
            <input type="text" name="neighborhood" class="input" placeholder="اسم الحي" required />
            
            <div class="flex gap-4">
                
                <input type="text" name="space" class="input w-1/3" placeholder="المساحة  " required />
                
                <input type="text" name="price" class="input w-1/3" placeholder="السعر" required />
                
                <input type="text" name="city" class="input w-1/3" placeholder="المدينة" required />
                
            </div>
            
            <input type="text" name="location" class="input" placeholder="احداثيات العقار على الخريطة" required />

            <div class="flex gap-4">

                <input type="text" name="rooms" class="input w-1/2" placeholder="عدد الغرف" required />
                
                <input type="number" name="bathrooms" class="input w-1/2" placeholder="عدد دورات المياه" required />
                
            </div>

            <button type="submit" class="submit_btn self-start">{{__('save')}}</button>

        </form>
    </div>

</div>

@include('client.footer')