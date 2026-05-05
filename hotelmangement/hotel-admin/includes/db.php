<?php
// includes/db.php — MySQL connection (mysqli)
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';        // <-- apnar mysql password ekhane
$DB_NAME = 'hotel_admin';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    $conn->set_charset('utf8mb4');
} catch (Throwable $e) {
    die('DB Connection failed: '.htmlspecialchars($e->getMessage()));
}

// helpers
function q(mysqli $c, string $sql, array $params = [], string $types = ''): mysqli_stmt {
    $stmt = $c->prepare($sql);
    if ($params) {
        if (!$types) $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt;
}
function fetchAll(mysqli $c, string $sql, array $params = [], string $types = ''): array {
    $r = q($c,$sql,$params,$types)->get_result();
    return $r ? $r->fetch_all(MYSQLI_ASSOC) : [];
}
function fetchOne(mysqli $c, string $sql, array $params = [], string $types = '') {
    $rows = fetchAll($c,$sql,$params,$types);
    return $rows[0] ?? null;
}
function scalar(mysqli $c, string $sql, array $params = [], string $types = '') {
    $r = q($c,$sql,$params,$types)->get_result();
    if (!$r) return null;
    $row = $r->fetch_array(MYSQLI_NUM);
    return $row[0] ?? null;
}
function e($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function bdt($n){ return '৳'.number_format((float)$n, 0); }
function jsonOut($data, int $code = 200): void {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
function isAjax(): bool {
    return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])==='xmlhttprequest')
        || (($_SERVER['HTTP_ACCEPT'] ?? '') !== '' && strpos($_SERVER['HTTP_ACCEPT'],'application/json') !== false);
}
