<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago</title>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>
    <div id="walletBrick_container"></div>

    <script>
        const mp = new MercadoPago("{{ $publicKey }}", { locale: 'es-MX' });

        const bricksBuilder = mp.bricks();
        const renderWalletBrick = async (bricksBuilder) => {
            await bricksBuilder.create("wallet", "walletBrick_container", {
            initialization: {
                preferenceId: "{{ $preference->id }}"
                }
            })
        };

        renderWalletBrick(bricksBuilder);
    </script>
</body>
</html>