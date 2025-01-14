<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $student_name; ?> - Resume</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body {
            font-family: 'Verdana', sans-serif;
            background-color: #222;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .resume-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background-color: #333;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
        }

        header h1 {
            font-size: 40px;
            margin: 0;
            color: #f39c12;
        }

        header p {
            font-size: 18px;
            color: #ecf0f1;
        }

        section h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #f39c12;
        }

        section ul {
            list-style-type: none;
            padding: 0;
        }

        section ul li {
            margin: 5px 0;
            color: #ecf0f1;
        }

        footer {
            text-align: center;
            font-size: 14px;
            color: #bdc3c7;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="resume-container">
        <header>
            <h1><?php echo $student_name; ?></h1>
            <p><?php echo $student_profession; ?></p>
            <p>Email: <?php echo $student_email; ?></p>
            <p>Phone: <?php echo $student_phone; ?></p>
        </header>

        <section>
            <h2>Education</h2>
            <ul>
                <?php foreach ($education as $edu): ?>
                    <li><strong><?php echo $edu['degree']; ?></strong> at <?php echo $edu['university']; ?> (<?php echo $edu['start_date']; ?> - <?php echo $edu['end_date']; ?>)</li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section>
            <h2>Skills</h2>
            <ul>
                <?php foreach ($skills as $skill): ?>
                    <li><?php echo $skill; ?></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <footer>
            <p>Generated on: <?php echo date('Y-m-d'); ?></p>
        </footer>
    </div>
</body>
</html>
