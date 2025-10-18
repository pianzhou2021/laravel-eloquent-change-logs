<?php
namespace Pianzhou\EloquentChangeLog\Observers;

use Illuminate\Database\Eloquent\Model;
use Pianzhou\EloquentChangeLog\Config;
use Pianzhou\EloquentChangeLog\Contracts\Watcher;
use Pianzhou\EloquentChangeLog\Enums\ChangeLog\Type;
use Pianzhou\EloquentChangeLog\Exceptions\NotFoundException;
use Pianzhou\EloquentChangeLog\Repositories\ChangeLog as Repository;

class ChangeLogObserver
{
    public function __construct(
        protected Repository $repository
    ) {
    }

    /**
     * Created event
     *
     * @param Model $model
     * @return void
     * @throws Exception
     */
    public function created(Model $model): void
    {
        if (!($model instanceof Watcher)) {
            throw new NotFoundException('This model not instance of Watcher!!');
        }

        $data   = collect($model->getAttributes())->map(function($value, $name) {
            return substr($value, 0, Config::get('smax_value_length', 255));
        });

        $originals   = $data->filter(function ($value, $name) use ($model) {
            return in_array($name, $model->watches());
        });

        $description    = $originals->map(function ($value, $name) use ($model) {
            return sprintf('[%s=%s]', $model->getTranslatedName($name), $model->getTranslatedValue($name, $value));
        })->implode(', ');

        $this->repository->record(
            $model,
            Type::CREATED,
            $model->getKey(),
            $description,
            [],
            $data->toArray()
        );
    }

    /**
     * Updated event
     *
     * @param Model $model
     * @return void
     * @throws Exception
     */
    public function updated(Model $model): void
    {
        if (!($model instanceof Watcher)) {
            throw new NotFoundException('This model not instance of Watcher!!');
        }

        $data   = collect($model->getAttributes())->map(function($value, $name) {
            return substr($value, 0, Config::get('max_value_length', 255));
        });

        $changes   = collect($model->getChanges())->filter(function ($value, $name) use ($model) {
            return in_array($name, $model->watches()) && $model->getOriginal($name) != $value;
        });

        if ($changes->isNotEmpty()) {
            $originals  = $changes->map(function ($value, $name) use ($model) {
                return $model->getOriginal($name);
            });
            
            $description    = $originals->map(function ($value, $name) use ($model) {
                return sprintf('%s[%s->%s]',
                    $model->getTranslatedName($name),
                    $model->getTranslatedValue($name, $value),
                    $model->getTranslatedValue($name, $model->getAttribute($name))
                );
            })->implode(', ');

            $this->repository->record(
                $model,
                Type::UPDATED,
                $model->getKey(),
                $description,
                $originals->toArray(),
                $data->toArray()
            );
        }
    }

    /**
     * Deleted event
     *
     * @param Model $model
     * @return void
     * @throws Exception
     */
    public function deleted(Model $model): void
    {
        if (!($model instanceof Watcher)) {
            throw new NotFoundException('This model not instance of Watcher!!');
        }

        $data   = collect($model->getAttributes())->map(function($value, $name) {
            return substr($value, 0, Config::get('max_value_length', 255));
        });
        $originals   = $data->filter(function ($value, $name) use ($model) {
            return in_array($name, $model->watches());
        })->map(function ($value, $key) use ($model) {
            return $model->getAttribute($key);
        });

        $description    = $originals->map(function ($value, $name) use ($model) {
            return sprintf('[%s=%s]', $model->getTranslatedName($name), $model->getTranslatedValue($name, $value));
        })->implode(', ');

        $this->repository->record(
            $model,
            Type::DELETED,
            $model->getKey(),
            $description,
            $originals->toArray(),
            $data->toArray()
        );
    }
}
