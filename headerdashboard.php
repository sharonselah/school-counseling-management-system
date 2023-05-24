<div class="header-dashboard">

        <div class="logo">
        CUEA Counseling
        </div>

        <div class="personal-info">
                <h2>Welcome, <span id="username"><?php echo $_SESSION["name"]; ?></span></h2>
                <div class="notification-icon">
                        <span class="notification-count" id="notificationCount">...</span>
                        <span class="icon" id="notificationIcon" onclick="toggleNotifications()"></span>
                </div>
        </div>
                

        <script>
        function toggleNotifications() {
                var notificationList = document.getElementById("notificationList");
                notificationList.classList.toggle("show");
        }
        </script>

</div>