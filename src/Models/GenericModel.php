<?php

namespace BravePickle\AliceLaravel\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Provides generic model for handling database mapping
 * The purpose of the model to load data rows to tables that does not have (and does not need) Laravel's
 * representation within the app
 */
class GenericModel extends Model
{
    public const CONTEXT_CONNECTION = 'connection';
    public const CONTEXT_TABLE = 'table';
    public const CONTEXT_FILLABLE = 'fillable';
    public const CONTEXT_GUARDED = 'guarded';
    public const CONTEXT_CASTS = 'casts';
    public const CONTEXT_TOUCHES = 'touches';
    public const CONTEXT_KEY_NAME = 'key_name';
    public const CONTEXT_KEY_TYPE = 'key_type';
    public const CONTEXT_TIMESTAMPS = 'timestamps';
    public const CONTEXT_FIELD_CREATED_AT = 'created_at';
    public const CONTEXT_FIELD_UPDATED_AT = 'updated_at';
    public const CONTEXT_INCREMENTING = 'incrementing';

    /**
     * Additional meta data for the generic model
     * @var array
     */
    protected $_meta = [];

    public function __construct(array $attributes = [], array $context = [])
    {
        $this->applyContext($context);

        parent::__construct($attributes);
    }

    /**
     * @param  array  $context
     */
    public function applyContext(array $context): void
    {
        if (!$context) {
            return;
        }

        if (array_key_exists(static::CONTEXT_CONNECTION, $context)) {
            $this->setConnection($context[static::CONTEXT_CONNECTION]);
        }

        if (array_key_exists(static::CONTEXT_TABLE, $context)) {
            $this->setTable($context[static::CONTEXT_TABLE]);
        }

        if (array_key_exists(static::CONTEXT_FILLABLE, $context)) {
            $this->setFillable($context[static::CONTEXT_FILLABLE]);
        }

        if (array_key_exists(static::CONTEXT_GUARDED, $context)) {
            $this->setGuarded($context[static::CONTEXT_GUARDED]);
        }

        if (array_key_exists(static::CONTEXT_CASTS, $context)) {
            $this->setCasts($context[static::CONTEXT_CASTS]);
        }

        if (array_key_exists(static::CONTEXT_TOUCHES, $context)) {
            $this->setTouches($context[static::CONTEXT_TOUCHES]);
        }

        if (array_key_exists(static::CONTEXT_KEY_NAME, $context)) {
            $this->setKeyName($context[static::CONTEXT_KEY_NAME]);
        }

        if (array_key_exists(static::CONTEXT_KEY_TYPE, $context)) {
            $this->setKeyType($context[static::CONTEXT_KEY_TYPE]);
        }

        if (array_key_exists(static::CONTEXT_INCREMENTING, $context)) {
            $this->setIncrementing((bool) $context[static::CONTEXT_INCREMENTING]);
        }

        if (array_key_exists(static::CONTEXT_TIMESTAMPS, $context)) {
            $this->timestamps = (bool) $context[static::CONTEXT_TIMESTAMPS];
        }

        if (array_key_exists(static::CONTEXT_FIELD_CREATED_AT, $context)) {
            $this->_meta[static::CONTEXT_FIELD_CREATED_AT] = $context[static::CONTEXT_FIELD_CREATED_AT];
        }

        if (array_key_exists(static::CONTEXT_FIELD_UPDATED_AT, $context)) {
            $this->_meta[static::CONTEXT_FIELD_UPDATED_AT] = $context[static::CONTEXT_FIELD_UPDATED_AT];
        }
    }

    /**
     * Get the name of the "created at" column.
     *
     * @return string|null
     */
    public function getCreatedAtColumn(): ?string
    {
        return $this->_meta[static::CONTEXT_FIELD_CREATED_AT] ?? static::CREATED_AT;
    }

    /**
     * Get the name of the "updated at" column.
     *
     * @return string|null
     */
    public function getUpdatedAtColumn(): ?string
    {
        return $this->_meta[static::CONTEXT_FIELD_UPDATED_AT] ?? static::UPDATED_AT;
    }

    /**
     * @param  string[]  $fillable
     * @return GenericModel
     */
    public function setFillable(array $fillable): self
    {
        $this->fillable = $fillable;

        return $this;
    }

    /**
     * @param  bool|string[]  $guarded
     * @return GenericModel
     */
    public function setGuarded($guarded): self
    {
        $this->guarded = $guarded;

        return $this;
    }

    /**
     * @param  array  $casts
     * @return GenericModel
     */
    public function setCasts(array $casts): GenericModel
    {
        $this->casts = $casts;

        return $this;
    }

    /**
     * @param  array  $touches
     * @return GenericModel
     */
    public function setTouches(array $touches): GenericModel
    {
        $this->touches = $touches;

        return $this;
    }

}
