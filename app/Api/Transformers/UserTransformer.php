<?php
namespace App\Api\Transformers;

use App\Models\Test;
use Dingo\Api\Contract\Transformer\Adapter;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    public function transform(Test $user)
    {
        return [
            'id'            => (int) $user->id,
            'name'          => $user->name,
        ];
    }
}