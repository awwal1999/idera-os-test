<?php


namespace App\Http\Controllers;


use App\Exceptions\NotFoundException;
use App\Http\Requests\AddCinemaShowsRequest;
use App\Http\Requests\GetCinemaShowsRequest;
use App\RepositoryContracts\CinemaRepository;
use App\RepositoryContracts\CinemaShowRepository;
use App\RepositoryContracts\ShowRepository;
use Carbon\Carbon;

class CinemaController extends BaseController
{
    /**
     * @var CinemaRepository
     */
    private $cinemaRepository;
    /**
     * @var ShowRepository
     */
    private $showRepository;
    /**
     * @var CinemaShowRepository
     */
    private $cinemaShowRepository;

    /**
     * CinemaController constructor.
     * @param  CinemaRepository  $cinemaRepository
     * @param  ShowRepository  $showRepository
     * @param  CinemaShowRepository  $cinemaShowRepository
     */
    public function __construct(
        CinemaRepository $cinemaRepository,
        ShowRepository $showRepository,
        CinemaShowRepository $cinemaShowRepository
    ) {
        $this->cinemaRepository = $cinemaRepository;
        $this->showRepository = $showRepository;
        $this->cinemaShowRepository = $cinemaShowRepository;
    }

    public
    function getCinemas()
    {
        $cinemas = $this->cinemaRepository->getCinemas();
        return $this->successfulResponse(200, $cinemas);
    }

    public
    function addShow(
        AddCinemaShowsRequest $request,
        $id
    ) {
        $cinema = $this->cinemaRepository->findById($id);
        if (!$cinema) {
            throw new NotFoundException('Cinema with Id cannot be found');
        }
        $show = $this->showRepository->findById($request->showId);
        $showTime = Carbon::createFromFormat('Y-m-d H:i', $request->showTime)->toDate();
        $this->cinemaRepository->addShow($cinema, $show, $showTime);
        return $this->successfulResponse(201);
    }

    public function getShows(GetCinemaShowsRequest $request, $id)
    {
        $cinema = $this->cinemaRepository->findById($id);

        if (!$cinema) {
            throw new NotFoundException('Cinema with Id cannot be found');
        }
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $cinemaShows = $this->cinemaShowRepository->findByCinemasAndStateDateAndEndDate($cinema, $startDate, $endDate);
        $cinemaShows = $cinemaShows->transform(function ($cinemaShow) {
            return [
                'show_time' => $cinemaShow->show_time,
                'name' => $cinemaShow->show->name,
                'description' => $cinemaShow->show->description
            ];
        });
        return $this->successfulResponse(200, $cinemaShows);
    }
}
