<?php
session_start();
include 'db.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
    header('Location: index.php');
    exit();
}

if (isset($_POST['delete'])) {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM parts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $sql = "UPDATE parts SET name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $name, $id);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = floatval($_POST['price']);
    $category = $_POST['category'];
    $photo = $_POST['photo'];
    
    if (!empty($name) && !empty($price) && !empty($category) && !empty($photo)) {
        $sql = "INSERT INTO parts (name, price, category, photo) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sdss', $name, $price, $category, $photo);
        $stmt->execute();
        $stmt->close();
    }
}

$sql = "SELECT * FROM parts";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="cart.php">Cart</a>
        <a href="index.php?logout=true">Logout</a>
    </nav>
    <div class="container">
        <div class="admin-panel">
            <h2>Add New Item</h2>
            <form method="post" action="admin.php">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" required>
                
                <label for="category">Category:</label>
                <input type="text" id="category" name="category" required>
                
                <label for="photo">Photo URL:</label>
                <input type="text" id="photo" name="photo" required>
                
                <input type="submit" name="add" value="Add Item">
            </form>
            
            <h2>Manage Items</h2>
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
                    <form method="post" action="admin.php" style="display:inline;">
                        <td><input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required></td>
                        <td><input type="number" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" step="0.01" required></td>
                        <td><input type="text" name="category" value="<?php echo htmlspecialchars($row['category']); ?>" required></td>
                        <td><input type="text" name="photo" value="<?php echo htmlspecialchars($row['photo']); ?>" required></td>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="submit" name="update" value="Update Name">
                            <input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');">
                        </td>
                    </form>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>
