<?php

namespace App\Exceptions;

use Exception;

class PostNotBelongsToUser extends Exception
{
    public function render()
    {
    	return ['errors' => 'Post Not Belongs to User'];
    }
}