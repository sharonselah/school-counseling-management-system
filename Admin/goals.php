<!--Progress Report-->

<input style='margin:0px;' class ="search_inline" type="search" name="search" id="searchgoals" placeholder="search goals..">
<?php

// Query to retrieve goal progress data
$sql = "SELECT goal.goal, COUNT(DISTINCT wg.goal_id) AS goal_count
        FROM weekly_goal_progress AS wg
        INNER JOIN goals AS goal ON wg.goal_id = goal.id
        GROUP BY goal.goal
        ORDER BY goal_count DESC";


$result = $conn->query($sql);

// Check if there are any goal progress entries
if ($result->num_rows > 0) {
    // Output table headers
    echo "<table id ='tablegoals' class='table'>
            <tr style='text-align: left;'>
                <th>Number</th>
                <th>Goal Name 
                    <span id='sortArrowNameDown'>&#9660;</span>
                    <span id='sortArrowNameUp'>&#9650;</span>
                </th>
                <th>Goal Count 
                    <span id='sortArrowCountDown'>&#9660;</span>
                    <span id='sortArrowCountUp'>&#9650;</span>
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