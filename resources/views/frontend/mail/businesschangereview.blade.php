

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
    <h1 style="text-align: center;"> Dear {{ $name }}</h1>
     <p>I hope this message finds you well. Thank you for taking the time to share your feedback about {{$post_name}}. We truly value your opinion, as it helps the user identify areas where he/she can improve.</p>
    <p>If you feel differently about the service now, we would be grateful if you could consider updating your review. Your updated feedback would not only help the user but also provide accurate information to others.</p>
 
   <div>Please update your review directly at 
<a href="{{$link}}"  style="  background-color: #8eb66f;   color: #ffffff; padding: 5px 5px; text-align: center; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 14px;"> <strong> Change review</strong></a>
   </div>  
    <p>Thank you so much for your time and consideration!!</p>
   <p>Warm regards, <br>
Support Team <br>
ecoSansar</p>
    </div>

</section>
</body>
</html>

