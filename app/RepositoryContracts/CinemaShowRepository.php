<?php


namespace App\RepositoryContracts;


use App\Models\Cinema;
use App\Models\Show;

interface CinemaShowRepository
{

    public function findByShowAndStartDateAndEndDate(Show $show, $startDate, $endDate);

    public function findByCinemasAndStateDateAndEndDate(Cinema $cinema, $startDate, $endDate);
}
