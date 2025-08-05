<?php 
    session_start();
?>
<html>
    <head>
        <title>Test</title>
    </head>
    <body>
        <?php
            include "classes/Bundle.php";
            include "classes/User.php";
            include "classes/Subscription.php";
            include "classes/Helper.php";

            $helper = new Helper();
            $user_array = [];

            // Fetch data from DB:
            $servername = "db";
            $username = "php_docker";
            $password = "password";
            $dbname = "php_docker";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // fetch the Users
            $sql = "SELECT Id, user_name, user_email FROM user";
            $user_array = $helper->fetchObjectsFromDb($sql, $conn, 'User');
            $selected_user = false;

            // Save selected user
            if (isset($_POST['submit'])) {
                if($_POST['submit'] == 'user-selected') {
                    $_SESSION['selected_user'] = $_POST['user-selection'];
                }
            }
            // Check for cancelled subscription
            if (isset($_POST['cancel'])) {
                cancelSubscription((int) substr($_POST['cancel'], -1), $conn);
            }

            if (isset($_SESSION['selected_user'])) {
                //find product in array
                $selected_user = $helper->findObjectInArrayById($user_array, (int)$_SESSION['selected_user']);

                echo "<p>Selected user:" . $selected_user . "</p>";

            }

            if (isset($_POST['add-1-month'])) {
                // fetch the Subscriptions
                $sql = "SELECT Id, start_date, end_date, user_id, bundle_id, active FROM subscription WHERE user_id = " . $selected_user->Id;
                $subscription_array = $helper->fetchObjectsFromDb($sql, $conn, 'Subscription');
                addMonthToSubscription((int) substr($_POST['add-1-month'], -1), $subscription_array, $conn, $helper);
            }

            // fetch the Subscriptions after modifications
            if ($selected_user) {
                $sql = "SELECT Id, start_date, end_date, user_id, bundle_id, active FROM subscription WHERE user_id = " . $selected_user->Id;
                $subscription_array = $helper->fetchObjectsFromDb($sql, $conn, 'Subscription');
            }

            // close connection
            $conn->close();

            echo "<h3>=== View subscriptions ===</h3>";

            echo '<br><form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                echo "<h4>--- Select users ---</h4>";
                echo "<label for='user-selection'>Choose user option:</label>
                    <select name='user-selection' id='user-selection'>";
                        foreach($user_array as $user) {
                            echo "<option value='$user->Id'>$user</option>";
                            echo "</br>";
                        }
                echo "</select>";
                echo "</br>";
                echo '<input type="submit" name="submit" value="user-selected">';
                echo "</br>";
            echo "</form>";

            echo "<br>";
            echo "<h4>--- Selected user's subscriptions ---</h4>";
            echo '<br><form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
            foreach($subscription_array as $subscription) {
                echo "<div>$subscription</div>";
                echo '<input type="submit" name="cancel" value="cancel-' . $subscription->Id . '">';
                echo '<input type="submit" name="add-1-month" value="add-1-month-' . $subscription->Id . '">';
                echo '</br>';
            }
            echo "</form>";

            function cancelSubscription(int $subscription_id, $conn) {
                //Change value of active in DB before display
                $sql = "UPDATE subscription SET active=0 WHERE id=$subscription_id";

                if ($conn->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            }

            function addMonthToSubscription(int $subscription_id, $subscription_array, $conn, $helper) {
                //Find subscription
                $subscription_to_add = $helper->findObjectInArrayById($subscription_array, $subscription_id);
                $subscription_to_add->addSubscriptionTime('+1 Month');
                $new_time = $subscription_to_add->end_date;
                //Change value of active in DB before display
                $sql = "UPDATE subscription SET active=1, end_date='$new_time' WHERE id=$subscription_id";

                if ($conn->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            }

        ?>
    </body>
</html>