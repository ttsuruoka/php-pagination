<?php
require_once dirname(dirname(__FILE__)).'/Pagination.php';

class PaginationTest extends PHPUnit_Framework_TestCase
{
    public function test_construct()
    {
        // OK:
        $page = new Pagination(1, 100, 10);
        $this->assertEquals($page->current, 1);
        $this->assertEquals($page->num_items, 100);
        $this->assertEquals($page->limit, 10);
        $this->assertEquals($page->prev, 0);
        $this->assertEquals($page->next, 2);
        $this->assertEquals($page->min, 1);
        $this->assertEquals($page->max, 10);
        $this->assertEquals($page->from_item, 1);
        $this->assertEquals($page->to_item, 10);

        // OK:
        $page = new Pagination(2, 100, 10);
        $this->assertEquals($page->current, 2);
        $this->assertEquals($page->num_items, 100);
        $this->assertEquals($page->limit, 10);
        $this->assertEquals($page->prev, 1);
        $this->assertEquals($page->next, 3);
        $this->assertEquals($page->min, 1);
        $this->assertEquals($page->max, 10);
        $this->assertEquals($page->from_item, 11);
        $this->assertEquals($page->to_item, 20);

        // OK: 負のページ番号
        // ページ構成：-3 -2 -1 0 1 2 3 （全7ページ）
        $page = new Pagination(-3, 7, 1, -3);
        $this->assertEquals($page->current, -3);
        $this->assertEquals($page->num_items, 7);
        $this->assertEquals($page->limit, 1);
        $this->assertEquals($page->prev, -4);
        $this->assertEquals($page->next, -2);
        $this->assertEquals($page->min, -3);
        $this->assertEquals($page->max, 3);
        $this->assertEquals($page->from_item, 1);
        $this->assertEquals($page->to_item, 1);

        $page = new Pagination(-2, 7, 1, -3);
        $this->assertEquals($page->current, -2);
        $this->assertEquals($page->num_items, 7);
        $this->assertEquals($page->limit, 1);
        $this->assertEquals($page->prev, -3);
        $this->assertEquals($page->next, -1);
        $this->assertEquals($page->min, -3);
        $this->assertEquals($page->max, 3);
        $this->assertEquals($page->from_item, 2);
        $this->assertEquals($page->to_item, 2);

        $page = new Pagination(-1, 7, 1, -3);
        $this->assertEquals($page->current, -1);
        $this->assertEquals($page->num_items, 7);
        $this->assertEquals($page->limit, 1);
        $this->assertEquals($page->prev, -2);
        $this->assertEquals($page->next, 0);
        $this->assertEquals($page->min, -3);
        $this->assertEquals($page->max, 3);
        $this->assertEquals($page->from_item, 3);
        $this->assertEquals($page->to_item, 3);


        $page = new Pagination(0, 7, 1, -3);
        $this->assertEquals($page->current, 0);
        $this->assertEquals($page->num_items, 7);
        $this->assertEquals($page->limit, 1);
        $this->assertEquals($page->prev, -1);
        $this->assertEquals($page->next, 1);
        $this->assertEquals($page->min, -3);
        $this->assertEquals($page->max, 3);
        $this->assertEquals($page->from_item, 4);
        $this->assertEquals($page->to_item, 4);

        $page = new Pagination(1, 7, 1, -3);
        $this->assertEquals($page->current, 1);
        $this->assertEquals($page->num_items, 7);
        $this->assertEquals($page->limit, 1);
        $this->assertEquals($page->prev, 0);
        $this->assertEquals($page->next, 2);
        $this->assertEquals($page->min, -3);
        $this->assertEquals($page->max, 3);
        $this->assertEquals($page->from_item, 5);
        $this->assertEquals($page->to_item, 5);

        $page = new Pagination(2, 7, 1, -3);
        $this->assertEquals($page->current, 2);
        $this->assertEquals($page->num_items, 7);
        $this->assertEquals($page->limit, 1);
        $this->assertEquals($page->prev, 1);
        $this->assertEquals($page->next, 3);
        $this->assertEquals($page->min, -3);
        $this->assertEquals($page->max, 3);
        $this->assertEquals($page->from_item, 6);
        $this->assertEquals($page->to_item, 6);

        $page = new Pagination(3, 7, 1, -3);
        $this->assertEquals($page->current, 3);
        $this->assertEquals($page->num_items, 7);
        $this->assertEquals($page->limit, 1);
        $this->assertEquals($page->prev, 2);
        $this->assertEquals($page->next, 4);
        $this->assertEquals($page->min, -3);
        $this->assertEquals($page->max, 3);
        $this->assertEquals($page->from_item, 7);
        $this->assertEquals($page->to_item, 7);
    }

