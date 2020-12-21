<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Ecommerce | ThankYou</title>
    <link rel="stylesheet" href="https://laravelecommerceexample.ca/css/app.css">
</head>

<body>
    @include('layouts.header')
    <div class="thank-you-section" style="padding-top: 200px">
        <h1>Thank you for <br> Your Order!</h1>
        <p>A confirmation email was sent</p>
        <div class="spacer"></div>
        <div>
            <a href="{{ route('landing-page') }}" class="button">Home Page</a>
        </div>
    </div>
</body>

</html>
