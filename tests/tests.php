<?php
session_start();
include('../includes/db.php');
include('../includes/sidebar.php');
?>

<div class="main-content">
    <div class="header-center">
        <h2 class="section-title">Available Tests</h2>
        <p class="section-description">Here are the tests available for you. Choose and start!</p>
    </div>

    <div class="test-list">
        <?php
        $query = "SELECT * FROM personality_tests";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='test-item'>
                        <div class='test-info'>
                            <h3>".htmlspecialchars($row['test_name']) . "</h3>
                            <p>".htmlspecialchars($row['description']) . "</p>
                        </div>
                        <div class='test-action'>
                            <a href='start_test.php?test_id=" . $row['test_id'] . "' class='start-btn'>Start Test</a>
                        </div>
                      </div>";
            }
        } else {
            echo "<p>No tests available at the moment.</p>";
        }
        ?>
    </div>
</div>
<!-- ✅ Hamburger Menu -->
<div class="hamburger-menu" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</div>

<!-- ✅ CSS Fix for Sidebar -->
<style>
    /* ✅ Sidebar Styling */
    .sidebar {
        width: 250px;
        background-color: #2c3e50;
        padding: 20px;
        color: #fff;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        transition: transform 0.3s ease;
        z-index: 1000;
    }

    /* ✅ Hamburger Styling */
    .hamburger-menu {
        position: fixed;
        top: 15px;
        right: 15px;
        cursor: pointer;
        z-index: 1100;
        font-size: 24px;
        color: #2c3e50;
        background-color: #fff;
        padding: 8px;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s ease;
        display: none; /* Hide on desktop */
    }

    .hamburger-menu:hover {
        background-color: #ecf0f1;
    }

    /* ✅ Responsive Sidebar */
    @media (max-width: 768px) {
        .sidebar {
            left: -250px; /* 👈 Hide sidebar on mobile */
        }

        .sidebar.open {
            left: 0; /* 👈 Slide in on mobile */
        }

        .hamburger-menu {
            display: block; /* 👈 Show on mobile */
        }
    }
</style>



<!-- ✅ CSS Styling -->
<style>
    /* ✅ General Styling */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        background-color: #f4f4f9;
        color: #333;
        overflow-x: hidden;
    }

    /* ✅ Main Content */
    .main-content {
        margin-left: 250px;
        padding: 60px;
        transition: margin-left 0.3s;
        min-height: 100vh;
        box-sizing: border-box;
    }

    /* ✅ Heading and Description */
    .header-center {
        text-align: center;
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 28px;
        color: #2c3e50;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .section-description {
        font-size: 18px;
        color: #555;
        margin-bottom: 20px;
    }

    /* ✅ Test List */
    .test-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* ✅ Test Item */
    .test-item {
        background-color: #ffffff;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: transform 0.3s ease;
    }

    /* ✅ Test Info */
    .test-info h3 {
        color: #007bff;
        font-size: 20px;
        margin-bottom: 5px;
    }

    .test-info p {
        font-size: 16px;
        color: #555;
        margin-bottom: 0;
    }

    /* ✅ Test Action */
    .test-action {
        text-align: right;
    }

    .start-btn {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s ease;
    }

    .start-btn:hover {
        background-color: #0056b3;
    }

    /* ✅ Hover Effect */
    .test-item:hover {
        background-color: #f9f9f9;
        transform: translateY(-5px);
    }

    /* ✅ Responsive Design */
    @media (max-width: 768px) {
        .main-content {
            margin-left: 0;
            padding: 20px;
            width: 100%; /* 👈 Full width on mobile */
        }

        .test-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
            width: 100%; /* 👈 Full width on mobile */
        }

        .test-info {
            text-align: left;
        }

        .test-action {
            text-align: left;
        }

        .start-btn {
            width: 100%; /* 👈 Full width on mobile */
            max-width: 250px;
        }
        .main-content {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    background-color: #ffffff;
    transition: margin-left 0.3s ease;
}

@media (max-width: 768px) {
    .main-content {
        margin-left: 0;
        padding: 15px;
    }
}

    }
</style>
