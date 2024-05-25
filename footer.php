<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #footer {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 80px;
            background: linear-gradient(100deg, grey, grey);
            color: white;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            font-family: 'Arial', sans-serif;
        }

        #footer b {
            font-size: 18px;
        }

        #footer center {
            margin: 0;
        }

        @media screen and (max-width: 600px) {
            #footer {
                height: auto;
                padding: 20px;
            }

            #footer b {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div id="footer">
        <b>
            <center>
                COPYRIGHT © 2024<br>
                Blood Bank Management System<br>
                ALL RIGHTS RESERVED.
            </center>
        </b>
    </div>
</body>

</html>
