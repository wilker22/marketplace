<!DOCTYPE html>
@extends('layouts.app')

@section('content')

<a href="{{route('admin.notifications.read.all')}}" class="btn btn-sm btn-primary">Marca todas como lidas</a>
<table class="table table-striped">
        <thead>
           <tr>
                <th>Notificação</th>
                <th>Criado em</th>
                <th>Ações</th>
                
           </tr>
                        
        </thead>
        <tbody>
            @foreach ($unreadNotifications as $n)
            <tr>
                
                <td>{{ $n->data['message']}}</td>
                <td>
                    {{ $n->created_at->locale('pt')->diffForHumans()}} ou
                    {{ $n->created_at->format('d/m/Y H:i:s')}}
                </td>
                
                <td>
                    <div class="btn-group">
                        <a href="#" class="btn btn-sm btn-primary">Marcar</a>
                    </div>
                    
                </td>
            </tr>  
            
            
            @endforeach
            
        </tbody>
    </table>
    
@endsection