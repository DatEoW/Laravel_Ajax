@extends('layout')


@section('container')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <form method="post" action="{{ route('user.store') }}">
        @csrf
        <div class="form_search">
            <div>
                <p>Tên</p>
                <input type="text" placeholder="Nhập ten" name="name_search">
            </div>
            <div>
                <p>Email</p>
                <input type="text" placeholder="Nhập email" name="email_search">
            </div>
            <div>
                <p>Nhóm</p>
                <select name="group" id="" style="padding:3px">
                    <option value="">Chọn trạng thái</option>
                    <option value="1">Hoạt Động</option>
                    <option value="0">Tạm Khóa</option>
                </select>
            </div>
            <div>
                <p>Trạng Thái</p>
                <select name="is_active" id="" style="padding:3px">
                    <option value="">Chọn trạng thái</option>
                    <option value="1">Hoạt Động</option>
                    <option value="0">Tạm Khóa</option>
                </select>
            </div>

        </div>
        <div class="right-button">
            <div>
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text">
            </div>
            <div>
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text">
            </div>

        </div>
    </form>

    <div style="display:flex;align-items:center;padding: 20px 40px 20px 40px;justify-content: space-between ">
        <div class="add_user">
            <i class="fa-solid fa-user-plus"></i>

            <button type="button" class="btn-add-user btn btn-primary border-0 shadow-none" data-bs-toggle="modal"
                data-bs-target="#exampleModal" style="border-radius: 1px">
                Thêm thành viên
            </button>

            <!-- Modal -->
            <form action="">
                <div class="modal fade" id="user-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Tên</label>
                                        <input type="text" class="form-control" name="name_add"
                                            id="exampleFormControlInput1" placeholder="Nhập tên">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email_add"
                                            id="exampleFormControlInput1" placeholder="Nhập email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Mật khẩu</label>
                                        <input type="password" class="form-control" name="password_add"
                                            id="exampleFormControlInput1" placeholder="Nhập mật khẩu">
                                    </div>

                                    <div>
                                        <label for="select" class="form-label">Nhóm</label>
                                        <select class="form-select form-select-sm" aria-label="Small select example"
                                            id="select">
                                            <option selected>Open this select menu</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>

    </div>






    <div style="margin:20px">
        <div style="display: flex;
    justify-content: center;">
            {{ $user->onEachSide(1)->links() }}
        </div>
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $key => $items)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $items->name }}</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011-04-25</td>
                        <td>$320,800</td>
                    </tr>
                @endforeach



            </tbody>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
            </tfoot>
        </table>
        <div style="display: flex;
    justify-content: flex-end;">
            {{ $user->onEachSide(1)->links() }}
        </div>

    </div>
    <script type="text/javascript">
        $(document).ready(function() {
           aler('hihi');

        })
    </script>
@endsection
