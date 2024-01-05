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
       {{-- {{ csrf_field() }} --}}
        {{-- {{ method_field('patch') }} --}}
        @method('patch')
        <div class="row col-md-12 col-sm-12 d-flex justify-content-center">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="hidden" name="is_delete" value="1">
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="exampleFormControlInput1" class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control w-75"  name="name"
                            id="nameEr"  placeholder="Nhập tên sản phẩm" value="{{ $product->name }}">

                    </div>
                    <span id="nameError" class="text-danger error-messages d-block mb-3" style="text-align: right"></span>
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="exampleFormControlInput1" class="form-label">Giá bán</label>
                        <input type="text" class="form-control w-75"  name="price"
                        id="priceEr"  placeholder="Nhập giá bán" value="{{ $product->price }}">

                    </div>
                    <span id="priceError" class="text-danger error-messages d-block mb-3" style="text-align: right"></span>
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="exampleFormControlTextarea1" class="form-label">Mô tả</label>
                        <textarea class="form-control w-75" id="editor" rows="3" name="describe" value="{{ $product->describe }}"></textarea>
                    </div>

                    <div class="mb-3 d-flex justify-content-between">
                        <span>Trạng thái</span>
                        <select class="form-select w-75" aria-label="Default select example" id="is_salesEr" name="is_sales_old" >
                            <option value="{{ $product->is_sales }}" disabled selected hidden id="dis">
                                @if($product->is_sales==1)
                                    Đang bán
                                @elseif($product->is_sales==2)
                                    Hết Hàng
                                @else
                                    Ngừng bán

                                @endif
                            </option>
                            <option value="1">Đang bán</option>
                            <option value="2">Hết hàng</option>
                            <option value="0">Ngừng bán</option>
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
                        <input type="text" disabled value="" class="form-control" id="imgText" >
                        <input type='file' style="visibility: hidden;width: 5px" id="imgInp" name="img" >
                    </div>
                </div>
                <span id="imgError" class="text-danger error-messages"></span>
                <div style="width:350px;height:350px">
                    <img id="showImg" src="/{{ $product->img }}"
                        alt="" style="max-width: 300px;max-height:300px" />
                </div>

            </div>
        </div>
        <div style="width:200px" class="mb-5">
            <button type="submit" id="updateBtn" class="btn btn-primary">Cập nhật</button>
            <button type="button" class="btn btn-warning" id="cancelBtn">Hủy</button>
        </div>


    </form>
    <script>

        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
            // Thiết lập giá trị ban đầu cho CKEditor
            editor.setData(`{!! str_replace(
              [chr(39), chr(34), chr(96)],
              [chr(92) . chr(39), chr(92) . chr(34), chr(92) . chr(96)],
              $product->describe,
          ) !!}`);
            }
            )
            .catch(error => {
                console.error(error);
            })


        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //preview ảnh
            $('#imgText').val(`{{ substr($product->img,9) }}`);

            $('#imgInp').on('change', function(event) {
                const file = event.target.files[0];
                let nameImg = file.name;
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

                const id = formData.get('id');
                const name = formData.get('name') ?? {{ $product->name }};
                const describe = formData.get('describe') ?? '';
                const price = formData.get('price') ?? {{ $product->price }};
                const img = formData.get('img');
                const is_sales = formData.get('is_sales_old')?? {{ $product->is_sales }};
                formData.append('is_sales',is_sales)
                // console.log(is_sales);
                $.ajax({
                    url: `{{ route('product.update', ['product' => ':productId']) }}`.replace(':productId', id),
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
                        window.location.href = '{{ route('product.index') }}';

                    },
                    error: function(error) {
                        console.log(error)
                        if (error) {
                            if (error.responseJSON.errors.name) {
                                $('#nameError').html(error.responseJSON.errors.name);
                                $('#nameEr').attr('style', 'border:1px solid red');
                            }
                            if (error.responseJSON.errors.price) {
                                $('#priceError').html(error.responseJSON.errors.price);
                                $('#priceEr').attr('style', 'border:1px solid red');
                            }
                            if (error.responseJSON.errors.is_sales) {
                                $('#is_salesError').html(error.responseJSON.errors.is_sales);
                                $('#is_salesEr').attr('style', 'border:1px solid red');
                            }
                            if (error.responseJSON.errors.img) {
                                $('#imgError').html(error.responseJSON.errors.img);
                                $('#imgEr').attr('style', 'border:1px solid red');
                            }

                        }

                    }

                })
            })
            //xử lý reset


            $('#cancelBtn').on('click', function(event) {
                window.location.href = '{{ route('product.index') }}';


            })
            //

            $('#nameEr').on("keyup", function() {
                let name = $(this).val();
                if (name.length === 0) {
                    nameEr = name.length === 0 ? 'Vui lòng nhập tên sản phẩm' : '';
                } else {
                    nameEr = name.length > 5 ? '' : 'Tên sản phẩm phải nhập lớn hơn 5 ký tự';
                }
                $('#nameError').html(nameEr);
            });
            $('#priceEr').on("keyup", function() {
                let price = $(this).val();

                if (price.length === 0) {
                    // $('#priceError').html(null);
                    priceEr = price.length === 0 ? 'Vui lòng nhập giá sản phẩm' : '';
                } else if (isNaN(price)) {
                    // $('#priceError').html(null);
                    priceEr = 'Giá sản phẩm phải là số ký tự';
                } else if (Number(price) < 0) {
                    priceEr = 'Giá sản phẩm phải là số số dương';
                } else {
                    priceEr = '';
                }
                $('#priceError').html(priceEr);

            });

            $('#imgInp').on("change", function(event) {
                $('#imgError').html('');
                let img = $(this).val();
                let pic_size = event.target.files[0].size;
                if (pic_size > 2 * 1024 * 1024) {
                    $('#imgError').html('Hình không được vượt quá 2MB');
                    return;
                }
                var image = new Image();
                $(image).on('load', function () {
                    var imageWidth = this.naturalWidth;
                    var imageHeight = this.naturalHeight;
                    if(imageWidth>1024){
                        $('#imgError').html('Chiều rộng hình không dược vượt quá 1024px');
                        return
                    }
                });

                // tạo object hình để lấy dữ liệu từ hình
                image.src = URL.createObjectURL(event.target.files[0]);
            });

        });
    </script>
@endsection
@section('footer')
    <main class="">
        <h6 class="text-center" style="font-weight: bold">@ Trần Phát Đạt</h6>
    </main>
@endsection
