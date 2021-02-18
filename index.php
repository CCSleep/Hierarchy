<?php
ini_set("display_errors",1);
?>
<html>
    <head>
        <?php session_start(); ob_start(); ?>
        <title>%title%</title>
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
            
            
        </style>
    </head>
    <body>
        <?php 
            include "page/api/Requests.php";
            Requests::register_autoloader();
            $page = $_GET["page"];
            $isLogin = !empty($_SESSION["card_barcode"]);
            switch ($page) {
                case "login":
                    include "page/login.php";
                    break;
                case "portal":
                    include "page/portal.php";
                    break;
                default:
                    if ($isLogin) {
                      header("location: /portal");
                    } else {
                      header("location: /login");
                    }
                    break;
            }
            switch ($LoginRequired) {
                case -1:
                    if ($isLogin) {
                      header("location: /portal");
                    }
                    break;
                case 1:
                    if (!$isLogin) {
                      header("location: /login");
                    }
                    break;
            }
        ?>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <script>
        function swalToast(text,icon,time=1500) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: time,
                timerProgressBar: true
            })

            Toast.fire({
              icon: icon,
              title: text
            });
        }
            var login = () => {
                var username = document.querySelector("#username").value;
                var password = document.querySelector("#password").value;
                axios.post("/api/login", data={"username":username,"password":password}).then((response) => {
                    if (response.data.success) {
                        swalToast("You will be redirected in 3 seconds!", "success",3000);
                        setTimeout(() => {location.reload();},3000);
                    } else {
                        switch(response.data.code) {
                            case -1:
                                swalToast("Username or password is missing!", "error",3000);
                                break;
                            case -2:
                                swalToast("Username/password combination is incorrect!", "error",3000);
                                break;
                            case -3:
                                swalToast("You are already logged in!", "info",3000);
                                break;
                        }
                    }
                });
            }
            
            document.querySelector("#login").addEventListener("click", () => {
               login(); 
            });
            document.querySelector("#username").addEventListener("keydown", function (e) {
              if (e.keyCode === 13) { 
                login(); 
              }
            });
            document.querySelector("#password").addEventListener("keydown", function (e) {
              if (e.keyCode === 13) { 
                login(); 
              }
            });
        </script>
</html>
<?php
$pageContents = ob_get_contents();
ob_end_clean(); 
echo str_replace('%title%', $Title, $pageContents);
?>