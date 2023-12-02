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
    <title>viewrentals.php</title>
	<!-- Table style -->
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
    <h1>View Rentals</h1>
	<!-- Table setup -->
    <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Film Title</th>
                <th>Inventory ID</th>
                <th>Rental Date</th>
                <th>Return Date</th>
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

            // Get rentals from the database
            $sql = "SELECT customer.first_name, customer.last_name, film.title, rental.inventory_id, rental.rental_date, rental.return_date
                    FROM rental
                    INNER JOIN inventory ON rental.inventory_id = inventory.inventory_id
                    INNER JOIN customer ON rental.customer_id = customer.customer_id
                    INNER JOIN film ON inventory.film_id = film.film_id
                    ORDER BY customer.last_name";

            $result = $connection->query($sql);
			
			// Used this website to get some help on ways to display the row count even though not required.
			// https://www.geeksforgeeks.org/how-to-count-rows-in-mysql-table-in-php/
			
			// Display the number of rows in rental. 16,044
			$count_sql_row = "SELECT COUNT(*) as total_rows FROM rental";
			$results = $connection->query($count_sql_row);
			$counted_row = $results->fetch_assoc();
			$total_rows = $counted_row['total_rows'];

			echo "<p>Total Rows of Films: " . $total_rows . "</p>";

			// Fill in table data
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['first_name']."</td>";
                    echo "<td>".$row['last_name']."</td>";
                    echo "<td>".$row['title']."</td>";
                    echo "<td>".$row['inventory_id']."</td>";
                    echo "<td>".$row['rental_date']."</td>";
                    echo "<td>".$row['return_date']."</td>";
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
