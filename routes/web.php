<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'locador'], function (){
    Route::post('/cadastrar', 'App\Http\Controllers\locadorController@cadastrarLocador')->name('cadastrarLocador');
    Route::post('/logar', 'App\Http\Controllers\locadorController@logarLocador')->name('logarLocador');
    Route::get('/logout', 'App\Http\Controllers\locadorController@logoutLocador')->name('logoutLocador');
});

Route::group(['prefix' => 'locatario'], function (){
    Route::post('/cadastrar', 'App\Http\Controllers\locatarioController@cadastrarLocatario')->name('cadastrarLocatario');
    Route::post('/logar', 'App\Http\Controllers\locatarioController@logarLocatario')->name('logarLocatario');
    Route::get('/logout', 'App\Http\Controllers\locadorController@logoutLocador')->name('logoutLocatario');
});

#Rota para executar o middleware e impedir interação sem uma sessão ativa
Route::group(['middleware' => ['login']], function() {

    Route::group(['prefix' => 'locador'], function (){
        Route::get('/conta', 'App\Http\Controllers\locadorController@contaLocador')->name('contaLocador');
        Route::post('/editar', 'App\Http\Controllers\locadorController@editarLocador')->name('editarLocador');
        Route::get('/excluir', 'App\Http\Controllers\locadorController@deletarLocador')->name('deletarLocador');
});
    Route::group(['prefix' => 'locatario'], function (){
        Route::get('/conta', 'App\Http\Controllers\locatarioController@contalocatario')->name('contalocatario');
        Route::post('/editar', 'App\Http\Controllers\locatarioController@editarlocatario')->name('editarlocatario');
        Route::get('/deletar', 'App\Http\Controllers\locatarioController@deletarlocatario')->name('deletarlocatario');
});

    Route::group(['prefix' => 'imovel'], function () {
        Route::post('/cadastrar', 'App\Http\Controllers\imovelController@cadastrarImovel')->name('cadastrarImovel');
        Route::post('/editar/{id}', 'App\Http\Controllers\imovelController@listarImovel')->name('listarImovel');
        Route::get('/buscar/{cep}', 'App\Http\Controllers\imovelController@buscarImovel')->name('buscarImovel');
        Route::get('/visualizar/{id}', 'App\Http\Controllers\imovelController@visualizarImovel')->name('visualizarImovel');
        Route::get('/deletar/{id}', 'App\Http\Controllers\imovelController@deletarImovel')->name('deletarImovel');
        Route::get('/filtrar_pessoas', 'App\Http\Controllers\imovelController@filtrarImovelValor')->name('filtrarImovelValor');
        Route::get('/filtrar_valor', 'App\Http\Controllers\imovelController@filtrarImovelPessoas')->name('filtrarImovelPessoas');
});

    Route::group(['prefix' => 'locacao'], function () {
        Route::post('/locar', 'App\Http\Controllers\locacaoController@locarImovel')->name('locarImovel');
        Route::post('/listar_locador/{id}', 'App\Http\Controllers\locacaoController@listarLocacaoLocador')->name('listarLocacaoLocador');
        Route::post('/buscar_locador/{cep}', 'App\Http\Controllers\locacaoController@buscarLocacaoLocador')->name('listarLocacaoLocador');
        Route::post('/listar_locatario/{id}', 'App\Http\Controllers\locacaoController@listarLocacaoLocatario')->name('listarLocacaoLocatario');
        Route::post('/buscar_locatario/{cep}', 'App\Http\Controllers\locacaoController@buscarLocacaolocatario')->name('buscarLocacaolocatario');
        Route::post('/cancelar_locacao/{id}', 'App\Http\Controllers\locacaoController@buscarLocacaolocatario')->name('buscarLocacaolocatario');   
});

});