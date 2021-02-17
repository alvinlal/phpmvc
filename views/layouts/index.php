<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ninja Pizza</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style type="text/css">
    .brand {
        background: #cbb09c !important;
    }

    .brand-text {
        color: #cbb09c !important;
    }

    form {
        max-width: 460px;
        margin: 20px auto;
        padding: 20px;
    }

    .pizza {
        width: 100px;
        margin: 40px auto -30px;
        display: block;
        position: relative;
        top: -30px;
    }
    </style>
</head>

<body class="grey lighten-4">
    <nav class="white z-depth-0">
        <div class="container">
            <a href="/" class="brand-logo brand-text">Ninja Pizza</a>
            <ul id="nav-mobile" class="right hide-on-small-and-down">
                <?php if (isset($_SESSION['name'])): ?>
                <li style="color:grey">
                    <?php echo "hello " . $_SESSION['name'] ?>
                </li>
                <?php endif?>
                <li><a href="add" class="btn brand z-depth-0">Add a Pizza</a></li>
                <?php if (!isset($_SESSION['userId'])): ?>
                <li><a href="/auth/signup" class="btn brand z-depth-0">signup</a></li>
                <li><a href="/auth/login" class="btn brand z-depth-0">login</a></li>
                <?php else: ?>
                <li><a href="/auth/logout" class="btn brand z-depth-0">logout</a></li>
                <?php endif?>
            </ul>
        </div>
    </nav>
    {{content}}
    <footer class="section">
        <div class="center grey-text">&copy; Copyright 2019 Ninja Pizzas by shaun pelling</div>
    </footer>
</body>

</html>