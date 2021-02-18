<?php
if (isset($_POST["submit"])) {
    if ($_POST["username"] == "HierarchyAdmin" && $_POST["password"] == "000000") {
        $_SESSION["admin_login"] = 1;
        header("location: ?page=portal");
    } else {
        echo "Login Failed!";
    }
}
?>
<div class="align-center">
    <div class="header">Hierarchy Admin</div>
    <form autocomplete="off" class="form" method="POST">
        <div class="group">
            <div class="label">Username</div>
            <input type="text" id="username" name="username" class="text-input">
        </div>
        <div class="group">
            <div class="label">Password</div>
            <input type="password" id="password" name="password" class="text-input">
        </div>
        <div class="group">
            <button type="submit" class="btn btn-primary" name="submit" id="login">Submit</button>
        </div>
    </form>
</div>