<?php
session_start();
include 'db.php';

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

$sql = "SELECT * FROM parts";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['login']); ?>!</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="cart.php">Cart</a>
        <a href="index.php?logout=true">Logout</a>
        <?php if ($_SESSION['login'] === 'admin') { ?>
        <a href="admin.php">Admin Panel</a>
        <?php } ?>
    </nav>
    <div class="container">
        <h2>Parts</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Photo</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['price']); ?></td>
                <td><?php echo htmlspecialchars($row['category']); ?></td>
                <td><img src="<?php echo htmlspecialchars($row['photo']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>"></td>
                <td><a href="cart.php?action=add&id=<?php echo $row['id']; ?>">Add to Cart</a></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
