<?php
session_start();

if (!isset($_SESSION['isAuthenticated'])) {
    header('Location: ../login.php');
    exit();
}
?>

<?php
require_once '../config/db.php';

try {
    $stmt = $pdo->query("
        SELECT 
            id,
            first_name as firstName,
            middle_name as middleName,
            last_name as lastName,
            student_id as studentId,
            personal_email as email,
            phinmaed_email as phinmaed,
            concern,
            submission_date as date,
            IFNULL(status, 'Pending') as status
        FROM student_concerns
        ORDER BY submission_date DESC
    ");

    $concerns = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <link rel="stylesheet" href="manage.css">
    <link rel="icon" href="/WebProject-v2/public/upangnavlogo.svg" type="image/icon type">

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
        import {
            styles as typescaleStyles
        } from '@material/web/typography/md-typescale-styles.js';

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

<md-dialog id="deleteDialog">
        <div slot="headline">Confirm Deletion</div>
        <div slot="content">
            Are you sure you want to delete this concern? This action cannot be undone.
        </div>
        <div slot="actions">
            <md-text-button onclick="document.getElementById('deleteDialog').close()">Cancel</md-text-button>
            <md-text-button id="confirmDeleteBtn">Delete</md-text-button>
        </div>
    </md-dialog>


    <md-dialog id="statusDialog">
        <div slot="headline">Confirm Status Change</div>
        <div slot="content" id="statusDialogContent">
            Are you sure you want to change the status of this concern?
        </div>
        <div slot="actions">
            <md-text-button onclick="document.getElementById('statusDialog').close()">Cancel</md-text-button>
            <md-text-button id="confirmStatusBtn">Confirm</md-text-button>
        </div>
    </md-dialog>

<body>
    <header class="header">
        <div class="search-container">
            <md-outlined-text-field
                class="search-field"
                id="search-field"
                placeholder="Search"
                oninput="searchTable(this.value)">
                <md-icon slot="leading-icon">search</md-icon>
            </md-outlined-text-field>
        </div>

        <mdc-dialog id="search-view">
            <div class="search-results">
                <!-- Dynamic search results will be displayed here -->
            </div>
        </mdc-dialog>
    </header>
    <section class="sidebar" id="sidebar">
        <div class="logo-container">
            <img src="/WebProject-v2/public/upangnavlogo.svg" alt="UPANG LOGO" class="logo">
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
                    <a href="/WebProject-v2/login.php" id="toLogin">
                        <span class="material-symbols-outlined icon">move_item</span>&ensp;Sign Out
                    </a>
                </li>
            </ul>
        </div>
    </section>
    <main class="main">
        <div class="contents">
            <div class="dashboard-container">
                <h1>Manage All Concerns</h1>

                <?php if (isset($error)): ?>
                    <div class="error"><?= htmlspecialchars($error) ?></div>
                <?php elseif (empty($concerns)): ?>
                    <div class="empty-state">
                        <span class="material-symbols-outlined">info</span>
                        <p>No concerns found</p>
                    </div>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student Name</th>
                                <th>Student ID</th>
                                <th>Email</th>
                                <th>Phinmaed Email</th>
                                <th>Concern</th>
                                <th>Date Submitted</th>
                                <th class="action-column">Actions</th> <!-- Added class for action column -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($concerns as $concern): ?>
                                <tr data-id="<?= htmlspecialchars($concern['id']) ?>">
                                    <td><?= htmlspecialchars($concern['id']) ?></td>
                                    <td><?= htmlspecialchars($concern['firstName'] . ' ' . ($concern['middleName'] ? $concern['middleName'] . ' ' : '') . $concern['lastName']) ?></td>
                                    <td><?= htmlspecialchars($concern['studentId']) ?></td>
                                    <td><?= htmlspecialchars($concern['email']) ?></td>
                                    <td><?= htmlspecialchars($concern['phinmaed']) ?></td>
                                    <td><?= htmlspecialchars($concern['concern']) ?></td>
                                    <td><?= date('M j, Y g:i a', strtotime($concern['date'])) ?></td>
                                    <td class="action-buttons">
                                        <div class="button-group">
                                            <?php if ($concern['status'] === 'Pending'): ?>
                                                <md-filled-tonal-button class="status-toggle resolved-btn" onclick="updateStatus(<?= $concern['id'] ?>, 'Resolved')">
                                                    <md-icon slot="icon" class="statusIcon">pending</md-icon>
                                                    Pending
                                                </md-filled-tonal-button>
                                            <?php else: ?>
                                                <md-filled-tonal-button class="status-toggle pending-btn" onclick="updateStatus(<?= $concern['id'] ?>, 'Pending')">
                                                    <md-icon slot="icon" class="statusIcon">check_circle</md-icon>
                                                    Resolved
                                                </md-filled-tonal-button>
                                            <?php endif; ?>
                                            <md-filled-tonal-button class="delete-btn" onclick="deleteConcern(<?= $concern['id'] ?>)">
                                                <md-icon slot="icon" class="statusIcon">delete</md-icon>
                                                Delete
                                            </md-filled-tonal-button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
        async function updateStatus(id, newStatus) {
            try {
                const response = await fetch('/WebProject-v2/api/update_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id,
                        status: newStatus
                    })
                });

                const result = await response.json();

                if (result.success) {
                    // Reload the page to see changes
                    location.reload();
                } else {
                    throw new Error(result.message || 'Failed to update status');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error updating status: ' + error.message);
            }
        }

        async function deleteConcern(id) {
            if (!confirm('Are you sure you want to delete this concern?')) return;

            try {
                const response = await fetch('/WebProject-v2/api/delete_concern.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id
                    })
                });

                const result = await response.json();

                if (result.success) {
                    // Remove the row from the table
                    document.querySelector(`tr[data-id="${id}"]`).remove();
                    // Show success message
                    alert('Concern deleted successfully');
                } else {
                    throw new Error(result.message || 'Failed to delete concern');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error deleting concern: ' + error.message);
            }
        }
    </script>

    <script type="module">
        import "./main.js"
    </script>
</body>

</html>