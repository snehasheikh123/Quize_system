<div class="sidebar" id="sidebar">
    <h2>Career Guidance</h2>
    <ul>
        <li><a href="/dashboard.php">🏠 Dashboard</a></li>
        <li><a href="/quizesystem/tests/tests.php">📝 Available Tests</a></li>
        <li><a href="/career_suggestions.php">💼 Career Suggestions</a></li>
        <li><a href="/jobs.php">📋 Job Listings</a></li>
        <li><a href="/progress/progress.php">📈 Progress Tracking</a></li>
        <li><a href="/logout.php">🚪 Logout</a></li>
    </ul>
</div>

<!-- ✅ Hamburger Menu -->
<div class="hamburger-menu" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</div>

<!-- ✅ CSS Styling -->
<style>
    /* ✅ Basic Styling */
    body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    /* ✅ Sidebar Styling */
    .sidebar {
        width: 250px;
        background-color: #2c3e50;
        padding: 20px;
        color: #fff;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0; /* Desktop par left side pe stick */
        transition: transform 0.3s ease;
        z-index: 1000;
    }

    .sidebar h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 22px;
        color: #ecf0f1;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
    }

    .sidebar ul li {
        padding: 15px;
        border-bottom: 1px solid #34495e;
        transition: background 0.3s;
    }

    .sidebar ul li:hover {
        background-color: #34495e;
    }

    .sidebar ul li a {
        color: #ecf0f1;
        text-decoration: none;
        display: block;
        font-size: 16px;
        font-weight: 500;
    }

    /* ✅ Hamburger Styling */
    .hamburger-menu {
        position: fixed;
        top: 15px;
        right: 15px; /* Right side pe hamburger menu */
        cursor: pointer;
        z-index: 1100;
        font-size: 24px;
        color: #2c3e50;
        background-color: #fff;
        padding: 8px;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s ease;
        display: none; /* Desktop par hidden */
    }

    .hamburger-menu:hover {
        background-color: #ecf0f1;
    }

    /* ✅ Responsive Behavior */
    @media (max-width: 768px) {
        .sidebar {
            left: auto;
            right: -250px; /* Phone view ke liye right se hide */
        }

        .sidebar.open {
            right: 0; /* Phone view ke liye right se show */
        }

        .hamburger-menu {
            display: block; /* Phone view pe hamburger dikhega */
        }
    }
</style>

<!-- ✅ JavaScript for Sidebar Toggle -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('open');
    }
</script>
