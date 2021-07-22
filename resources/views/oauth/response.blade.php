{{-- Illuminate/Foundation/Exceptions/views --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Login FB Errror</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

  <!-- Styles -->
  <style>
  html, body {
    background-color: #fff;
    color: #636b6f;
    font-family: 'Raleway', sans-serif;
    font-weight: 100;
    height: 100vh;
    margin: 0;
  }

  .full-height {
    height: 100vh;
  }

  .flex-center {
    align-items: center;
    display: flex;
    justify-content: center;
  }

  .position-ref {
    position: relative;
  }

  .content {
    text-align: center;
  }

  .title {
    font-size: 36px;
    padding: 20px;
  }

  .btn-back-home {
    padding: 15px;
    background-color: cornflowerblue;
    border-radius: 10px;
    color: #000;
    cursor: pointer;
    text-decoration: none;
  }
</style>
</head>
<body>
  <div class="flex-center position-ref full-height">
    <div class="content">
      <div class="title">
        @lang('homepage.email-exist')
      </div>
      <a href="{{ route('home') }}" class="btn-back-home">@lang('homepage.back-to-home')</a>
    </div>
  </div>
</body>
</html>