    public function test_minPage_maxPage_001()
    {
        // OK:  (num_items / limit) > num_pages
        $page = new Pagination(1, 200, 10);
        $this->assertEquals($page->current, 1);
        $this->assertEquals($page->num_items, 200);
        $this->assertEquals($page->limit, 10);
        $this->assertEquals($page->min, 1);
        $this->assertEquals($page->max, 20);
        $this->assertEquals($page->num_pages, 9);

        $this->assertEquals($page->minPage(), 1);
        $this->assertEquals($page->maxPage(), 9);
        $this->assertEquals($page->maxPage() - $page->minPage(), 8);

        $page->current = 2;
        $this->assertEquals($page->minPage(), 1);
        $this->assertEquals($page->maxPage(), 9);
        $this->assertEquals($page->maxPage() - $page->minPage(), 8);

        $page->current = 3;
        $this->assertEquals($page->minPage(), 1);
        $this->assertEquals($page->maxPage(), 9);
        $this->assertEquals($page->maxPage() - $page->minPage(), 8);

        $page->current = 4;
        $this->assertEquals($page->minPage(), 1);
        $this->assertEquals($page->maxPage(), 9);
        $this->assertEquals($page->maxPage() - $page->minPage(), 8);

        $page->current = 5;
        $this->assertEquals($page->minPage(), 1);
        $this->assertEquals($page->maxPage(), 9);
        $this->assertEquals($page->maxPage() - $page->minPage(), 8);

        $page->current = 6;
        $this->assertEquals($page->minPage(), 2);
        $this->assertEquals($page->maxPage(), 10);
        $this->assertEquals($page->maxPage() - $page->minPage(), 8);

        $page->current = 7;
        $this->assertEquals($page->minPage(), 3);
        $this->assertEquals($page->maxPage(), 11);
        $this->assertEquals($page->maxPage() - $page->minPage(), 8);

        $page->current = 15;
        $this->assertEquals($page->minPage(), 11);
        $this->assertEquals($page->maxPage(), 19);
        $this->assertEquals($page->maxPage() - $page->minPage(), 8);

        $page->current = 16;
        $this->assertEquals($page->minPage(), 12);
        $this->assertEquals($page->maxPage(), 20);
        $this->assertEquals($page->maxPage() - $page->minPage(), 8);

        $page->current = 17;
        $this->assertEquals($page->minPage(), 12);
        $this->assertEquals($page->maxPage(), 20);
        $this->assertEquals($page->maxPage() - $page->minPage(), 8);

        $page->current = 18;
        $this->assertEquals($page->minPage(), 12);
        $this->assertEquals($page->maxPage(), 20);
        $this->assertEquals($page->maxPage() - $page->minPage(), 8);

        $page->current = 19;
        $this->assertEquals($page->minPage(), 12);
        $this->assertEquals($page->maxPage(), 20);
        $this->assertEquals($page->maxPage() - $page->minPage(), 8);

        $page->current = 20;
        $this->assertEquals($page->minPage(), 12);
        $this->assertEquals($page->maxPage(), 20);
        $this->assertEquals($page->maxPage() - $page->minPage(), 8);
    }

    public function test_minPage_maxPage_002()
    {
        // OK:  (num_items / limit) < num_pages
        $page = new Pagination(1, 50, 10);
        $this->assertEquals($page->current, 1);
        $this->assertEquals($page->num_items, 50);
        $this->assertEquals($page->limit, 10);
        $this->assertEquals($page->min, 1);
        $this->assertEquals($page->max, 5);

        $this->assertEquals($page->num_pages, 9);
        $this->assertEquals($page->minPage(), 1);
        $this->assertEquals($page->maxPage(), 5);

        $page->current = 2;
        $this->assertEquals($page->minPage(), 1);
        $this->assertEquals($page->maxPage(), 5);

        $page->current = 3;
        $this->assertEquals($page->minPage(), 1);
        $this->assertEquals($page->maxPage(), 5);

        $page->current = 4;
        $this->assertEquals($page->minPage(), 1);
        $this->assertEquals($page->maxPage(), 5);

        $page->current = 5;
        $this->assertEquals($page->minPage(), 1);
        $this->assertEquals($page->maxPage(), 5);

        $page->current = 5;
        $this->assertEquals($page->minPage(), 1);
        $this->assertEquals($page->maxPage(), 5);
    }

    public function test_no_items()
    {
        $page = new Pagination(1, 0, 10);
        $this->assertEquals($page->current, 0);
        $this->assertEquals($page->from_item, 0);
        $this->assertEquals($page->to_item, 0);
        $this->assertEquals($page->minPage(), 0);
        $this->assertEquals($page->maxPage(), 0);
    }
}
