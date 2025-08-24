<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
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
        <a href="commod.php">Seconday Minerals Details</a>
        <a href="Login.php">Login</a>
        <a href="About.html">About</a>
    </nav>
    
    <section>
    
     <h1>Enter mineral composition</h1>

    <form method="get" action="search.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter name">

        <label for="column1"> Mineral Chemical Symbol:</label>
        <input type="text" id="chemistry" name="chemistry" placeholder="Enter Mineral Symbol">
        
        <label for="column1"> IMA Symbol:</label>
        <input type="text" id="IMA Symbol" name="IMA Symbol" placeholder="Enter IMA Symbol">
        
        <br>
        
        <label for="column1"> Strunz Class:</label>
        <input type="text" id="Strunz class" name="Strunz class" placeholder="Enter Strunz Class">
        
        <label for="column1"> Crystal System:</label>
        <input type="text" id="crystal system" name="crystal system" placeholder="Enter Crystal System">
        
        <label for="column1"> Color:</label>
        <input type="text" id="color" name="color" placeholder="Enter Mineral Color">
        
        <br>

        
        <label for="column1"> Cleavage:</label>
        <input type="text" id="cleavage" name="cleavage" placeholder="Enter Mineral Cleavage">
        
        <label for="column1"> Mohs:</label>
        <input type="text" id="mohs" name="mohs" placeholder="Enter mohs">
        
        <label for="column1"> Streak:</label>
        <input type="text" id="streak" name="streak" placeholder="Enter Streak">
        
        <label for="column1"> Gravity:</label>
        <input type="text" id="gravity" name="gravity" placeholder="Enter Gravity">
        
        <br>

        
        <label for="column1"> Luster:</label>
        <input type="text" id="luster" name="luster" placeholder="Enter Luster">
        
        <label for="column1"> Habit:</label>
        <input type="text" id="habit" name="habit" placeholder="Enter habit">
        
        <label for="column1"> Varieties:</label>
        <input type="text" id="varieties" name="varieties" placeholder="Enter Varieties">
        
        <br>

        <button type="submit">Search</button>
    </form>
        <?php

    include 'db_connection.php';

    $conditions = array();

    if (isset($_GET['name']) && $_GET['name'] !== '') {
        $conditions[] = "name LIKE '%" . mysqli_real_escape_string($conn, $_GET['name']) . "%'";
    }

    if (isset($_GET['chemistry']) && $_GET['chemistry'] !== '') {
        $conditions[] = "chemistry LIKE '%" . mysqli_real_escape_string($conn, $_GET['chemistry']) . "%'";
    }
        
    if (isset($_GET['IMA Symbol']) && $_GET['IMA Symbol'] !== '') {
        $conditions[] = "IMA Symbol LIKE '%" . mysqli_real_escape_string($conn, $_GET['IMA Symbol']) . "%'";
    }
        
    if (isset($_GET['Strunz class']) && $_GET['Strunz class'] !== '') {
        $conditions[] = "Strunz class LIKE '%" . mysqli_real_escape_string($conn, $_GET['Strunz class']) . "%'";
    }
        
    if (isset($_GET['crystal system']) && $_GET['crystal system'] !== '') {
        $conditions[] = "crystal system LIKE '%" . mysqli_real_escape_string($conn, $_GET['crystal system']) . "%'";
    }
        
    if (isset($_GET['color']) && $_GET['color'] !== '') {
        $conditions[] = "color LIKE '%" . mysqli_real_escape_string($conn, $_GET['color']) . "%'";
    }
        
    if (isset($_GET['cleavage']) && $_GET['cleavage'] !== '') {
        $conditions[] = "cleavage LIKE '%" . mysqli_real_escape_string($conn, $_GET['cleavage']) . "%'";
    }
        
    if (isset($_GET['mohs']) && $_GET['mohs'] !== '') {
        $conditions[] = "mohs LIKE '%" . mysqli_real_escape_string($conn, $_GET['mohs']) . "%'";
    }
        
    if (isset($_GET['streak']) && $_GET['streak'] !== '') {
        $conditions[] = "streak LIKE '%" . mysqli_real_escape_string($conn, $_GET['streak']) . "%'";
    }
        
    if (isset($_GET['gravity']) && $_GET['gravity'] !== '') {
        $conditions[] = "gravity LIKE '%" . mysqli_real_escape_string($conn, $_GET['gravity']) . "%'";
    }   
        
    if (isset($_GET['luster']) && $_GET['luster'] !== '') {
        $conditions[] = "luster LIKE '%" . mysqli_real_escape_string($conn, $_GET['luster']) . "%'";
    }   
        
    if (isset($_GET['habit']) && $_GET['habit'] !== '') {
        $conditions[] = "habit LIKE '%" . mysqli_real_escape_string($conn, $_GET['habit']) . "%'";
    }   
        
    if (isset($_GET['varieties']) && $_GET['varieties'] !== '') {
        $conditions[] = "varieties LIKE '%" . mysqli_real_escape_string($conn, $_GET['varieties']) . "%'";
    } 


    if (!empty($conditions)) {
            $sqlSearch = "SELECT * FROM database_2_minerals_cleaned WHERE " . implode(' AND ', $conditions);
            $resultSearch = $conn->query($sqlSearch);

            if ($resultSearch->num_rows > 0) {
                echo "<ul>";
                while ($row = $resultSearch->fetch_assoc()) {
                    echo "<li><a href='minerals.php?mineral={$row['name']}'>" . $row["name"] . "</a></li>";
                }
                echo "</ul>";

                // Display mineral details if 'mineral' is set in the URL
                if (isset($_GET['mineral'])) {
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
                }
            } else {
                echo "No matching results found.";
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
