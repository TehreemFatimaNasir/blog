<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];
    
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = "uploads/" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    $query = "INSERT INTO posts (title, content, user_id, image) VALUES ('$title', '$content', $user_id, '$image')";
    
    if ($conn->query($query) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <style>
        body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(to right, #2c3e50, #4ca1af);
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    max-width: 400px;
    padding: 30px;
    background-color: rgba(255, 255, 255, 0.95);
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    transition: transform 0.2s, box-shadow 0.2s;
}

.container:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.form-title {
    text-align: center;
    margin-bottom: 20px;
    font-size: 28px;
    font-weight: 700;
    color: #34495e;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #34495e;
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="password"] {
    width: 100%;
    height: 45px;
    padding: 10px;
    border: 1px solid #bdc3c7;
    border-radius: 5px;
    font-size: 16px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.form-group input[type="text"]:focus,
.form-group input[type="email"]:focus,
.form-group input[type="password"]:focus {
    border-color: #2980b9;
    box-shadow: 0 0 5px rgba(41, 128, 185, 0.5);
    outline: none;
}

.form-group input[type="submit"] {
    width: 100%;
    height: 45px;
    padding: 10px;
    background-color: #2980b9;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: background-color 0.3s, transform 0.2s;
}

.form-group input[type="submit"]:hover {
    background-color: #1a6f93;
    transform: translateY(-2px);
}

.error-message {
    color: #e74c3c;
    font-size: 14px;
    margin-top: 10px;
}

.success-message {
    color: #27ae60;
    font-size: 14px;
    margin-top: 10px;
}

nav {
    display: flex;
    justify-content: center;
    margin: 20px 0;
}

nav a {
    margin: 0 15px;
    text-decoration: none;
    color: #ffffff;
    font-weight: 500;
    transition: color 0.3s;
}

nav a:hover {
    color: #ffe600;
}

h2 {
    text-align: center;
    font-size: 24px;
    margin: 20px 0;
    color: #ffffff;
}
    </style>
</head>
<body>
    <h2>Create New Post</h2>
    <form method="POST" enctype="multipart/form-data">
        Title: <input type="text" name="title" required>
        Content: <textarea name="content" required></textarea>
        Post Image: <input type="file" name="image" accept="image/*">
        <input type="submit" value="Create Post">
    </form>
</body>
</html>
