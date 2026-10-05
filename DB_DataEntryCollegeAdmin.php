<!-- http://localhost/PlacementPro/Main_Code/DB_CollegeAdminDataEntry.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Admin Registration</title>
    <style>
        /* General Body Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        /* Form Container Styling */
        form {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
        }

        /* Form Title */
        .form-title {
            text-align: center;
            color: #333333;
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 24px;
            font-weight: 600;
        }

        /* Input Fields & Textarea */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        textarea {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #cccccc;
            border-radius: 6px;
            font-size: 16px;
            font-family: inherit;
            /* Textarea এর ফন্ট ঠিক রাখার জন্য */
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        /* Textarea Specific Styling */
        textarea {
            resize: vertical;
            min-height: 80px;
        }

        /* Input Focus Effect */
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        textarea:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.3);
        }

        /* Submit Button */
        button.submit-btn {
            background-color: #4a90e2;
            color: #ffffff;
            padding: 12px 15px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        /* Submit Button Hover */
        button.submit-btn:hover {
            background-color: #357abd;
        }
    </style>
</head>

<body>
    <form action="DB_ConnectionCollegeAdminTable.php" method="POST">
        <h2 class="form-title">College Admin Data Entry</h2>

        <input type="text" name="E_Id" placeholder="Employee ID" required>
        <input type="text" name="E_Name" placeholder="Employee Name" required>
        <input type="email" name="E_Email" placeholder="Employee Email" required>
        <input type="text" name="E_Phone" placeholder="Employee Phone" required>
        <input type="password" name="E_Password" placeholder="Password" required>

        <textarea name="E_Address" placeholder="Address" required></textarea>

        <button type="submit" name="submit" class="submit-btn">Register Admin</button>
    </form>
</body>

</html>