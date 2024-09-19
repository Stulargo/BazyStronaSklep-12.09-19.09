<?php
session_start();
include 'db.php';

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $id = intval($_GET['id']);
    if ($id > 0 && !in_array($id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $id;
    }
    header('Location: cart.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    $_SESSION['cart'] = [];
    header('Location: cart.php');
    exit();
}

$cart_items = implode(',', $_SESSION['cart']);
if ($cart_items) {
    $sql = "SELECT * FROM parts WHERE id IN ($cart_items)";
    $result = $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Cart</h1>
    </header>
    <nav>
        <a href="index.php">Back to Store</a>
        <a href="cart.php?action=clear">Clear Cart</a>
    </nav>
    <div class="container">
        <table>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Photo</th>
            </tr>
            <?php if (isset($result) && $result->num_rows > 0) { ?>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                    <td><?php echo htmlspecialchars($row['category']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($row['photo']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>"></td>
                </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="4">Your cart is empty.</td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
