<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function getUser($id)
    {
        $users = DB::select("SELECT * FROM users WHERE id = $id");
        //$result = app('db')->select("SELECT * FROM users WHERE id = $id");

        if ( empty($users) ) {
            return response()->json(
                ['error' => [
                    'message' => 'User not found'
                ]], Response::HTTP_NOT_FOUND
            );
        }


        return response()->json($users);
    }

    public function saveUser(Request $request)
    {
        $contentType = $request->header('content-type');

        if ( $contentType == 'application/json' ){

            $name = $request->get('name');
            $rating = $request->get('rating');

            $requestId = $request->get("id");
            $result = DB::select("SELECT * FROM users WHERE id = $requestId");

            if ( !empty($result) ) {
                return response()->json(
                    ['error' => [
                        'message' => 'User already exist'
                    ]], Response::HTTP_CONFLICT
                );
            }

            DB::insert("INSERT INTO users (name , rating) VALUES ('$name', '$rating');");

            return response('User created', Response::HTTP_CREATED, [
                'Location' => '/user/' . $requestId
            ]);
        } elseif ($contentType === 'application/xml') {
            return response('<message>error</message>', 200, ['Content-type' => 'application/xml'] );
        }
    }

    public function deleteUser($id)
    {
        $result = DB::delete("DELETE FROM users WHERE id = $id");

        if (!$result) {
            return response()->json(
                ['error' => [
                    'message' => 'User not found'
                ]], Response::HTTP_NOT_FOUND
            );
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function updateUser(Request $request, $id)
    {
        $dataToUpdate = $request->all();

        foreach ($dataToUpdate as $key => $value ) {

            $result = DB::update("UPDATE users SET $key = $value WHERE id = $id");
            if (empty($result)) {
                return response()->json(
                    ['error' => [
                        'message' => 'User not found'
                    ]], Response::HTTP_NOT_FOUND
                );
            }
        }

        return response(null, Response::HTTP_OK);
    }
}
