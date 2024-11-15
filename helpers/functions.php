<?php

function getTasks($db, $limit = 5, $offset = 0) {
    $stmt = $db->prepare("SELECT * FROM tasks ORDER BY completed ASC, priority DESC, name ASC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTotalTasks($db) {
    $stmt = $db->query("SELECT COUNT(*) as count FROM tasks");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] ?? 0;
}

function countCompletedTasks($db) {
    $stmt = $db->query("SELECT COUNT(*) as count FROM tasks WHERE completed = 1");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] ?? 0;
}
?>
