<?php

namespace Hapick\Collect;

class Collect
{

    private array $collection = [];

    public function __construct(array $array)
    {
        $this->collection = $array;
    }

    public function pluck(string $key): Collect
    {
        return new Collect(array_column($this->collection, $key));
    }

    public function groupBy(string $key): Collect
    {
        $result = [];
        foreach ($this->collection as $item) {
            $result[$item[$key]][] = $item;
        }
        return new Collect($result);
    }

    public function flip(): Collect
    {
        return new Collect(array_flip($this->collection));
    }

    public function diff(array $array): Collect
    {
        return new Collect(array_diff($this->collection, $array));
    }

    public function intersect(array $array): Collect
    {
        return new Collect(array_intersect($this->collection, $array));
    }

    public function each(callable $callback): Collect
    {
        foreach ($this->collection as $key => $item) {
            $callback($item, $key);
        }
        return $this;
    }

    public function map(callable $callback): Collect
    {
        return new Collect(array_map($callback, $this->collection));
    }

    public function reject(callable $callback): Collect
    {
        return $this->filter(function($item) use ($callback) {
            return !$callback($item);
        });
    }

    public function chunk(int $size): Collect
    {
        return new Collect(array_chunk($this->collection, $size));
    }

    public function collapse(): Collect
    {
        $results = [];
        foreach ($this->collection as $array) {
            $results = array_merge($results, $array);
        }
        return new Collect($results);
    }

    public function combine(array $values): Collect
    {
        return new Collect(array_combine($this->collection, $values));
    }

    public function contains($value): bool
    {
        return in_array($value, $this->collection, true);
    }

    public function count(): int
    {
        return count($this->collection);
    }

    public function toArray(): array
    {
        return $this->collection;
    }

    public function get($key = null)
    {
        return $this->array[$key] ?? $this->array;
    }

    public function first()
    {
        return $this->array[array_key_first($this->array)];
    }
    public function push($value, $key = null): Collect
    {
        if (gettype($value) === 'array') {
            $value = new self($value);
        }
        if ($key) {
            $this->array[$key] = $value;
        } else {
            $this->array[] = $value;
        }
        return $this;
    }

    public function unshift($value): Collect
    {
        array_unshift($this->array, $value);
        return $this;
    }

    public function shift(): Collect
    {
        array_shift($this->array);
        return $this;
    }

    public function pop(): Collect
    {
        array_pop($this->array);
        return $this;
    }

    public function splice($idx, $length = 1): Collect
    {
        array_splice($idx, $length);
        return $this;
    }
}

