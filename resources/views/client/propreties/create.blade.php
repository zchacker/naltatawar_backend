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

        <form action="{{ route('client.property.create.action') }}" method="post" id="myform" enctype="multipart/form-data" class="w-full flex flex-col gap-4">
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

            <div class="flex flex-col items-start justify-start">
                <div class="w-full bg-white ">

                    <div class="px-6 py-4 border-b">
                        <h5 class="text-start text-lg font-bold">{{ __('upload_fiels') }}</h5>
                    </div>

                    <div class="px-0 py-4">
                        <div id="upload-container" class="text-center mb-4">
                        </div>

                        <div class="progress mt-4 hidden my-12">
                            <div class="bg-green-600 h-6 text-center text-white leading-6" style="width: 0%" id="progressBar">0%</div>
                        </div>

                        <div class="flex justify-start items-center gap-4">
                            <button id="browseImages" type="button" class="bg-gray-200 text-black px-4 py-2 rounded hover:bg-gray-400">{{ __('select_file') }}</button>
                            <p>{{ __('proprety_imgs') }}</p>
                        </div>

                        <h6 class="text-gray-600 font-semibold mt-6">{{ __('proprety_imgs') }}</h6>
                        <div id="image-preview-container" class="mt-4 relative bg-light-secondary min-h-[200px] grid grid-cols-4 gap-4 p-4 rounded-lg border-dashed border-primary border">
                            <img src="{{ asset('imgs/print_photo.png') }}" class="w-[150px] absolute left-[50%] top-5" alt="" id="img_placeholder" />
                        </div>

                        <div class="flex justify-start items-center gap-4 mt-10">
                            <button id="browseVideos" type="button" class="bg-gray-200 text-black px-4 py-2 rounded hover:bg-gray-400">{{ __('select_file') }}</button>
                            <p>{{ __('proprety_videos') }}</p>
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
<script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>

