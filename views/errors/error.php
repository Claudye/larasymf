<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($message) ? $message :'Page not found' ?></title>
    
    <style>
        body{
            margin: 0;
            background-color:rgb(245, 240, 245);
            color: #999;
            font-size: small;
        }
        .e404{
           display: flex;
           flex-direction: column;
           justify-content: center;
           align-items: center;
            height: 100vh;
            font-weight: lighter;
        }
    </style>
</head>
<body>
<div class="e404">
    <div style="display:flex; font-size:3rem;"><span>  <?= isset($code) ? $code :'404' ?> </span>  | <?= isset($message) ? $message :'Page not found' ?></div>
</div>
</body>
</html>