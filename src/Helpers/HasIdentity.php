<?php

namespace RealMrHex\CrawlerCore\Helpers;

trait HasIdentity
{
    /**
     * This method is called upon instantiation of the Eloquent Model.
     * It adds the "seoMeta" field to the "$fillable" array of the model.
     *
     * @return void
     */
    public function initializeHasIdentity()
    {
        $this->identity['name'] = basename(str_replace('\\', '/', get_class($this)));
        $this->identity['identity-version'] = 'beta';
    }

    /**
     * Get identity name
     * @return string
     */
    public function identityGetName(): string
    {
        return $this->identity['name'];
    }

    /**
     * Set identity name
     * @param string $name
     * @return $this
     */
    public function identitySetName(string $name): self
    {
        $this->identity['name'] = $name;

        return $this;
    }

    /**
     * Set identity name
     * @param string $value
     * @return $this
     */
    public function identitySetBaseUrl(string $value): self
    {
        $this->identity['base_url'] = $value;

        return $this;
    }

    /**
     * Add identity item
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function identityAddItem(string $key, mixed $value): self
    {
        $this->identity[$key] = $value;

        return $this;
    }

    /**
     * Remove identity item
     * @param string $key
     * @return $this
     */
    public function identityRemoveItem(string $key): self
    {
         unset($this->identity[$key]);

        return $this;
    }

    /**
     * Remove identity item
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function identityGetItem(string $key, mixed $default = null): mixed
    {
        return $this->identity[$key] ?? $default;
    }
}