<?php 
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 2.5em;
        }

        nav {
            margin: 15px 0;
        }

        nav a {
            color: #ffffff;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav .btn {
            background-color: #1abc9c; /* Button background color */
            padding: 10px 15px; /* Padding for the button */
            border-radius: 5px; /* Rounded corners */
            color: #ffffff; /* Text color */
            text-decoration: none; /* Remove underline */
            font-weight: bold; /* Bold text */
            transition: background-color 0.3s; /* Transition for hover effect */
        }

        nav .btn:hover {
            background-color: #16a085; /* Darker shade on hover */
        }

        nav a:hover {
            color: #1abc9c;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-size: 2em;
            color: #34495e;
        }

        article {
            margin-bottom: 30px;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 20px;
        }

        article h3 {
            font-size: 1.8em;
            color: #2980b9;
        }

        article p {
            line-height: 1.6;
            color: #555;
        }

        article img {
            margin-top: 10px;
            border-radius: 5px;
            max-width: 100%;
            height: auto;
        }

        small {
            display: block;
            margin-top: 10px;
            font-size: 0.9em;
            color: #999;
        }

        h4 {
            margin-top: 20px;
            color: #2980b9;
        }

        form {
            margin-top: 10px;
        }

        form textarea {
            width: 100%;
            height: 60px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            resize: none;
            transition: border-color 0.3s;
        }

        form textarea:focus {
            border-color: #2980b9;
            outline: none;
        }

        form input[type="submit"] {
            background-color: #2980b9;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        form input[type="submit"]:hover {
            background-color: #1a6f93;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #2c3e50;
            color: #ffffff;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to My Blog</h1>
        <nav>
            <a href="index.php">Home</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="create_post.php" class="btn">Create Post</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <h2>Blog Posts</h2>
        <img src="uploads/banner.jpg" alt="Banner" style="width: 100%; height: auto;">
        <?php
        $result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
        while ($post = $result->fetch_assoc()): ?>
            <article>
                <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                <?php if ($post['image']): ?>
                    <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" style="max-width: 100%; height: auto;">
                <?php endif; ?>
                <small>Posted on <?php echo $post['created_at']; ?></small>
                
                <?php if (isset($_SESSION['user_id'])): // Check if user is logged in ?>
                    <div>
                        <a href="delete_post.php?id=<?php echo $post['id']; ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                    </div>
                <?php endif; ?>

                <h4>Comments:</h4>
                <form method="POST" action="add_comment.php">
                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                    <textarea name="comment" required></textarea>
                    <input type="submit" value="Add Comment">
                </form>
            </article>
        <?php endwhile; ?>
    </main>

    <footer>
        <p>&copy; 2024 My Blog</p>
    </footer>
</body>
</html>
