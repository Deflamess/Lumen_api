<?php

namespace App\Services;

use Illuminate\Http\Request;

interface UserServiceInterface
{
    public function get($id);
    public function save(Request $request);
    public function delete($id);
    public function update(Request $request, $id);
}