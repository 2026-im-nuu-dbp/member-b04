<?php
header('Content-Type: application/json; charset=utf-8'); // 宣告回傳格式為 JSON
require_once("db_config.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "不允許的存取方式"]);
    exit();
}

$account = trim($_POST["account"] ?? "");
$password = $_POST["password"] ?? "";
$nickname = trim($_POST["nickname"] ?? "");
$favorite_color = $_POST["favorite_color"] ?? "";

if ($account === "" || $password === "") {
    echo json_encode(["status" => "error", "message" => "帳號與密碼不能為空！"]);
    exit();
}

// 檢查帳號是否有人申請
$sql = "SELECT COUNT(*) FROM membership WHERE account = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$account]);
$exists = (int) $stmt->fetchColumn();

if ($exists !== 0) {
    // 這裡不再輸出 <script>，而是直接回傳錯誤狀態碼與訊息
    echo json_encode(["status" => "exists", "message" => "您所指定的帳號已經有人使用，請使用其它帳號"]);
    exit();
} else {
    $password_secure = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO membership (account, password, nickname, favorite_color) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$account, $password_secure, $nickname, $favorite_color]);

    // 註冊成功，將需要顯示的資料打包成 JSON 回傳
    echo json_encode([
        "status" => "success",
        "account" => $account,
        "password" => $password // 注意：實務上基於安全，通常不建議在註冊成功後再次回傳明文密碼
    ]);
    exit();
}
