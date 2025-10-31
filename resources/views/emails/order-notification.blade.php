<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Encomenda Recebida</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #fff3cd; padding: 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #ffc107;">
        <h1 style="color: #2c3e50; margin-top: 0;">Nova Encomenda Recebida!</h1>
        <p>Foi recebida uma nova encomenda no site.</p>
    </div>

    <div style="background-color: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
        <h2 style="color: #2c3e50; margin-top: 0;">Detalhes da Encomenda</h2>
        
        <p><strong>Número da Encomenda:</strong> #{{ $order->id }}</p>
        <p><strong>Data:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        
        <h3 style="color: #2c3e50; margin-top: 30px; margin-bottom: 15px;">Cliente:</h3>
        <p><strong>Nome:</strong> {{ $order->customer_name }}</p>
        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
        <p><strong>Telemóvel:</strong> {{ $order->customer_phone }}</p>
        
        @if($order->album)
        <p><strong>Álbum:</strong> {{ $order->album->name }}</p>
        @endif
        
        <h3 style="color: #2c3e50; margin-top: 30px; margin-bottom: 15px;">Itens Encomendados:</h3>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr style="background-color: #f8f9fa;">
                    <th style="text-align: left; padding: 10px; border-bottom: 2px solid #ddd;">Foto</th>
                    <th style="text-align: left; padding: 10px; border-bottom: 2px solid #ddd;">Serviço</th>
                    <th style="text-align: right; padding: 10px; border-bottom: 2px solid #ddd;">Preço</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        @if($item->photo_index !== null)
                            Foto {{ $item->photo_index + 1 }}
                        @else
                            Foto
                        @endif
                    </td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $item->service_name }}</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; text-align: right;">€{{ number_format($item->service_price, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #f8f9fa; font-weight: bold;">
                    <td colspan="2" style="padding: 10px; border-top: 2px solid #ddd; text-align: right;">Total:</td>
                    <td style="padding: 10px; border-top: 2px solid #ddd; text-align: right;">€{{ number_format($order->total_price, 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div style="background-color: #e8f5e9; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <p style="margin: 0;"><strong>Nota:</strong> Por favor, entre em contacto com o cliente para finalizar o pagamento e processar a encomenda.</p>
    </div>

    <div style="text-align: center; color: #666; font-size: 12px; margin-top: 30px;">
        <p>Digital Art Studio - Sistema de Notificações</p>
    </div>
</body>
</html>

