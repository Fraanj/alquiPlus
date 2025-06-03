<form action="{{ route('reservas.confirmarPago') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">Confirmar y Pagar</button>
</form>