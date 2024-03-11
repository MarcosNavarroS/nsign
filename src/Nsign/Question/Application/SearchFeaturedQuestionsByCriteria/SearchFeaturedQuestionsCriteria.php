<?php

declare(strict_types=1);

namespace App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria;

final class SearchFeaturedQuestionsCriteria
{
    public function __construct(
        public ?int $fromDate,
        public ?int $toDate,
        public int $page,
        public int $pageSize,
        public Sort $sort,
        public Order $order,
    ) {
    }

    public static function create(
        ?int $fromDate = null,
        ?int $toDate = null,
        ?int $page = null,
        ?int $pageSize = null,
        ?Sort $sort = null,
        ?Order $order = null,
    ): SearchFeaturedQuestionsCriteria {
        return new self(
            $fromDate,
            $toDate,
            $page ?? 1,
            $pageSize ?? 15,
            $sort ?? Sort::activity,
            $order ?? Order::desc,
        );
    }
}