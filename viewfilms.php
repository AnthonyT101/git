<!DOCTYPE html>
<!-- Author: Anthony
Date: 11/17/2023
File: Test 2
Purpose: Test 2
-->

<!-- I learned how to create the tables and connect to database with the help of 
the webstie https://www.siteground.com/tutorials/php-mysql/display-table-data/ -->

<html>
<head>
    <title>viewfilms.php</title>
	<!-- Table Style -->
	<style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>View Films</h1>
	<!-- Table Setup -->
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Rental Duration</th>
                <th>Rental Rate</th>
                <th>Length</th>
                <th>Category</th>
                <th>Number of Copies</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Connect to the Sakila database
            $host = 'localhost:3306';
			$username = 'anthony';
			$password = 'password123';
			$database = 'sakila';

            $connection = new mysqli($host, $username, $password, $database);

            // Get film details from the database using 'group by' command
            $sql = "SELECT film.title, film.description, film.rental_duration, film.rental_rate, film.length, category.name as category, COUNT(inventory.inventory_id) as num_copies 
                    FROM film 
                    INNER JOIN film_category ON film.film_id = film_category.film_id 
                    INNER JOIN category ON film_category.category_id = category.category_id 
                    INNER JOIN inventory ON film.film_id = inventory.film_id 
                    GROUP BY film.title ORDER BY film.title";

            $result = $connection->query($sql);
			
			// Fill in table data
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['title']."</td>";
                    echo "<td>".$row['description']."</td>";
                    echo "<td>".$row['rental_duration']."</td>";
                    echo "<td>".$row['rental_rate']."</td>";
                    echo "<td>".$row['length']."</td>";
                    echo "<td>".$row['category']."</td>";
                    echo "<td>".$row['num_copies']."</td>";
                    echo "</tr>";
                }
            }

            $connection->close();
            ?>
        </tbody>
    </table>
    
    <br>
	<!-- Return button -->
    <button onclick="window.location.href='controlpanel.html'">Go Back</button>
</body>
</html>
