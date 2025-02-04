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

        

        <form action="{{ route('client.property.edit.action' , $data->id) }}" method="post" id="myform" enctype="multipart/form-data" class="w-full flex flex-col gap-4">
            @csrf

            <input type="text" name="property_number" class="hidden" value="{{ $data->property_number }}" />

            <div class="flex flex-col w-full gap-2">
                <label for="title" class="text-gray-700"> عنوان العقار  </label>
                <input type="text" name="title" class="input" placeholder="عنوان العقار" value="{{ $data->title }}" required autocomplete="off" />
            </div>

            <div class="flex flex-col w-full gap-2">
                <label for="description" class="text-gray-700"> وصف العقار  </label>
                <textarea name="description" class="input" id="description" cols="30" rows="10" placeholder="وصف للعقار" required autocomplete="off">{{ $data->description }}</textarea>
            </div>

            <div class="flex gap-4 items-stretch justify-stretch">

                <div class="flex flex-col w-1/3 gap-2">
                    <label for="type" class="text-gray-700"> نوع العقار  </label>
                    <select name="type" id="type" class="input w-full !p-1">
                        <option value="" disabled selected>نوع العقار</option>
                        <option value="20"> شقة </option>
                        <option value="22"> فيلا </option>
                        <option value="19"> عمارة </option>
                    </select>
                </div>

                <div class="flex flex-col w-1/3 gap-2">
                    <label for="purpose" class="text-gray-700"> الغرض  </label>
                    <select name="purpose" id="purpose" class="input w-full !p-1">
                        <!-- <option value="" disabled selected>الغرض</option> -->
                        <option value="25"> {{ __('sell') }} </option>
                        <option value="26"> {{ __('rent') }} </option>
                        <option value="27"> {{ __('invest') }} </option>
                    </select>
                </div>

                <div class="flex flex-col w-1/3 gap-2">
                    <label for="license_no" class="text-gray-700"> رقم الترخيص </label>
                    <input type="text" name="license_no" class="input w-full" placeholder=" رقم الترخيص" value="{{ $data->license_no }}" required autocomplete="off" />
                </div>

            </div>

            {{--
            <div class="my-8">
                <label for="image">صورة الغلاف</label>
                <input type="file" name="image" class="" />
            </div>
            --}}            

            <div class="flex flex-col w-full gap-2">
                <label for="neighborhood" class="text-gray-700"> اسم الحي  </label>
                <input type="text" name="neighborhood" class="input" placeholder="اسم الحي" value="{{ $data->neighborhood }}" required autocomplete="off" />
            </div>

            <div class="flex gap-4">

                <div class="flex flex-col w-full gap-2">
                    <label for="city" class="text-gray-700"> المدينة  </label>
                    <input type="text" name="city" id="city" class="input w-full flex-1" placeholder="المدينة" value="{{ $data->city }}" required autocomplete="off" />
                </div>

                <input type="text" name="location" id="location" class="hidden input w-1/2" placeholder="احداثيات العقار على الخريطة" value="{{ $data->location }}"  />

            </div>

            <div class="flex gap-4">

                <div class="flex flex-col w-1/5 gap-2">
                    <label for="space" class="text-gray-700"> المساحة  </label>
                    <div class="flex items-center gap-2">
                        <input type="number" name="space" class="input w-1/5 flex-1" placeholder="المساحة" value="{{ $data->facilities['space'] }}" required autocomplete="off" />
                        <span>متر</span>
                    </div>
                </div>

                <div class="flex flex-col w-1/5 gap-2">
                    <label for="kitchen" class="text-gray-700"> السعر  </label>
                    <div class="flex flex-col items-start gap-2 flex-1">
                        <input type="number" name="price" class="input w-full " placeholder="السعر" value="{{ $data->price }}" required autocomplete="off" />                        
                        <span class="font-thin text-sm text-gray-900">/ كامل - سنوي</span>
                    </div>
                </div>

                <div class="flex flex-col w-1/5 gap-2">
                    <label for="rooms" class="text-gray-700">عدد الغرف</label>
                    <input type="number" name="rooms" class="input w-full" placeholder="عدد الغرف" value="{{ $data->facilities['rooms'] }}" required autocomplete="off" />
                </div>

                <div class="flex flex-col w-1/5 gap-2">
                    <label for="kitchen" class="text-gray-700">{{__('kitchen')}}</label>
                    <input type="number" name="kitchen" class="input w-full" placeholder="{{__('kitchen')}}" value="{{ $data->facilities['kitchen'] }}" required autocomplete="off" />
                </div>

                <div class="flex flex-col w-1/5 gap-2">
                    <label for="bathrooms" class="text-gray-700"> عدد دورات المياه  </label>
                    <input type="number" name="bathrooms" class="input w-Full" placeholder="عدد دورات المياه" value="{{ $data->facilities['bathrooms'] }}" required autocomplete="off" />
                </div>
            </div>

            <!-- map  -->
            <label for="">احداثيات العقار على الخريطة</label>
            <div id="map"></div>           

            <div class="my-8 flex flex-col gap-4">
                <h2 class="font-bold text-md">المرافق</h2>
                <div class="grid grid-cols-3 gap-4 w-full  border border-light-secondary p-2 rounded-md">

                    <label for="hall" class="w-full">
                        <input type="checkbox" name="hall" id="hall" value="1" {{ $data->facilities['hall'] == true ? 'checked' : '' }} />
                        {{__('hall')}}
                    </label>

                    <label for="living_room" class="w-full">
                        <input type="checkbox" name="living_room" id="living_room" value="1" {{ $data->facilities['living_room'] == true ? 'checked' : '' }} />
                        {{__('living_room')}}
                    </label>

                    <label for="elevator" class="w-full">
                        <input type="checkbox" name="elevator" id="elevator" value="1" {{ $data->facilities['elevator'] == true ? 'checked' : '' }} />
                        {{__('elevator')}}
                    </label>

                    <label for="fiber" class="w-full">
                        <input type="checkbox" name="fiber" id="fiber" value="1" {{ $data->facilities['fiber'] == true ? 'checked' : '' }} />
                        {{__('fiber')}}
                    </label>

                    <label for="school" class="w-full">
                        <input type="checkbox" name="school" id="school" value="1" {{ $data->facilities['school'] == true ? 'checked' : '' }} />
                        {{__('school')}}
                    </label>

                    <label for="mosque" class="w-full">
                        <input type="checkbox" name="mosque" id="mosque" value="1" {{ $data->facilities['mosque'] == true ? 'checked' : '' }} />
                        {{__('mosque')}}
                    </label>

                    <label for="garden" class="w-full">
                        <input type="checkbox" name="garden" id="garden" value="1" {{ $data->facilities['garden'] == true ? 'checked' : '' }} />
                        {{__('garden')}}
                    </label>

                    <label for="pool" class="w-full">
                        <input type="checkbox" name="pool" id="pool" value="1" {{ $data->facilities['pool'] == true ? 'checked' : '' }} />
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
                            
                            <!-- <img src="{{ asset('imgs/print_photo.png') }}" class="w-[150px] absolute left-[50%] top-5" alt="" id="img_placeholder" /> -->
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
                            {{--<img src="{{ asset('imgs/outline_video.png') }}" class="w-[150px]  absolute left-[50%] top-5" alt="" id="vid_placeholder" />--}}
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

