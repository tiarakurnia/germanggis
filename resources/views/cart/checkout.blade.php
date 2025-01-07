@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Checkout</h1>
        <h3>Total: Rp{{ number_format($total) }}</h3>

        <button id="pay-button">Bayar</button>
    </div>

    @push('scripts')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}">
        </script>
        <script>
            document.getElementById('pay-button').onclick = function() {
                window.snap.pay('{{ $snapToken }}');
            };
        </script>
    @endpush
@endsection
