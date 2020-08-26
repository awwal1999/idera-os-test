<?php


namespace App\RepositoryContracts;


use App\Models\Cinema;

interface ShowRepository
{

    public function getShows($startDate, $endDate);

    public function createShow($showRequest);

    public function findById($id);

    public function findByCinemaAndStartDateOrEndDate(Cinema $cinema, $startDate, $endDate);

}
