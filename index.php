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
$pc1 = $_POST['pc1'] ?? '';
$pc2 = $_POST['pc2'] ?? '';
$pc3 = $_POST['pc3'] ?? '';
$pc4 = $_POST['pc4'] ?? '';
$pc5 = $_POST['pc5'] ?? '';
$pc6 = $_POST['pc6'] ?? '';
$pc  = "{$pc1}{$pc2}{$pc3}{$pc4}{$pc5}{$pc6}";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($pc)) {
    if ($pc === $PASSCODE) {
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
function parse_markdown($text): string
{
    // 1. Protect raw HTML blocks or tags we want to preserve before escaping the rest
    // We can use placeholders or selectively escape. A safer approach for a lightweight
    // parser is to run htmlspecialchars with flags that allow specific tags, or process
    // inline elements carefully.
    // For simplicity and safety against XSS while allowing your specific styling/ruby tags:
    // We convert special chars *except* for our allowed HTML tags.
    // Escape general HTML to prevent unwanted injection, then safely restore specific tags:
    $text = htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8');
    // Restore allowed HTML tags and their attributes (ruby, rt, rp)
    $allowed_tags = ['ruby', '/ruby', 'rt', '/rt', 'rp', '/rp'];
    foreach ($allowed_tags as $tag) {
        $text = str_replace(htmlspecialchars("<$tag>", ENT_NOQUOTES, 'UTF-8'), "<$tag>", $text);
    }
    // 2. Markdown Headers
    $text = preg_replace('/^# (.*?)$/m', '<h1 class="text-3xl font-bold my-4">$1</h1>', $text);
    $text = preg_replace('/^## (.*?)$/m', '<h2 class="text-2xl font-semibold my-3">$1</h2>', $text);
    $text = preg_replace('/^### (.*?)$/m', '<h3 class="text-xl font-medium my-2">$1</h3>', $text);
    $text = preg_replace('/^#### (.*?)$/m', '<h4 class="text-lg font-medium my-2">$1</h4>', $text);
    // 3. Bold & Italics
    $text = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $text);
    $text = preg_replace('/\*(.*?)\*/s', '<em>$1</em>', $text);
    // 4. Line-by-line processing for paragraphs
    $lines = explode("\n", $text);
    $html = '';
    $inside_div = false;
    foreach ($lines as $line) {
        $trimmed = trim($line);
        // Track if we are inside a custom HTML block like <div class="...">
        if (str_starts_with($trimmed, '<div')) {
            $inside_div = true;
        }
        if (empty($trimmed)) {
            $html .= '<br>';
        } else if ($inside_div || str_starts_with($trimmed, '<h') || str_starts_with($trimmed, '</div')) {
            // Output raw if it's a header, container tag, or inside a custom div block
            $html .= $line . "\n";
        } else {
            // Wrap standard lines in paragraphs
            $html .= '<p class="my-2 leading-relaxed">' . $line . '</p>';
        }
        if (str_starts_with($trimmed, '</div>')) {
            $inside_div = false;
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
    <title>Reader</title>
    <!-- Favicons -->
    <link href="https://lee.ratinan.com/assets/img/favicon.png" rel="icon">
    <link href="https://lee.ratinan.com/assets/img/apple-touch-icon.png" rel="apple-touch-icon">
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
        /* FORM */
        .otp-inputs input {width: 40px;height: 40px;text-align: center;font-size: 1.2rem;border: 1px solid #ccc;border-radius: 4px;color:#000;}
        .otp-inputs input:focus {border-color: #007bff;outline: none;}
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css" integrity="sha512-ApSLB1Pd3/bZN8fWB/RG9YhN/7bd9Hkf3AGaE2mPfebjrxagjuBtx2GcgdqIlJkUzwylBo61r9Xa9NmgBI0swA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="marked.min.js"></script>
</head>
<body class="h-full bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-200 flex flex-col">

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
            <form method="post" id="otp-form" class="otp-container">
                <div class="otp-inputs flex justify-center gap-[10px]">
                    <label><input type="text" name="pc1" maxlength="1" pattern="[0-9]*" inputmode="numeric" autocomplete="one-time-code" required /></label>
                    <label><input type="text" name="pc2" maxlength="1" pattern="[0-9]*" inputmode="numeric" required /></label>
                    <label><input type="text" name="pc3" maxlength="1" pattern="[0-9]*" inputmode="numeric" required /></label>
                    <label><input type="text" name="pc4" maxlength="1" pattern="[0-9]*" inputmode="numeric" required /></label>
                    <label><input type="text" name="pc5" maxlength="1" pattern="[0-9]*" inputmode="numeric" required /></label>
                    <label><input type="text" name="pc6" maxlength="1" pattern="[0-9]*" inputmode="numeric" required /></label>
                </div>
                <button type="submit" id="submit-btn" style="display: none;">Verify</button>
            </form>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const form = document.getElementById("otp-form");
                    const inputs = [...form.querySelectorAll(".otp-inputs input")];

                    const handleOtpSubmit = () => {
                        const otpValue = inputs.map(input => input.value).join("");
                        if (otpValue.length === 6) {
                            // Trigger form submission or custom validation function here
                            form.submit();
                        }
                    };

                    inputs.forEach((input, index) => {
                        // Focus the first input on load
                        if (index === 0) input.focus();

                        // Handle typing and moving forward
                        input.addEventListener("input", (e) => {
                            const value = e.target.value;

                            // Ensure only numbers are entered
                            if (!/^[0-9]$/.test(value)) {
                                e.target.value = "";
                                return;
                            }

                            if (value && index < inputs.length - 1) {
                                inputs[index + 1].focus();
                            }

                            handleOtpSubmit();
                        });

                        // Handle Backspace and moving backward
                        input.addEventListener("keydown", (e) => {
                            if (e.key === "Backspace") {
                                if (input.value === "" && index > 0) {
                                    inputs[index - 1].focus();
                                    inputs[index - 1].value = "";
                                } else {
                                    input.value = "";
                                }
                                e.preventDefault();
                            }
                        });

                        // Handle pasting a full 6-digit code
                        input.addEventListener("paste", (e) => {
                            e.preventDefault();
                            const pasteData = e.clipboardData.getData("text").trim();

                            if (/^\d{6}$/.test(pasteData)) {
                                inputs.forEach((inp, idx) => {
                                    inp.value = pasteData[idx];
                                });
                                inputs[inputs.length - 1].focus();
                                handleOtpSubmit();
                            }
                        });
                    });
                });
            </script>
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
                    <a href="index.php" class="text-sm font-medium px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition"><i class="fa-solid fa-chevron-left"></i></a>
                    <button onclick="toggleSidebar()" class="text-sm font-medium px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-100 transition"><i class="fa-solid fa-bars"></i></button>
                <?php else: ?>
                    <a href="#" class="text-sm font-medium px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition"><i class="fa-solid fa-home"></i></a>
                <?php endif; ?>
                <b>READER</b>
            </div>
            <div class="flex items-center space-x-3">
                <!-- Theme Switcher -->
                <label>
                    <select onchange="setTheme(this.value)" class="text-sm px-1.5 py-1.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent focus:outline-none">
                        <option value="light">Light</option>
                        <option value="dark">Dark</option>
                        <option value="system">System</option>
                    </select>
                </label>
                <script>
                    document.querySelector('select[onchange*="setTheme"]').value = localStorage.getItem('theme') || 'system';
                </script>
                <a href="index.php?action=logout" class="text-sm text-red-600 dark:text-red-400 hover:underline">Logout</a>
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
            <?php
            // Find the current chapter index and prev/next links
            $prev_chapter = null;
            $next_chapter = null;
            // If we are looking at cover.md, "Next" should point to the first chapter
            if ($chapter_file === 'cover.md') {
                if (!empty($chapters)) {
                    $next_chapter = $chapters[0]['file'];
                }
            } else {
                // Find index among chapters
                for ($i = 0; $i < count($chapters); $i++) {
                    if ($chapters[$i]['file'] === $chapter_file) {
                        // Previous link
                        if ($i === 0) {
                            $prev_chapter = 'cover.md'; // Go back to cover if at chapter 1
                        } else {
                            $prev_chapter = $chapters[$i - 1]['file'];
                        }

                        // Next link
                        if ($i < count($chapters) - 1) {
                            $next_chapter = $chapters[$i + 1]['file'];
                        }
                        break;
                    }
                }
            }
            $class_name = 'type-reader';
            if (str_contains($chapter_file, 'chapter')) {
                $class_name = 'type-chapter';
            }
            ?>
            <div class="flex gap-8">
                <!-- Chapter Drawer / Sidebar -->
                <aside id="chapter-sidebar" class="fixed inset-y-0 left-0 z-40 w-72 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 p-6 py-8 -translate-x-full transition-transform duration-200 ease-in-out shadow-2xl">
                    <div class="flex justify-between items-center mt-10 mb-3">
                        <h3 class="font-bold">Table of Contents</h3>
                    </div>

                    <ul class="space-y-2 overflow-y-auto max-h-[calc(100vh-140px)]">
                        <a href="index.php?book=<?= $book_id ?>&chapter=cover.md" class="block px-3 py-2 rounded-lg text-sm font-medium transition <?= $chapter_file === 'cover.md' ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-800' ?>">Cover</a>
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
                                    <span class="block px-3 py-2 rounded-lg text-sm font-medium text-red-500 dark:text-red-400 cursor-not-allowed opacity-75" title="Chapter file missing">
                                        <?= htmlspecialchars($ch['name']) ?> (Missing)
                                    </span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </aside>
                <!-- Markdown Content Container -->
                <div class="flex-grow bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-6 md:p-10 rounded-xl shadow-sm">
                    <h1><?= $current_book['title'] ?></h1>
                    <p>
                    <?php if ($prev_chapter !== null): ?>
                        <a href="index.php?book=<?= $book_id ?>&chapter=<?= urlencode($prev_chapter) ?>" class="px-4 py-2 text-sm font-medium rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"><i class="fa-solid fa-chevron-left"></i></a>
                    <?php else: ?>
                        <span class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 dark:bg-gray-800/50 text-gray-400 dark:text-gray-600 border border-gray-200 dark:border-gray-800 cursor-not-allowed"><i class="fa-solid fa-chevron-left"></i></span>
                    <?php endif; ?>
                    <?php if ($next_chapter !== null): ?>
                        <a href="index.php?book=<?= $book_id ?>&chapter=<?= urlencode($next_chapter) ?>" class="px-4 py-2 text-sm font-medium rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"><i class="fa-solid fa-chevron-right"></i></a>
                    <?php else: ?>
                        <span class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 dark:bg-gray-800/50 text-gray-400 dark:text-gray-600 border border-gray-200 dark:border-gray-800 cursor-not-allowed"><i class="fa-solid fa-chevron-right"></i></span>
                    <?php endif; ?>
                        &nbsp; <span id="word-count"></span>
                    </p>
                    <hr class="my-8" />
                    <article class="<?= $class_name ?>" id="content-container"></article>
                    <hr class="my-8" />
                    <p>
                        <?php if ($prev_chapter !== null): ?>
                            <a href="index.php?book=<?= $book_id ?>&chapter=<?= urlencode($prev_chapter) ?>" class="px-4 py-2 text-sm font-medium rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"><i class="fa-solid fa-chevron-left"></i></a>
                        <?php else: ?>
                            <span class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 dark:bg-gray-800/50 text-gray-400 dark:text-gray-600 border border-gray-200 dark:border-gray-800 cursor-not-allowed"><i class="fa-solid fa-chevron-left"></i></span>
                        <?php endif; ?>
                        <?php if ($next_chapter !== null): ?>
                            <a href="index.php?book=<?= $book_id ?>&chapter=<?= urlencode($next_chapter) ?>" class="px-4 py-2 text-sm font-medium rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"><i class="fa-solid fa-chevron-right"></i></a>
                        <?php else: ?>
                            <span class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 dark:bg-gray-800/50 text-gray-400 dark:text-gray-600 border border-gray-200 dark:border-gray-800 cursor-not-allowed"><i class="fa-solid fa-chevron-right"></i></span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <script>
                <?php
                $target_file = "chapters/" . $book_id . "/" . basename($chapter_file);
                if (file_exists($target_file)) {
                    $markdown_content = file_get_contents($target_file);
                } else {
                    $markdown_content = '# Error 404; Chapter Not Found';
                }
                ?>
                const rawMarkdown = <?= json_encode($markdown_content) ?>;
                let parsedMarkdown = marked.parse(rawMarkdown);
                document.getElementById('content-container').innerHTML = parsedMarkdown;
                <?php if (str_contains($chapter_file, 'chapter')) : ?>
                const seg = new Intl.Segmenter('th', {granularity: 'word'});
                const parser = new DOMParser();
                const doc = parser.parseFromString(parsedMarkdown, 'text/html');
                const plainText = doc.body.textContent || '';
                const count = Array.from(seg.segment(plainText)).filter(s => s.isWordLike).length;
                document.getElementById('word-count').innerText = 'Word count: ' + count.toLocaleString();
                <?php endif; ?>
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