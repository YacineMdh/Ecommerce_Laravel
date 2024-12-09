@extends('layouts.admin')

@section('title', 'Créer un coupon')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Créer un coupon</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.coupons.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror"
                               id="code" name="code" value="{{ old('code') }}" required>
                        @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="discount" class="form-label">Réduction (%)</label>
                        <input type="number" class="form-control @error('discount') is-invalid @enderror"
                               id="discount" name="discount" value="{{ old('discount') }}"
                               min="0" max="100" required>
                        @error('discount')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="valid_until" class="form-label">Valide jusqu'au</label>
                        <input type="date" class="form-control @error('valid_until') is-invalid @enderror"
                               id="valid_until" name="valid_until" value="{{ old('valid_until') }}" required>
                        @error('valid_until')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_active"
                                   name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Actif</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Créer</button>
                        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
