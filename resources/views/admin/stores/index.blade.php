<!DOCTYPE html>
@extends('layouts.app')

@section('content')

@if(!$store)
    <a href="{{ route('admin.stores.create')}}" class="btn btn-sm btn-primary">Nova Loja</a>
@endif
<table class="table table-striped">
        <thead>
            <th>id</th>
            <th>Loja</th>
            <th>Total de Produtos</th>
            <th>Ações</th>
        </thead>
        <tbody>
           
            <tr>
                <td>{{ $store->id}}</td>
                <td>{{ $store->name}}</td>
                <td>{{ $store->products->count()}}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('admin.stores.edit', ['store' => $store->id]) }}" class="btn btn-sm btn-primary">EDITAR</a>
                        <form action="{{ route('admin.stores.destroy', ['store' => $store->id]) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger">REMOVER</a>
                        </form>
                    </div>
                </td>
            </tr>  
            
        </tbody>
    </table>
    
@endsection