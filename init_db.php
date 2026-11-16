<?php
// init_db.php
$dbDir = __DIR__ . '/data';
if (!is_dir($dbDir)) {
    mkdir($dbDir, 0777, true);
}

$pdo = new PDO('sqlite:' . $dbDir . '/blog.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("
    CREATE TABLE IF NOT EXISTS posts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        user_id INTEGER DEFAULT 1,
        title TEXT NOT NULL,
        content TEXT NOT NULL,
        published INTEGER DEFAULT 1,
        published_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        tags TEXT DEFAULT NULL
    );
");

// Добавляем тестовые посты, если таблица пустая
$count = $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();
if ($count == 0) {
    $stmt = $pdo->prepare("INSERT INTO posts (title, content, published, published_at) VALUES (?, ?, ?, ?)");
    for ($i = 1; $i <= 15; $i++) {
        $stmt->execute([
            "Тестовий пост #$i: Цікава стаття про веб-розробку",
            "Це детальний зміст публікації номер $i. У цій статті розглядаються ключові особливості побудови додатків на базі сучасного фреймворку Yii 2 та шаблону MVC.",
            ($i % 5 == 0 ? 0 : 1), // часть неопубликованных
            date('Y-m-d H:i:s', strtotime("-$i days"))
        ]);
    }
    echo "Таблиця posts успішно створена та заповнена даними!\n";
} else {
    echo "Таблиця вже містить дані.\n";
}