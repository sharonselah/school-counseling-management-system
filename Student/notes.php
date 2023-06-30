
<div id="notes" style="margin-top: 10px; min-height: 100vh; box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;">
    <h2>Notes</h2>
    <?php
    // Query the notes table for the student's notes and counselor's name
    $sql = "SELECT n.*, c.name AS counselor_name
            FROM notes AS n
            INNER JOIN counselors AS c ON n.counselor_id = c.counselor_id
            WHERE n.student_id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo '<table style="width: 80%;margin:auto; border-collapse: collapse;">';
      echo '<tr><th style="padding: 8px; text-align: left;">Counselor Name</th><th style="padding: 8px; text-align: left;">Notes</th></tr>';

      while ($note = $result->fetch_assoc()) {
          echo '<tr>';
          echo '<td style="padding: 8px;">' . $note["counselor_name"] . '</td>';
          echo '<td style="padding: 8px;"><a href="#" onclick="showNoteContent(' . $note["note_id"] . ')" style="color: blue; text-decoration: underline; cursor: pointer;">View Notes</a></td>';
          echo '</tr>';
          echo '<tr id="note_content_' . $note["note_id"] . '" style="display: none;">';
          echo '<td colspan="2">';
          echo '<label>Title:</label>';
          echo '<textarea name="title" readonly style="width: 100%; resize: none; margin-bottom: 8px;">' . $note["title"] . '</textarea>';
          echo '<label>Content:</label>';
          echo '<textarea rows="10" cols="40" name="content" readonly style="width: 100%; resize: vertical;">' . $note["content"] . '</textarea>';
          echo '</td>';
          echo '</tr>';
      }

        echo '</table>';
    } else {
        echo '<div style="height: 70vh; width: 100%; display: flex; justify-content: center; align-items: center;">
                <p style="text-align: center;">No notes found. <br>
                Please book and attend a counseling session to get notes</p>
              </div>';
    }
    ?>
</div>

<script>
    function showNoteContent(noteId) {
        var noteContent = document.getElementById("note_content_" + noteId);
        if (noteContent.style.display === "none") {
            noteContent.style.display = "table-row";
        } else {
            noteContent.style.display = "none";
        }
    }
</script>
