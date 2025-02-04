var coverImg = null;
let uploadedFiles = {
    images: [],
    videos: []
};

let submitBtn               = $('#submit-btn');

let coverImage              = $('#coverImage');
let browseImages            = $('#browseImages');
let browseVideos            = $('#browseVideos');  

let coverPreviewContainer   = $('#cover-image-preview-container');
let imagePreviewContainer   = $('#image-preview-container');
let videoPreviewContainer   = $('#video-preview-container');

let coverProgressBar        = $('#coverImageProgressBar');
let imageProgressBar        = $('#imageProgressBar');
let videoProgressBar        = $('#videoProgressBar');

let cover_img_placeholder   = $('#cover_img_placeholder');
let img_placeholder         = $('#img_placeholder');
let vid_placeholder         = $('#vid_placeholder');

function set_images(images) 
{
    this.images = images;
}

function set_videos(videos) 
{
    this.videos = videos;
}

function set_cover(cover)
{
    this.cover = cover;
}

let coverImageUploader = new Resumable({
    target: target_url,
    query: {
        _token: csrf
    },
    fileType: ['jpg', 'png', 'jpeg', 'webp'],
    headers: {
        'Accept': 'application/json'
    },
    testChunks: false,
    throttleProgressCallbacks: 1,
    maxFiles: 1,
    //chunkSize: 1 * 1024 * 1024, // 1 MB
});

// watch this tutorial for any docs
// https://shouts.dev/articles/laravel-upload-large-file-with-resumablejs-and-laravel-chunk-upload
let imageUploader = new Resumable({
    target: target_url,
    query: {
        _token: csrf
    },
    fileType: ['jpg', 'png', 'jpeg', 'webp'],
    headers: {
        'Accept': 'application/json'
    },
    testChunks: false,
    throttleProgressCallbacks: 1,
    //chunkSize: 1 * 1024 * 1024, // 1 MB
});

let videoUploader = new Resumable({
    target: target_url,
    query: {
        _token: csrf
    },
    fileType: ['mp4'],
    headers: {
        'Accept': 'application/json'
    },
    testChunks: false,
    throttleProgressCallbacks: 1,
});

coverImageUploader.assignBrowse(coverImage[0]);
imageUploader.assignBrowse(browseImages[0]);
videoUploader.assignBrowse(browseVideos[0]);

coverImageUploader.on('fileAdded', function(file) {
    console.log("file added");        
    showCoverImageProgress();
    coverPreviewFile(file, coverPreviewContainer);
    coverImageUploader.upload();
});

imageUploader.on('fileAdded', function(file) {
    console.log("file added");
    showImageProgress();
    previewFile(file, imagePreviewContainer);
    imageUploader.upload();
});

videoUploader.on('fileAdded', function(file) {
    showVideoProgress();
    previewFile(file, videoPreviewContainer);
    videoUploader.upload();
});

coverImageUploader.on('fileProgress', function(file) {                
    updateCoverImageProgress(Math.floor(file.progress() * 100));
});

imageUploader.on('fileProgress', function(file) {                
    updateImageProgress(Math.floor(file.progress() * 100));
});

videoUploader.on('fileProgress', function(file) {
    updateVideoProgress(Math.floor(file.progress() * 100));
});

coverImageUploader.on('fileSuccess', function(file, response) {
    submitBtn.removeAttr("disabled");
    // image uploaded successfuly
    response = JSON.parse(response);

    let fileData = {
        file: file,
        //path: response.path,
        filename: file.file.name,
        file_id: response.file_id
    };
    coverImg = fileData;

    console.log("coverImg: " , coverImg);
    
    cover_img_placeholder.hide();
    storeFileId(response.file_id, file.fileName, coverPreviewContainer);
});

imageUploader.on('fileSuccess', function(file, response) {
    submitBtn.removeAttr("disabled");
    // image uploaded successfuly
    response = JSON.parse(response);
    let fileData = {
        file: file,
        //path: response.path,
        filename: file.file.name,
        file_id: response.file_id
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
        file: file,
        //path: response.path,
        filename: response.filename,
        file_id: response.file_id
    };
    uploadedFiles.videos.push(fileData);
    vid_placeholder.hide();
    storeFileId(response.file_id, file.fileName, videoPreviewContainer);
});


coverImageUploader.on('fileError', function(file, response) {
    // alert('Image uploading error.');
    Swal.fire({
        title: 'خطأ',
        text: error_upload_img,
        icon: 'error',
        confirmButtonText: ok_btn
    });
});

