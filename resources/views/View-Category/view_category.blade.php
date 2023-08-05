@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('View Category') }}</div>

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
                                        <th scope="col" width="40%">Title</th>
                                        <th scope="col" width="40%">Sub Category Title</th>
                                        <th scope="col" width="5%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody
                                    @foreach ($categories as $key=>$category)
                                        <tr class="text-center">
                                            <td>{{$key +1}}</td>
                                            <td>{{ $category->title }}</td>
                                            <td>
                                                <ol style="list-style: none">
                                                    @foreach ($category->subcategories as $subcategory)
                                                        <li>{{ $subcategory->title }}</li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                            <td>
                                                <a class="btn btn-danger" href="{{route('category-delete',['id'=>$category->id])}}">
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
    $(document).ready(function() {
        $('#myTable').DataTable();
    });

</script>
