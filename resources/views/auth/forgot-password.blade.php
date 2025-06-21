<!doctype html>
<html lang="vi">

<head>
    <title>Quên mật khẩu</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <style>
        body {
            background: linear-gradient(135deg, #0a2e65, #1e90ff);
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 32px rgba(0, 0, 0, 0.15);
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .error-msg {
            color: red;
            font-size: 0.875rem;
            margin-top: 4px;
        }

        .status-msg {
            color: green;
            font-size: 0.9rem;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <main>
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <div class="card p-4">
                    <div class="text-center mb-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/3064/3064197.png" alt="Logo"
                            class="brand-logo">
                        <h3 class="mb-1">Quên mật khẩu?</h3>
                        <p class="text-muted mb-3">Nhập email để nhận liên kết đặt lại mật khẩu</p>
                    </div>

                    @if (session('status'))
                        <div class="status-msg text-success text-center">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Địa chỉ Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Nhập email của bạn" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="error-msg">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Gửi mã xác minh</button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none">Quay lại đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
