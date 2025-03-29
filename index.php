<html>
<head>
    <meta name="robots" content="noindex, nofollow" />
    <meta charset="ISO-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Self-Destruct</title>
    <style>
        body { background-color: #333; color: white; font-family: sans-serif; }
        table { border-collapse: collapse; }
        th, td { text-align: left; padding: 5px; border-bottom: 1px solid #CCC; }
        tr:nth-child(even) { background-color: #444; }
    </style>
</head>
<body>
<h1>Self-Destruct</h1>

<?php
require_once('TextFileAccess.php');
$textFile = new TextFileAccess("deletelist.txt");

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'edit':
                $textFile->updateLine($_POST['line_number'], 
                    $_POST['folder'] . ';' . $_POST['creation'] . ';' . 
                    $_POST['deletion'] . ';' . $_POST['comment']);
                break;
            case 'add':
                $textFile->appendLine(
                    $_POST['folder'] . ';' . $_POST['creation'] . ';' . 
                    $_POST['deletion'] . ';' . $_POST['comment']);
                break;
            case 'delete':
                $textFile->deleteLine($_POST['line_number']);
                break;
        }
    }
}
?>

<table>
    <tr>
        <th>Folder</th>
        <th>Creation</th>
        <th>Deletion</th>
        <th>Exists</th>
        <th>Comment</th>
        <th>Actions</th>
    </tr>
<?php
$lineNumber = 0;
$lines = $textFile->readAllLines();

foreach ($lines as $line) {
    list($folder, $creationdate, $deletiondate, $comment) = explode(';', $line);
    if ($folder == "" || substr($folder, 0, 1) == "#") { 
        $lineNumber++;
        continue; 
    }
    echo "<tr>"
        . "<td>" . htmlspecialchars($folder) . "</td>"
        . "<td>" . htmlspecialchars($creationdate) . "</td>"
        . "<td>" . htmlspecialchars($deletiondate) . "</td>"
        . "<td>" . (file_exists("../" . $folder) && is_dir("../" . $folder) ? "Yes" : "No") . "</td>"
        . "<td>" . htmlspecialchars($comment) . "</td>"
        . "<td>
            <button onclick=\"showEditForm($lineNumber, '$folder', '$creationdate', '$deletiondate', '$comment')\">Edit</button>
            <form method='post' style='display: inline;'>
                <input type='hidden' name='action' value='delete'>
                <input type='hidden' name='line_number' value='$lineNumber'>
                <button type='submit' onclick='return confirm(\"Are you sure?\")'>Delete</button>
            </form>
           </td>"
        . "</tr>";
    $lineNumber++;
}
?>
</table>

<!-- Add new entry form (moved to bottom) -->
<form method="post" style="margin: 20px 0;">
    <h3>Add New Entry</h3>
    <input type="hidden" name="action" value="add">
    <input type="text" name="folder" placeholder="Folder" required>
    <input type="text" name="creation" placeholder="Creation Date" required value="<?php echo date('Y-m-d'); ?>">
    <input type="text" name="deletion" placeholder="Deletion Date" required>
    <input type="text" name="comment" placeholder="Comment">
    <button type="submit">Add</button>
</form>

<!-- Edit form (hidden by default) -->
<div id="editForm" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); 
    background: #444; padding: 20px; border: 1px solid #666;">
    <h2>Edit Entry</h2>
    <form method="post">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="line_number" id="edit_line_number">
        <input type="text" name="folder" id="edit_folder" required style="width: 300px; margin-bottom: 10px;"><br>
        <input type="text" name="creation" id="edit_creation" required style="width: 300px; margin-bottom: 10px;"><br>
        <input type="text" name="deletion" id="edit_deletion" required style="width: 300px; margin-bottom: 10px;"><br>
        <input type="text" name="comment" id="edit_comment" style="width: 300px; margin-bottom: 10px;"><br>
        <button type="submit">Save</button>
        <button type="button" onclick="hideEditForm()">Cancel</button>
    </form>
</div>

<script>
function showEditForm(lineNumber, folder, creation, deletion, comment) {
    document.getElementById('editForm').style.display = 'block';
    document.getElementById('edit_line_number').value = lineNumber;
    document.getElementById('edit_folder').value = folder;
    document.getElementById('edit_creation').value = creation;
    document.getElementById('edit_deletion').value = deletion;
    document.getElementById('edit_comment').value = comment;
}

function hideEditForm() {
    document.getElementById('editForm').style.display = 'none';
}
</script>
</body>
</html>