@extends('layout')

@section('container')
    {{-- modal add --}}
    <div class="modal fade ajax-modal" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <div class="form-group mb-3">
                            <p>Nhóm</p>
                            <select name="group_role" class="form-select" id="getGroup_role">
                                <option value="" disabled selected hidden>Chọn nhóm</option>
                                <option value="0">Admin</option>
                                <option value="1">Editor</option>
                                <option value="2">Reviwer</option>

                            </select>
                            <span id="groupError" class="text-danger error-messages"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
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
            <input type="hidden" id="idUpdateUser">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modal-title-u">Form cập nhật thành viên</h1>
                        <p id="userPoli"></p>
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
                            <p>Nhóm</p>
                            <select name="group_role" class="form-select" id="group_role-1">
                                <option value="" disabled selected hidden>Chọn nhóm</option>
                                <option value="0">Admin</option>
                                <option value="1">Editor</option>
                                <option value="2">Reviwer</option>
                            </select>
                            <span id="groupdError-1" class="text-danger error-messages"></span>
                        </div>
                        <div class="form-group">
                            <p>Trạng thái</p>
                            <select name="is_active" class="form-select" id="is-active-1">
                                <option value="" disabled selected hidden>Chọn trạng thái</option>
                                <option value="1">Hoạt động</option>
                                <option value="0">Tạm khóa</option>

                            </select>
                            <span id="status_Error-1" class="text-danger error-messages"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" id="updateBtn">Cập Nhật thành viên</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
    {{-- modal delete --}}
    <div class="modal fade ajax-modal" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" role="dialog">
        <form action="" id="ajaxForm-delete">

            <input type="hidden" id="idDeleteUser">

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="text-align:center">
                        <div id="deleteIcon">

                        </div>

                        <h1 class="modal-title fs-5" id="modal-title-d" style="text-align:center"></h1>
                    </div>
                    <div class="modal-footer" style="justify-content: center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="deleteNo">Không</button>
                        <button type="button" class="btn btn-danger" id="deleteBtn">Xóa</button>
                    </div>
                </div>
            </div>
        </form>

    </div>

    {{-- modal Lock --}}
    <div class="modal fade ajax-modal" id="lockModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" role="dialog">
        <form action="" id="ajaxForm-lock">

            <input type="hidden" id="idLockUser">
            <input type="hidden" id="activeUser">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="text-align:center">
                        <div id="lockIcon">

                        </div>

                        <h1 class="modal-title fs-5" id="modal-title-l" style="text-align:center"></h1>
                    </div>
                    <div class="modal-footer" style="justify-content: center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="lockNo">Không</button>
                        <button type="button" class="btn btn-danger" id="lockBtn"></button>
                    </div>
                </div>
            </div>
        </form>

    </div>
    {{-- search --}}
    <div class="row justify-content-center" style="width:100%">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <form id="ajaxForm-search" style="margin-top:30px;">
                <div style="" class="form_search">
                    <div class="form-group">
                        <p>Tên</p>
                        <input type="text" placeholder="Nhập họ tên" name="name" id="getName"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <p>Email</p>
                        <input type="text" placeholder="Nhập Email" name="email" id="getEmail"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <p>Nhóm</p>
                        <select name="group_role" class="form-select" id="">
                            <option value="" disabled selected hidden>Chọn nhóm user</option>
                            <option value="0">Admin</option>
                            <option value="1">Editor</option>
                            <option value="2">Reviwer</option>
                            <option value="3">Tất cả</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <p>Trạng thái</p>
                        <select name="is_active" class="form-select" id="getIs_status">
                            <option value="" disabled selected hidden>Chọn trạng thái</option>
                            <option value="1">Hoạt động</option>
                            <option value="0">Tạm khóa</option>
                            <option value="2">Tất cả</option>

                        </select>
                    </div>
                </div>
                <div style="display: flex;flex-wrap: wrap;" class="form_search">
                    <div>
                        <a href="javascript:void(0)" style="margin-bottom:40px !important;margin-top:40px;"
                            @if (Auth::user()->group_role === 0) data-bs-toggle="modal" @else @endif
                            data-role={{ Auth::user()->group_role }} data-bs-target="#addModal"
                            class="btn btn-info mb-3 toAdd">
                            <i class="fa-solid fa-user-plus" style="color: white"></i>
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
            <div id="formTo_C">
                <div id="fromTo">

                </div>
            </div>
            <div class="table-responsive">

                <table class="table" id="user-table">
                    <form action="">
                        <input type="hidden" value="{{ Auth::user()->id }}" id="idUser">
                        <input type="hidden" value="{{ Auth::user()->group_role }}" id="roleUser">
                    </form>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="text-truncate" style="max-width:50px">Tên</th>
                            <th scope="col" class="text-truncate" style="max-width:50px">Email</th>
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
                            <th scope="col" class="text-truncate" style="max-width:50px">Tên</th>
                            <th scope="col" class="text-truncate" style="max-width:50px">Email</th>
                            <th scope="col">Nhóm</th>
                            <th scope="col">Trạng Thái</th>
                            <th scope="col">Hành Động</th>
                        </tr>
                        </thead>
                    </tfoot>

                </table>
            </div>
            <div class="row">
                <div class="col-10- col-sm-10 col-md-6 col-lg-6 col-xl-6">
                    <div class="d-flex align-items-center gap-2">
                        <label for="perPage">Hiển thị</label>
                        <select class="form-select form-select-sm w-auto" id="perPage">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>

                        </select>
                        <label for="perPage">đơn vị</label>
                    </div>
                </div>

                <div class="col-xs-10 col-sm-10 col-md-6 col-lg-6 col-xl-6">
                    <nav aria-label="Page user management navigation" aria-label="Page navigation example">
                        <ul class="pagination justify-content-end" id="paginate"></ul>

                    </nav>
                </div>
            </div>
        </div>
    </div>


    <script>
        let perPage = 10;
        let page = 1;
        let name = '';
        let email = '';
        let group_role = '';
        let is_active = '';
        let search = false;
        let idUser = $('#idUser').val();
        let roleUser = $('#roleUser').val();

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
                        // console.log(response)
                        if (Number(roleUser) === 0) {
                            roleUser = false;
                        }

                        if (response[0].path?.split('8000/').at(1) == 'user') {
                            $('#user').attr('class', 'btn btn-warning')
                        }
                        const total = response[0].total ?? 0;
                        const from = response[0].from ?? 0;
                        const to = response[0].to ?? 0;
                        const lastPage = response[0].last_page ?? 0;
                        const links = response[0].links ?? [];
                        const items = response[0].data ?? [];

                        // hiện from- to
                        if (total < 10) {
                            $('#fromTo').html(null);
                            perPage = total;
                            $('#fromTo').append(`
                         <p style="text-align:right;">Hiển thị từ ${from} ~ ${perPage} trong tổng số <strong>${total}</strong> user</p>
                    `);
                        }
                        if (total === 1) {
                            $('#fromTo').html(null);
                            $('#fromTo').append(`
                         <p style="text-align:right;">Hiển thị  ${from}  trong tổng số <strong>${total}</strong> user</p>
                    `);
                        }
                        if (total >= 10) {
                            $('#fromTo').html(null);
                            $('#fromTo').append(`
                         <p style="text-align:right;">Hiển thị từ ${from} ~ ${to} trong tổng số <strong>${total}</strong> user</p>
                    `);
                        }
                        if (total === 0) {
                            $('#fromTo').html(null);
                            $('#fromTo').append(`
                         <p style="text-align:right;">Không có sản phẩm hiển thị</strong> user</p>
                    `);
                        }

                        // tạo bảng table
                        $('#tbody-table').html(null); // để làm sạch bảng mỗi khi render lại table
                        for (let i = 0; i < items.length; i++) {
                            if (response[0].data[i].is_active === 0) {
                                response[0].data[i].is_active = false
                            }

                            $('#tbody-table').append(`
                            <tr>
                            <th scope="row">${i+1}</th>
                            <td class="text-truncate" style="max-width:150px">${response[0].data[i]?.name}</td>
                            <td class="text-truncate" style="max-width:150px">${response[0].data[i]?.email}</td>
                            <td>${response[0].data[i]?.group_text}</td>
                            <td>${response[0].data[i]?.active_text}</td>
                            <td><a href="javascript:void(0)" data-id="${response[0].data[i]?.id}" data-role="${response[0].data[i]?.group_role}" class="btn btn-primary editButton " data-bs-toggle="${roleUser?'':'modal'}"
                        data-bs-target="#updateModal" ><i class="fas fa-edit"></i></a>
                        <a  id="delete${response[0].data[i]?.id}"  href="javascript:void(0)" data-id="${response[0].data[i]?.id}" data-role="${response[0].data[i]?.group_role}" class="btn btn-danger toDelete " ${roleUser?'':'data-bs-toggle="modal"'}  data-bs-target="#deleteModal"
                        data-id="${response[0].data[i]?.id}"><i class="fa-solid fa-trash-can"></i></a>
                        <a id="lock${response[0].data[i]?.id}"  href="javascript:void(0)" data-id="${response[0].data[i]?.id}" data-role="${response[0].data[i]?.group_role}" data-active="${response[0].data[i]?.is_active?1:0}" class="btn btn-info toLock " data-bs-toggle="${roleUser?'':'modal'}"  data-bs-target="#lockModal"
                        data-id="${response[0].data[i]?.id}" ${response[0].data[i]?.is_active?'':'style="padding-left:9px;padding-right:9px"'}>${response[0].data[i]?.is_active? '<i class="fas fa-user" style="color:white"></i>':'<i class="fas fa-user-slash" style="color:red"></i>'}</a>
                        </td>
                        `);
                        }
                        $('#paginate').html(null);
                        let pa = $('#paginate');
                        if (response[0].total === 0) {
                            $('#tbody-table').append(`
                        <p style="text-align:center;width:100%">

                                <h1 style="width:100%">
                            Không có dữ liệu hiện tại

                            </h1>

                            </p>

                        `);
                        }
                        if (response[0].total < 20) {
                            return;
                        }

                        for (let i = 0; i < links.length; i++) {
                            //lấy số trang
                            const page = links[i]?.url?.split('page=').at(1);
                            if (i === 0) {
                                pa.append(`<li class="page-item ${links[i].active ? ' active' : ''}" data-page="${page}">
                                <a class="page-link" href="#!" aria-label="Previous" data-page="${page}">
                                    <span aria-hidden="true" data-page="${page}">&lt;</span>
                                </a>
                                </li>`)
                            } else if (i === links.length - 1) {

                                pa.append(`<li class="page-item ${links[i].active ? ' active' : ''}" data-page="${page}">
                                    <a class="page-link" href="#!" aria-label="Next" data-page="${page}">
                                        <span aria-hidden="true" data-page="${page}">&gt;</span>
                                    </a>
                                    </li>`)
                            } else {
                                pa.append(`<li class="page-item ${links[i].active ? ' active' : ''}" data-page="${page}">
                                <a class="page-link" href="#!" data-page="${page}">${links[i].label}</a>
                                </li>`)
                            }
                        }
                        pa.append(`<li class="page-item" data-page="${lastPage}">
                                <a class="page-link" href="#!" aria-label="LastPage" data-page="${lastPage}">
                                    <span aria-hidden="true" data-page="${lastPage}">&raquo;</span>
                                </a>
                                </li>`)






                    }
                });
            }



            renderTable(page, perPage, name, email, group_role, is_active);
            // add
            $('body').on('click', '.toAdd', function() {
                let role = $(this).data('role');
                if (roleUser != 0) {
                    $('.ajax-modal').modal('hide');
                    Swal.fire({
                        title: 'Bạn không đủ quyền',
                        icon: "error",
                        timer: 2000,
                    });
                    return;
                }
            });

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

                        renderTable(page, perPage, name, email, group_role, is_active);
                        $('#ajaxForm')[0].reset();
                    },
                    error: function(error) {
                        if (error) {
                            $('#nameError').html(error.responseJSON.errors.name);
                            $('#emailError').html(error.responseJSON.errors.email);
                            $('#passwordError').html(error.responseJSON.errors.password);
                            $('#groupError').html(error.responseJSON.errors.group_role);

                        }

                    }

                })
            })

            //edit
            $('body').on('click', '.editButton', function() {
                let id = $(this).data('id');
                $('#idUpdateUser').val(id);


                $.ajax({
                    url: '{{ url('user', '') }}' + '/' + id + '/edit',
                    method: 'GET',
                    success: function(response) {

                        $('#name-1').val(response.name);
                        $('#email-1').val(response.email);
                        $('#is-active-1').val(response.is_active);
                        $('#group_role-1').val(response.group_role);
                        $('#password-1').val(null);

                    },
                    error: function(error) {
                        $('.ajax-modal').modal('hide');
                        if (error.status == 403) {

                            Swal.fire({
                                title: error.responseJSON.error,
                                icon: "error",
                                timer: 2000,
                            });

                        }
                    }

                })
            })
            const form1 = $('#ajaxForm-update')[0];
            $('#updateBtn').click(function(event) {
                $('.error-messages').html('');
                let formData1 = new FormData(form1);
                const name1 = formData1.get('name');
                const email1 = formData1.get('email');
                const password1 = formData1.get('password');
                const group_role1 = formData1.get('group_role') ?? 1;
                const is_active1 = formData1.get('is_active') ?? '';
                // console.log(name)
                const id = $('#idUpdateUser').val();
                $.ajax({
                    url: `{{ route('user.update', ['user' => ':userId']) }}`.replace(':userId', id),
                    method: 'PATCH',
                    data: {
                        name: name1,
                        email: email1,
                        password: password1,
                        group_role: group_role1,
                        is_active: is_active1,
                        id,
                    },
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
                        renderTable(page, perPage, name, email, group_role, is_active);
                        $('#ajaxForm-update')[0].reset();
                    },
                    error: function(error) {
                        // $('.ajax-modal').modal('hide');
                        if (error.status == 403) {

                            Swal.fire({
                                title: error.responseJSON.error,
                                icon: "error",
                                timer: 2000,
                            });

                        }

                        $('#nameError-1').html(error.responseJSON.errors.name);
                        $('#emailError-1').html(error.responseJSON.errors.email);
                        $('#passwordError-1').html(error.responseJSON.errors.password);
                        $('#groupError-1').html(error.responseJSON.errors.group_role);
                        $('#statusError-1').html(error.responseJSON.errors.is_active);

                    }
                })
            })

            //search
            const form2 = $('#ajaxForm-search')[0];
            $('#ajaxForm-search').on('submit', (function(event) {
                event.preventDefault();
                $('.error-messages').html('');
                let formData2 = new FormData(form2);
                 name = formData2.get('name');
                 email = formData2.get('email');
                 group_role = formData2.get('group_role') ?? '';
                 is_active = formData2.get('is_active') ?? 2;

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
                console.log(event.target.dataset.page)
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
            $('body').on('click', '.toDelete', function() {
                // lấy id từng user

                let id = $(this).data('id');
                let role = $(this).data('role');
                if (roleUser != 0) {
                    $('.ajax-modal').modal('hide');
                    Swal.fire({
                        title: 'Bạn không đủ quyền',
                        icon: "error",
                        timer: 2000,
                    });
                    return;
                }


                if (Number(idUser) == Number(id)) {
                    $('#modal-title-d').html(`Bạn không thể xóa User <strong>${id}</strong> `)
                    $('#deleteBtn').hide();
                    $('#deleteNo').html('Quay lại').attr('class', 'btn btn-primary');
                    $('#deleteIcon').html(
                        '<i class="fa-solid fa-triangle-exclamation" style="color:red;font-size:50px"></i>'
                    );

                } else {
                    $('#deleteBtn').show();
                    $('#deleteIcon').html(
                        '<i class="fa-regular fa-circle-question" style="color:yellow;font-size:50px"></i>'
                    );
                    $('#deleteNo').html('Quay lại').attr('class', 'btn btn-secondary');
                    $('#modal-title-d').html(`Bạn có chắc muốn xóa User <strong>${id}</strong> `)
                    $('#idDeleteUser').val(id)
                }



            });
            $('#deleteBtn').click(function(event) {
                const id = $('#idDeleteUser').val()
                const phuongThuc = 'delete';
                $.ajax({
                    url: `{{ route('changeUser') }}/?id=${id}&phuongThuc=${phuongThuc}`,
                    method: 'POST',
                    success: function(response) {
                        $('.ajax-modal').modal('hide');
                        renderTable(page, perPage, name, email, group_role, is_active);
                        if (response) {
                            Swal.fire({
                                title: "Xóa thành công",
                                text: `Bạn đã xóa thành công User ${id}`,
                                icon: "success",
                                timer: 2000,
                            });
                        }


                    },
                    error: function(error) {
                        $('.ajax-modal').modal('hide');
                        if (error.status == 403) {

                            Swal.fire({
                                title: error.responseJSON.error,
                                icon: "error",
                                timer: 2000,
                            });

                        }
                    }
                })
            });
            // xử lý khóa user
            $('body').on('click', '.toLock', function() {
                // lấy id từng user

                let id = $(this).data('id');
                let active = $(this).data('active');
                let role = $(this).data('role');
                if (roleUser != 0) {
                    Swal.fire({
                        title: 'Bạn không đủ quyền',
                        icon: "error",
                        timer: 2000,
                    });
                }

                $('#activeUser').val(active);

                if (Number(idUser) == Number(id)) {
                    $('#modal-title-l').html(`Bạn không thể khóa User <strong>${id}</strong> `)
                    $('#lockBtn').hide();
                    $('#lockNo').html('Quay lại').attr('class', 'btn btn-primary');
                    $('#lockIcon').html(
                        '<i class="fa-solid fa-triangle-exclamation" style="color:red;font-size:50px"></i>'
                    );
                } else {
                    $('#lockBtn').show();
                    $('#lockIcon').html(
                        '<i class="fa-regular fa-circle-question" style="color:yellow;font-size:50px"></i>'
                    );
                    $('#lockNo').html('Quay lại').attr('class', 'btn btn-secondary');
                    if (Number(active) === 0) {
                        $('#modal-title-l').html(`Bạn có muốn mở khóa User <strong>${id}</strong> `);
                        $('#lockBtn').text('Mở Khóa').attr('class', 'btn btn-success');
                    } else {
                        $('#modal-title-l').html(`Bạn có chắc muốn khóa User <strong>${id}</strong> `);
                        $('#lockBtn').text('Khóa')
                    }

                    $('#idLockUser').val(id)
                }



            });
            $('#lockBtn').click(function(event) {
                const id = $('#idLockUser').val();
                const active = $('#activeUser').val();

                let phuongThuc = '';
                if (Number(active) == 0) {
                    phuongThuc = 'unlock';
                } else {
                    phuongThuc = 'lock';
                }

                $.ajax({
                    url: `{{ route('changeUser') }}/?id=${id}&phuongThuc=${phuongThuc}`,
                    method: 'POST',
                    success: function(response) {
                        $('.ajax-modal').modal('hide');
                        renderTable(page, perPage, name, email, group_role, is_active);
                        if (response) {
                            if (response.phuongThuc === 'lock') {

                                Swal.fire({
                                    title: "Khóa thành công",
                                    text: `Bạn đã khóa thành công User ${id}`,
                                    icon: "success",
                                    timer: 2000,
                                });
                            } else {
                                Swal.fire({
                                    title: "Mở khóa thành công",
                                    text: `Bạn đã mở khóa thành công User ${id}`,
                                    icon: "success",
                                    timer: 2000,
                                });
                            }

                        }


                    },
                    error: function(error) {
                        $('.ajax-modal').modal('hide');
                        if (error.status == 403) {
                            Swal.fire({
                                title: error.responseJSON.error,
                                icon: "error",
                                timer: 2000,
                            });

                        }
                    }
                })
            });

        });
    </script>
@endsection

@section('footer')
    <main class="">
        <h6 class="text-center" style="font-weight: bold">@ Trần Phát Đạt</h6>
    </main>
@endsection
