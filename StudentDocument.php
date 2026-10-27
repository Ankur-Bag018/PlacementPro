<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlacementPro - Document Submission</title>
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

        /* The single div container */
        .form-container {
            background-color: #ffffff;
            width: 100%;
            max-width: 600px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
        }

        /* Styling for the important note */
        .note-box {
            background-color: #fff3cd;
            color: #856404;
            padding: 12px;
            border-left: 4px solid #ffeeba;
            margin-bottom: 25px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 4px;
            line-height: 1.5;
        }

        label {
            display: block;
            font-weight: 600;
            color: #555;
            margin: 15px 0 5px 0;
        }

        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px dashed #ccc;
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
            background-color: #fafafa;
            cursor: pointer;
            transition: border-color 0.3s;
        }

        input[type="file"]:focus {
            border-color: #007bff;
            outline: none;
        }

        /* Custom file input styling for better UX */
        input[type="file"]::file-selector-button {
            padding: 6px 12px;
            border-radius: 4px;
            border: 1px solid #007bff;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            margin-right: 10px;
            transition: background-color 0.3s;
        }

        input[type="file"]::file-selector-button:hover {
            background-color: #0056b3;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 25px;
        }

        .submit-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <!-- The single div used for the form -->
    <div class="form-container">
        <h2>Submit Documents</h2>
        
        <p class="note-box">
            Note: Accept Only College verify Document and all document have under 2mb.
        </p>
        
        <!-- enctype="multipart/form-data" is strictly required for file uploads -->
        <form action="upload_documents.php" method="POST" enctype="multipart/form-data">
            
            <label for="reg_card">University Registration Card</label>
            <input type="file" id="reg_card" name="reg_card" accept=".pdf, .jpg, .jpeg" required>

            <label for="sem_results">All Semester Results</label>
            <input type="file" id="sem_results" name="sem_results" accept=".pdf, .jpg, .jpeg" required>

            <label for="aadhar_card">Aadhar Card</label>
            <input type="file" id="aadhar_card" name="aadhar_card" accept=".pdf, .jpg, .jpeg" required>

            <label for="college_id">College Id Card</label>
            <input type="file" id="college_id" name="college_id" accept=".pdf, .jpg, .jpeg" required>

            <label for="marksheet_10_12">10th & 12th Marks Sheet</label>
            <input type="file" id="marksheet_10_12" name="marksheet_10_12" accept=".pdf, .jpg, .jpeg" required>

            <label for="admit_10_12">10th & 12th Admit Card</label>
            <input type="file" id="admit_10_12" name="admit_10_12" accept=".pdf, .jpg, .jpeg" required>

            <label for="passport_photo">Passport Size Photo</label>
            <input type="file" id="passport_photo" name="passport_photo" accept=".pdf, .jpg, .jpeg" required>

            <button type="submit" class="submit-btn">Upload Documents</button>
            
        </form>
    </div>

</body>
</html>