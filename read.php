<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Viewer</title>
    <!-- Load Firebase v8 SDKs required by your connection script -->
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-firestore.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-auth.js"></script>
    
    <!-- Include your connection file here -->
    <script src="firebase.js"></script>

    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .data-table th, .data-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        .data-table th { background-color: #f4f4f4; }
        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <h2>Database Collection Viewer</h2>
    <p>Viewing collection: <strong>admins</strong></p>
    
    <div id="error-message" class="error"></div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th>Document ID</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status (Active)</th>
            </tr>
        </thead>
        <tbody id="data-body">
            <tr>
                <td colspan="4">Loading data...</td>
            </tr>
        </tbody>
    </table>

    <script>
        // Wait for the window to load ensuring scripts are ready
        window.addEventListener('DOMContentLoaded', () => {
            // Check if the global object exists
            if (!window._9jaCash || !window._9jaCash.db) {
                document.getElementById('error-message').innerText = "Error: _9jaCash database object not initialized.";
                return;
            }

            const db = window._9jaCash.db;
            const tableBody = document.getElementById('data-body');

            // Reference your collection name here
            db.collection('admins').get()
                .then((querySnapshot) => {
                    tableBody.innerHTML = ''; // Clear loading state

                    if (querySnapshot.empty) {
                        tableBody.innerHTML = '<tr><td colspan="4">No documents found in this collection.</td></tr>';
                        return;
                    }

                    querySnapshot.forEach((doc) => {
                        const data = doc.data();
                        
                        // Create a row for each document
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${doc.id}</td>
                            <td>${data.email || 'N/A'}</td>
                            <td>${data.role || 'N/A'}</td>
                            <td>${data.isActive !== undefined ? data.isActive : 'N/A'}</td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch((error) => {
                    console.error("Error fetching documents: ", error);
                    document.getElementById('error-message').innerText = `Failed to read database: ${error.message}`;
                    tableBody.innerHTML = '<tr><td colspan="4" class="error">Error loading data. Check console or security rules.</td></tr>';
                });
        });
    </script>
</body>
</html>
