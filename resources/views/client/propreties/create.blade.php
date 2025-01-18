@if (Auth::guard('agent')->check())
    @include('agent.header')
@else
    @include('client.header')
@endif

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

        <form action="{{ route('client.property.create.action') }}" method="post" id="myform" enctype="multipart/form-data" class="w-full flex flex-col gap-4">
            @csrf

            <input type="text" name="title" class="input" placeholder="عنوان العقار" value="{{ old('title') }}" required autocomplete="off" />

            <textarea name="description" class="input" id="description" cols="30" rows="10" placeholder="وصف للعقار" required autocomplete="off">{{ old('description') }}</textarea>

            <div class="flex gap-4 items-stretch justify-stretch">

                <select name="type" id="type" class="input w-1/3">
                    <option value="" disabled selected>نوع العقار</option>
                    <option value="20"> شقة </option>
                    <option value="22"> فيلا </option>
                    <option value="19"> عمارة </option>
                </select>

                <select name="purpose" id="purpose" class="input w-1/3">
                    <!-- <option value="" disabled selected>الغرض</option> -->
                    <option value="25"> {{ __('sell') }} </option>
                    <option value="26"> {{ __('rent') }} </option>
                    <option value="27"> {{ __('invest') }} </option>
                </select>

                <input type="text" name="license_no" class="input w-1/3" placeholder=" رقم الترخيص" value="{{ old('license_no') }}" required autocomplete="off" />

            </div>

            {{--
            <div class="my-8">
                <label for="image">صورة الغلاف</label>
                <input type="file" name="image" class="" />
            </div>
            --}}            

            <input type="text" name="neighborhood" class="input" placeholder="اسم الحي" value="{{ old('neighborhood') }}" required autocomplete="off" />

            <div class="flex gap-4">

                <input type="text" name="city" class="input w-full" placeholder="المدينة" value="{{ old('city') }}" required autocomplete="off" />

                <input type="text" name="location" id="location" class="hidden input w-1/2" placeholder="احداثيات العقار على الخريطة" value="{{ old('location') ?? '24.740325969940773,46.714341351147276' }}"  />

            </div>

            <div class="flex gap-4">

                <div class="flex items-center gap-2">
                    <input type="number" name="space" class="input w-1/5 flex-1" placeholder="المساحة" value="{{ old('space') }}" required autocomplete="off" />
                    <span>م</span>
                </div>

                <div class="flex items-center gap-2">
                    <input type="number" name="price" class="input w-1/5 flex-1" placeholder="السعر" value="{{ old('price') }}" required autocomplete="off" />
                    <span>/ كامل أو سنوي</span>
                </div>

                <input type="number" name="rooms" class="input w-1/5" placeholder="عدد الغرف" value="{{ old('rooms') }}" required autocomplete="off" />

                <input type="number" name="kitchen" class="input w-1/5" placeholder="{{__('kitchen')}}" value="{{ old('kitchen') }}" required autocomplete="off" />

                <input type="number" name="bathrooms" class="input w-1/5" placeholder="عدد دورات المياه" value="{{ old('bathrooms') }}" required autocomplete="off" />

            </div>

            <!-- map  -->
            <label for="">احداثيات العقار على الخريطة</label>
            <div id="map"></div>           

            <div class="my-8 flex flex-col gap-4">
                <h2 class="font-bold text-md">المرافق</h2>
                <div class="grid grid-cols-3 gap-4 w-full  border border-light-secondary p-2 rounded-md">

                    <label for="hall" class="w-full">
                        <input type="checkbox" name="hall" id="hall" value="1" />
                        {{__('hall')}}
                    </label>

                    <label for="living_room" class="w-full">
                        <input type="checkbox" name="living_room" id="living_room" value="1" />
                        {{__('living_room')}}
                    </label>

                    <label for="elevator" class="w-full">
                        <input type="checkbox" name="elevator" id="elevator" value="1" />
                        {{__('elevator')}}
                    </label>

                    <label for="fiber" class="w-full">
                        <input type="checkbox" name="fiber" id="fiber" value="1" />
                        {{__('fiber')}}
                    </label>

                    <label for="school" class="w-full">
                        <input type="checkbox" name="school" id="school" value="1" />
                        {{__('school')}}
                    </label>

                    <label for="mosque" class="w-full">
                        <input type="checkbox" name="mosque" id="mosque" value="1" />
                        {{__('mosque')}}
                    </label>

                    <label for="garden" class="w-full">
                        <input type="checkbox" name="garden" id="garden" value="1" />
                        {{__('garden')}}
                    </label>

                    <label for="pool" class="w-full">
                        <input type="checkbox" name="pool" id="pool" value="1" />
                        {{__('pool')}}
                    </label>


                </div>
            </div>

            <!-- files section  -->
            <div class="flex flex-col items-start justify-start">
                <div class="w-full bg-white ">

                    <div class="px-6 py-4 border-b">
                        <h5 class="text-start text-lg font-bold">{{ __('upload_fiels') }}</h5>
                    </div>

                    <div class="px-0 py-4">
                        <div id="upload-container" class="text-center mb-4">
                        </div>

                        
                        <div class="flex justify-start items-center gap-4 mt-2">
                            <button id="coverImage" type="button" class="bg-gray-200 text-black px-4 py-2 rounded hover:bg-gray-400">{{ __('select_file') }}</button>
                            <p>{{ __('cover_img') }}</p>
                        </div>
                        
                        <div class="progress hidden mt-8">
                            <div class="bg-green-600 h-6 text-center text-white leading-6 rounded-md" style="width: 0%" id="coverImageProgressBar">0%</div>
                        </div>

                        <h6 class="text-gray-600 font-semibold mt-6">{{ __('cover_img') }}</h6>
                        <div id="cover-image-preview-container" class="mt-2 mb-6 relative bg-light-secondary min-h-[200px] grid grid-cols-4 gap-4 p-4 rounded-lg border-dashed border-primary border">
                            <img src="{{ asset('imgs/print_photo.png') }}" class="w-[150px] absolute left-[50%] top-5" alt="" id="cover_img_placeholder" />
                        </div>


                        <div class="flex justify-start items-center gap-4 mt-8">
                            <button id="browseImages" type="button" class="bg-gray-200 text-black px-4 py-2 rounded hover:bg-gray-400">{{ __('select_file') }}</button>
                            <p>{{ __('proprety_imgs') }}</p>
                        </div>

                        <div class="progress mt-4 hidden">
                            <div class="bg-green-600 h-6 text-center text-white leading-6 rounded-md" style="width: 0%" id="imageProgressBar">0%</div>
                        </div>

                        <h6 class="text-gray-600 font-semibold mt-6">{{ __('proprety_imgs') }}</h6>
                        <div id="image-preview-container" class="mt-4 relative bg-light-secondary min-h-[200px] grid grid-cols-4 gap-4 p-4 rounded-lg border-dashed border-primary border">
                            <img src="{{ asset('imgs/print_photo.png') }}" class="w-[150px] absolute left-[50%] top-5" alt="" id="img_placeholder" />
                        </div>

                        

                        <div class="flex justify-start items-center gap-4 mt-8">
                            <button id="browseVideos" type="button" class="bg-gray-200 text-black px-4 py-2 rounded hover:bg-gray-400">{{ __('select_file') }}</button>
                            <p>{{ __('proprety_videos') }}</p>
                        </div>

                        <div class="progress mt-4 hidden">
                            <div class="bg-green-600 h-6 text-center text-white leading-6 rounded-md" style="width: 0%" id="videoProgressBar">0%</div>
                        </div>

                        <h6 class="text-gray-600 font-semibold mt-6">{{ __('proprety_videos') }}</h6>
                        <div id="video-preview-container" class="mt-4 relative bg-light-secondary min-h-[200px] grid grid-cols-4 gap-4 p-4 rounded-lg border-dashed border-primary border">
                            <img src="{{ asset('imgs/outline_video.png') }}" class="w-[150px]  absolute left-[50%] top-5" alt="" id="vid_placeholder" />
                        </div>
                    </div>

                </div>
            </div>

            <button type="submit" class="submit_btn self-start" id="submit-btn">{{__('save')}}</button>

        </form>
    </div>

