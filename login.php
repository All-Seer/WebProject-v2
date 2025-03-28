<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login</title>
    <link rel="stylesheet" href="login.css">

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
    <div class="parentContainer">
        <div class="leftContainer">
            <img src="./public/upanglogoo-1.png" alt="UPANG LOGO" class="logo">
            <div class="text1">Phinma UPang Email Concern</div>
            <div class="text2">CRUD System</div>
            <hr class="leftHR">
            <div class="address">#0587 MacArthur Highway, Brgy. Nancayasan, Urdaneta City, Pangasinan, Philippines</div>
            <div class="footer">
                <div class="copyright">Copyright © 2025 Three Inch Geng | All rights reserved</div>
            </div>
        </div>
        <div class="rightContainer">
            <div class="text3">Admin Login</div>
            <md-outlined-text-field label="Username" placeholder="Admin123" type="name">
            </md-outlined-text-field>
            <md-outlined-text-field label="Password" type="password">
            </md-outlined-text-field>

            <md-filled-button id="tonavMain">
                Login
            </md-filled-button>

            <div class="hrOr">
                <hr class="rightHR1">
                <span>or</span>
                <hr class="rightHR2">
            </div>

            <md-outlined-button id="toConcern">Submit a concern</md-outlined-button>
        </div>
    </div>

    <!-- Import JavaScript -->
    <script type="module">
        import "./main.js"
        import "./login.js"
    </script>
</body>

</html>