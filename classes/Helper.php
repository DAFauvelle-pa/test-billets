<?php
class Helper {
    function fetchObjectsFromDb(string $query, $conn,string $type): array {
        $data_array = [];
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                switch($type) {
                    case 'Bundle':
                        $data_array[] = new Bundle($row['title'], $row['Id']);
                        break;
                    case 'User':
                        $data_array[] = new User($row['user_name'], $row['user_email'], $row['Id']);
                        break;
                    case 'Subscription':
                        $start_date = new DateTime($row['start_date']);
                        $end_date = new DateTime($row['end_date']);
                        $data_array[] = new Subscription($start_date, $end_date, $row['user_id'], $row['bundle_id'], $row['Id'], $row['active']);
                }
            }
        }
        return $data_array;
    }

    function findObjectInArrayById(array $data_array,int $Id) {
                $result = null;
                foreach ($data_array as $data) {
                    if($data->Id) {
                        if ((int)$data->Id ===  $Id) {
                            $result = $data;
                            break;
                        }
                    }
                }
                $selected_data = $result ?? false;
        return $selected_data;
    }


    function testInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}