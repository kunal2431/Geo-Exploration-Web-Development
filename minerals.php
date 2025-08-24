<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minerals</title>
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
        <h1>Geo-Exploration</h1>
    </header>

    <nav>
        <a href="Main.html">Home</a>
        <a href="Minerals.php">Minerals</a>
        <a href="search.php">Minerals Composition Search</a>
        <a href="site.php">Site Details</a>
        <a href="commod.php">Secondary Minerals Details</a>
        <a href="Login.php">Login</a>
        <a href="About.html">About</a>
    </nav>

    <section>
        <form method="get" action="minerals.php">
            <label for="search">Search Mineral:</label>
            <input type="text" id="search" name="search" placeholder="Enter mineral name">
            <button type="submit">Search</button>
        </form>
        <?php
      
        include 'db_connection.php';

        if (isset($_GET['search'])) {
            $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
            $sqlSearch = "SELECT name FROM database_2_minerals_cleaned WHERE name LIKE '%$searchTerm%'";
            $resultSearch = $conn->query($sqlSearch);

            if ($resultSearch->num_rows > 0) {
                echo "<ul>";
                while ($row = $resultSearch->fetch_assoc()) {
                    echo "<li><a href='minerals.php?mineral={$row['name']}'>" . $row["name"] . "</a></li>";
                }
                echo "</ul>";
            } else {
                echo "Element not found.";
            }

            $conn->close();
        } else if (isset($_GET['mineral'])) { 
            $selectedMineral = mysqli_real_escape_string($conn, $_GET['mineral']);

            $sqlDetails = "SELECT * FROM database_2_minerals_cleaned WHERE name = '$selectedMineral'";
            $resultDetails = $conn->query($sqlDetails);

            if ($resultDetails->num_rows > 0) {
                echo "<ul>";
                while ($row = $resultDetails->fetch_assoc()) {
                    foreach ($row as $key => $value) {
                        echo "<li><strong>$key:</strong> $value</li>";
                    }
                }
                echo "</ul>";
            } else {
                echo "Mineral details not found.";
            }

            $sqlSites = "SELECT site_name FROM database_1_best_mineral_ores_around_the_world_cleaned WHERE commod1 = '$selectedMineral'";
            $resultSites = $conn->query($sqlSites);

            if ($resultSites->num_rows > 0) {
                echo "<h3>List of Site Names for $selectedMineral:</h3>";
                echo "<ul>";
                while ($rowSite = $resultSites->fetch_assoc()) {
                    echo "<li><a href='site.php?site_name={$rowSite['site_name']}'>" . $rowSite["site_name"] . "</a></li>";
                }
                echo "</ul>";
            } else {
                echo "No sites found for the selected mineral.";
            }

            $conn->close();
        } else {
            $rowsPerPage = 50;
            $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $offset = ($currentPage - 1) * $rowsPerPage;

            $sql = "SELECT name FROM database_2_minerals_cleaned LIMIT $offset, $rowsPerPage";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<ol>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li><a href='minerals.php?mineral={$row['name']}'>" . $row["name"] . "</a></li>";
                }
                echo "</ol>";

                $sqlTotal = "SELECT COUNT(*) AS total FROM database_2_minerals_cleaned";
                $resultTotal = $conn->query($sqlTotal);
                $totalRows = $resultTotal->fetch_assoc()['total'];
                $totalPages = ceil($totalRows / $rowsPerPage);

                echo "<div>";
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<a href='minerals.php?page=$i'>$i</a> ";
                }
                echo "</div>";
            } else {
                echo "0 results";
            }

            $conn->close();
        }
        ?>

    </section>

    <footer>
        &copy; Developed by Kunal.P.Sangurmath for CS637.
    </footer>

</body>

</html>
