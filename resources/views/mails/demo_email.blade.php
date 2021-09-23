<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h5>Email của bạn : {{ $data['email']}}</h5>
    <p>Xin chào ,{{ $data['name']}}</p>

    <h3>Xác nhận tài khoản ?</h3>
    <form action="{{ route('register.vertify',['user'=>$data['id']]) }}" method="POST">
        @csrf
        <button type="submit">Xác thực ngay</button>
    </form>

</body>
</html>

