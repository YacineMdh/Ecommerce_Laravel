<!-- resources/views/admin/orders/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Détail de la commande')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Commande #{{ $order->getId() }}</h1>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Retour aux commandes</a>
        </div>

        <!-- Informations générales -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informations de la commande</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Date :</strong> {{ $order->getCreatedAt()->format('d/m/Y H:i') }}</p>
                        <p><strong>Client :</strong> {{ $order->getUser()->getName() }}</p>
                        <p><strong>Email :</strong> {{ $order->getUser()->getEmail() }}</p>
                        <p><strong>Total :</strong> {{ number_format($order->getTotal(), 2) }} €</p>
                        <p>
                            <strong>Statut :</strong>
                        <form action="{{ route('admin.orders.status', $order->getId()) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="form-select form-select-sm d-inline-block" style="width: auto;">
                                <option value="pending" {{ $order->getStatus() == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="processing" {{ $order->getStatus() == 'processing' ? 'selected' : '' }}>En cours</option>
                                <option value="completed" {{ $order->getStatus() == 'completed' ? 'selected' : '' }}>Terminée</option>
                                <option value="cancelled" {{ $order->getStatus() == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                            </select>
                        </form>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Adresses</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Adresse de livraison</h6>
                                <p>
                                    14 rue de la République<br>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Adresse de facturation</h6>
                                <p>
                                    14 rue de la République<br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Détail des produits -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Produits commandés</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Prix unitaire</th>
                            <th>Quantité</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->getItems() as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                            <img src="https://www.istockphoto.com/resources/images/HomePage/Tiles/C7-APRIL-iStock-1312066565.jpg"
                                                 alt="{{ $item->getProduct()->getName() }}"
                                                 class="me-2" style="width: 50px; height: 50px; object-fit: cover;">

                                        <div>
                                            <h6 class="mb-0">{{ $item->getProduct()->getName() }}</h6>
                                            <small class="text-muted">
                                                Catégorie: {{ $item->getProduct()->getCategory()->getName() }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ number_format($item->getPrice(), 2) }} €</td>
                                <td>{{ $item->getQuantity() }}</td>
                                <td>{{ number_format($item->getPrice() * $item->getQuantity(), 2) }} €</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total</strong></td>
                            <td><strong>{{ number_format($order->getTotal(), 2) }} €</strong></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
