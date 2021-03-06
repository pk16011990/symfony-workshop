<?php
declare(strict_types=1);

namespace App\Model\Cache;

use Doctrine\Common\Cache\PhpFileCache;

class PermanentPhpFileCache extends PhpFileCache
{
    /**
     * {@inheritdoc}
     */
    protected function doFetch($id)
    {
        $fileName = $this->getFilename($id);

        // note: error suppression is still faster than `file_exists`, `is_file` and `is_readable`
        $value = @include $fileName;
        if ($value === false) {
            return $value;
        }

        return unserialize($value);
    }

    /**
     * {@inheritdoc}
     */
    protected function doContains($id)
    {
        $value = $this->doFetch($id);

        return $value !== false;
    }

    /**
     * {@inheritdoc}
     */
    protected function doSave($id, $data, $lifeTime = 0)
    {
        if ($lifeTime !== 0 && $lifeTime !== null) {
            $message = self::class . ' does not support $lifetime';
            throw new \InvalidArgumentException($message);
        }

        $filename = $this->getFilename($id);

        $code = '<?php return ' . var_export(serialize($data), true) . ';';

        return $this->writeFile($filename, $code);
    }
}