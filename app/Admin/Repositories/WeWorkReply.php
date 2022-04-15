<?php

namespace App\Admin\Repositories;

use App\Models\WeWork\WeWorkReply as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class WeWorkReply extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
