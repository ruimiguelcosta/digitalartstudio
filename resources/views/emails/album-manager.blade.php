<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <p>Olá</p>
    
    <p>O site digitalartstudio.pt designou(a) como gestor(a) do álbum <strong>{{ $albumName }}</strong>.</p>
    
    <p>Esta é a sua password temporária: <strong>{{ $password }}</strong></p>
    
    <p>Pode fazer login <a href="{{ $loginUrl }}" style="color: #007bff; text-decoration: none;">aqui</a>.</p>
    
    <p>Obrigado</p>
</body>
</html>

