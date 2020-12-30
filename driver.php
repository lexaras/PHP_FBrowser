<?php $url = $_SERVER['REQUEST_URI'];
print("<h1>Directory contents: $url</h1>");
//Logout button 
print('<div class="logout">Click here to <a href="index.php?action=logout"> logout.</div>');
?>
<table>
    <thead>
        <tr>
            <th>Type</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($_FILES['image'])) {
            $errors = array();
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];
            // check extension (and only permit jpegs, jpgs and pngs)
            $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));
            $extensions = array("jpeg", "jpg", "png", "txt");
            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
            }
            if ($file_size > 2097152) {
                $errors[] = 'File size must be excately 2 MB';
            }
            if (empty($errors) == true) {
                move_uploaded_file($file_tmp, $_GET['path'] . "./" . $file_name);
            } else {
                print_r($errors);
            }
        }
        //Display cwd(current working directory) files and directories
        if (!isset($_GET['path']) && !isset($_POST['new_dir']) && empty($_POST)) {
            $dir = getcwd();
            // print_r($dir);
            $files_directories = scandir($dir);
            // print('<br>');
            // print_r($files_directories);
            display($files_directories);
        };
        //Navigate between folders if path has changed and display cwd again
        if (isset($_GET) && $_GET['path'] != "") {
            $current_dir = $_GET['path'];
            // print($current_dir);
            chdir($current_dir);
            $dir = getcwd();
            //  print($dir);
            $files_directories = scandir($dir);
            navigate($files_directories, $url);
        }
        //Create new directory
        if (isset($_POST['new_dir']) && $_POST['new_dir'] != "") {
            $dir = getcwd();
            //print($dir);
            mkdir($dir . '/' . $_POST['new_dir']);
            header('Location: ' . $_SERVER['REQUEST_URI']);
            $files_directories = scandir($dir);
            display($files_directories);
        };
        //Delete file
        if (!empty($_POST) && !isset($_POST['new_dir'])) {
            $file_name = str_replace("_", ".", array_keys($_POST)[0]);
            // print($file_name);
            unlink($file_name);
            header('Location: ' . $_SERVER['REQUEST_URI']);
            $dir = getcwd();
            $files_directories = scandir($dir);
            display($files_directories);
        }
        ?>
    </tbody>
</table>
<?php
//Back button
$current_dir = $_SERVER['REQUEST_URI'];
$previous_dir = dirname($current_dir);
print("<button><a href='$previous_dir'>Back</a></button>");
//history.back(1)- not working properly when making new dir
//print('<button type="button" onclick="history.back(1);">Back</button>'); 

//New directory input + button fields
print("<form action=''method='POST'><input type='text' name='new_dir' 
id='input' placeholder='Name of new directory'><button id='submit'>Submit</button></form>");
?>

<!-- Upload file form and -->
<form action="" method="POST" enctype="multipart/form-data">
    <input id='upl_buttons' type="file" name="image" />
    <br>
    <input id='upl_buttons' type="submit" value="Upload file" />
</form>


<?php
//Functions

//Looping through array of files/directories and displaying each 
//into the table with a single if condition(whether its file or dir)
function display($files_directories)
{
    foreach ($files_directories as $each) {
        if ($each != '.' && $each != '..')
            if (is_dir($each)) {
                print("<tr><td>Folder</td><td><a href='?path=$each'>" . $each . "</a></td><td></td></tr>");
            } else print("<tr><td>File</td><td>" . $each . "</a></td><td><form method='POST'><input type='submit' name='$each' value='Delete'></form></td></tr>");
    };
};
function navigate($files_directories, $url)
{
    foreach ($files_directories as $each) {
        if ($each != '.' && $each != '..')
            if (is_dir($each)) {
                print("<tr><td>Folder</td><td><a href='$url/$each'>" . $each . "</a></td><td></td></tr>");
            } else print("<tr><td>File</td><td>" . $each . "</a></td><td><form method='POST'><input type='submit' name='$each' value='Delete'></form></td></tr><br>");
    };
}
?>