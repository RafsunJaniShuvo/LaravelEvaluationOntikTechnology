@extends('layouts.app')

@section('content')
    <style>
        .error{
            color:red;
        }
    </style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Create Category  <i class="fa-solid fa-plus"></i>
                        </button>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sub_category" onclick="appendOption()">
                            Create Sub Category  <i class="fa-solid fa-plus"></i>
                        </button>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#products" onclick="appendOptionForSubCategory()">
                           Create Products  <i class="fa-solid fa-plus"></i>
                        </button>
                        <a href="{{route('view_category')}}">
                            <button type="button" class="btn btn-primary">
                                View Category
                            </button>
                        </a>
                        <a href="{{route('view_sub_category')}}">
                            <button type="button" class="btn btn-primary">
                                View Sub Category
                            </button>
                        </a>
                        <a href="{{route('view_products')}}">
                            <button type="button" class="btn btn-primary">
                                View Products
                            </button>
                        </a>
                        <!-- Modal -->
                        {{-- Category Modal --}}
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Create Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="#" id="modal_form" class="modal_form" enctype="multipart/form-data">
                                       @csrf
                                        <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">Title</label>
                                                    <input type="text" class="form-control" id="title" name="title">
                                                    <span id="title_error" class="error" ></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="desc" class="form-label">Description</label>
                                                    <textarea id="desc" name="desc" class="form-control desc"></textarea>
                                                    <span id="desc_error" class="error"></span>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="saveButton">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                            {{-- sub category modal --}}
                        <div class="modal fade" id="sub_category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Create Sub Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <form action="#" id="sub_modal_form" class="sub_modal_form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="subtitle" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="subtitle" name="subtitle">
                                                <span id="subtitle_error" class="error" ></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="subdesc" class="form-label">Description</label>
                                                <textarea id="subdesc" name="subdesc" class="form-control desc"></textarea>
                                                <span id="subdesc_error" class="error"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="desc" class="form-label">Category</label>
                                                <select class="form-select" aria-label="Default select example" id="dynamic-select" name="subCategoryId">


                                                </select>
                                                <span id="subCategoryId_error" class="error"></span>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="saveButtonSubCategory">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
{{--                     products modal--}}
                        <div class="modal fade" id="products" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Create Products</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="#" id="productsFormId" class="productsFormId" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="productsTitle" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="productsTitle" name="productsTitle">
                                                <span id="productsTitle_error" class="error"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="productsDesc" class="form-label">Description</label>
                                                <textarea id="productsDesc" name="productsDesc" class="form-control desc"></textarea>
                                                <span id="productsDesc_error" class="error" ></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="dynamic-select-sub-category" class="form-label">Sub Category</label>
                                                <select class="form-select" aria-label="Default select example" id="dynamic-select-sub-category" name="products">


                                                </select>
                                                <span id="products_error" class="error" ></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Price</label>
                                                <input type="text" class="form-control" id="price" name="price">
                                                <span id="price_error" class="error" ></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="thumbnail" class="form-label">Thumbnail</label>
                                                <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                                                <span id="thumbnail_error" class="error" ></span>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="productsSave">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
{{--    jquery dataTables--}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
{{--    jquery validate--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{--    jquery date picker--}}
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>

    $(document).on('click','#saveButton',function (){
        var formData = new FormData($('.modal_form')[0]);
        $.ajax({
            type:"POST",
            // dataType:"json",
            url:"{{route('store_category')}}",
            data: formData,

            // data:formdata,
            contentType: false,
            processData: false,

            success:function(response){
                if(response.errors){
                    $.each(response.errors, function(field, errors) {
                        // You can append the error messages to your form or any desired location
                        $('#' + field + '_error').text(errors[0]);
                    });
                }
                if(response.status=='success'){
                    alert("Category Created Successfully");
                    $('#exampleModal').modal('hide');
                    location.reload();
                    // $('#myTable').DataTable().ajax.reload();

                }
            },
            error:function(response){
                console.log(response)
            }
        })
    })

    $(document).on('click','#saveButtonSubCategory',function (){
        var formData = new FormData($('.sub_modal_form')[0]);
        $.ajax({
            type:"POST",
            url:"{{route('store_sub_category')}}",
            data: formData,

            // data:formdata,
            contentType: false,
            processData: false,

            success:function(response){
                if(response.errors){
                    $.each(response.errors, function(field, errors) {
                        // You can append the error messages to your form or any desired location
                        $('#' + field + '_error').text(errors[0]);
                    });
                }
                if(response.status=='success'){
                    alert("Sub Category Created Successfully");
                    $('#sub_category').modal('hide');
                    location.reload();
                    // $('#myTable').DataTable().ajax.reload();

                }
            },
            error:function(response){
                console.log(response)
            }
        })
    })

    $(document).on('click','#productsSave',function (){
        var formData = new FormData($('.productsFormId')[0]);
        $.ajax({
            type:"POST",
            url:"{{route('store_products')}}",
            data: formData,
            dataType: 'json',
            // data:formdata,
            contentType: false,
            processData: false,

            success:function(response){
                if(response.errors){
                    $.each(response.errors, function(field, errors) {
                        // You can append the error messages to your form or any desired location
                        $('#' + field + '_error').text(errors[0]);
                    });
                }
                if(response.status=='success'){
                    alert("Prducts Saved Successfully");
                    $('#products').modal('hide');
                    location.reload();
                    // $('#myTable').DataTable().ajax.reload();

                }
            },
            error:function(error){
                console.log(error,5555)

            }
        })
    })

    function appendOption() {
        $.ajax({
            url: '/get-category',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                var selectElement = $('#dynamic-select');
                selectElement.empty(); // Clear existing options
                // Append nw options from the response <option selected>Open this select menu</option>
                let show = '<option selected>Open this select menu</option>';
                selectElement.append(show);
                $.each(response, function (index, option) {
                    selectElement.append('<option value="' + index + '">' + option + '</option>');
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function appendOptionForSubCategory() {
        $.ajax({
            url: '/get-sub-category',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                var selectElement = $('#dynamic-select-sub-category');
                selectElement.empty(); // Clear existing options
                // Append nw options from the response <option selected>Open this select menu</option>
                let show = '<option selected>Open this select menu</option>';
                selectElement.append(show);
                $.each(response, function (index, option) {
                    selectElement.append('<option value="' + index + '">' + option + '</option>');
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    }


    let ajaxtable = $('#myTable').DataTable({
        "processing":true,
        "serverSide":true,
{{--        "ajax":"{{route('ajax.getData')}}",--}}
        "columns":[
            {"data":"id"},
            {"data":"user_name"},
            {"data":"email"},
            {"data":null,
                render:function(data,type,row)
                {
                    return data.gender == '0' ? 'Female' : 'Male';
                }
            },
            {"data":null,
                render:function(data,type,row){
                    // console.log(data.qualification);
                    let quali = '';
                    switch(data.qualification){
                        case '0':
                            quali = 'B.Sc';
                            break;
                        case '1':
                            quali = 'H.Sc';
                            break;
                        case '2':
                            quali = 'S.Sc';
                            break;

                    }
                    return quali;
                }
            },
            {"data":"birthday"},
            {"data":null,
                render:function(data){
                    return data.status =='0' ? 'Inactive' : 'Active';
                }
            },
            {"data":"description"},
            {"data":null,
                render: function(data,type) {

                    // console.log(data);
                    return '<img src="' + data.images + '" height="100px" width="100px"/>';

                }
            },
            {
                "data":"actions",
            },
        ]
    });
</script>
