@extends('layout')


@section('container')
    <hr class="bg-danger border-2 border-top border-danger" />


    <div class="d-flex bd-highlight container">
        <div class="p-2 flex-grow-1 bd-highlight"> <strong>Chi tiết sản phẩm</strong></div>
        <div class="p-2 bd-highlight"><a href="{{ route('product.index') }}"
                class="text-decoration-none link-info link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Sản
                phẩm</a></div>
        <div class="p-2 bd-highlight">></div>
        <div class="p-2 bd-highlight">Chi tiêt sản phẩm</div>
    </div>


    <hr class="bg-danger border-2 border-top border-danger container" />
    <form class="col-md-10 col-sm-10 container d-flex justify-content-center mt-5 flex-wrap" id="ajaxForm"
        enctype='multipart/form-data'>

        <div class="row col-md-12 col-sm-12 d-flex justify-content-center">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="hidden" name="is_delete" value="1">
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="exampleFormControlInput1" class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control w-75"  name="name"
                            id="nameEr"  placeholder="Nhập tên sản phẩm" value="{{ $product->name }}">

                    </div>
                    <span id="nameError" class="text-danger error-messages d-block mb-3" style="text-align: right"></span>
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="exampleFormControlInput1" class="form-label">Giá bán</label>
                        <input type="text" class="form-control w-75"  name="price"
                        id="priceEr"  placeholder="Nhập giá bán">

                    </div>
                    <span id="priceError" class="text-danger error-messages d-block mb-3" style="text-align: right"></span>
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="exampleFormControlTextarea1" class="form-label">Mô tả</label>
                        <textarea class="form-control w-75" id="editor" rows="3" name="describe"></textarea>
                    </div>

                    <div class="mb-3 d-flex justify-content-between">
                        <span>Trạng thái</span>
                        <select class="form-select w-75" aria-label="Default select example" id="is_salesEr" name="is_sales" >
                            <option value="" disabled selected hidden>Chọn trạng thái</option>
                            <option value="1">Đang bán</option>
                            <option value="2">Hết hàng</option>
                            <option value="3">Ngừng bán</option>
                        </select>

                    </div>
                    <span id="is_salesError" class="text-danger error-messages d-block mb-3" style="text-align: right"></span>

                </div>

            </div>
            <div class="col-md-6">


                <div class="form-group ">
                    <div class="d-flex mb-5" style="padding-left: 20px" id="img-box">
                        <label for="imgInp" class="btn btn-primary w-50">Upload ảnh</label>
                        <button type="reset" id="resetImg" class="btn btn-danger w-50">Xóa ảnh</button>
                        <input type="text" disabled value="Tên file hình ảnh" class="form-control" id="imgText">
                        <input type='file' style="visibility: hidden;width: 5px" id="imgInp" name="img" >
                    </div>
                </div>
                <span id="imgError" class="text-danger error-messages"></span>
                <div style="width:350px;height:350px">
                    <img id="showImg" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-image-512.png"
                        alt="" style="max-width: 300px;max-height:300px" />
                </div>

            </div>
        </div>
        <div style="width:200px" class="mb-5">
            <button type="submit" id="addBtn" class="btn btn-primary">Thêm mới</button>
            <button type="reset" class="btn btn-warning" id="resetBtn">Reset</button>
        </div>


    </form>
    <script>
         ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //preview ảnh
            $('#imgInp').on('change', function(event) {
                const file = event.target.files[0];
                let nameImg=file.name;
                $('#imgText').val(nameImg);

                if (file) {
                    $('#showImg').attr('src', URL.createObjectURL(file))
                }
            })
            // xóa preview ảnh
            $('#resetImg').on('click', function(event) {
                $('#showImg').attr('src',
                    'https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-image-512.png');
                    $('#imgText').val(null);

            })
            // xử lý ký tự đặc biệt
            function removeAccents(str) {
                return str.normalize('NFD')
                            .replace(/[\u0300-\u036f]/g, '')
                            .replace(/đ/g, 'd').replace(/Đ/g, 'D');
            }


            //add
            $('#ajaxForm').on('submit', event => {

                event.preventDefault();
                     $('.error-messages').html('');
                let formData = new FormData(event.target);



                $.ajax({
                    url: '{{ route('product.store') }}',
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
                        window.location.href = '{{ route('product.index') }}';

                    },
                    error: function(error) {
                        if (error) {


                            $('#imgError').html(error.responseJSON.errors.img);
                            if(error.responseJSON.errors.name){
                                $('#nameError').html(error.responseJSON.errors.name);
                                $('#nameEr').attr('style','border:1px solid red');
                            }
                            if(error.responseJSON.errors.price){
                                $('#priceError').html(error.responseJSON.errors.price);
                                $('#priceEr').attr('style','border:1px solid red');
                            }
                            if(error.responseJSON.errors.is_sales){
                                $('#is_salesError').html(error.responseJSON.errors.is_sales);
                                $('#is_salesEr').attr('style','border:1px solid red');
                            }
                            if(error.responseJSON.errors.img){
                                $('#imgError').html(error.responseJSON.errors.img);
                                $('#imgEr').attr('style','border:1px solid red');
                            }

                        }

                    }

                })
            })
            //xử lý reset
            $('#resetBtn').on("click", function() {
                $('#editor').html(null);
                $('#showImg').attr('src',
                    'https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-image-512.png');
                    $('#imgText').val(null);
                    $('#nameEr').html(null);
            });
        });

    </script>
@endsection
