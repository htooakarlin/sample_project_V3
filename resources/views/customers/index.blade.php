<!DOCTYPE html>
<html>
    <head>
        <style>
            ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
                background-color: #333;
            }

            li {
                float: left;
            }

            li a {
                display: block;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
            }

            li a:hover {
                background-color: #111;
            }

            .selected {
                background-color: rgb(165, 214, 238);
            }

            button {
                padding: 8px 15px;
                border: none;
                border-radius: 4px;
                background: #451cda;
                font-weight: bold;
                color: white;
            }
            button:hover {
                background-color: #745dc7;
            }

            #selectedID_area {
                display: flex;
                align-items: center;
            }
            #selectedID_area button {
                padding: 8px 15px;
                height: auto;
            }
            #selectedID {
                padding-right: 10px;
            }

            #usersTable {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 10px;
            }

            #usersTable td, #usersTable th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #usersTable th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #098cc4;
                color: white;
            }

            #CarsOfUserTable {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 10px;
            }

            #CarsOfUserTable td, #CarsOfUserTable th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #CarsOfUserTable th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #451cda;
                color: white;
            }
        </style>
    </head>
    <body>
        <ul>
            <li><a href="/cars">Cars</a></li>
            <li><a href="/users">Users</a></li>
        </ul>

        <h1>Users</h1>

        <table id="usersTable">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
            </tr>
            @foreach ($customers as $customer)
                <tr data-id="{{ $customer->id }}">
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->phone }}</td>
                </tr>
            @endforeach
        </table>

        <button id="create_btn" onclick="location.href='/users/create';">Create User</button>

        <div id="selectedID_area" style="visibility: hidden;">
            <h3 id="selectedID">Selected User ID: </h3>
            <button id="cancel_btn" onclick="cancel()">Cancel</button>
        </div>

        <div id="btns_area" style="visibility: hidden;">
            <button id="edit_btn">Edit</button>
            <button id="delete_btn">Delete</button>
        </div>

        <div id="belongCars" style="display: none">
            <h1>The Cars belongs to User</h1>

            <table id="CarsOfUserTable">
                <tr>
                    <th>ID</th>
                    <th>Model</th>
                    <th>Make</th>
                    <th>Price</th> 
                    <th>Year</th>
                    <th>Purchase-Date</th>
                </tr>
                <!-- <tr data-id="1">
                    <td>1</td>
                    <td>Revuelto</td>
                    <td>Lamborghini</td>
                    <td>$2000000</td>
                    <td>2024</td>
                </tr>
                <tr data-id="2">
                    <td>2</td>
                    <td>Roma</td>
                    <td>Ferrari</td>
                    <td>$1000000</td>
                    <td>2020</td>
                    <th>Customer ID</th>
                    <th>Car ID</th>
                    <th>Purchase Date</th>
                </tr> -->
            </table>
            <button id="buyCar_btn">Buy Car</button>
            <button id="buyCar_edit_btn">Edit</button>
        </div>

        <script>
            const table = document.getElementById("usersTable");
            const selectedID_area = document.getElementById("selectedID_area");
            const selectedItemText = document.getElementById("selectedID");
            const createBtn = document.getElementById('create_btn');
            const cancelBtn = document.getElementById("cancel_btn");
            const btns_area = document.getElementById("btns_area");

            const buyCar_btn = document.getElementById("buyCar_btn");
            const edit_btn = document.getElementById("edit_btn");
            const delete_btn = document.getElementById("delete_btn");
            const buyCar_edit_btn = document.getElementById("buyCar_edit_btn");

            const belongCars = document.getElementById("belongCars");
            const carsTable = document.getElementById("CarsOfUserTable");
            
            const cancel = () => {
                document.querySelectorAll("tr.selected").forEach(row => row.classList.remove("selected"));
                createBtn.style.display = 'block';
                selectedItemText.textContent = 'Selected User ID: ';
                selectedID_area.style.visibility = 'hidden';
                btns_area.style.visibility = 'hidden';
                belongCars.style.display = 'none';
            }

            table.addEventListener("click", (event) => {
                const clickedRow = event.target.closest("tr");
                if (!clickedRow || !clickedRow.hasAttribute("data-id")) return;

                document.querySelectorAll("tr.selected").forEach(row => row.classList.remove("selected"));
                createBtn.style.display = 'none';
                cancelBtn.style.display = 'block';
                selectedID_area.style.visibility = 'visible';
                btns_area.style.visibility = 'visible';
                belongCars.style.display = 'block';

                clickedRow.classList.add("selected");
                const selectedID = clickedRow.getAttribute("data-id");

                fetch(`/users/${selectedID}/purchases`)
                    .then(response => response.json())
                    .then(data => {
                        // Clear existing rows except the header
                        carsTable.querySelectorAll('tr:not(:first-child)').forEach(row => row.remove());

                        // Add rows for each purchase
                        data.forEach(purchase => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${purchase.id}</td>
                                <td>${purchase.model}</td>
                                <td>${purchase.make}</td>
                                <td>${purchase.price}</td>
                                <td>${purchase.year}</td>
                                <td>${purchase.purchase_date}</td>
                            `;
                            carsTable.appendChild(row);
                        });
                    })
                    .catch(error => console.error('Error fetching purchases:', error));

                edit_btn.onclick = function() {
                    window.location.href = `/users/edit/${selectedID}`;
                }
                delete_btn.onclick = function() {
                    window.location.href = `/users/delete/${selectedID}`;
                }
                buyCar_btn.onclick = function() {
                    window.location.href = `/articles/users/${selectedID}/buyCar/`;
                }
                buyCar_edit_btn.onclick = function() {
                    window.location.href = `/articles/users/${selectedID}/ownCar/edit/`;
                }

                selectedItemText.textContent = `Selected User ID: ${selectedID}`;
            });
        </script>
    </body>
</html>
