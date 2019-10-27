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
    <table>
        <tr>
            <th>Folder</th>
            <th>Creation</th>
            <th>Deletion</th>
            <th>Exists</th>
            <th>Comment</th>
        </tr>
<?php
$deleteList = fopen("deletelist.txt", "r") or die("Unable to open file");

while(!feof($deleteList)) {
    list($folder, $creationdate, $deletiondate, $comment) = explode(';', fgets($deleteList));
    if ($folder == "" || substr($folder, 0, 1) == "#") { continue; }
    echo "<tr><td>" . $folder . "</td>"
        . "<td>" . $creationdate . "</td>"
        . "<td>" . $deletiondate . "</td>"
        . "<td>" . (file_exists("../" . $folder) && is_dir("../" . $folder) ? "Yes" : "No") . "</td>"
        . "<td>" . $comment . "</td></tr>";
}

fclose($deleteList);
?>
    </table>
</body>
</html>