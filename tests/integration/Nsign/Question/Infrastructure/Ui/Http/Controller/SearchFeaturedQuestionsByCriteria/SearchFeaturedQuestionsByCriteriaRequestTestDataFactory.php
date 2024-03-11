<?php

declare(strict_types=1);

namespace App\Tests\integration\Nsign\Question\Infrastructure\Ui\Http\Controller\SearchFeaturedQuestionsByCriteria;

use App\Nsign\Question\Infrastructure\Ui\Http\Controller\SearchFeaturedQuestionsByCriteria\SearchFeaturedQuestionsByCriteriaRequest;

final class SearchFeaturedQuestionsByCriteriaRequestTestDataFactory
{
    public static function create(
        ?int $fromDate = null,
        ?int $toDate = null,
        ?int $page = 1,
        ?int $pageSize = 15,
        ?string $sort = 'activity',
        ?string $order = 'desc',
    ): SearchFeaturedQuestionsByCriteriaRequest {
        return new SearchFeaturedQuestionsByCriteriaRequest(
            $fromDate,
            $toDate,
            $page,
            $pageSize,
            $sort,
            $order,
        );
    }
}