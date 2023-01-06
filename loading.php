<!DOCTYPE html>
<html>

<head>
    <style>
        .loader {
            height: 100px;
            background-image: url("resources/loading.gif");
            background-position: center;
            background-size: contain;
            background-repeat: no-repeat;
        }

        .load {
            display: block;
            position: fixed;
            padding-top: 20%;
            z-index: 8;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(255, 255, 255, 0.420);
        }
    </style>
</head>

<body>

    <!-- loading -->
    <div id="loader" class="load">
        <div class="loader"></div>
    </div>
    <!-- loading -->
</body>

</html>