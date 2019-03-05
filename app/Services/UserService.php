<?php

namespace App\Services;

use App\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserService implements UserServiceInterface
{
    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id)
    {
        //$users = DB::select("SELECT * FROM users WHERE id = $id");
        //$users = app('db')->select("SELECT * FROM users WHERE id = $id");

        $users = User::all('name','id','rating')
            ->where('id','=', $id);


        if ( empty($users) ) {
            return response()->json(
                ['error' => [
                    'message' => 'User not found'
                ]], Response::HTTP_NOT_FOUND
            );
        }


        return response()->json($users);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function save(Request $request)
    {
        $contentType = $request->header('content-type');

        if ( $contentType == 'application/json' ) {

            $name = $request->get('name');
            $rating = $request->get('rating');
            $requestId = $request->get("id");

            $result = User::where('id','=', $requestId)->first();

            if ( !empty($result) ) {
                return response()->json(
                    ['error' => [
                        'message' => 'User already exists'
                    ]], Response::HTTP_CONFLICT
                );
            }

            DB::insert("INSERT INTO users (name, rating) VALUES ('$name', '$rating');");

            return response('User Created', Response::HTTP_CREATED,
                ['Location' => '/user/' . $requestId]
            );

        } elseif ($contentType === 'application/xml') {

            return response('<message>error</message>',
                200, ['Content-type' => 'application/xml']
            );
        }
    }

    public function delete($id)
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

    public function update(Request $request, $id)
    {

        $dataToUpdate = $request->all();

        foreach ($dataToUpdate as $key => $value ) {

            $result = DB::update("UPDATE users SET $key = '$value' WHERE id = $id");

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