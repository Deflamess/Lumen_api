<?php

namespace App\Services;


interface RestClientInterface
{
    public function get($id);
    public function post(array $data);
    public function delete($id);
    public function put($id, array $data);
}
