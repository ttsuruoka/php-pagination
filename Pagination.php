<?php
/**
 * ページネーションを扱うライブラリ
 *
 * @package Pagination
 * @author  tatsuya.tsuruoka@gmail.com
 * @url     https://github.com/ttsuruoka/php-pagination
 */
class Pagination
{
    public $current;    // 現在のページ番号
    public $max;        // 最大のページ番号
    public $min;        // 最小のページ番号
    public $prev;       // ひとつ前のページ番号
    public $next;       // ひとつ次のページ番号
    public $num_items;  // 項目の総件数
    public $limit;      // 1 ページに表示する件数
    public $from_item;  // 何件目から表示するか
    public $to_item;    // 何件目まで表示するか
    public $num_pages;  // ページ目次に一度に表示するページ数

    public function __construct($current, $num_items, $limit = 20, $min = 1)
    {
        $this->num_items = $num_items;
        $this->limit = $limit;
        $this->max = (int)ceil($num_items / $limit) + $min - 1;
        $this->min = $min;
        $this->current = min(max($current, $this->min), $this->max);
        $this->prev = $this->current - 1;
        $this->next = $this->current + 1;
        $this->from_item = max($this->limit * ($this->current - $this->min) + 1, 0);
        $this->to_item = min($this->from_item + $this->limit - 1, $num_items);
        $this->num_pages = 9;
    }

    // ページ目次の最小のページ番号
    public function minPage()
    {
        if ($this->num_items == 0) return 0;
        $n = max(($this->num_pages - 1) / 2, ($this->num_pages - 1) - ($this->max - $this->current));
        return max($this->current - $n, $this->min);
    }

    // ページ目次の最大のページ番号
    public function maxPage()
    {
        $n = max(($this->num_pages - 1) / 2, ($this->num_pages - 1) - ($this->current - $this->min));
        return min($this->current + $n, $this->max);
    }
}
