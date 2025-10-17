<?php

namespace Pianzhou\EloquentChangeLog\Repositories;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Pianzhou\EloquentChangeLog\Config;
use Pianzhou\EloquentChangeLog\Enums\ChangeLog\Type;
use Pianzhou\EloquentChangeLog\Models\ChangeLog as Model;

class ChangeLog
{
    public function __construct(
        protected Model $model
    ){}

    /**
     * Record change log
     *
     * @param EloquentModel $model
     * @param Type $type
     * @param string $description
     * @param array $old
     * @param array $data
     * @param AdminUser|null $adminUser
     * @return bool
     */
    public function record(EloquentModel $model, Type $type, string $key, string $description, array $old = [], array $data = []): Model|bool
    {
        $model = (new Model([
            'model'                 => get_class($model),
            'type'                  => $type,
            'key'                   => $key,
            'description'           => $description,
            'old'                   => $old,
            'data'                  => $data,
        ]));
        
        $hook = Config::get('record_hook');
        if (is_callable($hook)) {
            $hook($model);
        }
        
        return $model->save();
    }
}
