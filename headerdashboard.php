<div class="header-dashboard">

        <div class="logo">
        CUEA Counseling
        </div>

        <div class="personal-info">
                <h2>Welcome, <span id="username"><?php echo $_SESSION["name"]; ?></span></h2>
                <div class="notification-icon">

                        <?php
                                include '../Backend/db.php';

                                $id = $_SESSION["user_id"];

                                $stmt= $conn->prepare("SELECT COUNT(*) FROM notifications WHERE
                                is_read = 0 AND recipient_id =?");

                                $stmt->bind_param('s', $id);
                                $stmt->execute();
                                $stmt->bind_result($count);

                                $stmt->fetch();
                                $stmt->close();
                      
                        ?>
                        <span class="notification-count" id="notificationCount"><?php echo $count;?></span>
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