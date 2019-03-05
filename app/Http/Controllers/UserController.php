<?php

namespace App\Http\Controllers;

use App\Services\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // stores UserService
    private $user;

    //DI with UserServiceInterface
    public function __construct(UserServiceInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUser($id)
    {
      return $this->user->get($id);
    }

    /**
     * @param Request $request
     */
    public function saveUser(Request $request)
    {
        return $this->user->save($request);
    }

    public function deleteUser($id)
    {
        return $this->user->delete($id);
    }

    public function updateUser(Request $request, $id)
    {
        return $this->user->update($request, $id);
    }
}
