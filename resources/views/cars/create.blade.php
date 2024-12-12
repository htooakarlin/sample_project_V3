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

            button{
                padding: 8px 15px;
                border: none;
                border-radius: 4px;
                background: #451cda;
                font-weight: bold;
                color: white;
            }
            button:hover{
                background-color:#745dc7; 
            }

            #selectedID_area{
                display:flex;
                align-items: center;
            }
            #selectedID_area button{
                padding: 8px 15px;
                height: auto; 
            }
            #selectedID{
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

            * {
                box-sizing: border-box;
            }
            /* Add padding to containers */
            .container {
                padding: 16px;
                background-color: white;
            }

            /* Full-width input fields */
            input[type=text], input[type=number] {
                width: 100%;
                padding: 15px;
                margin: 5px 0 22px 0;
                display: inline-block;
                border: none;
                background: #f1f1f1;
            }

            input[type=text]:focus, input[type=number]:focus {
                background-color: #ddd;
                outline: none;
            }

            /* Overwrite default styles of hr */
            hr {
                border: 1px solid #f1f1f1;
                margin-bottom: 25px;
            }

            /* Set a style for the submit button */
            .registerbtn {
                background-color: #451cda;
                color: white;
                padding: 16px 20px;
                margin: 8px 0;
                border: none;
                cursor: pointer;
                width: 100%;
                opacity: 0.9;
            }

            .registerbtn:hover {
                opacity: 1;
            }

        </style>
    </head>
    <body>
        <ul>
            <li><a href="/cars">Cars</a></li>
            <li><a href="/users">Users</a></li>
        </ul>

        <form method="post">
            @csrf
            <div class="container">
                <h1>Create Car</h1>
                <hr>
            
                <label for="model"><b>Model</b></label>
                <input type="text" placeholder="Enter Car Model" name="model" id="model" required>

                <label for="make"><b>Make</b></label>
                <input type="text" placeholder="Enter Make" name="make" id="make" required>

                <label for="price"><b>Price</b></label>
                <input type="text" placeholder="Enter Price" name="price" id="price" required>

                <label for="year"><b>Year</b></label>
                <input type="number" placeholder="Enter Year" name="year" id="year" value="2000" min="1900" max="2100">
            
                <hr>
            
                <button type="submit" class="registerbtn">Create</button>
            </div>
        </form>

    </body>
</html>

