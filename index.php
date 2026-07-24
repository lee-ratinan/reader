<?php
session_start();

// Configuration
$PASSCODE = "151189"; // Change your 6-digit passcode here
$BOOKS_JSON = 'books.json';

// Handle Logout / Login Actions
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['authenticated']);
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['passcode'])) {
    if ($_POST['passcode'] === $PASSCODE) {
        $_SESSION['authenticated'] = true;
        header('Location: index.php');
        exit;
    } else {
        $login_error = "Invalid 6-digit passcode.";
    }
}

// Check Authentication
$is_authenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;

// Simple Markdown to HTML parser function
function parse_markdown($text)
{
    $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    // Headers
    $text = preg_replace('/^# (.*?)$/m', '<h1 class="text-3xl font-bold my-4">$1</h1>', $text);
    $text = preg_replace('/^## (.*?)$/m', '<h2 class="text-2xl font-semibold my-3">$1</h2>', $text);
    $text = preg_replace('/^### (.*?)$/m', '<h3 class="text-xl font-medium my-2">$1</h3>', $text);
    // Bold & Italics
    $text = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $text);
    $text = preg_replace('/\*(.*?)\*/s', '<em>$1</em>', $text);
    // Paragraphs
    $lines = explode("\n", $text);
    $html = '';
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) {
            $html .= '<br>';
        } else if (!str_starts_with($line, '<h')) {
            $html .= '<p class="my-2 leading-relaxed">' . $line . '</p>';
        } else {
            $html .= $line;
        }
    }
    return $html;
}

