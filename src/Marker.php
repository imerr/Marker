<?php
namespace imer\Marker;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use imer\Marker\Exception\InvalidTypeException;
use imer\Marker\Exception\ValidationException;

class Marker {
    public static $defaults;
    // config
    protected $type;
    protected $validator;
    protected $view;
    protected $max;
    // state
    protected $items = [];

    public function __construct($type) {
        $cfg = Config::get('marker.types.' . $type);
        if (!$cfg) {
            throw new InvalidTypeException;
        }
        $this->type = $type;
        // Initialize object
        foreach (static::$defaults as $key => $value) {
            $this->$key = isset($cfg[$key]) ? $cfg[$key] : $value;
        }
        $this->items = Session::get('marker.' . $type, []);
    }

    public function save() {
        Session::set('marker.' . $this->type, $this->items);
    }

    public function items() {
        return $this->items;
    }

    public function count() {
        return count($this->items);
    }

    public function type() {
        return $this->type;
    }

    public function validate($value) {
        if (is_callable($this->validator)) {
            return call_user_func($this->validator, $value);
        }
        $validator = Validator::make(['value' => $value], [
            'value' => $this->validator
        ]);
        return !$validator->fails();
    }

    public function add($item) {
        if (!$this->validate($item)) {
            throw new ValidationException();
        }
        if (!in_array($item, $this->items)) {
            $this->items[] = $item;
        }
        return $this;
    }

    public function remove($item) {
        $key = array_search($item, $this->items);
        if ($key !== false) {
            unset($this->items[$key]);
        }
        return $this;
    }

    public function renderDropdown() {
        return view($this->view, ['marker' => $this]);
    }

    public function makeCheckbox($value) {
        return '<input type="checkbox" data-marker="checkbox" data-marker-type="' . $this->type . '" ' .
               'value="' . e($value) . '"' . (in_array($value, $this->items) ? ' checked="checked"' : '') . '>';
    }
    public function makeToggleAllCheckbox() {
        return '<input type="checkbox" data-marker="checkbox-toggle" data-marker-type="'.$this->type.'">';
    }

    public function clear() {
        $this->items = [];
    }
}

Marker::$defaults = [
    'view' => 'vendor.marker.default',
    'validator' => function ($val) {
        return true;
    },
    'max' => 10000,
];