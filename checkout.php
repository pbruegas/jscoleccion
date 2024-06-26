<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JS Coleccion</title>
    <link rel="stylesheet" href="./style-prefix.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-transform: capitalize;
            transition: all .2s linear;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 25px;
            min-height: 100vh;
            background: #fffbff;
        }

        .container form {
            padding: 20px;
            width: 700px;
            background: #fff;
            box-shadow: 0 5px 10px rgba(0, 0, 0, .1);
        }

        .container form .row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .container form .row .col {
            flex: 1 1 250px;
        }

        .container form .row .col .title {
            font-size: 20px;
            color: #333;
            padding-bottom: 5px;
            text-transform: uppercase;
        }

        .container form .row .col .inputBox {
            margin: 15px 0;
        }

        .container form .row .col .inputBox span {
            margin-bottom: 10px;
            display: block;
        }

        .container form .row .col .inputBox input {
            width: 100%;
            border: 1px solid #ccc;
            padding: 10px 15px;
            font-size: 15px;
            text-transform: none;
        }

        .container form .row .col .inputBox input:focus {
            border: 1px solid #000;
        }

        .container form .row .col .flex {
            display: flex;
            gap: 15px;
        }

        .container form .row .col .flex .inputBox {
            margin-top: 5px;
        }

        .container form .submit-btn {
            width: 100%;
            padding: 12px;
            font-size: 17px;
            background: #d39eab;
            color: #fff;
            margin-top: 5px;
            cursor: pointer;
        }

        .container form .submit-btn:hover {
            background: #eac9c1;
        }
    </style>
</head>

<body>
    <div class="container">

    <form action="index.php" method="POST" class="checkout">

            <div class="row">

                <div class="col">

                    <h3 class="title">billing address</h3>

                    <div class="inputBox">
                        <span>Full name :</span>
                        <input type="text" required>
                    </div>
                    <div class="inputBox">
                        <span>Email :</span>
                        <input type="email" required>
                    </div>
                    <div class="inputBox">
                        <span>Address :</span>
                        <input type="text" required>
                    </div>
                    <div class="flex">
                        <div class="inputBox">
                            <span>Zip Code :</span>
                            <input type="text" required>
                        </div>
                    </div>

                </div>
            </div>

            <input type="submit" value="proceed to checkout" class="submit-btn">

        </form>

    </div>
</body>

</html>
