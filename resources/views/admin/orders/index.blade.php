@extends('layouts.admin')

@section('title', 'Gestion des commandes')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>Commandes</h1>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->getId() }}</td>
                    <td>{{ $order->getUser()->getName() }}</td>
                    <td>{{ $order->getTotal() }} €</td>
                    <td>
                        <form action="{{ route('admin.orders.status', $order->getId()) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                <option value="pending" {{ $order->getStatus() == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="processing" {{ $order->getStatus() == 'processing' ? 'selected' : '' }}>En cours</option>
                                <option value="completed" {{ $order->getStatus() == 'completed' ? 'selected' : '' }}>Terminée</option>
                                <option value="cancelled" {{ $order->getStatus() == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                            </select>
                        </form>
                    </td>
                    <td>{{ $order->getCreatedAt()->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->getId()) }}" class="btn btn-sm btn-info">Détails</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
