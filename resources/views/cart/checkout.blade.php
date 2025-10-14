@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="mb-4">Finalizar Pedido</h2>
        <form action="{{ route('orders.checkout') }}" method="POST" id="checkout-form">
            @csrf
            <div class="mb-3">
                <label for="cep" class="form-label">CEP</label>
                <input type="text" name="cep" id="cep" class="form-control" required maxlength="9">
            </div>
            <div class="mb-3">
                <label for="logradouro" class="form-label">Logradouro</label>
                <input type="text" name="logradouro" id="logradouro" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="numero" class="form-label">Número</label>
                <input type="text" name="numero" id="numero" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="bairro" class="form-label">Bairro</label>
                <input type="text" name="bairro" id="bairro" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="cidade" class="form-label">Cidade</label>
                <input type="text" name="cidade" id="cidade" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="uf" class="form-label">UF</label>
                <input type="text" name="uf" id="uf" class="form-control" required maxlength="2">
            </div>
            <div class="mb-3">
                <label for="complemento" class="form-label">Complemento</label>
                <input type="text" name="complemento" id="complemento" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Finalizar Pedido</button>
        </form>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(function() {
    $('#cep').on('blur', function() {
        var cep = $(this).val().replace(/\D/g, '');
        if (cep.length === 8) {
            $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(data) {
                if (!data.erro) {
                    $('#logradouro').val(data.logradouro);
                    $('#bairro').val(data.bairro);
                    $('#cidade').val(data.localidade);
                    $('#uf').val(data.uf);
                }
            });
        }
    });
});
</script>
