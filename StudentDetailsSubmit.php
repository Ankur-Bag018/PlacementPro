<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlacementPro - Academic Details</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* The SINGLE div container for the entire form */
        .form-container {
            background-color: #ffffff;
            width: 100%;
            max-width: 800px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        /* Use CSS Grid directly on the form to create 2 columns without divs */
        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px 20px;
        }

        /* Wrapping the inputs inside the label acts as a single grid item */
        label {
            display: flex;
            flex-direction: column;
            font-weight: 600;
            color: #555;
            font-size: 14px;
        }

        input, select {
            margin-top: 6px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
            background-color: #fafafa;
            transition: border-color 0.3s;
        }

        input:focus, select:focus {
            border-color: #007bff;
            outline: none;
            background-color: #fff;
        }

        input[type="file"]::file-selector-button {
            padding: 5px 10px;
            border-radius: 4px;
            border: 1px solid #007bff;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            margin-right: 10px;
        }

        /* Helper classes to make certain elements span across both columns */
        .full-width {
            grid-column: 1 / -1;
        }

        .section-title {
            margin-top: 15px;
            margin-bottom: 5px;
            color: #007bff;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 5px;
            font-size: 18px;
        }

        .submit-btn {
            padding: 14px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 15px;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        /* Responsive design: switch to 1 column on smaller screens */
        @media (max-width: 600px) {
            form {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- ONLY ONE DIV -->
    <div class="form-container">
        <h2>Student Academic Details</h2>
        
        <!-- enctype required for Resume upload -->
        <form action="submit_academic_details.php" method="POST" enctype="multipart/form-data">
            
            <label>College ID
                <input type="text" name="college_id" placeholder="Enter College ID" required>
            </label>

            <label>Registration No
                <input type="text" name="registration_no" placeholder="Enter Registration No" required>
            </label>

            <label>Roll No
                <input type="text" name="roll_no" placeholder="Enter Roll No" required>
            </label>

            <label>Email ID
                <input type="email" name="email_id" placeholder="Enter Email ID" required>
            </label>

            <label>Date of Birth
                <input type="date" name="dob" required>
            </label>

            <label>Department
                <select name="department" required>
                    <option value="" disabled selected>Select Department</option>
                    <option value="BCA">BCA</option>
                    <option value="B.Tech CS">B.Tech CS</option>
                    <option value="B.Tech IT">B.Tech IT</option>
                    <option value="MCA">MCA</option>
                    <option value="BBA">BBA</option>
                </select>
            </label>

            <label>Year
                <select name="year" required>
                    <option value="" disabled selected>Select Year</option>
                    <option value="1st Year">1st Year</option>
                    <option value="2nd Year">2nd Year</option>
                    <option value="3rd Year">3rd Year</option>
                    <option value="4th Year">4th Year</option>
                </select>
            </label>

            <label>Semester
                <select name="semester" required>
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
            </label>

            <label>Section
                <input type="text" name="section" placeholder="e.g., A, B, or C">
            </label>

            <label>Active Backlog(s)
                <input type="number" name="active_backlog" placeholder="0 if none" min="0" required>
            </label>

            <h3 class="full-width section-title">Academic Grades</h3>

            <label>1st Sem SGPA <input type="number" step="0.01" max="10" name="sgpa_1"></label>
            <label>2nd Sem SGPA <input type="number" step="0.01" max="10" name="sgpa_2"></label>
            <label>3rd Sem SGPA <input type="number" step="0.01" max="10" name="sgpa_3"></label>
            <label>4th Sem SGPA <input type="number" step="0.01" max="10" name="sgpa_4"></label>
            <label>5th Sem SGPA <input type="number" step="0.01" max="10" name="sgpa_5"></label>
            <label>6th Sem SGPA <input type="number" step="0.01" max="10" name="sgpa_6"></label>
            <label>7th Sem SGPA <input type="number" step="0.01" max="10" name="sgpa_7"></label>
            <label>8th Sem SGPA <input type="number" step="0.01" max="10" name="sgpa_8"></label>

            <label class="full-width">Overall CGPA
                <input type="number" step="0.01" max="10" name="cgpa" placeholder="Enter Current CGPA" required>
            </label>

            <h3 class="full-width section-title">Documents</h3>

            <label class="full-width">Resume Upload (PDF Only)
                <input type="file" name="resume" accept=".pdf" required>
            </label>

            <button type="submit" class="submit-btn full-width">Submit Profile Details</button>
            
        </form>
    </div>

</body>
</html>