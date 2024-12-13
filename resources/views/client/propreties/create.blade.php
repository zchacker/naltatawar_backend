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

            <div class="flex flex-col items-start justify-start">
                <div class="w-full bg-white shadow-md rounded-lg">
                    <div class="px-6 py-4 border-b">
                        <h5 class="text-start text-lg font-bold">Upload File</h5>
                    </div>

                    <div class="px-6 py-4">
                        <div id="upload-container" class="text-center mb-4">
                            <button id="browseImages" type="button" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Browse Images</button>
                            <button id="browseVideos" type="button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 ml-4">Browse Videos</button>
                        </div>

                        <div class="progress mt-4 hidden">
                            <div class="bg-blue-500 h-6 text-center text-white leading-6" style="width: 0%" id="progressBar">0%</div>
                        </div>

                        <h6 class="text-gray-600 font-semibold mt-6">Image Previews</h6>
                        <div id="image-preview-container" class="mt-4 grid grid-cols-3 gap-4"></div>

                        <h6 class="text-gray-600 font-semibold mt-6">Video Previews</h6>
                        <div id="video-preview-container" class="mt-4 grid grid-cols-3 gap-4"></div>
                    </div>

                </div>
            </div>

            <button type="submit" class="submit_btn self-start">{{__('save')}}</button>

        </form>
    </div>

</div>




<!-- jQuery -->
<!-- <script src="{{ asset('assets/js/jQuery.min.js') }}"></script> -->
<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
<!-- Resumable JS -->
<script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>

<script type="text/javascript">
    let browseImages = $('#browseImages');
    let browseVideos = $('#browseVideos');
    let imagePreviewContainer = $('#image-preview-container');
    let videoPreviewContainer = $('#video-preview-container');
    let progressBar = $('#progressBar');

    let imageUploader = new Resumable({
        target: '{{ route('client.property.file.upload') }}',
        query: { _token: '{{ csrf_token() }}' },
        fileType: ['jpg', 'png', 'jpeg'],
        headers: {
            'Accept': 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    let videoUploader = new Resumable({
        target: '{{ route('client.property.file.upload') }}',
        query: { _token: '{{ csrf_token() }}' },
        fileType: ['mp4'],
        headers: {
            'Accept': 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    imageUploader.assignBrowse(browseImages[0]);
    videoUploader.assignBrowse(browseVideos[0]);

    imageUploader.on('fileAdded', function (file) {
        showProgress();
        previewFile(file, imagePreviewContainer);
        imageUploader.upload();
    });

    videoUploader.on('fileAdded', function (file) {
        showProgress();
        previewFile(file, videoPreviewContainer);
        videoUploader.upload();
    });

    imageUploader.on('fileProgress', function (file) {
        updateProgress(Math.floor(file.progress() * 100));
    });

    videoUploader.on('fileProgress', function (file) {
        updateProgress(Math.floor(file.progress() * 100));
    });

    imageUploader.on('fileSuccess', function (file, response) {
        response = JSON.parse(response);
        //alert('Image uploaded successfully!');
    });

    videoUploader.on('fileSuccess', function (file, response) {
        response = JSON.parse(response);
        //alert('Video uploaded successfully!');
    });

    imageUploader.on('fileError', function (file, response) {
        alert('Image uploading error.');
    });

    videoUploader.on('fileError', function (file, response) {
        alert('Video uploading error.');
    });

    function showProgress() {
        progressBar.css('width', '0%');
        progressBar.text('0%');
        progressBar.parent().removeClass('hidden');
    }

    function updateProgress(value) {
        progressBar.css('width', `${value}%`);
        progressBar.text(`${value}%`);
    }

    function previewFile(file, container) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let content;
            if (file.file.type.startsWith('image/')) {
                content = `
                    <div class="relative">
                        <img src="${e.target.result}" alt="Preview" class="w-24 h-24 object-cover rounded">
                        <button class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center remove-preview">&times;</button>
                    </div>`;
            } else if (file.file.type.startsWith('video/')) {
                content = `
                    <div class="relative">
                        <video class="w-24 h-24 object-cover rounded" controls>
                            <source src="${e.target.result}" type="${file.file.type}">
                            Your browser does not support the video tag.
                        </video>
                        <button class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center remove-preview">&times;</button>
                    </div>`;
            }

            container.append(content);

            // Attach event listener to remove button
            container.find('.remove-preview').last().on('click', function () {
                $(this).parent().remove();
            });
        };
        reader.readAsDataURL(file.file);
    }
</script>

@include('client.footer')