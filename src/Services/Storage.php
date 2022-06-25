<?php

namespace RealMrHex\CrawlerCore\Services;

use RealMrHex\CrawlerCore\Base\ServiceBase as Service;
use RealMrHex\CrawlerCore\Helpers\Singleton;

class Storage extends Service
{
    use Singleton;

    #region Attributes
    /**
     * Storage data
     * @var array<string, mixed>
     */
    protected array $storage = [];

    /**
     * Storage name
     * @var string
     */
    protected string $name;
    #endregion

    #region File Logic
    /**
     * Create a file for current storage.
     * @return Storage
     */
    protected function createStorageFile(): Storage
    {
        fopen($this->getStorageFilePath(), 'w');
        return $this;
    }

    /**
     * Get storage file name.
     * @return string
     */
    protected function getStorageFileName(): string
    {
        return "{$this->name}_storage.json";
    }

    /**
     * Get storage file name.
     * @return string
     */
    protected function getStorageFilePath(): string
    {
        return $this->getStorageBasePath() . $this->getStorageFileName();
    }

    /**
     * Get storage file name.
     * @return string
     */
    protected function getStorageBasePath(): string
    {
        return getcwd() . '/App/Storage/Data/';
    }
    #endregion

    #region Decode/Encode
    /**
     * Decode the storage
     * @return Storage
     */
    protected function decode(): Storage
    {
        //Read storage data
        $storage = file_get_contents($this->getStorageFilePath());

        //Convert it to PHP-Array [Associated]
        $storage = json_decode($storage, true);

        //Set it
        $this->setStorage($storage ?? []);

        return $this;
    }

    /**
     * Encode the storage
     * @return Storage
     */
    protected function encode(): Storage
    {
        //Get the storage data.
        $storageData = $this->getStorage();

        //Convert it to JSON
        $storageData = json_encode($storageData);

        //Initialize the file
        $storageFile = fopen($this->getStorageFilePath(), 'w');

        //Write data to file
        fwrite($storageFile, $storageData);

        //Close the stream
        fclose($storageFile);

        return $this;
    }
    #endregion

    #region Internal Logic
    /**
     * Set the storage data.
     * @param array $storage
     * @return $this
     */
    protected function setStorage(array $storage): Storage
    {
        $this->storage = $storage;
        return $this;
    }

    /**
     * Get the storage data.
     * @return array
     */
    protected function getStorage(): array
    {
        return $this->storage;
    }

    /**
     * Delete the storage item.
     * @param string $key
     * @return Storage
     */
    protected function deleteStorageItem(string $key): Storage
    {
        unset($this->storage[$key]);
        return $this;
    }

    /**
     * Get the storage item.
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function getStorageItem(string $key, mixed $default): mixed
    {
        return $this->storage[$key] ?? $default;
    }

    /**
     * Get the storage item.
     * @param string $crawler
     * @param string $key
     * @param string $item
     * @param mixed $default
     * @return mixed
     */
    protected function getStorageItemForCrawlerByKeyItem(string $crawler, string $key, string $item, mixed $default): mixed
    {
        return $this->storage[$crawler][$key][$item] ?? $default;
    }

    /**
     * Get the storage item.
     * @param string $crawler
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function getStorageItemForCrawlerByKey(string $crawler, string $key, mixed $default): mixed
    {
        return $this->storage[$crawler][$key] ?? $default;
    }

    /**
     * Set the storage item.
     * @param string $key
     * @param mixed $value
     * @return Storage
     */
    protected function setStorageItem(string $key, mixed $value): Storage
    {
        $this->storage[$key] = $value;
        return $this;
    }

    /**
     * Add item to storage item.
     * @param string $existingKey
     * @param string $key
     * @param mixed $value
     * @return Storage
     */
    protected function addStorageListItem(string $existingKey, string $key, mixed $value): Storage
    {
        ($key == '')
            ? $this->storage[$existingKey][] = $value
            : $this->storage[$existingKey][$key] = array_merge($this->storage[$existingKey][$key] ?? [], (is_array($value) ? $value : [$value]));

        return $this;
    }
    #endregion

    #region External Logic

    /**
     * Initialize Storage
     * @return $this
     */
    public function init(): static
    {
        $this->name = time() . '_' . $_ENV['STORAGE_NAME'];
        $this->createStorageFile();
        return $this;
    }

    /**
     * Set storage item
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function set(string $key, mixed $value): Storage
    {
        $this
            ->decode()
            ->setStorageItem($key, $value)
            ->encode();

        return $this;
    }

    /**
     * Add item to existing storage item [list/array]
     * @param string $existingKey
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function addToList(string $existingKey, string $key = '', mixed $value = ''): Storage
    {
        $this
            ->decode()
            ->addStorageListItem($existingKey, $key, $value)
            ->encode();

        return $this;
    }

    /**
     * Get storage item
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this
            ->decode()
            ->getStorageItem($key, $default);
    }

    /**
     * Get storage item
     * @param string $crawler
     * @param string $key
     * @param string $item
     * @param mixed|null $default
     * @return mixed
     */
    public function getCrawlerDataByKeyItem(string $crawler, string $key, string $item, mixed $default = null): mixed
    {
        return $this
            ->decode()
            ->getStorageItemForCrawlerByKeyItem($crawler, $key, $item, $default);
    }

    /**
     * Get storage item
     * @param string $crawler
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function getCrawlerData(string $crawler, string $key, mixed $default = null): mixed
    {
        return $this
            ->decode()
            ->getStorageItemForCrawlerByKey($crawler, $key, $default);
    }

    /**
     * Delete storage item
     * @param string $key
     * @return $this
     */
    public function delete(string $key): Storage
    {
        $this
            ->decode()
            ->deleteStorageItem($key)
            ->encode();

        return $this;
    }

    /**
     * Re-New storage data
     * @param array $newStorage
     * @return $this
     */
    public function renew(array $newStorage): Storage
    {
        $this
            ->setStorage($newStorage)
            ->encode();

        return $this;
    }
    #endregion
}