imageUploader.on('fileError', function(file, response) {
    // alert('Image uploading error.');
    Swal.fire({
        title: 'خطأ',
        text: error_upload_img,
        icon: 'error',
        confirmButtonText: ok_btn
    });
});

videoUploader.on('fileError', function(file, response) {
    // alert('Video uploading error.');
    Swal.fire({
        title: 'خطأ',
        text: error_upload_vid,
        icon: 'error',
        confirmButtonText: ok_btn
    });
});

function showCoverImageProgress() {
    submitBtn.attr("disabled", true);
    coverProgressBar.css('width', '0%');
    coverProgressBar.text('0%');
    coverProgressBar.parent().removeClass('hidden');
}

function showImageProgress() {
    submitBtn.attr("disabled", true);
    imageProgressBar.css('width', '0%');
    imageProgressBar.text('0%');
    imageProgressBar.parent().removeClass('hidden');
}

function showVideoProgress() {
    submitBtn.attr("disabled", true);
    videoProgressBar.css('width', '0%');
    videoProgressBar.text('0%');
    videoProgressBar.parent().removeClass('hidden');
}

function updateCoverImageProgress(value) {
    console.log("Progress: ",value);
    coverProgressBar.css('width', `${value}%`);
    coverProgressBar.text(`${value}%`);
}

function updateImageProgress(value) {
    console.log("Progress: ",value);
    imageProgressBar.css('width', `${value}%`);
    imageProgressBar.text(`${value}%`);
}

function updateVideoProgress(value) {
    console.log("Progress: ",value);
    videoProgressBar.css('width', `${value}%`);
    videoProgressBar.text(`${value}%`);
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
            imageUploader.cancel();// resetting            
            //sendRemoveRequest(fileName, 'image');
            uploadedFiles.images = uploadedFiles.images.filter(file => file.filename !== fileName);// this local
            $(this).parent().remove();            
        });

        // Attach event listener to remove button
        container.find('.remove-preview-video').last().on('click', function() {
            let fileName = $(this).data('file-name');
            videoUploader.cancel();// resetting
            //sendRemoveRequest(fileName, 'video');
            uploadedFiles.videos = uploadedFiles.videos.filter(file => file.filename !== fileName);// this local
            $(this).parent().remove();
        });

    };
    reader.readAsDataURL(file.file);
}

function coverPreviewFile(file , container){
    let reader = new FileReader();
    reader.onload = function(e) {
        let content;
        if (file.file.type.startsWith('image/')) {
            content = `
                <div class="relative" data-file-name="${file.fileName}">
                    <img src="${e.target.result}" alt="Preview" class="w-56 h-56 bg-white object-cover rounded">
                    <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center remove-preview-image" data-file-name="${file.fileName}">&times;</button>
                </div>`;
        }            

        container.empty();
        container.append(content);
        
        // Attach event listener to remove button
        container.find('.remove-preview-image').last().on('click', function() {
            let fileName = $(this).data('file-name');
            imageUploader.cancel();// resetting            
            //sendRemoveRequest(fileName, 'image');
            coverImg = null;// clear the cover image
            $(this).parent().remove();
        });            

    };
    reader.readAsDataURL(file.file);
}

function storeFileId(id, fileName, container) {
    container.find(`[data-file-name="${fileName}"]`).attr('data-file-id', id);
}

function sendRemoveRequest(fileName, fileType) {
    console.log(fileName);
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

    // disable submit button to avoid douple submit
    submitBtn.attr("disabled", true);

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

    if( coverImg != null ) {
        // add cover hidden id        
        $('<input>')
            .attr('type', 'hidden')
            .attr('name', `cover_img`) // e.g., videos[0][file_id]
            .val(coverImg.file_id)
            .appendTo(form);
    }

    // add the token for csrf
    $('<input>')
            .attr('type', 'hidden')
            .attr('name', '_token') // e.g., videos[0][file_id]
            .val(csrf)
            .appendTo(form);

    
    // console.log(uploadedFiles.images.length);
    // event.preventDefault(); // Prevent the default behavior
    // event.stopPropagation(); // Stop other event handlers

    // Optional: Prevent form submission if the array is empty    
    if (uploadedFiles.images.length === 0 ){// && uploadedFiles.videos.length === 0) {
        submitBtn.removeAttr("disabled");
        event.preventDefault();

        Swal.fire({
            title: 'خطأ',
            text: most_upload_img,
            icon: 'error',
            confirmButtonText: ok_btn
        });
        //alert(`{{ __('upload_images') }}`);
    }
    

});