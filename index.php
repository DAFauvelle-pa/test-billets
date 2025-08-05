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
            $product_array = [];
            $user_array = [];
            // define variables and set to empty values
            $nameErr = $emailErr = "";
            $name = $email = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST["name"])) {
                    $nameErr = "Name is required";
                } else {
                    $name = $helper->testInput($_POST["name"]);
                    // check if name only contains letters and whitespace
                    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                    $nameErr = "Only letters and white space allowed";
                    }
                }
                
                if (empty($_POST["email"])) {
                    $passwordErr = "Password is required";
                } else {
                    $email = $helper->testInput($_POST["email"]);
                    // check if e-mail address is well-formed
                    if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",$name)) {
                    $nameErr = "Please enter a valid email address";
                    }
                }
            }

            echo "<h3>=== Add a new user ===</h3>";
            echo '<br><form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                echo 'Name: <input type="text" name="name" value="' . $name . '">
                    <span class="error">* ' . $nameErr . '</span>
                    <br><br>
                    Email: <input type="text" name="email" value="' . $email . '">
                    <span class="error">* ' . $emailErr . '</span>
                    <br><br>
                    <input type="submit" name="submit" value="add-user">  
                    <br><br>';
            echo '</form>';

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

            // fetch the bundles
            $sql = "SELECT Id, title FROM bundle";
            $product_array = $helper->fetchObjectsFromDb($sql, $conn, 'Bundle');

            // add new user if new User was submited
            if (isset($_POST['submit'])) {
                if($_POST['submit'] == 'add-user') {
                    // Activate user
                    $new_username = $_POST['name'];
                    $new_email = $_POST['email'];
                    $sql = "INSERT INTO user (user_name, user_email)
                            VALUES ('$new_username', '$new_email')";
                    if ($conn->query($sql) === TRUE) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }

            // fetch the Users
            $sql = "SELECT Id, user_name, user_email FROM user";
            $user_array = $helper->fetchObjectsFromDb($sql, $conn, 'User');

            // add new subscription if new subscription was clicked
            if (isset($_POST['submit'])) {
                if($_POST['submit'] == 'add-subscription') {
                    $now = new DateTime('now');   

                    $duration = $_POST['subscription-options'];
                    $bundle_id = (int)$_POST['bundle-options'];
                    $user_id = (int)$_POST['user-options'];

                    $new_subscription = new Subscription($now, $now, $user_id, $bundle_id, null, 1, $duration);
                    $sql = "INSERT INTO subscription (start_date, end_date, user_id, bundle_id, active)
                            VALUES ('$new_subscription->start_date', '$new_subscription->end_date', '$user_id', '$bundle_id', '1')";
                    if ($conn->query($sql) === TRUE) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }

            //close connection
            $conn->close();

            echo "<h3>=== Create new subscription ===</h3>";

            echo '<br><form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                echo "<label for='subscription-options'>Choose subscription option:</label>
                    <select name='subscription-options' id='subscription-options'>
                        <option value='+1 month'>1 Month</option>
                        <option value='+2 month'>2 Month</option>
                        <option value='+1 year'>1 Year</option>
                    </select>";

                echo "<h4>--- All the Bundles ---</h4>";
                echo "<label for='bundle-options'>Choose bundle option:</label>
                    <select name='bundle-options' id='bundle-options'>";
                    foreach($product_array as $product) {
                            echo "<option value='$product->Id'>$product</option>";
                            echo "</br>";
                    }
                echo "</select>";

                echo "<h4>--- All the Users ---</h4>";
                echo "<label for='user-options'>Choose user option:</label>
                    <select name='user-options' id='user-options'>";
                        foreach($user_array as $user) {
                            echo "<option value='$user->Id'>$user</option>";
                            echo "</br>";
                        }
                echo "</select>";
                echo "</br>";
                echo '<input type="submit" name="submit" value="add-subscription">';
                echo "</br>";
            echo "</form>";
            echo '<a href="/subscription-view.php">View subscriptions<a/>';
        ?>
        </form>
    </body>
</html>
