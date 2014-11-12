<?php
// +----------------------------------------------------------------------
// | [wallstreetcn]
// +----------------------------------------------------------------------
// | Author: Mr.5 <mr5.simple@gmail.com>
// +----------------------------------------------------------------------
// + Datetime: 2014-11-12 16:42
// +----------------------------------------------------------------------
// + ModelIterator.php
// +----------------------------------------------------------------------

namespace Eva\EvaCommon\Utils;

class ModelIterator implements \Iterator
{
    protected $position = 0;
    protected $total_items = 0;
    protected $perSize = 100;
    protected $endPosition = 0;
    protected $limit = 0;
    /**
     * @var \Phalcon\Mvc\Model\Query\BuilderInterface
     */
    protected $queryBuilder;

    /**
     * Model 迭代器
     * @param string $modelName model类名
     * @param int $perSize 每次多少条
     * @param int $limit 总条数限制
     */
    public function __construct($modelName, $perSize = 100, $limit = 0)
    {
        /** @var \Eva\EvaEngine\Mvc\Model $special */
        $special = new $modelName();
        $this->perSize = $perSize;
        $this->limit = $limit;
        $this->queryBuilder = $special->getModelsManager()->createBuilder();
        $this->queryBuilder->from($modelName);
    }

    public function getCreateBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * @return $this
     */
    public function start()
    {
        $total_items = $this->queryBuilder->columns('count(*) as __iterator_total_items')
            ->getQuery()->execute()->toArray();
        $total_items = $total_items[0]['__iterator_total_items'];
        $this->endPosition = ceil($total_items / $this->perSize);
        $this->queryBuilder->columns(null);
        return $this;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        $limit_offset = $this->position * $this->perSize;
        $this->queryBuilder->limit($this->perSize, $limit_offset);
        return $this->queryBuilder->getQuery()->execute();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return $this->position <= $this->endPosition;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->position = 0;
    }
}
