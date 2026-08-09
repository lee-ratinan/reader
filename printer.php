<?php
session_start();
$is_authenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;
if (!$is_authenticated) {
    header('Location: index.php#not-authenticated');
    exit;
}
$book_id = $_GET['book'] ?? null;
$BOOKS_JSON = 'books.json';
$books = [];
if (file_exists($BOOKS_JSON)) {
    $books = json_decode(file_get_contents($BOOKS_JSON), true);
} else {
    header('Location: index.php#no-books-json');
    exit;
}
$book_id = $_GET['book'] ?? null;
if (empty($book_id)) {
    header('Location: index.php#no-book-id');
    exit;
}
$current_book = null;
foreach ($books as $b) {
    if ($b['id'] === $book_id) {
        $current_book = $b;
        break;
    }
}
if (empty($current_book)) {
    header('Location: index.php#no-current-book');
    exit;
}
if (!file_exists($current_book['chapters_file'])) {
    header('Location: index.php#no-chapter-file');
    exit;
}
//$chapters = json_decode(file_get_contents($current_book['chapters_file']), true);
$chapter_file = $_GET['chapter'] ?? 'cover.md';
?>
<!DOCTYPE html>
<html lang="<?= $current_book['language_code'] ?? 'en' ?>" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reader</title>
    <!-- Favicons -->
    <link href="https://lee.ratinan.com/assets/img/favicon.png" rel="icon">
    <link href="https://lee.ratinan.com/assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200..900&family=Noto+Serif+TC:wght@200..900&family=Noto+Serif+Thai:wght@100..900&family=Alegreya:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <style>
        body {font-family: 'Noto Serif Thai', 'Noto Serif JP', 'Noto Serif TC', serif;}
        h1 {font-size:1.6em!important;}
        h2 {font-size:1.4em!important;}
        h3 {font-size:1.2em!important;}
        h4 {font-size:1.1em!important;}
        h1, h2, h3, h4 {font-weight:bold!important;margin-bottom:1.5em!important;}
        .type-chapter h1, .type-chapter h2 {display: none;}
        .type-chapter h3, .type-chapter h4 {text-align: center; font-family: 'Alegreya', serif; font-size: 1.5em !important; font-weight: normal !important;}
        .type-chapter h4 {font-style: italic;}
        p {margin-bottom:1em!important;}
        .center {text-align:center!important;}
        blockquote {border-left:4px solid #888;padding-left:1em;margin-left:0;}
    </style>
    <script src="marked.min.js"></script>
</head>
<body>
<?php
$class_name = 'type-reader';
if (str_contains($chapter_file, 'chapter')) {
    $class_name = 'type-chapter';
}
$target_file = "chapters/" . $book_id . "/" . basename($chapter_file);
if (file_exists($target_file)) {
    $markdown_content = file_get_contents($target_file);
    echo '<script type="text/template" id="markdown-source">' . $markdown_content . '</script>';
} else {
    echo '<script type="text/template" id="markdown-source"># Error 404; Chapter Not Found</script>';
}
?>
<article class="<?= $class_name ?> p-4" id="content-container"></article>
<script>
    const rawMarkdown = document.getElementById('markdown-source').innerHTML;
    let parsedMarkdown = marked.parse(rawMarkdown);
    document.getElementById('content-container').innerHTML = parsedMarkdown;
</script>
</body>
</html>
