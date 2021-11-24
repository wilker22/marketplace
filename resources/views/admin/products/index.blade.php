<!DOCTYPE html>
@extends('layouts.app')

@section('content')

<a href="{{ route('admin.products.create')}}" class="btn btn-sm btn-primary">Novo Produto</a>
<table class="table table-striped">
        <thead>
            <th>id</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Loja</th>
            
        </thead>
        <tbody>
            @foreach ($products as $p)
            <tr>
                <td>{{ $p->id}}</td>
                <td>{{ $p->name}}</td>
                <td>{{number_format($p->price, '2',',','.')}}</td>  
                <td>{{ $p->store->name }}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('admin.products.edit', $p->id) }}" class="btn btn-sm btn-primary">EDITAR</a>
                      
                        <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn btn-sm btn-danger">REMOVER</button>
                        </form>
                    </div>
                    
                </td>
            </tr>  
            
            
            @endforeach
            
        </tbody>
    </table>
    {{ $products->links() }}
@endsection