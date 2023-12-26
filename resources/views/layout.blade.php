<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> --}}


</head>

<body>



    {{-- modal add --}}
    <div class="modal fade ajax-modal" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                            <input type="password" name="password" id="password" class="form-control">
                            <span id="passwordError" class="text-danger error-messages"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="addBtn">Thêm thành viên</button>
                    </div>
                </div>
            </div>
        </form>

    </div>


    {{-- modal update --}}

    <div class="modal fade ajax-modal" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <form action="" id="ajaxForm-update">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modal-title-1">Form cập nhật thành viên</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="">Tên</label>
                            <input type="text" name="name" id="name-1" class="form-control">
                            <span id="nameError-1" class="text-danger error-messages"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Email</label>
                            <input type="text" name="email" id="email-1" class="form-control">
                            <span id="emailError-1" class="text-danger error-messages"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Mật khẩu</label>
                            <input type="password" name="password" id="password-1" class="form-control">
                            <span id="passwordError-1" class="text-danger error-messages"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Nhóm</label>
                            <select name="group_role" id="getGroup_role">
                                <option value="" disabled selected hidden>Chọn nhóm</option>
                                <option value="0">Admin</option>
                                <option value="1">Editor</option>
                                <option value="2">Reviwer</option>
                            </select>
                            <span id="passwordError-1" class="text-danger error-messages"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateBtn">Cập Nhật thành viên</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
    {{-- modal delete --}}
    <div class="modal fade ajax-modal" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <form action="" id="ajaxForm-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modal-title-1">Bạn có chắc muốn xóa </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Không</button>
                        <button type="button" class="btn btn-primary" id="updateBtn">Xóa</button>
                    </div>
                </div>
            </div>
        </form>

    </div>

    {{-- modal Lock --}}
    <div class="row">
        <div class="col-md-8 offset-2">
            <form id="ajaxForm-search">
                <div style="" class="form_search">
                    <div class="form-group">
                        <p>Tên</p>
                        <input type="text" placeholder="Nhập họ tên" name="name" id="getName">
                    </div>
                    <div class="form-group">
                        <p>Email</p>
                        <input type="text" placeholder="Nhập Email" name="email" id="getEmail">
                    </div>
                    <div class="form-group">
                        <p>Nhóm</p>
                        <select name="group_role" id="getGroup_role">
                            <option value="" disabled selected hidden>Chọn nhóm</option>
                            <option value="0">Admin</option>
                            <option value="1">Editor</option>
                            <option value="2">Reviwer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <p>Trạng thái</p>
                        <select name="is_active" id="getIs_status">
                            <option value="" disabled selected hidden>Chọn trạng thái</option>
                            <option value="1">Hoạt động</option>
                            <option value="0">Tạm khóa</option>

                        </select>
                    </div>
                </div>
                <div style="display: flex;gap:80px;flex-wrap: wrap;" class="form_search">
                    <div>
                        <a href="" class="btn btn-info mb-3"
                            style="margin-bottom:40px !important;margin-top:40px;" data-bs-toggle="modal"
                            data-bs-target="#addModal"><i class="fa-solid fa-user-plus" style="color: white"></i>
                            Thêm thành viên</a>
                    </div>

                    <div>
                        <button type="submit" id="searchBtn" class="btn btn-info mb-3"
                            style="margin-bottom:40px !important;margin-top:40px;"><i class="fas fa-search"
                                style="color: white"></i> Tìm kiếm</button>
                        <button id="resetBtn" type="reset" class="btn btn-info mb-3"
                            style="margin-bottom:40px !important;margin-top:40px;"><i class="fa-solid fa-circle-xmark"
                                style="color: white"></i> Xóa tìm kiếm</button>
                    </div>
                </div>


            </form>
            <div id="fromTo">

            </div>
            <table class="table" id="user-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="text-truncate" style="max-width:150px">Tên</th>
                        <th scope="col" class="text-truncate" style="max-width:150px">Email</th>
                        <th scope="col">Nhóm</th>
                        <th scope="col">Trạng Thái</th>
                        <th scope="col">Hành Động</th>
                    </tr>
                </thead>
                <tbody id="tbody-table">

                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="text-truncate" style="max-width:150px">Tên</th>
                        <th scope="col" class="text-truncate" style="max-width:150px">Email</th>
                        <th scope="col">Nhóm</th>
                        <th scope="col">Trạng Thái</th>
                        <th scope="col">Hành Động</th>
                    </tr>
                    </thead>
                </tfoot>

            </table>
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="d-flex align-items-center gap-2">
                        <label for="perPage">Hiển thị</label>
                        <select class="form-select form-select-sm w-auto" id="perPage">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            {{-- <option value="50">50</option> --}}
                        </select>
                        <label for="perPage">đơn vị</label>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <nav aria-label="Page user management navigation" aria-label="Page navigation example">
                        <ul class="pagination justify-content-end" id="paginate"></ul>

                    </nav>
                </div>
            </div>


        </div>



    </div>







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>



    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>



    <script>
        let perPage = 10;
        let page = 1;
        let name = '';
        let email = '';
        let group_role = '';
        let is_active = '';


        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const renderTable = function(
                page = 1,
                perPage = 10,
                name = '',
                email = '',
                group_role = '',
                is_active = ''
            ) {

                $.ajax({
                    url: `{{ route('user.index') }}/?page=${page}&perPage=${perPage}&name=${name}&email=${email}&group_role=${group_role}&is_active=${is_active}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {

                        const total = response[0].total ?? 0;
                        const from = response[0].from ?? 0;
                        const to = response[0].to ?? 0;
                        const lastPage = response[0].last_page ?? 0;
                        const links = response[0].links ?? [];
                        const items = response[0].data ?? [];


                        $('#fromTo').html(null);

                        $('#fromTo').append(`
                             <p style="text-align:right;">Hiển thị từ ${from} ~ ${perPage} trong tổng số <strong>${total}</strong> user</p>
                        `);
                        // tạo bảng table
                        $('#tbody-table').html(null); // để làm sạch bảng mỗi khi render lại table
                        for (let i = 0; i < items.length; i++) {
                            $('#tbody-table').append(`
                        <tr>
                        <th scope="row">${i+1}</th>
                        <td class="text-truncate" style="max-width:150px">${response[0].data[i]?.name}</td>
                        <td class="text-truncate" style="max-width:150px">${response[0].data[i]?.email}</td>
                        <td>${response[0].data[i]?.group_text}</td>
                        <td>${response[0].data[i]?.active_text}</td>
                        <td><a href="javascript:void(0)" data-id="${response[0].data[i]?.id}" class="btn btn-primary editButton" data-bs-toggle="modal"
                    data-bs-target="#updateModal" ><i class="fas fa-edit"></i></a>
                    <a href="javascript:void(0)" data-id="${response[0].data[i]?.id}" class="btn btn-danger toDelete" data-bs-toggle="modal"  data-bs-target="#deleteModal"
                    data-id="${response[0].data[i]?.id}"><i class="fas fa-cancel"></i></a>
                    <a href="javascript:void(0)" data-id="${response[0].data[i]?.id}" class="btn btn-info toLock" data-bs-toggle="modal"  data-bs-target="#lockModal"
                    data-id="${response[0].data[i]?.id}"><i class="fa-solid fa-lock"></i></a>
                     </td>
                            `)
                        }
                        $('#paginate').html(null);
                        let pa = $('#paginate');

                        for (let i = 0; i < links.length; i++) {
                            //lấy số trang
                            const page = links[i]?.url?.split('page=').at(1);
                            if (i === 0) {
                                pa.append(`<li class="page-item ${links[i].active ? ' active' : ''}" data-page="${page}">
                                    <a class="page-link" href="#" aria-label="Previous" data-page="${page}">
                                        <span aria-hidden="true" data-page="${page}">&lt;</span>
                                    </a>
                                    </li>`)
                            } else if (i === links.length - 1) {

                                pa.append(`<li class="page-item ${links[i].active ? ' active' : ''}" data-page="${page}">
                                        <a class="page-link" href="#" aria-label="Next" data-page="${page}">
                                            <span aria-hidden="true" data-page="${page}">&gt;</span>
                                        </a>
                                        </li>`)
                            } else {
                                pa.append(`<li class="page-item ${links[i].active ? ' active' : ''}" data-page="${page}">
                                    <a class="page-link" href="#" data-page="${page}">${links[i].label}</a>
                                    </li>`)
                            }
                        }
                        pa.append(`<li class="page-item" data-page="${lastPage}">
                                    <a class="page-link" href="#" aria-label="LastPage" data-page="${lastPage}">
                                        <span aria-hidden="true" data-page="${lastPage}">&raquo;</span>
                                    </a>
                                    </li>`)

                    }
                });
            }



            renderTable(page, perPage, name, email, group_role, is_active);
            // add

            const form = $('#ajaxForm')[0];
            $('#addBtn').click(function(event) {

                $('.error-messages').html('');
                let formData = new FormData(form);
                $.ajax({
                    url: '{{ route('user.store') }}',
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
                        $('.ajax-modal').modal('hide');

                        if (response) {
                            Swal.fire({
                                title: "Thêm thành công",
                                text: "Thêm thành viên mới thành công",
                                icon: "success",
                                timer: 2000,
                            });
                        }

                        table.ajax.reload();
                        $('#ajaxForm')[0].reset();
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
            const form1 = $('#ajaxForm-update')[0];
            //edit
            $('body').on('click', '.editButton', function() {
                let id = $(this).data('id');



                $.ajax({
                    url: '{{ url('user', '') }}' + '/' + id + '/edit',
                    method: 'GET',
                    success: function(response) {

                        $('#name-1').val(response.name);
                        $('#email-1').val(response.email);
                        $('#updateBtn').click(function(event) {
                            let formData1 = new FormData(form1);
                            $.ajax({
                                url: '{{ url('update-user') }}' + '/' + id,
                                method: 'POST',
                                processData: false,
                                contentType: false,
                                data: formData1,
                                success: function(response) {

                                    $('.ajax-modal').modal('hide');

                                    if (response) {
                                        Swal.fire({
                                            title: "Cập nhật thành công",
                                            text: "Cập nhật thành viên thành công",
                                            icon: "success",
                                            timer: 2000,
                                        });

                                    }
                                    // console.log(response.success)
                                    table.ajax.reload();
                                    $('#ajaxForm-update')[0].reset();
                                },
                                error: function(error) {
                                    if (error) {

                                        $('#nameError-1').html(error
                                            .responseJSON.errors.name);
                                        $('#emailError-1').html(error
                                            .responseJSON.errors.email);
                                        $('#passwordError-1').html(error
                                            .responseJSON.errors
                                            .password);
                                    }
                                }
                            })
                        })

                    },

                })
            })

            //search
            const form2 = $('#ajaxForm-search')[0];
            $('#ajaxForm-search').on('submit', (function(event) {
                event.preventDefault();
                $('.error-messages').html('');
                let formData2 = new FormData(form2);
                const name = formData2.get('name');
                const email = formData2.get('email');
                const group_role = formData2.get('group_role') ?? '';


                const is_active = formData2.get('is_active') ?? 1;

                renderTable(page, perPage, name, email, group_role, is_active);

            }));



            // xử lý chuyển trang
            $('#perPage').on('change', function(event) {

                perPage = event.target.value;
                // console.log(perPage)
                renderTable(page, perPage, name, email, group_role, is_active);
            });
            // click page
            $('#paginate').on('click', function(event) {
                const toPage = Number(event.target.dataset.page);
                // console.log(event.target.dataset.page)
                if (toPage?.toString() === 'NaN') {
                    return;
                }
                page = toPage;
                renderTable(page, perPage, name, email, group_role, is_active);

            });

            // xử lý search name khi gõ dữ liệu vào input
            $('#getName').on("keyup", function() {
                let name = $(this).val();
                // console.log(name)
                renderTable(page, perPage, name, email, group_role, is_active);

            });
            // xử lý xóa dữ liệu input khi search
            $('#resetBtn').on("click", function() {

                renderTable(page, perPage, name, email, group_role, is_active);
            });
            // xử lý xóa user
            $('body').on('click', '.toDelete', function(){
                // lấy id từng user
                let id = $(this).data('id');
                $.ajax({
                    url: `{{ route('user.index') }}/?`,
                    method: 'DELETE',
                    success: function(response) {

                    }
                })
            });
















        });
    </script>
    <script></script>
</body>

</html>