<script type="text/javascript">

    let uploadedFiles = {
        images: [],
        videos: []
    };

    let submitBtn    = $('#submit-btn');
    let browseImages = $('#browseImages');
    let browseVideos = $('#browseVideos');
    let imagePreviewContainer = $('#image-preview-container');
    let videoPreviewContainer = $('#video-preview-container');
    let progressBar = $('#progressBar');

    let img_placeholder = $('#img_placeholder');
    let vid_placeholder = $('#vid_placeholder');

    let imageUploader = new Resumable({
        target: `{{ route('client.property.file.upload') }}`,
        query: {
            _token: '{{ csrf_token() }}'
        },
        fileType: ['jpg', 'png', 'jpeg'],
        headers: {
            'Accept': 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    let videoUploader = new Resumable({
        target: `{{ route('client.property.file.upload') }}`,
        query: {
            _token: '{{ csrf_token() }}'
        },
        fileType: ['mp4'],
        headers: {
            'Accept': 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    imageUploader.assignBrowse(browseImages[0]);
    videoUploader.assignBrowse(browseVideos[0]);

    imageUploader.on('fileAdded', function(file) {
        console.log("file added");
        showProgress();
        previewFile(file, imagePreviewContainer);
        imageUploader.upload();
    });

    videoUploader.on('fileAdded', function(file) {
        showProgress();
        previewFile(file, videoPreviewContainer);
        videoUploader.upload();
    });

    imageUploader.on('fileProgress', function(file) {                
        updateProgress(Math.floor(file.progress() * 100));
    });

    videoUploader.on('fileProgress', function(file) {
        updateProgress(Math.floor(file.progress() * 100));
    });

    imageUploader.on('fileSuccess', function(file, response) {
        submitBtn.removeAttr("disabled");
        // image uploaded successfuly
        response = JSON.parse(response);
        let fileData = {
            file: file,
            path: response.path,
            filename: file.file.name,
            file_id: response.file_id,
            wp_id: response.wp_id
        };
        uploadedFiles.images.push(fileData);
        img_placeholder.hide();
        storeFileId(response.file_id, file.fileName, imagePreviewContainer);
    });

    videoUploader.on('fileSuccess', function(file, response) {
        submitBtn.removeAttr("disabled");
        // video uploaded successfuly
        response = JSON.parse(response);
        let fileData = {
            path: response.path,
            filename: response.filename,
            file_id: response.file_id,
            wp_id: response.wp_id
        };
        uploadedFiles.videos.push(fileData);
        vid_placeholder.hide();
        storeFileId(response.file_id, file.fileName, videoPreviewContainer);
    });

    imageUploader.on('fileError', function(file, response) {
        alert('Image uploading error.');
    });

    videoUploader.on('fileError', function(file, response) {
        alert('Video uploading error.');
    });

    function showProgress() {
        submitBtn.attr("disabled", true);
        progressBar.css('width', '0%');
        progressBar.text('0%');
        progressBar.parent().removeClass('hidden');
    }

    function updateProgress(value) {
        console.log("Progress: ",value);
        progressBar.css('width', `${value}%`);
        progressBar.text(`${value}%`);
    }

    function previewFile(file, container) {
        let reader = new FileReader();
        reader.onload = function(e) {
            let content;
            if (file.file.type.startsWith('image/')) {
                content = `
                    <div class="relative" data-file-name="${file.fileName}">
                        <img src="${e.target.result}" alt="Preview" class="w-56 h-56 bg-white object-cover rounded">
                        <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center remove-preview-image" data-file-name="${file.fileName}">&times;</button>
                    </div>`;
            } else if (file.file.type.startsWith('video/')) {
                content = `
                    <div class="relative" data-file-name="${file.fileName}">
                        <video class="bg-white w-56 h-56 object-cover rounded" controls>
                            <source src="${e.target.result}" type="${file.file.type}">
                            Your browser does not support the video tag.
                        </video>
                        <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center remove-preview-video" data-file-name="${file.fileName}">&times;</button>
                    </div>`;
            }

            container.append(content);

            // Attach event listener to remove button
            container.find('.remove-preview-image').last().on('click', function() {
                let fileName = $(this).data('file-name');                
                let file = uploadedFiles.images.find(file => file.filename.toLowerCase() === fileName.toLowerCase());                                
                // imageUploader.removeFile(file);
                imageUploader.cancel();// resetting
                // imageUploader.files = [];
                sendRemoveRequest(fileName, 'image');
                $(this).parent().remove();
            });

            // Attach event listener to remove button
            container.find('.remove-preview-video').last().on('click', function() {
                let fileName = $(this).data('file-name');
                sendRemoveRequest(fileName, 'video');
                $(this).parent().remove();
            });

        };
        reader.readAsDataURL(file.file);
    }

    function storeFileId(id, fileName, container) {
        container.find(`[data-file-name="${fileName}"]`).attr('data-file-id', id);
    }

    function sendRemoveRequest(fileName, fileType) {
        let fileId = $(`[data-file-name="${fileName}"]`).data('file-id');
        console.log("removed successfuly ", fileId);       

        if (fileId) {
            /*$.ajax({
                url: `{{ route('client.property.file.upload') }}`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: fileId
                },
                success: function(response) {
                    alert('File removed successfully!');

                    if (fileType === 'image') {
                        uploadedFiles.images = uploadedFiles.images.filter(file => file.filename !== fileName);
                    } else if (fileType === 'video') {
                        uploadedFiles.videos = uploadedFiles.videos.filter(file => file.filename !== fileName);
                    }
                },
                error: function() {
                    alert('Error while removing file.');
                }
            });*/
        }
    }


    // On form submit, create hidden inputs for each number in the array
    $('#myform').on('submit', function(event) {
        const form = $(this);

        // Remove any previously added hidden inputs to avoid duplicates
        form.find('input[type="hidden"]').remove();

        // Add hidden inputs for `file_id` in images
        uploadedFiles.images.forEach((fileData, index) => {
            $('<input>')
                .attr('type', 'hidden')
                .attr('name', `images[${index}]`) // e.g., images[0][file_id]
                .val(fileData.file_id)
                .appendTo(form);
        });

        // Add hidden inputs for `file_id` in videos
        uploadedFiles.videos.forEach((fileData, index) => {
            $('<input>')
                .attr('type', 'hidden')
                .attr('name', `videos[${index}]`) // e.g., videos[0][file_id]
                .val(fileData.file_id)
                .appendTo(form);
        });

        event.preventDefault();

        // Optional: Prevent form submission if the array is empty
        /**
        if (uploadedFiles.images.length === 0 && uploadedFiles.videos.length === 0) {
            event.preventDefault();
            alert('No data to submit!');
        }
        **/

    });


</script>

@include('client.footer')