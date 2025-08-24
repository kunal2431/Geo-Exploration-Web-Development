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
    
    <h1>Minerals Sites</h1>

    <?php
   
    include 'db_connection_sites.php';

    
    $sqlCountries = "SELECT DISTINCT country FROM database_1_best_mineral_ores_around_the_world_cleaned ORDER BY country ASC";
    $resultCountries = $conn->query($sqlCountries);

    if ($resultCountries->num_rows > 0) {
        echo "<form method='get' action='site.php'>";
        echo "<label for='country'>Select a Country:</label>";
        echo "<select id='country' name='country'>";
        echo "<option value='' selected>Select Country</option>";
        while ($rowCountry = $resultCountries->fetch_assoc()) {
            $selected = (isset($_GET['country']) && $_GET['country'] == $rowCountry['country']) ? 'selected' : '';
            echo "<option value='{$rowCountry['country']}' $selected>{$rowCountry['country']}</option>";
        }
        echo "</select>";
        echo "<button type='submit'>Show Sites</button>";
        echo "</form>";
    }

   
    if (isset($_GET['country']) && !empty($_GET['country'])) {
        $selectedCountry = mysqli_real_escape_string($conn, $_GET['country']);

        
        $rowsPerPage = 50;
        $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $offset = ($currentPage - 1) * $rowsPerPage;

        
        $sqlSites = "SELECT site_name FROM database_1_best_mineral_ores_around_the_world_cleaned WHERE country = '$selectedCountry' LIMIT $offset, $rowsPerPage";
        $resultSites = $conn->query($sqlSites);

        if ($resultSites->num_rows > 0) {
            echo "<ol>";
            while ($rowSite = $resultSites->fetch_assoc()) {
                echo "<li><a href='site.php?site_name={$rowSite['site_name']}'>{$rowSite['site_name']}</a></li>";
            }
            echo "</ol>";

            
            $sqlTotal = "SELECT COUNT(*) AS total FROM database_1_best_mineral_ores_around_the_world_cleaned WHERE country = '$selectedCountry'";
            $resultTotal = $conn->query($sqlTotal);
            $totalRows = $resultTotal->fetch_assoc()['total'];
            $totalPages = ceil($totalRows / $rowsPerPage);

            echo "<div>";
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<a href='site.php?country=$selectedCountry&page=$i'>$i</a> ";
            }
            echo "</div>";
        } else {
            echo "No sites found for the selected country.";
        }
    }

   
    if (isset($_GET['site_name']) && !empty($_GET['site_name'])) {
        $selectedSiteName = mysqli_real_escape_string($conn, $_GET['site_name']);

     
        $sqlDetails = "SELECT * FROM database_1_best_mineral_ores_around_the_world_cleaned WHERE site_name = '$selectedSiteName'";
        $resultDetails = $conn->query($sqlDetails);

        if ($resultDetails->num_rows > 0) {
            echo "<h2>Details for $selectedSiteName</h2>";
            echo "<ul>";
            $rowDetails = $resultDetails->fetch_assoc();
            foreach ($rowDetails as $key => $value) {
                echo "<li><strong>$key:</strong> $value</li>";
            }
            echo "</ul>";
        } else {
            echo "Site details not found.";
        }
    }

 
    $conn->close();
    ?>
     
    </section>

    <footer>
        &copy; Devloped by Kunal.P.Sangurmath for CS637.
    </footer>

</body>

</html>
