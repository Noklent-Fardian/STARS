@extends('errors::layout')

@section('title', 'Terlalu Banyak Permintaan')
@section('code', '429')
@section('icon', 'bi bi-exclamation-triangle')
@section('message', 'Anda telah membuat terlalu banyak permintaan dalam waktu singkat. Silakan tunggu sejenak dan coba lagi.')
