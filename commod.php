<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoExploration</title>
    <link rel="stylesheet" href="Style.css">
    <style>
        section table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; 
        }

        

        section ul {
            list-style: none;
            padding: 0;
        }

        section li {
            margin-bottom: 10px;
        }

        section strong {
            display: inline-block;
            width: 120px; 
            font-weight: bold;
        }

     
        section {
            line-height: 1.6;
        }

        section a {
            color: #007bff;
            text-decoration: none;
        }

        section a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <header>
        <h1>GeoExploration</h1>
    </header>

    <nav>
        <a href="Main.html">Home</a>
        <a href="Minerals.php">Minerals</a>
        <a href="search.php">Minerals Composition Search</a>
        <a href="site.php">Site Details</a>
        <a href="commod.php">Seconday Minerals Details</a>
        <a href="Login.php">Login</a>
        <a href="About.html">About</a>
    </nav>

    <section>
        
        <form method="get" action="commod.php">
            <label for="commod1">Enter Primary Mineral:</label>
            <input type="text" id="commod1" name="commod1" required>
            <button type="submit">Submit</button>
        </form>
        <?php
        include 'db_connection.php';

if (isset($_GET['commod1'])) {

    $selectedCommod1 = mysqli_real_escape_string($conn, $_GET['commod1']);
    $sqlDetails = "SELECT DISTINCT commod2, commod3 FROM database_1_best_mineral_ores_around_the_world_cleaned WHERE commod1 = '$selectedCommod1'";
    $resultDetails = $conn->query($sqlDetails);

    if ($resultDetails->num_rows > 0) {
        echo "<h2>Primary Mineral: $selectedCommod1</h2>";
        echo "<ul>";

        $distinctCommod2 = [];
        $distinctCommod3 = [];

        while ($row = $resultDetails->fetch_assoc()) {
           
            $commod2Values = array_filter(array_map('trim', explode(',', $row['commod2'])));
            $commod3Values = array_filter(array_map('trim', explode(',', $row['commod3'])));

            $distinctCommod2 = array_merge($distinctCommod2, $commod2Values);
            $distinctCommod3 = array_merge($distinctCommod3, $commod3Values);
        }

    
        $distinctCommod2 = array_values(array_unique($distinctCommod2));
        $distinctCommod3 = array_values(array_unique($distinctCommod3));

        echo "<li><strong>Secondary Compound:</strong> " . implode(', ', $distinctCommod2) . "</li>";
        echo "<li><strong>Tertiary Compund:</strong> " . implode(', ', $distinctCommod3) . "</li>";
        echo "</ul>";
    } else {
        echo "No details found for Primary Compund: $selectedCommod1";
    }
} elseif (isset($_GET['search'])) {
    
    $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
    $sqlSearch = "SELECT DISTINCT commod1 FROM database_1_best_mineral_ores_around_the_world_cleaned WHERE commod1 LIKE '%$searchTerm%'";
    $resultSearch = $conn->query($sqlSearch);

    if ($resultSearch->num_rows > 0) {
        echo "<h2>Search Results:</h2>";
        echo "<ul>";

        while ($row = $resultSearch->fetch_assoc()) {
            echo "<li><a href='commod.php?commod1={$row['commod1']}'>" . $row["commod1"] . "</a></li>";
        }

        echo "</ul>";
    } else {
        echo "No results found.";
    }
}


$conn->close();
        ?>

    </section>

    <footer>
        &copy; Developed by Kunal.P.Sangurmath for CS637.
    </footer>

</body>

</html>
