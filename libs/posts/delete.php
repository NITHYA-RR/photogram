<?php

require_once __DIR__ . '/../app/Post.class.php';
require_once __DIR__ . '/../includes/Session.class.php';
require_once __DIR__ . '/../includes/Api.class.php';

$delete = function () {
    $sql = "DELETE FROM `$this->table` WHERE id = ?";
    $stmt = $this->conn->prepare($sql);

    if (!$stmt) {
        error_log("❌ Prepare failed: " . $this->conn->error);
        return false;
    }

    $stmt->bind_param("i", $this->id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        error_log("✅ Post deleted from DB: ID " . $this->id);
        return true;
    } else {
        error_log("⚠️ Nothing deleted.");
        return false;
    }
};

// require_once __DIR__ . '/../includes/Session.class.php';
// require_once __DIR__ . '/../includes/Api.class.php';

// ${basename(__FILE__, '.php')} = function () {
// if ($this->isAuthenticated() and $this->paramsExists('id')) {
// $p = new Post($this->request['id']);
// $this->response($this->json([
// 'message' => $p->delete()
// ]), 200);
// } else {
// $this->response($this->json([
// 'message' => "BAd Request"
// ]), 400);
// }
// };

// ${basename(__FILE__, '.php')} = function () {
// // Get ID from POST directly
// $id = isset($_POST['id']) ? (int)$_POST['id'] : null;

// if ($id) {
// $p = new Post($id);
// $deleted = $p->delete();

// // Send response
// $this->response($this->json([
// 'message' => $deleted
// ]), 200);
// } else {
// $this->response($this->json([
// 'message' => false
// ]), 400);
// }
// };