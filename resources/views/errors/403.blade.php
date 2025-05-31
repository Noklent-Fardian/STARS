@extends('errors::layout')

@section('title', 'Dilarang')
@section('code', '403')
@section('icon', 'bi bi-ban')
@section('message', {{ $exception->getMessage() ?: 'Akses ke sumber daya ini dilarang. Anda tidak memiliki izin untuk melihat halaman ini.' }})
