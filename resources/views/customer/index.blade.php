

@extends('layouts.app')

@section('content')

    Customer Id: {{ $customer->id }} <br>
    User Id: {{ $customer->user_id }} <br>
    Name: {{ $customer->name }} <br>
    Email: {{ $customer->user->email }} <br>
    Address: {{ $customer->address }} <br>
    City: {{ $customer->city }} <br>
    Province: {{ $customer->province }} <br>
    Postal: {{ $customer->postal }} <br>
    Phone: {{ $customer->phone }} <br>

    <a href="{{ action('CustomerController@edit', $customer->id) }}">[EDIT]</a>

    @if(!Auth::user()->hasRole('manager'))
        <a href="{{ action('OrderController@index', $customer->id) }}">[VIEW ORDERS]</a>
    @else
        <a href="{{ action('AdminController@orders') }}">[VIEW ORDERS]</a>
    @endif

    <p>You can only delete your account if you do not have any open orders!</p>
    <form method="POST" action="{{ action('CustomerController@destroy', $customer->id) }}">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <input type="submit" value="[DELETE]">
    </form>

@endsection
