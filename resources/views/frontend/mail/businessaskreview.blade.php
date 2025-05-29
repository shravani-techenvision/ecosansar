

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
     <p>I hope you had a great experience working with {{ $post_name }}! Your feedback is incredibly valuable to us and helps ensure we maintain high-quality service standards.</p>
    <p>If you could spare a moment to share your thoughts on {{ $post_name }}'s service — what went well and any areas for improvement — it would be greatly appreciated. Your insights will not only help us grow but also ensure we meet your expectations in the future.</p>
 
   <div>Please leave your review directly at 
<a href="{{$link}}"  style="  background-color: #8eb66f;   color: #ffffff; padding: 5px 5px; text-align: center; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 14px;"> <strong> Give review</strong></a>
   </div>  
    <p>Thank you for your time and support!</p>
   <p>Warm regards, <br>
Support Team <br>
ecoSansar</p>
    </div>

</section>
</body>
</html>

