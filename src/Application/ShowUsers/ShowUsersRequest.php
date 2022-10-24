<?php

namespace App\Application\ShowUsers;

class ShowUsersRequest
{
    private int $page;
    private int $perPage;

    public function __construct(int $page, int $perPage)
    {
        $this->page = $page;
        $this->perPage = $perPage;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }
}