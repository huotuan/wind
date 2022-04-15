<?php

namespace App\Admin\Repositories;

use App\Models\WeWork\WeWorkUser as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class WeWorkUser extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
