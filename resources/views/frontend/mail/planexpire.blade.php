<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ecosansar</title>

    <style>
        body{
            font-family: 'EuclidFlex-Regular'!important;
        }

        a:link, a:visited {
          background-color: #f44336;
          color: white;
          padding: 14px 25px;
          text-align: center;
          text-decoration: none;
          display: inline-block;
        }

        a:hover, a:active {
          background-color: #8eb66f;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
          }

          td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
          }

          tr:nth-child(even) {
            background-color: #dddddd;
          }

        </style>
</head>
<body>
<section style="background-color:#edf2f7; padding: 81px 0px;">
    <div style="margin: 0px 40px; background-color:#ffffff;padding: 25px; border-radius: 10px;">
    <!--<h1 style="text-align: center;">Your Plan expire in 7 days</h1>-->
    <p>Hello {{ $user->name }},</p>
<p>Your trial plan will expire in {{ $daysLeft }} {{ $daysLeft > 1 ? 'days' : 'day' }}.</p>
<p>Please take necessary actions to renew your plan before the expiry date.</p>

    
    </div>

</section>
</body>
</html>

