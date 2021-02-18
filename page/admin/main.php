<html>
    <head>
        <title>Admin Panel</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- <link rel="stylesheet" href="/css/main.css">  Will replace with real CSS -->
        
        <style>
            * {
                font-family: "Nunito";
            }
            
            .header {
                font-size: 6rem;
                padding: 0.5rem 0.5rem 0.5rem 0;
                color: #2a2a2a;
            }
            
            .group {
                display: flex;
                flex-direction: column;
            }
            
            .group > .label {
                font-size: 150%;
                margin-bottom: 1em;
                color: #484848;
            }
            
            .group > .text-input {
                margin-bottom: 1rem;
                padding: 0.25rem;
                border: none;
                border-bottom: 2px #c9c9c9 solid;
                font-size: 1.17rem;
                transition: border-color .3s ease-in-out;

            }
            
            .group > .text-input:focus {
                margin-bottom: 1rem;
                padding: 0.25rem;
                outline: none;
                border: none;
                border-bottom: 2px #ffbfc0 solid;
            }
            
            .group > input[type=text] {
                width: 20rem;
                letter-spacing: 0.1rem;
            }
            
            .group > input[type=password] {
                width: 20rem;
                -webkit-text-security: disc !important;
                letter-spacing: 0.3rem;
                
            }
            
            .btn {
                width: 20rem;
                margin: 1% 1% 1% 0;
                text-transform: uppercase;
                font-size: 1.5rem;
                padding: 0.5rem;
                border-radius: 5px;
                transition: border-color .15s ease-in-out, background-color .15s ease-in-out;
                box-shadow: 1px 1px #c9c9c9;
            }
            .btn.btn-primary {
                color: #FFFFFF;
                background-color: #ff8c8e;
                border: 3px rgba(0,0,0,0) solid;
                font-weight: bold;
                
            }
            
            .btn.btn-primary:hover {
                background-color: #ff9e9f;
            }
            
            .btn:focus {
                outline: none;
                background-color: #ff9e9f;
                border: 3px #ffb2b3 solid;
                
            }
            
            .align-center {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            
            @media screen and (max-width:420px) {
                .group > .label {
                    font-size: 7.5vw;
                }
                
                .header {font-size: 30vw;}
                .btn, .group > input[type=text], .group > input[type=password] { width: 90vw;}
            }
            
            .card-containers {
                display: flex;
                flex-direction: row;
                align-items: center;
            }
            .card {
                box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
                transition: 0.3s;
                margin: 2%;
                padding: 2%;
            }
            
            .card:hover {
                box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
                
            }
            .container {
                padding: 2px 16px;
            }
            
            a {
                color: black;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <?php
            session_start();
            $page = $_GET["page"];
            $isLogin = !empty($_SESSION["admin_login"]);
            switch ($page) {
                case "login":
                    include "login.php";
                    break;
                case "portal":
                    include "portal.php";
                    break;
                default:
                    if ($isLogin) {
                      header("location: ?page=portal");
                    } else {
                      header("location: ?page=login");
                    }
                    break;
            }
            switch ($page) {
                case "login":
                    if ($isLogin) {
                      header("location: ?page=portal");
                    }
                    break;
                default:
                    if (!$isLogin) {
                      header("location: ?page=login");
                    }
                    break;
            }
        ?>
    </body>
</html>
