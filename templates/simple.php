<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($student_name); ?> - Resume</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script>
        function printResume() {
            window.print(); // Print the resume
        }
    </script>
</head>
<body>
    <div class="resume-container">
        <header>
            <h1><?php echo htmlspecialchars($student_name); ?></h1>
            <p><?php echo htmlspecialchars($student_profession ?: 'Not Provided'); ?></p>
            <p>Email: <?php echo htmlspecialchars($student_email ?: 'Not Provided'); ?></p>
            <p>Phone: <?php echo htmlspecialchars($student_phone ?: 'Not Provided'); ?></p>
        </header>

        <section>
            <h2>Education</h2>
            <?php if (!empty($education) && is_array($education)): ?>
                <ul>
                    <?php foreach ($education as $edu): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($edu['degree'] ?? 'Degree Not Specified'); ?></strong>
                            at <?php echo htmlspecialchars($edu['university'] ?? 'University Not Provided'); ?>
                            (<?php echo htmlspecialchars($edu['start_date'] ?? 'Unknown'); ?> - <?php echo htmlspecialchars($edu['end_date'] ?? 'Present'); ?>)
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No education details provided.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Skills</h2>
            <?php if (!empty($skills) && is_array($skills)): ?>
                <ul>
                    <?php foreach ($skills as $skill): ?>
                        <li><?php echo htmlspecialchars($skill); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No skills provided.</p>
            <?php endif; ?>
        </section>

        <footer>
            <p>Generated on: <?php echo date('Y-m-d'); ?></p>
        </footer>

        <!-- Print & Edit Buttons -->
        <div class="resume-buttons">
            <button onclick="printResume()">🖨 Print Resume</button>
            <a href="edit.php?id=<?php echo htmlspecialchars($id); ?>" class="btn-edit">✏ Edit Resume</a>
        </div>
    </div>
</body>
</html>
