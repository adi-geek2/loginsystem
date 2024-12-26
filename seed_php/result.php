<?php
// Get the quality from GET parameter or default to 'Unknown'
$quality = isset($_GET['quality']) ? htmlspecialchars($_GET['quality']) : 'Unknown';
$score = isset($_GET['score']) ? htmlspecialchars($_GET['score']) : 'Unknown';

// Get the seed image path from GET parameter or default to a placeholder
$fileName = isset($_GET['image']) ? htmlspecialchars($_GET['image']) : 'Placeholder.jpg';
$seedImagePath = "../seed_php/uploads/" . $fileName;

// Determine the color class based on the quality
if ($quality === "Good Seed") {
    $colorClass = "text-success"; // Green for good quality
} elseif ($quality === "Bad Seed") {
    $colorClass = "text-danger"; // Red for bad quality
} else {
    $colorClass = "text-warning"; // Yellow for unknown quality
}

// Get the current date and time
date_default_timezone_set('Asia/Kolkata');
$currentDateTime = date("Y-m-d H:i:s");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seed Quality Results</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .image-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .image-container img {
            max-width: 100%; /* Fit image to container width */
            max-height: 500px; /* Restrict height */
            height: auto; /* Maintain aspect ratio */
            width: auto; /* Maintain aspect ratio */
            border: 1px solid #ddd; /* Optional border */
        }
        .result-box {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container text-center mt-5">
        <h1>Seed Quality Results</h1>

        <!-- Display Seed Image -->
        <div class="image-container">
            <h4>Uploaded Seed Image</h4>
            <img src="<?php echo $seedImagePath; ?>" alt="Seed Image">
        </div>


        <!-- Display Results -->
        <div class="card mt-3">
            <div class="card-body">
                <h3>Quality: <span class="<?php echo $colorClass; ?>"><?php echo $quality; ?></span></h3>
                <h3>Quality Score (0 to 1): <span class="<?php echo $colorClass; ?>"><?php echo $score; ?></span></h3>
                <p>Analysis performed on: <strong><?php echo $currentDateTime; ?></strong></p>
            </div>
        </div>

        <!-- Upload Another Image -->
        <a href="../seed_html/test_image.html" class="btn btn-primary mt-4">Upload Another Image</a>
        
        <!-- Add a blank line -->
        <br><br>

        <!-- Back to Profile Button -->
        <a href="../welcome.php" class="btn btn-secondary mb-3">
            <i class="fas fa-user"></i> Back to Profile
        </a>
    </div>
</body>
</html>
