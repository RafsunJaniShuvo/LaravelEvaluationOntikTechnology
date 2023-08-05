@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('View Sub Category') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row d-flex justify-content-center">
                            <div class="col-md-12 col-lg-12 mx-auto table-responsive">

                                <table class="table"  id="myTable" >
                                    <thead>
                                    <tr class="text-center">
                                        <th scope="col" width="15%" >Sl No.</th>
                                        <th scope="col" width="40%">Sub Category Title</th>
                                        <th scope="col" width="40%">Products Title</th>
                                        <th scope="col" width="40%">Products Thumbnail</th>
                                        <th scope="col" width="5%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody

                                    @foreach ($subCategories as $key=>$subcategory)
                                        <tr class="text-center">
                                            <td>{{$key +1}}</td>
                                            <td>{{ $subcategory->title }}</td>
                                            <td>
                                                <ol style="list-style: none">
                                                    @foreach ($subcategory->products as $product)
                                                        <li>
                                                            {{ $product->title }}
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                            <td>
                                                <ol style="list-style: none">
                                                    @foreach ($subcategory->products as $product)
                                                        <li>
                                                            <img width="100%" src="{{ $product->thumbnail }}" alt="">
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                            <td>
                                                <a class="btn btn-danger" href="{{route('sub_category_delete',['id'=>$subcategory->id])}}">
                                                    Delete
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                        </tbody>
                                </table>
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
        console.log(formData);
        $.ajax({
            type:"POST",
            // dataType:"json",
            url:"{{route('store_category')}}",
            data: formData,

            // data:formdata,
            contentType: false,
            processData: false,

            success:function(response){
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
        console.log(formData);
        $.ajax({
            type:"POST",
            url:"{{route('store_sub_category')}}",
            data: formData,

            // data:formdata,
            contentType: false,
            processData: false,

            success:function(response){
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
        console.log(formData);
        $.ajax({
            type:"POST",
            url:"{{route('store_products')}}",
            data: formData,

            // data:formdata,
            contentType: false,
            processData: false,

            success:function(response){
                if(response.status=='success'){
                    alert("Prducts Saved Successfully");
                    $('#products').modal('hide');
                    location.reload();
                    // $('#myTable').DataTable().ajax.reload();

                }
            },
            error:function(response){
                console.log(response)
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
    $(document).ready(function() {
        {{--let ajaxtable = $('#myTable').DataTable({--}}
        {{--    "processing":true,--}}
        {{--    "serverSide":true,--}}
        {{--    "ajax":"{{route('subCategory')}}",--}}
        {{--    "columns":[--}}
        {{--        {"data":"id"},--}}
        {{--        {"data":"title"},--}}
        {{--        {"data":"description"},--}}
        {{--    ]--}}
        {{--});--}}

        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    });


</script>
