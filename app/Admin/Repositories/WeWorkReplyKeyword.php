<?php

namespace App\Admin\Repositories;

use App\Models\WeWork\WeWorkReplyKeyword as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class WeWorkReplyKeyword extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