</div>




<!-- jQuery -->
<!-- <script src="{{ asset('assets/js/jQuery.min.js') }}"></script> -->
<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
<!-- Resumable JS -->
<!-- https://github.com/23/resumable.js -->
<script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>

<!-- this code to upload files  -->
{{-- @vite(['resources/js/proprety.js']) --}}

<script>
    // these vars to pass to proprety.js
    let csrf = '{{ csrf_token() }}';
    let target_url = "{{ route('client.property.file.upload') }}";
    let error_upload_img = "{{ __('error_uploading_img') }}";
    let error_upload_vid = "{{ __('error_uploading_video') }}";
    let most_upload_img  = "{{ __('upload_images') }}";
    let ok_btn =  "{{ __('ok') }}";    
</script>
<script src="{{ asset('js/proprety.js') }}"></script>


<script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_KEY')}}&callback=initMap" async ></script>
<style>
    #map {
        height: 500px;
        width: 100%;
    }
</style>

<script>
    async function initMap() {
        // Specify the initial center of the map        
        const initialPosition = { lat: 24.740325969940773, lng: 46.714341351147276 }; // Example coordinates

        const { Map } = await google.maps.importLibrary("maps");

        // Create a new map centered at the initial position
        const map = new Map(document.getElementById("map"), {
            zoom: 15,
            center: initialPosition,
        });

        // Create a marker that will be placed at the clicked location
        const marker = new google.maps.Marker({
            position: initialPosition,
            map: map,
            draggable: true, // Allow the marker to be dragged
        });

        // Update the latitude and longitude display
        function updateLatLngDisplay(latLng) {                        
            if (latLng && typeof latLng.lat === 'function' && typeof latLng.lng === 'function') {
                // document.getElementById("lat").textContent = latLng.lat().toFixed(6);
                // document.getElementById("lng").textContent = latLng.lng().toFixed(6);
                document.getElementById("location").value = latLng.lat().toFixed(6) + ',' + latLng.lng().toFixed(6);
            } else {
                console.error("Invalid latLng object:", latLng);
            }
        }

        // Set initial display values
        updateLatLngDisplay(initialPosition);

        // Add a click event listener to the map
        map.addListener("click", (event) => {
            const clickedLocation = event.latLng;

            // Move the marker to the clicked location
            marker.setPosition(clickedLocation);

            // Update the latitude and longitude display
            updateLatLngDisplay(clickedLocation);
        });

        // Add a dragend event listener to the marker
        marker.addListener("dragend", () => {
            const newPosition = marker.getPosition();

            // Update the latitude and longitude display
            updateLatLngDisplay(newPosition);
        });
    }
</script>


@if (Auth::guard('agent')->check())
    @include('agent.footer')
@else
    @include('client.footer')
@endif