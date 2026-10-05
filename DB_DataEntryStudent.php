<!-- http://localhost/PlacementPro/Main_Code/DB_StudentDataEntry.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        /* General Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Center the form on the page */
        body {
            background-color: #eef2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Form Container Styling */
        form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            max-width: 800px;
            width: 100%;
            /* Using CSS Grid for a 2-column layout */
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        /* Form Title */
        .form-title {
            grid-column: span 2;
            text-align: center;
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 24px;
            font-weight: 600;
        }

        /* Input and Select styling */
        input[type="text"],
        input[type="password"],
        input[type="number"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            background-color: #f9fafb;
            outline: none;
            transition: all 0.3s ease;
            color: #333;
        }

        /* Hover and Focus states for inputs and selects */
        input:focus, 
        select:focus,
        textarea:focus {
            border-color: #3b82f6;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        /* Make Textarea span both columns */
        textarea {
            grid-column: span 2;
            resize: vertical;
            min-height: 100px;
        }

        /* Submit Button Styling */
        input[type="submit"] {
            grid-column: span 2;
            background-color: #3b82f6;
            color: white;
            font-size: 16px;
            font-weight: 600;
            padding: 14px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease, transform 0.1s ease;
        }

        input[type="submit"]:hover {
            background-color: #2563eb;
        }

        input[type="submit"]:active {
            transform: scale(0.98);
        }

        /* Responsive Design: Switch to 1 column on smaller screens */
        @media (max-width: 640px) {
            form {
                grid-template-columns: 1fr;
            }
            .form-title, 
            textarea, 
            input[type="submit"] {
                grid-column: span 1;
            }
        }
    </style>
</head>
<body>
    <form action="DB_ConnectionStudentTable.php" method="POST">
        <h2 class="form-title">Student Registration</h2>
        
        <input type="text" name="S_Id" placeholder="Student ID" required>
        <input type="text" name="S_Roll" placeholder="Roll Number" required>
        <input type="password" name="S_Password" placeholder="Password" required>
        <input type="text" name="S_RegNo" placeholder="Registration Number">
        <input type="text" name="S_Name" placeholder="Name">
        <input type="text" name="S_Course" placeholder="Course">
        
        <!-- Changed to Select Dropdown for Year -->
        <select name="S_Year">
            <option value="" disabled selected>Select Year</option>
            <option value="1st">1st Year</option>
            <option value="2nd">2nd Year</option>
            <option value="3rd">3rd Year</option>
            <option value="4th">4th Year</option>
        </select>

        <!-- Changed to Select Dropdown for Semester -->
        <select name="S_Sem">
            <option value="" disabled selected>Select Semester</option>
            <option value="1">1st Semester</option>
            <option value="2">2nd Semester</option>
            <option value="3">3rd Semester</option>
            <option value="4">4th Semester</option>
            <option value="5">5th Semester</option>
            <option value="6">6th Semester</option>
            <option value="7">7th Semester</option>
            <option value="8">8th Semester</option>
        </select>

        <input type="number" step="0.01" name="S_CGPA" placeholder="CGPA">
        <input type="text" name="S_Phone" placeholder="Phone Number">
        <input type="email" name="S_Email" placeholder="Email">
        <input type="number" name="S_Active_Backlog" placeholder="Active Backlog">
        <input type="number" step="0.01" name="S_1stYGPA" placeholder="1st Year GPA">
        <input type="number" step="0.01" name="S_2ndYGPA" placeholder="2nd Year GPA">
        <input type="number" step="0.01" name="S_3rdYGPA" placeholder="3rd Year GPA">
        <input type="number" step="0.01" name="S_4thYGPA" placeholder="4th Year GPA">
        <textarea name="S_Address" placeholder="Address"></textarea>
        
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>