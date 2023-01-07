<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('error', function ($title = 'error', $error, $version = '1.0', $status_code) {
            return response()->json([
                'Content-Type' => 'application/json',
                'apiVersion' => $version,
                'status' => 'error',
                'status_code' => $status_code,
                'title' => $title,

                'error' => [
                    'message' => $error
                ],


            ], $status_code);
        });
        Response::macro('success', function ($success, $version = '1.0') {
            return response()->json([
                'Content-Type:' => 'application/json',
                'apiVersion' => $version,
                'status' => 'success',
                'status_code' => 200,
                'success' => [
                    'message' => $success
                ],

            ], 200);
        });
        Response::macro('singleresource', function ($resource, $version = '1.0') {
            // return $resource;
            return response()->json([
                'Content-Type:' => 'application/json',
                'apiVersion' => $version,
                'status' => 'success',
                'status_code' => 200,
                'data' =>  $resource,

            ], 200);
        });

        Response::macro('tokenresponse', function ($token, $user, $version = '1.0') {

            return response()->json([
                'Content-Type:' => 'application/json',
                'apiVersion' => $version,
                'status' => 'success',
                'status_code' => 200,
                'data' => $user,
                'AccessToken' => [
                    'token' => $token,
                    'token_type' => 'bearer',
                ],

            ], 200);
        });
    }
}
