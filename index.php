<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $priority = $_POST['priority'];
    $sql = "INSERT INTO tasks (user_id, title, category, priority) VALUES ('$user_id', '$title', '$category', '$priority')";

    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['delete'])) {
    $task_id = $_GET['delete'];
    $sql = "DELETE FROM tasks WHERE id='$task_id' AND user_id='$user_id'";
    $conn->query($sql);
}

if (isset($_GET['complete'])) {
    $task_id = $_GET['complete'];
    $sql = "UPDATE tasks SET is_completed=TRUE WHERE id='$task_id' AND user_id='$user_id'";
    $conn->query($sql);
}

$tasks = $conn->query("SELECT * FROM tasks WHERE user_id='$user_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
</head>
<body>
    <h2>To-Do List</h2>
    <form method="post">
        Task: <input type="text" name="title" required><br>
        Category: <input type="text" name="category"><br>
        Priority: 
        <select name="priority">
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
        </select><br>
        <button type="submit">Add Task</button>
    </form>

    <h3>Your Tasks</h3>
    <ul>
        <?php while ($task = $tasks->fetch_assoc()) : ?>
            <li>
                <?php echo $task['title']; ?> - <?php echo $task['category']; ?> - <?php echo $task['priority']; ?>
                <?php if ($task['is_completed']) : ?>
                    <strong>(Completed)</strong>
                <?php else : ?>
                    <a href="?complete=<?php echo $task['id']; ?>">Complete</a>
                <?php endif; ?>
                <a href="?delete=<?php echo $task['id']; ?>">Delete</a>
            </li>
        <?php endwhile; ?>
    </ul>
    <a href="logout.php">Logout</a>
</body>
</html>
