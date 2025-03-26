<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="manage.css">

    <!-- Material Design Web Components Import -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script type="importmap">
    {
      "imports": {
        "@material/web/": "https://esm.run/@material/web/"
      }
    }
  </script>
    <script type="module">
        import '@material/web/all.js';
        import { styles as typescaleStyles } from '@material/web/typography/md-typescale-styles.js';

        document.adoptedStyleSheets.push(typescaleStyles.styleSheet);
    </script>

    <!-- Poppin Font Import -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

</head>

<body>
    <header class="header">
        <div class="search-container">
            <md-outlined-text-field class="search-field" id="search-field" placeholder="Search"><md-icon
                    slot="leading-icon">search</md-icon></md-outlined-text-field>
        </div>

        <mdc-dialog id="search-view">
            <div class="search-results">
                <!-- Dynamic search results will be displayed here -->
            </div>
        </mdc-dialog>
    </header>
    <section class="sidebar" id="sidebar">
        <div class="logo-container">
            <img src="/public/upangnavlogo.svg" alt="UPANG LOGO" class="logo">
        </div>
        <div class="barItems">
            <ul>
                <li class="dashboard" id="nav"><a href="./dashboard.php"><span
                            class="material-symbols-outlined icon">bar_chart_4_bars</span>&ensp;Dashboard</a></li>
                <li class="concerns" id="nav"><a href="./concerns.php"><span
                            class="material-symbols-outlined icon">work_history</span>&ensp;Pending Concerns</a></li>
                <li class="accomplished" id="nav"><a href="./thisweek.php"><span
                            class="material-symbols-outlined icon">all_match</span>&ensp;This Week</a></li>
                <li class="history" id="nav"><a href="./history.php"><span
                            class="material-symbols-outlined icon">save_clock</span>&ensp;History</a></li>
                <li class="manage" id="nav"><a href="./manage.php"><span
                            class="material-symbols-outlined icon">bookmark_manager</span>&ensp;Manage Concerns</a></li>
                <hr>
                <li class="signOut" id="nav">
                    <a href="/WebProject%20v2/login.php" id="toLogin">
                        <span class="material-symbols-outlined icon">move_item</span>&ensp;Sign Out
                    </a>
                </li>
            </ul>
        </div>
    </section>
    <main class="main">
        <div class="contents">
            <!-- contents -->
        </div>
    </main>

    <script type="module">
        import "./main.js"
        import "./manage.js"
    </script>
</body>

</html>