<script>
    // get files data to JS

    // push images data
    @foreach($data->images()->get() as $file)
        //console.log(`{{ $file->file->url }}`)
        data = {
            file: null,            
            filename: `{{ $file->file->url }}`,
            file_id: `{{ $file->file->id }}`
        };
        uploadedFiles.images.push(data);

        content = `
        <div class="relative" data-file-name="{{ $file->file->url }}">
            <img src="{{ $file->file->url }}" alt="Preview" class="w-56 h-56 bg-white object-cover rounded">
            <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center remove-preview-image" data-file-id="{{$file->file->id}}" data-file-name="{{ $file->file->url }}">&times;</button>
        </div>`;
            
        imagePreviewContainer.append(content);

        imagePreviewContainer.find('.remove-preview-image').last().on('click', function() {
            let fileName = $(this).data('file-name');
            let fileID = $(this).data('file-id');
            imageUploader.cancel();// resetting  
            //console.error(fileID);          
            sendRemoveRequest(fileID, 'image');// this to server
            uploadedFiles.images = uploadedFiles.images.filter(file => file.filename !== fileName);// this local
            $(this).parent().remove();
        });

    @endforeach

    // push videos
    @foreach($data->videos()->get() as $file)
        //console.log(`{{ $file->file->url }}`)
        data = {
            file: null,            
            filename: `{{ $file->file->url }}`,
            file_id: `{{ $file->file->id }}`
        };
        uploadedFiles.videos.push(data);

        content = `
        <div class="relative" data-file-name="{{ $file->file->url }}">
            <video class="bg-white w-56 h-56 object-cover rounded" controls>
                <source src="{{ $file->file->url }}" >
                Your browser does not support the video tag.
            </video>
            <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center remove-preview-video" data-file-id="{{$file->file->id}}" data-file-name="{{ $file->file->url }}">&times;</button>
        </div>`;

        videoPreviewContainer.append(content);

        videoPreviewContainer.find('.remove-preview-image').last().on('click', function() {
            let fileName = $(this).data('file-name');
            let fileID = $(this).data('file-id');
            imageUploader.cancel();// resetting  
            //console.error(fileID);          
            sendRemoveRequest(fileID, 'image');// this to server   
            uploadedFiles.videos = uploadedFiles.videos.filter(file => file.filename !== fileName);// this local         
            $(this).parent().remove();   
        });

    @endforeach

    // push cover    
    data = {
        file: null,            
        filename: `{{ $data->cover->url }}`,
        file_id: `{{ $data->cover->id }}`
    };
    coverImg = data;

    content = `
    <div class="relative" data-file-name="{{ $data->cover->url }}">
        <img src="{{ $data->cover->url }}" alt="Preview" class="w-56 h-56 bg-white object-cover rounded">
        <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center remove-preview-image" data-file-id="{{ $data->cover->id }} data-file-name="{{ $data->cover->url }}">&times;</button>
    </div>`;

    coverPreviewContainer.empty();
    coverPreviewContainer.append(content);

    // Attach event listener to remove button
    coverPreviewContainer.find('.remove-preview-image').last().on('click', function() {
        //let fileName = $(this).data('file-name');
        //let fileID = $(this).data('file-id');
        //sendRemoveRequest(fileID, 'image');
        imageUploader.cancel();// resetting            
        coverImg = null;
        $(this).parent().remove();
    }); 
    
    console.log(uploadedFiles);

</script>

<script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_KEY')}}&callback=initMap" async ></script>
<style>
    #map {
        height: 500px;
        width: 100%;
    }
</style>

@php 
    $coords = explode( ',' , $data->location );    
@endphp

<script>
    async function initMap() {        

        // Specify the initial center of the map        
        const initialPosition = { lat: {{ doubleVal($coords[0]) }} , lng: {{ doubleVal($coords[1]) }} }; // Example coordinates

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