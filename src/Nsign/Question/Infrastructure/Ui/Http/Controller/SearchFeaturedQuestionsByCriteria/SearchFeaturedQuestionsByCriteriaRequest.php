<?php

declare(strict_types=1);

namespace App\Nsign\Question\Infrastructure\Ui\Http\Controller\SearchFeaturedQuestionsByCriteria;

use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\Order;
use App\Nsign\Question\Application\SearchFeaturedQuestionsByCriteria\Sort;
use App\Shared\Kernel\Infrastructure\Ui\Http\Request\SerializableRequest;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;

final class SearchFeaturedQuestionsByCriteriaRequest implements SerializableRequest
{
    public function __construct(
        public ?int $fromDate,
        public ?int $toDate,
        public ?int $page,
        public ?int $pageSize,
        public ?string $sort,
        public ?string $order,
    ) {
    }

    public static function validationConstraint(): Constraint
    {
        return new Collection([
            'fields' => [
                'fromDate' => new Optional([
                    'constraints' => [
                        new Type('numeric'),
                        new Positive(),
                    ]
                ]),
                'toDate' => new Optional([
                    'constraints' => [
                        new Type('numeric'),
                        new Positive(),
                    ]
                ]),
                'page' => new Optional([
                    'constraints' => [
                        new Type('numeric'),
                        new Positive(),
                    ]
                ]),
                'pageSize' => new Optional([
                    'constraints' => [
                        new Type('numeric'),
                        new Positive(),
                    ]
                ]),
                'sort' => new Optional([
                    'constraints' => [
                        new Choice(choices: array_column(Sort::cases(), 'name')),
                    ]
                ]),
                'order' => new Optional([
                    'constraints' => [
                        new Choice(choices: array_column(Order::cases(), 'name')),
                    ]
                ]),
            ],
        ]);
    }
}