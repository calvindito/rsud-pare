@extends('errors.layouts')
@section('title', __('Akses Dilarang'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Akses Dilarang'))