// Load Books Data
$books = [];
if (file_exists($BOOKS_JSON)) {
    $books = json_decode(file_get_contents($BOOKS_JSON), true);
}
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Writing Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Tailwind dark mode configuration
        tailwind.config = {darkMode: 'class'};

        // Theme Management Script
        function setTheme(theme) {
            const root = document.documentElement;
            if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                root.classList.add('dark');
            } else {
                root.classList.remove('dark');
            }
            localStorage.setItem('theme', theme);
        }

        // Initialize theme on load
        (function () {
            const savedTheme = localStorage.getItem('theme') || 'system';
            setTheme(savedTheme);
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200..900&family=Noto+Serif+TC:wght@200..900&family=Noto+Serif+Thai:wght@100..900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Serif Thai', 'Noto Serif JP', 'Noto Serif TC', serif;
        }
    </style>
</head>
<body
    class="h-full bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-200 flex flex-col">

<?php if (!$is_authenticated): ?>
    <!-- LOGIN VIEW -->
    <div class="flex flex-col items-center justify-center flex-grow px-4">
        <div
            class="max-w-md w-full bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-center mb-6">Writing Portal Access</h2>
            <?php if (isset($login_error)): ?>
                <div class="mb-4 p-3 text-sm text-red-600 bg-red-100 dark:bg-red-900/30 dark:text-red-400 rounded-lg">
                    <?= $login_error ?>
                </div>
            <?php endif; ?>
            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Enter 6-Digit Passcode</label>
                    <input type="password" name="passcode" maxlength="6" pattern="[0-9]{6}" required
                           class="w-full px-4 py-3 text-center tracking-widest text-lg rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="------">
                </div>
                <button type="submit"
                        class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    Access Portal
                </button>
            </form>
        </div>
    </div>

<?php else: ?>
    <!-- LOGGED IN VIEWS -->
    <?php
    $book_id = $_GET['book'] ?? null;
    $chapter_file = $_GET['chapter'] ?? 'cover.md';

    $current_book = null;
    $chapters = [];

    if ($book_id) {
        foreach ($books as $b) {
            if ($b['id'] === $book_id) {
                $current_book = $b;
                break;
            }
        }
        if ($current_book && file_exists($current_book['chapters_file'])) {
            $chapters = json_decode(file_get_contents($current_book['chapters_file']), true);
        }
    }
    ?>

    <!-- Top Navigation Bar -->
    <header
        class="border-b border-gray-200 dark:border-gray-800 bg-white/80 dark:bg-gray-900/80 backdrop-blur sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <?php if ($book_id): ?>
                    <a href="index.php"
                       class="text-sm font-medium px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        ← Books List
                    </a>
                    <button onclick="toggleSidebar()"
                            class="text-sm font-medium px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-100 transition">
                        📖 Chapters
                    </button>
                <?php else: ?>
                    <h1 class="font-bold text-lg">My Writing Portal</h1>
                <?php endif; ?>
            </div>

            <div class="flex items-center space-x-3">
                <!-- Theme Switcher -->
                <select onchange="setTheme(this.value)"
                        class="text-sm px-2.5 py-1.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent focus:outline-none">
                    <option value="light">Light</option>
                    <option value="dark">Dark</option>
                    <option value="system">System</option>
                </select>
                <script>
                    document.querySelector('select[onchange*="setTheme"]').value = localStorage.getItem('theme') || 'system';
                </script>

                <a href="index.php?action=logout"
                   class="text-sm text-red-600 dark:text-red-400 hover:underline">Logout</a>
            </div>
        </div>
    </header>

    <main class="flex-grow max-w-5xl w-full mx-auto px-4 py-8 relative">
        <!-- Backdrop Overlay -->
        <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-30 hidden transition-opacity"></div>
        <?php if (!$book_id): ?>
            <!-- BOOK LIST VIEW -->
            <h2 class="text-2xl font-bold mb-6">Select a Book</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <?php foreach ($books as $book): ?>
                    <a href="index.php?book=<?= $book['id'] ?>"
                       class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-200 dark:bg-gray-700">
                            <img src="<?= htmlspecialchars($book['cover_image']) ?>"
                                 alt="<?= htmlspecialchars($book['title']) ?>"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                        <div class="p-4">
                            <span
                                class="text-xs font-semibold text-blue-600 dark:text-blue-400"><?= htmlspecialchars($book['genre']) ?></span>
                            <h3 class="text-lg font-bold mt-1 group-hover:text-blue-500 transition"><?= htmlspecialchars($book['title']) ?></h3>
                            <span
                                class="text-xs font-semibold">by <?= htmlspecialchars($book['author']) ?> / <?= htmlspecialchars($book['language']) ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <!-- READER VIEW -->
            <div class="flex gap-8">
                <!-- Chapter Drawer / Sidebar -->
                <aside id="chapter-sidebar" class="fixed inset-y-0 left-0 z-40 w-72 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 p-6 -translate-x-full transition-transform duration-200 ease-in-out shadow-2xl">
                    <br/><br/><br/>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold">Table of Contents</h3>
                        <button onclick="toggleSidebar()" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-xl font-bold">
                            &times;
                        </button>
                    </div>

                    <ul class="space-y-2 overflow-y-auto max-h-[calc(100vh-120px)]">
                        <?php foreach ($chapters as $ch):
                            $filepath = "chapters/" . $book_id . "/" . $ch['file'];
                            $exists = file_exists($filepath);
                            ?>
                            <li>
                                <?php if ($exists): ?>
                                    <a href="index.php?book=<?= $book_id ?>&chapter=<?= urlencode($ch['file']) ?>"
                                       class="block px-3 py-2 rounded-lg text-sm font-medium transition <?= $chapter_file === $ch['file'] ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-800' ?>">
                                        <?= htmlspecialchars($ch['name']) ?>
                                    </a>
                                <?php else: ?>
                                    <span
                                        class="block px-3 py-2 rounded-lg text-sm font-medium text-red-500 dark:text-red-400 cursor-not-allowed opacity-75"
                                        title="Chapter file missing">
                        <?= htmlspecialchars($ch['name']) ?> (Missing)
                    </span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </aside>

                <!-- Markdown Content Container -->
                <div class="flex-grow bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-6 md:p-10 rounded-xl shadow-sm">
                    <?php
                    $target_file = "chapters/" . $book_id . "/" . basename($chapter_file);
                    if (file_exists($target_file)) {
                        $markdown_content = file_get_contents($target_file);
                        echo parse_markdown($markdown_content);
                    } else {
                        echo '<h2 class="text-xl font-bold text-red-500">File Not Found</h2><p class="mt-2">The requested chapter file could not be loaded.</p>';
                    }
                    ?>
                </div>
            </div>

            <script>
                function toggleSidebar() {
                    const sidebar = document.getElementById('chapter-sidebar');
                    const backdrop = document.getElementById('sidebar-backdrop');

                    sidebar.classList.toggle('-translate-x-full');
                    sidebar.classList.toggle('translate-x-0');

                    if (backdrop) {
                        backdrop.classList.toggle('hidden');
                    }
                }
            </script>
        <?php endif; ?>
    </main>
<?php endif; ?>

</body>
</html>