@extends('layouts.admin')

@section('title', 'Gestion des coupons')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Coupons</h1>
            <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
                Créer un coupon
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Code</th>
                            <th>Réduction</th>
                            <th>Valide jusqu'au</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($coupons as $coupon)
                            <tr>
                                <td>{{ $coupon->getCode() }}</td>
                                <td>{{ $coupon->getDiscount() }}%</td>
                                <td>{{ $coupon->getValidUntil()->format('d/m/Y') }}</td>
                                <td>
                                <span class="badge bg-{{ $coupon->isActive() ? 'success' : 'danger' }}">
                                    {{ $coupon->isActive() ? 'Actif' : 'Inactif' }}
                                </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.coupons.edit', $coupon->getId()) }}"
                                       class="btn btn-sm btn-primary">
                                        Modifier
                                    </a>
                                    <form action="{{ route('admin.coupons.destroy', $coupon->getId()) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce coupon ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
