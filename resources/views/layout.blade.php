<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> --}}


</head>

<body>



    {{-- modal --}}
    <div class="modal fade ajax-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <form action="" id="ajaxForm">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modal-title">Form thêm mới thành viên</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="">Tên</label>
                            <input type="text" name="name" id="name" class="form-control">
                            <span id="nameError" class="text-danger error-messages"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Email</label>
                            <input type="text" name="email" id="email" class="form-control">
                            <span id="emailError" class="text-danger error-messages"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Mật khẩu</label>
                            <input type="text" name="password" id="password" class="form-control">
                            <span id="passwordError" class="text-danger error-messages"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveBtn">Thêm thành viên</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <div class="row">
        <div class="col-md-10 offset-1">
            <a href="" class="btn btn-info mb-3" style="margin-top:100px" data-bs-toggle="modal"
                data-bs-target="#exampleModal">Thêm thành viên</a>
            <table class="table" id="user-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Email</th>
                        <th scope="col">Nhóm</th>
                        <th scope="col">Trạng Thái</th>
                        <th scope="col">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Email</th>
                        <th scope="col">Nhóm</th>
                        <th scope="col">Trạng Thái</th>
                        <th scope="col">Hành Động</th>
                    </tr>
                    </thead>
                </tfoot>
        </div>


    </div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>



    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>



    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // $('#modal-title').html('ahihih');


            $('#user-table').DataTable({
                processing: true,
                severSide: true,

                ajax: '{{ route('user.index') }}',
                columns: [
                    {
                        data: 'id'},
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {   data:'name'},
                    {
                        data: 'is_active'
                    },
                    {
                        data: 'action',orderable:false,searchable:false
                    },

                ]

            });

            var form = $('#ajaxForm')[0];
            $('#saveBtn').click(function(event) {

                $('.error-messages').html('');
                var formData = new FormData(form);

                $.ajax({
                    url: '{{ route('user.store') }}',
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
                        $('.ajax-modal').modal('hide');
                        if (response) {
                            swal("Thành công!", response.success, "success");
                        }
                        console.log(response.success)
                    },
                    error: function(error) {
                        if (error) {

                            $('#nameError').html(error.responseJSON.errors.name);
                            $('#emailError').html(error.responseJSON.errors.email);
                            $('#passwordError').html(error.responseJSON.errors.password);
                        }
                    }


                })
            })
        });
    </script>
</body>

</html>
