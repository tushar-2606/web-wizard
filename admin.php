<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<style>
    /* Global Styles */
    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #a1c4fd, #c2e9fb);
        min-height: 100vh;
        color: #333;
    }

    .navbar {
        display: flex;
        gap: 20px;
        padding: 15px 40px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 30px rgba(0,0,0,0.1);
    }

    .navbar a {
        text-decoration: none;
        color: #fff;
        font-weight: 600;
        transition: 0.3s;
    }

    .navbar a:hover {
        text-shadow: 0 0 8px rgba(255,255,255,0.9);
    }

    .container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 30px;
        background: rgba(255,255,255,0.25);
        border-radius: 20px;
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }

    h1 {
        text-align: center;
        margin-bottom: 40px;
        font-weight: 600;
        color: #1e3c72;
        text-shadow: 1px 1px 5px rgba(0,0,0,0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    th, td {
        padding: 15px;
        text-align: left;
        transition: 0.3s;
    }

    th {
        background: linear-gradient(90deg, #ffb347, #ffcc33);
        color: #fff;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    tbody tr {
        background: rgba(255,255,255,0.7);
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 12px;
        margin-bottom: 10px;
        display: table-row; 
    }

    tbody tr:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }

    .status-registered {
        background: linear-gradient(135deg, #a8ff78, #78ffd6);
        color: #2E7D32;
        font-weight: 600;
        text-align: center;
        border-radius: 12px;
        padding: 6px 12px;
        box-shadow: 0 4px 15px rgba(46,125,50,0.2);
    }

    .status-waiting {
        background: linear-gradient(135deg, #fff8dc, #fffacd, #fdfd96
);
        color: #8D6E63;
        font-weight: 600;
        text-align: center;
        border-radius: 12px;
        padding: 6px 12px;
        box-shadow: 0 4px 15px rgba(141,110,99,0.2);
    }

</style>
</head>
<body>

<div class="navbar">
    <a href="index.php">Home</a>
    <a href="index.php">Logout</a>
</div>

<div class="container">
    <h1>Admin Dashboard</h1>

    <?php
    // Demo participants data
    $participants = [
        ['event_name'=>'Tech Talk 2025','name'=>'Student1','email'=>'student1@example.com','phone'=>'1234567890','status'=>'registered'],
        ['event_name'=>'Tech Talk 2025','name'=>'Student2','email'=>'student2@example.com','phone'=>'1234567891','status'=>'registered'],
        ['event_name'=>'Tech Talk 2025','name'=>'Student3','email'=>'student3@example.com','phone'=>'1234567892','status'=>'registered'],
        ['event_name'=>'Tech Talk 2025','name'=>'Student4','email'=>'student4@example.com','phone'=>'1234567893','status'=>'waiting'],
        ['event_name'=>'Workshop AI Basics','name'=>'Student5','email'=>'student5@example.com','phone'=>'1234567894','status'=>'registered'],
        ['event_name'=>'Workshop AI Basics','name'=>'Student3','email'=>'student3@example.com','phone'=>'1234567892','status'=>'waiting'],
    ];
    ?>

    <table>
        <thead>
            <tr>
                <th>Event</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($participants as $p): ?>
            <tr>
                <td><?= $p['event_name'] ?></td>
                <td><?= $p['name'] ?></td>
                <td><?= $p['email'] ?></td>
                <td><?= $p['phone'] ?></td>
                <td class="status-<?= $p['status'] ?>"><?= ucfirst($p['status']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

</body>
</html>
