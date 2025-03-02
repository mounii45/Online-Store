<?php
include 'includes/db.php'; // like import

if ($conn) {
    echo "database connected successfully";
} else {
    echo "Failed to connect the database";
}
