<?php
session_start();
include "db.php";

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

/* 📚 Fetch Assignments */
$assignments = $conn->query("SELECT * FROM assignments");

/* 🔥 COUNT LOGIC (FIXED) */
$totalAssignments = $assignments->num_rows;

/* ✅ IMPORTANT FIX */
$submittedResult = $conn->query("
    SELECT COUNT(DISTINCT assignment_id) as total 
    FROM submissions 
    WHERE student_id='$student_id'
");

$submittedData = $submittedResult->fetch_assoc();
$submittedCount = $submittedData['total'];

$pendingCount = $totalAssignments - $submittedCount;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assignments</title>
    <link rel="stylesheet" href="assignment.css">
</head>

<body>

<div class="header">
    <a href="dashboard.php">⬅ Back</a>
    <h2> Assignment</h2>
</div>

<div style="display:flex; gap:10px; margin:15px;">
    
    <div style="flex:1; background:#007bff; color:white; padding:10px; border-radius:8px; text-align:center;">
        📚 Total: <?php echo $totalAssignments; ?>
    </div>

    <div style="flex:1; background:#28a745; color:white; padding:10px; border-radius:8px; text-align:center;">
        ✅ Submitted: <?php echo $submittedCount; ?>
    </div>

    <div style="flex:1; background:#dc3545; color:white; padding:10px; border-radius:8px; text-align:center;">
        ⏳ Pending: <?php echo $pendingCount; ?>
    </div>

</div>

<?php if($assignments->num_rows > 0) { ?>

    <?php while($row = $assignments->fetch_assoc()) { ?>

        <?php
        $assignment_id = $row['id'];

        $check = $conn->query("SELECT * FROM submissions 
                               WHERE student_id='$student_id' 
                               AND assignment_id='$assignment_id'");

        $isSubmitted = ($check->num_rows > 0);

        /* 🔥 ONLY FIX */
        $fileName = trim($row['file']); // space remove
        ?>

        <div class="card assignment-card" style="margin-bottom:15px;">

            <div style="
                padding:8px;
                margin-bottom:10px;
                border-radius:6px;
                font-weight:bold;
                color:white;
                background: <?php echo $isSubmitted ? '#28a745' : '#dc3545'; ?>;
            ">
                <?php echo $isSubmitted ? '✅ Submitted' : '⏳ Pending (“Download it and remember to submit!”)'; ?>
            </div>

            <h3><?php echo $row['title']; ?></h3>

            <p><?php echo $row['description']; ?></p>

            <p>📅 Deadline: <?php echo $row['deadline']; ?></p>

            <!-- 🔥 FIXED DOWNLOAD -->
            <a href="uploads/<?php echo $fileName; ?>" download>
                ⬇ Download Question
            </a>

            <br><br>

            <?php if(!$isSubmitted) { ?>
                <form action="submit_assignment.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="assignment_file" required>

                    <input type="hidden" name="assignment_id" value="<?php echo $row['id']; ?>">

                    <button type="submit">Submit Assignment</button>
                </form>
            <?php } else { ?>
                <button disabled style="
                    background: gray;
                    cursor: not-allowed;
                    padding:8px;
                    border:none;
                    border-radius:5px;
                    color:white;
                ">
                    Already Submitted
                </button>
            <?php } ?>

        </div>

    <?php } ?>

<?php } else { ?>

    <p style="text-align:center; color:red;">No assignments available</p>

<?php } ?>

</body>
</html>