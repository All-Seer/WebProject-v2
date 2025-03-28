<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Form</title>
    <link rel="stylesheet" href="./index.css">

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

    <md-dialog id="autoCloseDialog">

        <div slot="headline" class="containerImg">
            <img src="./public/check.gif" class="dialogImg" alt="Success">
        </div>
        <div slot="headline" class="dialogHead">
            Success
        </div>
        <div slot="content">
            <div class="dialogContent">
                Your concern has been submitted
            </div>
        </div>
    </md-dialog>
</head>


<body>
    <div class="parentContainer">
        <div class="leftContainer">
            <img src="./public/upanglogoo-1.png" alt="UPANG LOGO" class="logo">
            <div class="text1">Submit your Concern</div>
            <md-outlined-button id="toLogin">Login As Admin</md-outlined-button>
        </div>


        <div class="middleContainer">
            <form id="studentForm" method="POST">
                <md-outlined-text-field label="Personal Email" placeholder="user@gmail.com" type="email"
                    name="personalEmail" required>
                </md-outlined-text-field>

                <md-outlined-text-field label="Phinmaed Email" placeholder="user.up@phinmaed.com" type="email"
                    name="phinmaedEmail" required>
                </md-outlined-text-field>

                <md-outlined-select label="Concern" name="concern">
                    <md-select-option value="" selected>
                        <div slot="headline"></div>
                    </md-select-option>
                    <md-select-option value="Reset Password">
                        <div slot="headline">Reset Password</div>
                    </md-select-option>
                    <md-select-option value="2FA">
                        <div slot="headline">2FA</div>
                    </md-select-option>
                    <md-select-option value="Others">
                        <div slot="headline">Others</div>
                    </md-select-option>
                </md-outlined-select>

                <md-outlined-text-field label="Student ID" placeholder="0000-0000-000000" type="text" name="studentID"
                    required>
                </md-outlined-text-field>

                <md-outlined-text-field label="First Name" placeholder="Christian Jeano" type="text" name="firstName"
                    required>
                </md-outlined-text-field>

                <md-outlined-text-field label="Middle Name" placeholder="Russel" type="text" name="middleName">
                </md-outlined-text-field>

                <md-outlined-text-field label="Last Name" placeholder="Garcia" type="text" name="lastName" required>
                </md-outlined-text-field>
            </form>
        </div>

        <div class="rightContainer">
            <div class="notif">
                Make sure to fill all the forms
            </div>
            <md-filled-button id="submitButton">
                Submit
            </md-filled-button>
        </div>
    </div>

    <!-- Import JavaScript -->
    <script type="module">
        import "./main.js"
        import "./index.js"
    </script>
</body>

</html>