@extends('main.admin.layouts.master')

@section('title','Admin Dashboard')
@section('label','Project Details')

@section('noti')
    {{ $orderCounts->count() }}
@endsection

@section('content')
    <!-- add account start  -->
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center ms-1">
                <a href="{{ route('project#list') }}"><i class="fa-solid fa-arrow-left-long" id="arrow-back"></i></a>
            </div>
            @if(session('updateSuccess'))
                <div class="row mt-3 mb-0 me-5 justify-content-end" id="alert-row">
                    <div class="col-lg-6 w-auto alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('updateSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            <div id="table-web">
                <form action="{{ route('project#update') }}" method="POST" class="mt-4" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $projects->id }}" name="projectId">
                    <div class="form-group row">
                        <div class="col-lg-6 col-sm-6 mb-4">
                            <label for="">Name</label>
                            <input type="text" name="projectName" value="{{ old('projectName',$projects->name) }}" class="form-control mt-1 @error('projectName') is-invalid @enderror" placeholder="Enter project name">
                            @error('projectName')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-sm-6 mb-4">
                            <label for="">Type</label>
                            <input type="text" name="projectType" value="{{ old('projectType',$projects->type) }}" class="form-control mt-1 @error('projectType') is-invalid @enderror" placeholder="Enter project type">
                            @error('projectType')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6 col-sm-6 mb-4">
                            <label for="">Duration</label>
                            <input type="text" name="projectDuration" value="{{ old('projectDuration',$projects->project_duration) }}" class="form-control mt-1 @error('projectDuration') is-invalid @enderror" placeholder="eg: Jan 2024 - Feb 2024">
                            @error('projectDuration')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-sm-6 mb-4">
                            <label for="">Website Link</label>
                            <input type="text" name="projectLink" value="{{ old('projectLink',$projects->website_link) }}" class="form-control mt-1 @error('projectLink') is-invalid @enderror" placeholder="https://website.com/">
                            @error('projectLink')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6 col-sm-6 mb-4">
                            <label for="">Paragraph 1</label>
                            <textarea name="projectPara1" class="form-control mt-1 @error('projectPara1') is-invalid @enderror" cols="30" rows="10" placeholder="Enter package explanation">{{ old('projectPara1',$projects->paragraph1) }}</textarea>
                            @error('projectPara1')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-sm-6 mb-4">
                            <label for="">Paragraph 2</label>
                            <textarea name="projectPara2" class="form-control mt-1 @error('projectPara2') is-invalid @enderror" cols="30" rows="10" placeholder="Enter package explanation">{{ old('projectPara2',$projects->paragraph2) }}</textarea>
                            @error('projectPara2')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Price Plan Letter</label>
                        <textarea name="projectPriceLetter" class="form-control mt-1 @error('projectPriceLetter') is-invalid @enderror" cols="30" rows="4" placeholder="Enter package explanation">{{ old('projectPriceLetter',$projects->price_letter) }}</textarea>
                        @error('projectPriceLetter')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Project Permission*</label>
                        <select name="projectPermission" id="" class="form-control mt-1 @error('projectPermission') is-invalid @enderror">
                            <option value="" disabled selected>Choose permission ...</option>
                            @foreach ($permissions as $p)
                                <option value="{{ $p->name }}" @if($projects->project_permission == $p->name) selected @endif>{{ $p->name }}</option>
                            @endforeach
                        </select>
                        @error('projectPermission')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Images</label>
                        <input type="file" id="file" name="projectImages[]" class="form-control mt-1 @error('projectImages') is-invalid @enderror" accept="image/*" multiple onchange="loadFiles(event);">
                        <input type="hidden" id="orderedImages" name="orderedImages">

                        <div id="image-preview-container" class="mt-3 d-flex flex-wrap">
                            @if($projects->images && is_array(json_decode($projects->images, true)))
                                @foreach(json_decode($projects->images, true) as $index => $image)
                                    <img src="{{ asset('storage/projects/'.$image) }}" class="img-thumbnail mx-1 mb-2" data-index="{{ $index }}" alt="Existing Image">
                                @endforeach
                            @else
                                <img src="{{ asset('admin/image/default.jpg') }}" id="output2" class="mt-3 img-thumbnail" alt="Default Image">
                            @endif
                        </div>
                        @error('projectImages')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3 mx-auto" id="update-btn" disabled>Update</button>
                </form>
            </div>
        </div>
    </main>
    <!-- add account end -->
@endsection


@section('scriptSource')
<script>
    var loadFiles = function(event) {
        var container = document.getElementById("image-preview-container");
        container.innerHTML = "";

        if (event.target.files.length > 0) {
            const orderedFiles = [];
            const files = Array.from(event.target.files);

            files.forEach((file, index) => {
                orderedFiles.push(index);

                var image = document.createElement("img");
                image.src = URL.createObjectURL(file);
                image.className = "img-thumbnail mx-1 mb-2";
                image.style.width = "280px";
                image.style.height = "160px";
                image.dataset.index = index;

                image.draggable = true;
                image.ondragstart = (e) => e.dataTransfer.setData("text", e.target.dataset.index);
                image.ondragover = (e) => e.preventDefault();
                image.ondrop = (e) => {
                    e.preventDefault();

                    const draggedIndex = e.dataTransfer.getData("text");
                    const targetIndex = e.target.dataset.index;

                    const draggedImage = container.querySelector(`[data-index="${draggedIndex}"]`);
                    const targetImage = container.querySelector(`[data-index="${targetIndex}"]`);

                    if (draggedImage && targetImage) {
                        container.insertBefore(draggedImage, targetImage.nextSibling);
                        const reorderedIndices = Array.from(container.children).map(
                                (img) => img.dataset.index
                            );
                            document.getElementById("orderedImages").value = JSON.stringify(reorderedIndices);
                    }
                };

                container.appendChild(image);
            });
            document.getElementById("orderedImages").value = JSON.stringify(orderedFiles);
        }
    };
    document.getElementById("file").addEventListener("change", loadFiles);



    // update btn
    const updateBtnFormElements = document.querySelectorAll('input,textarea,select');
    const updateBtn = document.getElementById('update-btn');
    const initialValues = {};

    updateBtnFormElements.forEach(element => {
        initialValues[element.name] = element.value;
    });

    function checkUpdateValueForBtn() {
        let hasChanged = false;
        updateBtnFormElements.forEach(element => {
            if (element.value != initialValues[element.name]) {
                hasChanged = true;
            }
        });
        updateBtn.disabled = !hasChanged;
    }

    updateBtnFormElements.forEach(element => {
        element.addEventListener('input', checkUpdateValueForBtn);
        element.addEventListener('change', checkUpdateValueForBtn);
    });

    checkUpdateValueForBtn();
</script>
@endsection
