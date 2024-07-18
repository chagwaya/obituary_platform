<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "obituary_platform";
$records_per_page = 10;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Determine the current page number
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page-1) * $records_per_page;

// Write SQL query to select all records from the obituaries table with pagination
$sql = "SELECT * FROM obituaries LIMIT $start_from, $records_per_page";
$result = $conn->query($sql);

// Fetch the total number of records
$total_records_sql = "SELECT COUNT(*) FROM obituaries";
$total_records_result = $conn->query($total_records_sql);
$total_records = $total_records_result->fetch_row()[0];
$total_pages = ceil($total_records / $records_per_page);

// Prepare meta tags
$meta_title = "Obituaries - Page $page";
$meta_description = "Browse through the obituaries on page $page. Find information about the lives and legacies of those who have passed.";
$meta_keywords = "obituaries, memorials, remembrances, legacies";

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $meta_title; ?></title>
    <meta name="description" content="<?php echo $meta_description; ?>">
    <meta name="keywords" content="<?php echo $meta_keywords; ?>">
    <link rel="stylesheet" href="styles.css">
    <link rel="canonical" href="http://example.com/view_obituaries.php?page=<?php echo $page; ?>">
    <meta property="og:title" content="<?php echo $meta_title; ?>">
    <meta property="og:description" content="<?php echo $meta_description; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://example.com/view_obituaries.php?page=<?php echo $page; ?>">
    <meta property="og:image" content="http://example.com/images/obituary.jpg">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="table-container">
        <h2>Obituaries</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Date of Death</th>
                    <th>Content</th>
                    <th>Author</th>
                    <th>Submission Date</th>
                    <th>Share</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo $row['date_of_birth']; ?></td>
                            <td><?php echo $row['date_of_death']; ?></td>
                            <td><?php echo htmlspecialchars($row['content']); ?></td>
                            <td><?php echo htmlspecialchars($row['author']); ?></td>
                            <td><?php echo $row['submission_date']; ?></td>
                            <td>
                                <a href="C:\xampp\htdocs\obituary\fcaebook icon.jpeg/view_obituaries.php?id=<?php echo $row['id']; ?>" target="_blank">
                                    <i class="fab fa-facebook-square"></i>
                                </a>
                                <a href="C:\xampp\htdocs\obituary\twitter icon.jpeg/view_obituaries.php?id=<?php echo $row['id']; ?>&text=<?php echo urlencode($row['name']); ?>" target="_blank">
                                    <i class="fab fa-twitter-square"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No obituaries found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="view_obituaries.php?page=<?php echo $i; ?>" class="<?php if ($i == $page) echo 'active'; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
    </div>
</body>
</html>
