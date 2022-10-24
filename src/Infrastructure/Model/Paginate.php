<?php

namespace App\Infrastructure\Model;

class Paginate
{
    private int $total;
    private int $per_page;
    private int $current_page;
    private int $last_page;
    private int $from;
    private int $to;
    private array $data;

    public function __construct(int $page, int $perPage, int $totalItems, array $data)
    {
        $totalPages = ceil($totalItems / $perPage);
        $totalResponse = count($data);
        $totalLast = ($page - 1) * $perPage;

        $this->total = $totalItems;
        $this->per_page = $perPage;
        $this->current_page = $page;
        $this->last_page = $totalPages;
        $this->from = $totalResponse ? $totalLast + 1 : 0;
        $this->to = $totalResponse ? $totalLast + $totalResponse : 0;
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->per_page;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->current_page;
    }

    /**
     * @return int
     */
    public function getLastPage(): int
    {
        return $this->last_page;
    }

    /**
     * @return int
     */
    public function getFrom(): int
    {
        return $this->from;
    }

    /**
     * @return int
     */
    public function getTo(): int
    {
        return $this->to;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}