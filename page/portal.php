<?php 
$Title = "Project Hierarchy - Main"; 
$LoginRequired = 1;
?>

<?php 
// This time, we use direct code because request library doesn't keep sessions
include "page/api/db.php";
$barcode = $db->real_escape_string($_SESSION["card_barcode"]);
$ctl = $db->query("SELECT * FROM `users` WHERE barcode='$barcode'");
$info = $ctl->fetch_assoc();

$protocol = isset($_SERVER["HTTPS"]) ? "https://" : "http://";
$subject = substr($info['barcode'], 0 ,2);
$request = Requests::get("$protocol/{$_SERVER['SERVER_NAME']}/api/departments?alias=$subject", array());
$rawData = json_decode($request->body, true);
$departmentInfo = $rawData["success"] ? $rawData["data"] : array("name_th" => "ยังไม่พบ", "name_en" => "N/A");
?>
<h1>On testing ...</h1>
<div class="card">
    <h1>Barcode</h1>
    <div class="barcode">
        <img src="/api/barcode?f=svg&s=code-128&d=<?php echo $info['barcode']; ?>">
    </div>
    <div class="info">
        <h1>Hello, <?php echo $info['first_name']." ".$info['last_name']; ?></h1>
        <h3>Card Number: <?php echo $info['barcode']; ?></h3>
        <p>Department_TH: <?php echo $departmentInfo['name_th']; ?></p>
        <p>Department_EN: <?php echo $departmentInfo['name_en']; ?></p>
    </div>
</div>