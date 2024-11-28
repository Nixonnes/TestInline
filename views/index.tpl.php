<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inline</title>
    <base href="<?= PATH . '/' ?>">
    <link href="/views/styles/main.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="logo">
                <h1>Inline</h1>
            </div>
        </header>
        <main>
            <h1>Поиск постов</h1>
            <form action="../search.php" method="GET">
                <input class="search_input" name="query" type="text" placeholder="Что вы хотите найти?">
            </form>
        </main>
    </div>
</body>
</html>