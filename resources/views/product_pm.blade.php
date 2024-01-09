@extends('layout')

@section('container')
    {{-- modal delete --}}
    <div class="modal fade ajax-modal" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        role="dialog">
        <form action="" id="ajaxForm-delete">

            <input type="hidden" id="idDeleteProduct">

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
    {{-- search --}}
    <div class="row justify-content-center" style="width:100%">
        <div class="col-md-8">
            <form id="ajaxForm-search" style="margin-top:30px;">
                <div style="" class="form_search">
                    <div class="form-group">
                        <p>Tên</p>
                        <input type="text" placeholder="Nhập tên sản phẩm" name="name" id="getName"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <p>Trạng thái</p>
                        <select name="is_sales" class="form-select" id="getIs_sales">
                            <option value="3" disabled selected hidden>Chọn trạng thái</option>
                            <option value="1">Đang bán</option>
                            <option value="2">Hết Hàng</option>
                            <option value="0">Ngừng Bán</option>
                            <option value="3">Tất cả</option>

                        </select>
                    </div>
                    <div class="d-flex flex-nowrap justify-content-end" style="align-items: center">
                        <div style="width:30%">
                            <span>Giá bán từ</span>
                            <input type="text" class="form-control" style="width:90%" name="priceMin" id="getpriceMin">
                        </div>

                        <div style="margin-top: 20px;margin-right:20px">~</div>
                        <div style="width:30%">
                            <span>Giá bán từ</span>
                            <input type="number" class="form-control" style="width:90%" name="priceMax" id="getpriceMax">
                        </div>
                    </div>

                </div>
                <span id="priceError" class="text-danger error-messages d-block mb-3" style="text-align: right"></span>
                <div style="display: flex;gap:80px;flex-wrap: wrap;" class="form_search">
                    <div>
                        <a href="{{ route('product.create') }}" style="margin-bottom:40px !important;margin-top:40px;"
                            class="btn btn-info mb-3">
                            <i class="fa-solid fa-square-plus" style="color:white"></i>
                            Thêm mới</a>

                    </div>

                    <div>
                        <button type="submit" id="searchBtn" class="btn btn-info mb-3"
                            style="margin-bottom:40px !important;margin-top:40px;"><i class="fas fa-search"
                                style="color: white"></i> Tìm kiếm</button>
                        <button id="resetBtn" type="reset" class="btn btn-info mb-3"
                            style="margin-bottom:40px !important;margin-top:40px;margin-right: 10px;"><i
                                class="fa-solid fa-circle-xmark" style="color: white"></i> Xóa tìm kiếm</button>
                    </div>
                </div>


            </form>
            <div id="fromTo">

            </div>
            <table class="table" id="product-table">
                <form action="">
                    <input type="hidden" value="{{ Auth::user()->id }}" id="idUser">
                    <input type="hidden" value="{{ Auth::user()->group_role }}" id="roleUser">
                </form>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="text-truncate" style="max-width:140px">Tên sản phẩm</th>
                        <th scope="col" class="text-truncate" style="max-width:140px">Mô tả</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Tình trạng</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody id="tbody-table">

                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="text-truncate" style="max-width:140px">Tên sản phẩm</th>
                        <th scope="col" class="text-truncate" style="max-width:140px">Mô tả</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Tình trạng</th>
                        <th scope="col">Hành động</th>
                    </tr>
                    </thead>
                </tfoot>

            </table>
            <div class="row" id="menu-foot">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="d-flex align-items-center gap-2">
                        <label for="perPage">Hiển thị</label>
                        <select class="form-select form-select-sm w-auto" id="perPage">
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>

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

    <script>
        let perPage = 10;
        let page = 1;
        let name = '';
        let is_sales = 3;
        let priceMin = '';
        let priceMax = '';
        let search = false;
        let idUser = $('#idUser').val();
        let roleUser = $('#roleUser').val();


        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // khởi tạm function render data
            const renderTable = function(
                page = 1,
                perPage = 10,
                name = '',
                priceMin = '',
                priceMax = '',
                is_sales = ''
            ) {

                $.ajax({
                    url: `{{ route('product.index') }}/?page=${page}&perPage=${perPage}&name=${name}&priceMin=${priceMin}&priceMax=${priceMax}&is_sales=${is_sales}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (Number(roleUser) === 2) {
                            roleUser = false;
                        }

                        if (response[0].path?.split('8000/').at(1) == 'product') {
                            $('#product').attr('class', 'btn btn-warning')
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
                         <p style="text-align:right;">Hiển thị từ ${from} ~ ${perPage} trong tổng số <strong>${total}</strong> product</p>
                    `);
                        }
                        if (total === 1) {
                            $('#fromTo').html(null);
                            $('#fromTo').append(`
                         <p style="text-align:right;">Hiển thị  ${from}  trong tổng số <strong>${total}</strong> product</p>
                    `);
                        }
                        if (total >= 10) {
                            $('#fromTo').html(null);
                            $('#fromTo').append(`
                         <p style="text-align:right;">Hiển thị từ ${from} ~ ${to} trong tổng số <strong>${total}</strong> product</p>
                    `);
                        }
                        if (total === 0) {
                            $('#fromTo').html(null);
                            $('#fromTo').append(`
                         <p style="text-align:right;">Không có sản phẩm hiển thị</strong> product</p>
                    `);
                        }


                        // tạo bảng table
                        $('#tbody-table').html(null); // để làm sạch bảng mỗi khi render lại table
                        for (let i = 0; i < items.length; i++) {

                            let id = response[0].data[i]?.id;

                            let route_edit =
                                `{{ route('product.edit', ['product' => ':productId']) }}`.replace(
                                    ':productId', id);
                            $('#tbody-table').append(`
                            <tr>
                            <th scope="row">${response[0].data[i]?.id}</th>
                            <td class="text-truncate content1" style="max-width:150px"><span class="tooltiptext"><img  class="img" src="/${response[0].data[i]?.img}">${response[0].data[i]?.name}</span> </td>
                            <td class="text-truncate" style="max-width:150px">${response[0].data[i]?.describe}</td>
                            <td>$${response[0].data[i]?.price}</td>
                            <td>${response[0].data[i]?.sales_text}</td>
                            <td><a href="${route_edit}" data-id="${response[0].data[i]?.id}" data-role="${response[0].data[i]?.group_role}" class="btn btn-primary editButton}"
                        ><i class="fas fa-edit"></i></a>
                        <a  id="delete${response[0].data[i]?.id}"  href="javascript:void(0)" data-id="${response[0].data[i]?.id}" data-role="${response[0].data[i]?.group_role}" class="btn btn-danger toDelete" ${roleUser?'data-bs-toggle="modal"':''}  data-bs-target="#deleteModal"
                        data-id="${response[0].data[i]?.id}"><i class="fa-solid fa-trash-can"></i></a>

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
            renderTable(page, perPage, name, priceMin, priceMax, is_sales);
            // xử lý chuyển trang
            $('#perPage').on('change', function(event) {

                perPage = event.target.value;
                renderTable(page, perPage, name, priceMin, priceMax, is_sales);
            });
            // click page
            $('#paginate').on('click', function(event) {
                const toPage = Number(event.target.dataset.page);
                if (toPage?.toString() === 'NaN') {
                    // console.log(toPage)
                    return;
                }
                page = toPage;

                renderTable(page, perPage, name, priceMin, priceMax, is_sales);

            });
            // xử lý xóa product
            $('body').on('click', '.toDelete', function() {
                // lấy id từng product

                let id = $(this).data('id');
                let role = $(this).data('role');
                console.log(roleUser)
                if (roleUser === false) {
                    $('.ajax-modal').modal('hide');
                    Swal.fire({
                        title: 'Bạn không đủ quyền',
                        icon: "error",
                        timer: 2000,
                    });
                    return;
                }

                $('#deleteBtn').show();
                $('#deleteIcon').html(
                    '<i class="fa-regular fa-circle-question" style="color:yellow;font-size:50px"></i>'
                );
                $('#deleteNo').html('Quay lại').attr('class', 'btn btn-secondary');
                $('#modal-title-d').html(`Bạn có chắc muốn xóa sản phẩm <strong>${id}</strong> `)
                $('#idDeleteProduct').val(id)




            });
            $('#deleteBtn').click(function(event) {
                let id = $('#idDeleteProduct').val();
                $.ajax({
                    url: `{{ route('product.destroy', ['product' => ':productId']) }}`.replace(
                        ':productId', id),
                    method: 'delete',
                    success: function(response) {
                        $('.ajax-modal').modal('hide');
                        renderTable(page, perPage, name, priceMin, priceMax, is_sales);
                        if (response) {
                            Swal.fire({
                                title: "Xóa thành công",
                                text: `Bạn đã xóa thành công Product ${id}`,
                                icon: "success",
                                timer: 2000,
                            });
                        }


                    },
                    error: function(error) {
                        if (error) {
                            $('.ajax-modal').modal('hide');
                            Swal.fire({
                                title: "Xóa không thành công",
                                text: `Bạn đã xóa không thành công Product  ${id}`,
                                icon: "error",
                                timer: 2000,
                            });

                        }
                    }
                })
            });

            //hover tên ra image
            $('body').on('mousemove', function(event) {
                let y = event.pageY - this.offsetTop;
                let x = event.pageX - this.offsetRight;
                $('.img').css({
                    'right': x + 'px',
                    'top': y + 'px',
                });

            });


            // search theo từng cú gõ
            $('#getName').on("keypress", function() {

                priceMin = $('#getpriceMin').val();
                priceMax = $('#getpriceMax').val();
                is_sales = $('#getIs_sales').val() ?? 3;

                name = $(this).val();
                renderTable(page, perPage, name, priceMin, priceMax, is_sales);
            });
            $('#getpriceMin').on('keypress', function() {
                console.log(123)
                priceMin = $(this).val();
                priceMax = $('#getpriceMax').val();

                if (Number(priceMin) > Number(priceMax)) {
                    $('#priceError').html('Giá min không thể lớn hơn giá max');
                } else {
                    $('#priceError').html(null);
                }
                var keycode = event.which || event.keyCode;

                if (!(keycode >= 48 && keycode <= 57)) {
                    $('#priceError').html('Giá chỉ được nhập số');

                }

            })
            $('#getpriceMax').on('keyup', function() {
                priceMax = $(this).val();
                priceMin = $('#getpriceMin').val();
                if (Number(priceMin) > Number(priceMax)) {
                    $('#priceError').html('Giá min không thể lớn hơn giá max');
                } else {
                    $('#priceError').html(null)
                }
            })


            //search

            $('#ajaxForm-search').on('submit', (function(event) {
                event.preventDefault();
                $('.error-messages').html('');
                let formData2 = new FormData(event.target);
                name = formData2.get('name') ?? '';
                priceMin = formData2.get('priceMin');
                priceMax = formData2.get('priceMax');
                is_sales = formData2.get('is_sales') ?? 3;

                if (Number(priceMin) < 0 || Number(priceMax < 0)) {
                    $('#priceError').html('Giá tiền không được là số âm');
                    return;
                }
                if (Number(priceMin) > Number(priceMax)) {
                    $('#priceError').html('Giá min không được lớn hơn giá max');
                    return;
                }
                renderTable(page, perPage, name, priceMin, priceMax, is_sales);

            }));
            // xử lý cập nhật dữ liệu sau khi xóa input tìm kiếm
            $('#resetBtn').on("click", function() {
                renderTable(page, perPage, name, priceMin, priceMax, is_sales);
            });




        });
    </script>
@endsection


@section('footer')
    <main class="">
        <h6 class="text-center" style="font-weight: bold">@ Trần Phát Đạt</h6>
    </main>
@endsection
