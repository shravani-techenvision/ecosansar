

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
    <h1 style="text-align: center;"> {{ $post_name }} asked for review</h1>
   <div style="text-align-last: center;">
<a   class="btn btn-primary btn-small btn-rounded icon shadow add-listing" href="{{$link}}"  style="  background-color: #8eb66f;   color: #ffffff; padding: 10px 20px; text-align: center; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 14px;"> <strong> Give review</strong></a>
   </div>   
    </div>

</section>
</body>
</html>

