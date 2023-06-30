<!--Progress Report-->


<?php

// Query to retrieve goal progress data
$sql = "SELECT goal.goal, COUNT(DISTINCT wg.goal_id) AS goal_count
        FROM weekly_goal_progress AS wg
        INNER JOIN goals AS goal ON wg.goal_id = goal.id
        GROUP BY goal.goal";

$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

if ($sort == 'asc') {
    $orderBy = 'ORDER BY goal_count ASC';
} elseif ($sort == 'desc') {
    $orderBy = 'ORDER BY goal_count DESC';
} else {
    $orderBy = ''; // No sorting specified, use default ordering
}

$sql .= ' ' . $orderBy;


$result = $conn->query($sql); ?>




<?php

// Check if there are any goal progress entries
if ($result->num_rows > 0) {
    // Output table headers
    echo "<table id ='tablegoals' class='table'>
            <tr style='text-align: left;'>
                <th>Number</th>
                <th>Goal Name </th>
                <th>
                <div style='display:flex;'>
                Goal Count 
                    <form method='GET' action='admindashboard.php'>
                        <input type='hidden' name='page' value='goals.php'>
                        <button type='submit' name='sort' value='asc'>
                            &#9650;
                        </button>
                        <button type='submit' name='sort' value='desc'>
                            &#9660;
                        </button>
                    </form>
                </div>
                
                </th>
               
            </tr>";

    // Output each goal progress entry
    $count = 1; 
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>$count</td>
                <td>" . $row['goal'] . "</td>
                <td>" . $row['goal_count'] . "</td>
                
              </tr>";
              $count++;
    }

    echo "</table>";
} else {
    echo "No goal progress entries found.";
}


?>
