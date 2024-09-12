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
    
    <p>Dear {{$name}},</p><br>
    
    <p>This is a reminder that your listing ______ will be deactivated in 1 days. We hope you have
        made a connection for this listing! <br><br>
        
        <!--<a href="https://ecosansar.com/consumer_login">Reactivate</a><br>-->
        </p>
        
         <p>
         For any queries, please email us at 
         <a href="mailto:support@ecosansar.com">support@ecosansar.com</a><br><br>
          Happy discovering,<br>
          Warm regards,<br>
          Team ecoSansar
        </p>

    </div>

</section>
</body>
</html>

