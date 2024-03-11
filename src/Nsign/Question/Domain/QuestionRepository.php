<?php

namespace App\Nsign\Question\Domain;

interface QuestionRepository
{
    /**
     * @throws QuestionNotFound
     * @throws UnableToGetQuestion
     */
    public function getById(QuestionId $id): Question;
}