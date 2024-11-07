<!DOCTYPE html>
<html lang="en">

<head>
    <title>LU-QMS</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="bootstrap-template/assets/img/emerson.ico" type="image/x-icon" />
    <x-header-bootstrap-import />
</head>

<body>
    <div class="wrapper">
        <x-sidebar />
        <x-mainpanel />
    </div>
    <x-queue />
    <x-js-bootstrap-down />
</body>

</html>
