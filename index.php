<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Shop</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #343a40;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .card {
            display: flex;
            flex-direction: column;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            display: flex;
            padding: 20px;
            flex: 1;
        }
        .card-body .left-column, .card-body .right-column {
            flex: 1;
        }
        .card-body .left-column {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card-body .left-column p {
            margin: 5px 0;
            font-size: 1em;
            color: #777;
        }
        .card-body .left-column .stars {
            font-size: 1.5em; /* Bigger stars */
            color: #ffd700; /* Gold color for stars */
        }
        .card-body .right-column {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-end;
        }
        .card-body .right-column .price {
            font-size: 1.4em;
            font-weight: bold;
            color: #e74c3c;
        }
        .card-body .right-column .taxes {
            font-size: 0.8em;
            color: #777;
            margin-top: -20px; /* Adjust to move it closer to the price */
        }
        .card-body .right-column .button-container {
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
            margin-top: auto;
        }
        button.addCart {
            padding: 10px 20px;
            font-size: 1em;
            color: white;
            background-color: #28a745;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
        }
        .card-footer button:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    $servername = "localhost"; // change this to your server name
    $username = "root"; // change this to your username
    $password = "rootpassword"; // change this to your password
    $dbname = "flowphone"; // change this to your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, brand, model, screen_size, storage, price, os, ratings, image_url FROM phones";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<div class='card'>";
            echo "<img src='" . $row["image_url"] . "' alt='" . $row["brand"] . " " . $row["model"] . "'>";
            echo "<div class='card-body'>";
            echo "<div class='left-column'>";
            echo "<h3>" . $row["brand"] . " " . $row["model"] . "</h3>";
            echo "<p>Screen Size: " . $row["screen_size"] . " in</p>";
            echo "<p>Storage: " . $row["storage"] . " GB</p>";
            echo "<p>OS: " . $row["os"] . "</p>";
            echo "<p class='stars'>" . str_repeat('★', $row["ratings"]) . str_repeat('☆', 5 - $row["ratings"]) . "</p>";
            echo "</div>";
            echo "<div class='right-column'>";
            echo "<p class='price'>€" . $row["price"] . "</p>";
            echo "<p class='taxes'>Taxes Included</p>";
            echo "<div class='button-container'>";
            echo "<button class='addCart' onclick='buyProduct(" . $row["id"] . ")'>Add to Cart</button>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>
</div>

<script>
    function buyProduct(id) {
        alert('Product with ID ' + id + ' has been added to your cart.');
        // Here you can add further functionality to handle the purchase
    }
</script>

</body>
</html>
