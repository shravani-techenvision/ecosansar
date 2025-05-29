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
     <h1 style="text-align: center;">Dear {{ $details['userName'] }} </h1>
    <p>There is a new post with Pincode: {{ $details['pincode'] }} and Resource: {{ $details['resource'] }}.</p>

    <h3>Post Details:</h3>
     
                <strong>Address:</strong> 
                @if($posts->address)
                    {{ $posts->address }}
                @else
                    No address available
                @endif
                <br>
                
                <strong>Description:</strong> {{ $posts->resource_des }}<br>
                
                <strong>Date:</strong> {{ $posts->created_at->format('d M Y') }}<br>
              
             <p><a href="{{ $dynamicLink }}" style="  background-color: #8eb66f;   color: #ffffff; padding: 5px 5px; text-align: center; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 14px;"><strong>View Post</strong></a></p>

    <p>Thank you!</p>
</body>

</html>
