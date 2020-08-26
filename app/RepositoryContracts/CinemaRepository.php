<?php


namespace App\RepositoryContracts;


use App\Models\Cinema;
use App\Models\Show;

interface CinemaRepository
{

    public function getCinemas();

    public function findById($id);

    public function addShow(Cinema $cinema, Show $show, $showTime);

    public function findByShowABetweenStartDateAndEndDate(Show $show, $startDate, $endDate);
}
