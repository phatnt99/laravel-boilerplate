<?php


namespace App\Queries;

use Closure;
use Illuminate\Database\Eloquent\Builder as BaseBuilder;

class Builder extends BaseBuilder
{

    /**
     * @param  Closure|string|array  $column
     * @param  string|null  $value
     * @return $this
     */
    public function whereStartsWith($column, $value = null)
    {
        $this->where($column, 'like', $value.'%');
        return $this;
    }

    /**
     * @param  Closure|string|array  $column
     * @param  string|null  $value
     * @return $this
     */
    public function whereEndsWith($column, $value = null)
    {
        $this->where($column, 'like', '%'.$value);
        return $this;
    }

    /**
     * @param  Closure|string|array  $column
     * @param  string|null  $value
     * @return $this
     */
    public function whereLike($column, $value = null)
    {
        $this->where($column, 'like', '%'.$value.'%');
        return $this;
    }

    /**
     * @param  Closure|string|array  $column
     * @param  string|null  $value
     * @return $this
     */
    public function whereEqual($column, $value = null)
    {
        $this->where($column, '=', $value);
        return $this;
    }

    /**
     * @param  Closure|string|array  $column
     * @param  string|null  $value
     * @return $this
     */
    public function whereNotEqual($column, $value = null)
    {
        $this->where($column, '<>', $value);
        return $this;
    }

}
