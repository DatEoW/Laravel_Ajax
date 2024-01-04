
@extends('.layout')

@section('container')
<style>

     h1 {
            font-size: 3em;
            color: #e74c3c;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2em;
            margin-top: 0;
        }

</style>
<div class="container text-center" style="height: 100vh;">
    <h1>403 - Truy cập bị từ chối</h1>
    <p>Rất xin lỗi nhưng bạn không có quyền truy cập trang này</p>
    <span id="countdown">Bạn sẽ được chuyển</span>
</div>


    <!-- Đoạn mã JavaScript để thực hiện đếm ngược và chuyển hướng -->
    <script>
        var countdownElement = document.getElementById('countdown');
        var seconds = 3;

        function updateCountdown() {
            countdownElement.innerHTML = 'Bạn sẽ được chuyển lại trang sau: '+ '<strong>'+seconds+'</strong>' + 's';
            seconds--;

            if (seconds < 0) {
                window.location.href = document.referrer; // Chuyển hướng về trang cũ
            } else {
                setTimeout(updateCountdown, 1000); // Cập nhật sau mỗi giây
            }
        }

        updateCountdown(); // Bắt đầu đếm ngược
    </script>
@endsection

@section('footer')
    <main class="fixed-bottom">
        <h6 class="text-center" style="font-weight: bold">@ Trần Phát Đạt</h6>
    </main>
@endsection
